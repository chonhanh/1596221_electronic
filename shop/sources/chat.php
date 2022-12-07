<?php
/* Chat action */
if (!empty($_POST['submit-chat']) || ($func->isAjax() && !empty($_GET['isAjaxChat']))) {
    $isLogin = $func->getMember('active');
    $idMember = $func->getMember('id');
    $codeCaptcha = $_POST['captcha-chat'];
    $sessionCaptcha = (!empty($_SESSION["captcha"]["chat-" . NAME_SHOP])) ? $_SESSION["captcha"]["chat-" . NAME_SHOP] : null;
    $responseCaptcha = $_POST['recaptcha_response_chat'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataChat = (!empty($_POST['dataChat'])) ? $_POST['dataChat'] : null;
    $dataChatPhoto = $func->listsGallery('chat-file-photo');

    /* Valid data */
    $errors = array();
    if (empty($isLogin)) {
        $errors[] = 'Vui lòng đăng nhập để trò chuyện';
    } else if ($shopInfo['isOwned']) {
        $errors[] = 'Gian hàng này thuộc quyền sở hữu của bạn';
    } else {
        /* Check exist chat of member */
        if (!empty($isLogin) && !empty($idMember)) {
            $existChat = $d->rawQueryOne("select id from #_$tableShopChat where id_parent = 0 and id_shop = ? and id_member = ?", array($idShop, $idMember));
        }

        if (!empty($existChat)) {
            $errors[] = 'Bạn đã gửi tin nhắn cho chúng tôi. Hãy truy cập vào mục <strong>Danh Sách Trò Chuyện</strong> trong <strong>Trang Cá Nhân</strong> để trò chuyện với chúng tôi';
        } else {
            if (empty($dataChat['message'])) {
                $errors[] = 'Nội dung tin nhắn không được trống';
            }

            if (!empty($dataChatPhoto) && count($dataChatPhoto) > 2) {
                $errors[] = 'Hình ảnh không được vượt quá 2 hình';
            }

            if (empty($codeCaptcha)) {
                $errors[] = 'Mã bảo mật không được trống';
            }

            if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
                $errors[] = 'Mã bảo mật không chính xác';
            }
        }
    }

    if (!empty($errors)) {
        $str = '<div class="text-left">';

        foreach ($errors as $v_error) {
            $str .= "- " . $v_error . "</br>";
        }

        $str .= "</div>";

        /* Destroy session captcha */
        unset($_SESSION["captcha"]["chat-" . NAME_SHOP]);

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

    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Chat' && $codeCaptcha == $sessionCaptcha) || $testCaptcha == true) {
        if (!empty($dataChat)) {
            /* Data report */
            $dataChatMain = array();
            $dataChatMain['id_parent'] = 0;
            $dataChatMain['id_shop'] = $idShop;
            $dataChatMain['id_member'] = $idMember;
            $dataChatMain['message'] = htmlspecialchars($dataChat['message']);
            $dataChatMain['poster'] = 'member';
            $dataChatMain['status'] = 'new-shop';
            $dataChatMain['date_posted'] = time();

            if ($d->insert($tableShopChat, $dataChatMain)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if (!empty($dataChatPhoto)) {
                    $myFile = $_FILES['chat-file-photo'];
                    $fileCount = count($myFile["name"]);

                    for ($i = 0; $i < $fileCount; $i++) {
                        if (in_array($myFile["name"][$i], $dataChatPhoto, true)) {
                            $_FILES['file-uploader-temp'] = array(
                                'name' => $myFile['name'][$i],
                                'type' => $myFile['type'][$i],
                                'tmp_name' => $myFile['tmp_name'][$i],
                                'error' => $myFile['error'][$i],
                                'size' => $myFile['size'][$i]
                            );
                            $file_name = $func->uploadName($myFile["name"][$i]);

                            if ($photo = $func->uploadImage("file-uploader-temp", '.jpg|.png|.jpeg', UPLOAD_PHOTO_SOURCE, $file_name)) {
                                $dataTemp = array();
                                $dataTemp['id_parent'] = $id_insert;
                                $dataTemp['photo'] = $photo;
                                $d->insert($tableShopChatPhoto, $dataTemp);
                            }
                        }
                    }
                }

                $successReport = true;
            } else {
                $successReport = false;
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
            $resultAjax['message'] = 'Gửi tin nhắn thành công. Hãy truy cập vào mục Danh Sách Trò Chuyện trong Trang Cá Nhân để trò chuyện với chúng tôi.';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Gửi tin nhắn thành công. Hãy truy cập vào mục Danh Sách Trò Chuyện trong Trang Cá Nhân để trò chuyện với chúng tôi.", URL_SHOP);
        }
    } else {
        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = 'Gửi tin nhắn thất bại. Vui lòng thử lại sau.';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Gửi tin nhắn thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
        }
    }
}
