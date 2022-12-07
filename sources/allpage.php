<?php
if (!defined('SOURCES')) die("Error");
// $func->dump(json_decode(file_get_contents('http://c31e-113-161-88-45.ap.ngrok.io/chonhanh/api/storefont/product/lists'), true), true);
$sectorType = (!empty($_REQUEST['sectorType'])) ? htmlspecialchars($_REQUEST['sectorType']) : '';
if (!empty($sectorType)){
    $sector = $defineSectors['types'][$sectorType];
}

$apiResp = $restApi->get($apiRoutes['storefront']['product']['lists']);
$apiResp = $restApi->decode($apiResp, true);
$dm_list = array();

if (!empty($apiResp) && ($apiResp['status'])==200) {
    foreach ($apiResp['data'] as $key => $v) {
        $dm_list[$key]= $v;
    }
}


/* Query allpage */
$favicon = $cache->get("select photo from #_photo where id_shop = $idShop and type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('favicon', 'photo_static'), 'fetch', 7200);
$logo = $cache->get("select id, photo, options from #_photo where id_shop = $idShop and type = ? and act = ? limit 0,1", array('logo', 'photo_static'), 'fetch', 7200);
$social = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('social'), 'result', 7200);

$policy = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('chinh-sach-ho-tro'), 'result', 7200);
$recruitment = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('tuyen-dung'), 'result', 7200);
$support = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('ho-tro-thanh-toan'), 'result', 7200);
$ministry = $cache->get("select photo, link from #_photo where id_shop = $idShop and type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('bo-cong-thuong', 'photo_static'), 'fetch', 7200);
$advertisesHome = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('advertise-home'), 'result', 7200);
$advertiseLeft = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('advertise-left'), 'result', 7200);
$advertiseRight = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('advertise-right'), 'result', 7200);

$sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($config['website']['list']), 'result', 7200);


/* Get statistic */
$counter = $statistic->getCounter();
$online = $statistic->getOnline();

/* Feedback */
if (!empty($_POST['submit-feedback']) || ($func->isAjax() && !empty($_GET['isAjaxFeedback']))) {
    $codeCaptcha = $_POST['captcha-feedback'];
    $sessionCaptcha = (!empty($_SESSION["captcha"]["feedback"])) ? $_SESSION["captcha"]["feedback"] : null;
    $responseCaptcha = $_POST['recaptcha_response_feedback'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataFeedback = (!empty($_POST['dataFeedback'])) ? $_POST['dataFeedback'] : null;

    /* Valid data */
    $errors = array();
    if (empty($dataFeedback['fullname'])) {
        $errors[] = 'Họ tên không được trống';
    }

    if (empty($dataFeedback['phone'])) {
        $errors[] = 'Số điện thoại không được trống';
    }

    if (!empty($dataFeedback['phone']) && !$func->isPhone($dataFeedback['phone'])) {
        $errors[] = 'Số điện thoại không hợp lệ';
    }

    if (empty($dataFeedback['email'])) {
        $errors[] = 'Email không được trống';
    }

    if (!empty($dataFeedback['email']) && !$func->isEmail($dataFeedback['email'])) {
        $errors[] = 'Email không hợp lệ';
    }

    if (empty($dataFeedback['content'])) {
        $errors[] = 'Nội dung không được trống';
    }

    if (empty($codeCaptcha)) {
        $errors[] = 'Mã bảo mật không được trống';
    }

    if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
        $errors[] = 'Mã bảo mật không chính xác';
    }

    if (!empty($errors)) {
        $str = '<div class="text-left">';

        foreach ($errors as $v_error) {
            $str .= "- " . $v_error . "</br>";
        }

        $str .= "</div>";

        /* Destroy session captcha */
        unset($_SESSION["captcha"]["feedback"]);

        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = $str;
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer($str, $configBase, false);
        }
    }

    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Feedback' && $codeCaptcha == $sessionCaptcha) || $testCaptcha == true) {
        if (!empty($dataFeedback)) {
            $data = array();
            $data['id_shop'] = $idShop;
            $data['fullname'] = htmlspecialchars($dataFeedback['fullname']);
            $data['phone'] = htmlspecialchars($dataFeedback['phone']);
            $data['email'] = htmlspecialchars($dataFeedback['email']);
            $data['content'] = htmlspecialchars($dataFeedback['content']);
            $data['date_created'] = time();
            $data['type'] = 'phan-hoi';

            if ($d->insert('newsletter', $data)) {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["feedback"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'success';
                    $resultAjax['message'] = 'Góp ý/phản hồi thành công. Chúng tôi sẽ hồi âm tới bạn sớm nhất.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer("Góp ý/phản hồi thành công. Chúng tôi sẽ hồi âm tới bạn sớm nhất.", $configBase);
                }
            } else {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["feedback"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = 'Góp ý/phản hồi thất bại. Vui lòng thử lại sau.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer("Góp ý/phản hồi thất bại. Vui lòng thử lại sau.", $configBase, false);
                }
            }
        } else {
            /* Destroy session captcha */
            unset($_SESSION["captcha"]["feedback"]);

            /* Is ajax */
            if ($func->isAjax()) {
                $resultAjax = array();
                $resultAjax['status'] = 'error';
                $resultAjax['message'] = 'Góp ý/phản hồi thất bại. Vui lòng thử lại sau.';
                echo json_encode($resultAjax);
                exit();
            } else {
                $func->transfer("Góp ý/phản hồi thất bại. Vui lòng thử lại sau.", $configBase, false);
            }
        }
    } else {
        /* Destroy session captcha */
        unset($_SESSION["captcha"]["feedback"]);

        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = 'Góp ý/phản hồi thất bại. Vui lòng thử lại sau.';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Góp ý/phản hồi thất bại. Vui lòng thử lại sau.", $configBase, false);
        }
    }
}
