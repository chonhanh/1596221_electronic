<?php
/* Report status */
$reportStatus = $cache->get("select id, name$lang, desc$lang from #_report_status where find_in_set('hienthi',status) order by numb,id desc", null, 'result', 7200);

/* Report action */
if (!empty($_POST['submit-report']) || ($func->isAjax() && !empty($_GET['isAjaxReport']))) {
    $isLogin = $func->getMember('active');
    $idMember = $func->getMember('id');
    $codeCaptcha = $_POST['captcha-report'];
    $sessionCaptcha = (!empty($_SESSION["captcha"]["report-" . NAME_SHOP])) ? $_SESSION["captcha"]["report-" . NAME_SHOP] : null;
    $responseCaptcha = $_POST['recaptcha_response_report'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataReport = (!empty($_POST['dataReport'])) ? $_POST['dataReport'] : null;

    /* Check exist report of member */
    if (!empty($isLogin) && !empty($idMember)) {
        $existReport = $d->rawQueryOne("select B.id_member as idMember from #_$tableShopReport as A, #_$tableShopReportInfo as B where A.id = B.id_parent and A.id_shop = ? and B.id_member = ?", array($idShop, $idMember));
    }

    /* Valid data */
    $errors = array();
    if (empty($isLogin)) {
        $errors[] = 'Vui lòng đăng nhập để báo xấu gian hàng';
    } else if (!empty($existReport['idMember'])) {
        $errors[] = 'Bạn đã báo xấu gian hàng này';
    } else {
        if (empty($dataReport['id_status'])) {
            $errors[] = 'Chưa chọn dữ liệu báo xấu';
        }

        if (empty($dataReport['fullname'])) {
            $errors[] = 'Họ tên không được trống';
        }

        if (empty($dataReport['phone'])) {
            $errors[] = 'Số điện thoại không được trống';
        }

        if (!empty($dataReport['phone']) && !$func->isPhone($dataReport['phone'])) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }

        if (empty($dataReport['email'])) {
            $errors[] = 'Email không được trống';
        }

        if (!empty($dataReport['email']) && !$func->isEmail($dataReport['email'])) {
            $errors[] = 'Email không hợp lệ';
        }

        if (empty($dataReport['content'])) {
            $errors[] = 'Nội dung không được trống';
        }

        if (empty($codeCaptcha)) {
            $errors[] = 'Mã bảo mật không được trống';
        }

        if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
            $errors[] = 'Mã bảo mật không chính xác';
        }
    }

    if (!empty($errors)) {
        $str = '<div class="text-left">';

        foreach ($errors as $v_error) {
            $str .= "- " . $v_error . "</br>";
        }

        $str .= "</div>";

        /* Destroy session captcha */
        unset($_SESSION["captcha"]["report-" . NAME_SHOP]);

        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = $str;
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer($str, URL_SHOP, false);
        }
    }

    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Report' && $codeCaptcha == $sessionCaptcha) || $testCaptcha == true) {
        if (!empty($dataReport)) {
            /* Check exist report */
            $reportDetail = $d->rawQueryOne("select id, id_shop from #_$tableShopReport where id_shop = ? limit 0,1", array($idShop));

            /* Data report info */
            $dataReportInfo = array();
            $dataReportInfo['id_member'] = $idMember;
            $dataReportInfo['id_status'] = htmlspecialchars($dataReport['id_status']);
            $dataReportInfo['fullname'] = htmlspecialchars($dataReport['fullname']);
            $dataReportInfo['phone'] = htmlspecialchars($dataReport['phone']);
            $dataReportInfo['email'] = htmlspecialchars($dataReport['email']);
            $dataReportInfo['content'] = htmlspecialchars($dataReport['content']);

            /* Insert or Update data */
            if (!empty($reportDetail['id'])) {
                $dataReportInfo['id_parent'] = $reportDetail['id'];

                /* Insert data report info */
                if ($d->insert($tableShopReportInfo, $dataReportInfo)) {
                    $successReport = true;
                } else {
                    $successReport = false;
                }
            } else {
                /* Data report */
                $dataReportMain = array();
                $dataReportMain['id_shop'] = $idShop;
                $dataReportMain['numb'] = 0;
                $dataReportMain['status'] = 0;
                $dataReportMain['date_created'] = time();

                if ($d->insert($tableShopReport, $dataReportMain)) {
                    $id_insert = $d->getLastInsertId();
                    $dataReportInfo['id_parent'] = $id_insert;

                    /* Insert data report info */
                    if ($d->insert($tableShopReportInfo, $dataReportInfo)) {
                        $successReport = true;
                    } else {
                        $successReport = false;
                    }
                } else {
                    $successReport = false;
                }
            }
        } else {
            $successReport = false;
        }
    } else {
        $successReport = false;
    }

    /* Destroy session captcha */
    unset($_SESSION["captcha"]["report-" . NAME_SHOP]);

    /* Flag report */
    if ($successReport == true) {
        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'success';
            $resultAjax['message'] = 'Báo xấu gian hàng thành công. Chúng tôi sẽ xem xét trong thời gian sớm nhất.';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Báo xấu gian hàng thành công. Chúng tôi sẽ xem xét trong thời gian sớm nhất.", URL_SHOP);
        }
    } else {
        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = 'Báo xấu gian hàng thất bại. Vui lòng thử lại sau.';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Báo xấu gian hàng thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
        }
    }
}
