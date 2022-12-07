<?php
if (!defined('SOURCES')) die("Error");

if (!empty($_POST['submit-contact'])) {
    $codeCaptcha = $_POST['captcha-contact'];
    $sessionCaptcha = (!empty($_SESSION["captcha"]["contact-" . NAME_SHOP])) ? $_SESSION["captcha"]["contact-" . NAME_SHOP] : null;
    $responseCaptcha = $_POST['recaptcha_response_contact'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;

    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Contact') || $testCaptcha == true) {
        $message = '';
        $response = array();
        $dataContact = (!empty($_POST['dataContact'])) ? $_POST['dataContact'] : null;

        /* Valid data */
        if (empty($dataContact['fullname'])) {
            $response['messages'][] = 'Họ tên không được trống';
        }

        if (empty($dataContact['phone'])) {
            $response['messages'][] = 'Số điện thoại không được trống';
        }

        if (!empty($dataContact['phone']) && !$func->isPhone($dataContact['phone'])) {
            $response['messages'][] = 'Số điện thoại không hợp lệ';
        }

        if (empty($dataContact['address'])) {
            $response['messages'][] = 'Địa chỉ không được trống';
        }

        if (empty($dataContact['email'])) {
            $response['messages'][] = 'Email không được trống';
        }

        if (!empty($dataContact['email']) && !$func->isEmail($dataContact['email'])) {
            $response['messages'][] = 'Email không hợp lệ';
        }

        if (empty($dataContact['subject'])) {
            $response['messages'][] = 'Chủ đề không được trống';
        }

        if (empty($dataContact['content'])) {
            $response['messages'][] = 'Nội dung không được trống';
        }

        if (empty($codeCaptcha)) {
            $response['messages'][] = 'Mã bảo mật không được trống';
        }

        if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
            $response['messages'][] = 'Mã bảo mật không chính xác';
        }

        if (!empty($response)) {
            /* Destroy session captcha */
            unset($_SESSION["captcha"]["contact-" . NAME_SHOP]);

            /* Flash data */
            if (!empty($dataContact)) {
                foreach ($dataContact as $k => $v) {
                    if (!empty($v)) {
                        $flash->set($k, $v);
                    }
                }
            }

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect("lien-he");
        }

        /* Save data */
        $data = array();
        $data['id_shop'] = $idShop;
        $data['sector_prefix'] = $prefixSector;
        $data['fullname'] = (!empty($dataContact['fullname'])) ? htmlspecialchars($dataContact['fullname']) : '';
        $data['email'] = (!empty($dataContact['email'])) ? htmlspecialchars($dataContact['email']) : '';
        $data['phone'] = (!empty($dataContact['phone'])) ? htmlspecialchars($dataContact['phone']) : '';
        $data['address'] = (!empty($dataContact['address'])) ? htmlspecialchars($dataContact['address']) : '';
        $data['subject'] = (!empty($dataContact['subject'])) ? htmlspecialchars($dataContact['subject']) : '';
        $data['content'] = (!empty($dataContact['content'])) ? htmlspecialchars($dataContact['content']) : '';
        $data['date_created'] = time();
        $data['numb'] = 1;

        if ($d->insert('contact', $data)) {
            $id_insert = $d->getLastInsertId();

            if ($func->hasFile("file_attach")) {
                $fileUpdate = array();
                $file_name = $func->uploadName($_FILES['file_attach']["name"]);

                if ($file_attach = $func->uploadImage("file_attach", '.doc|.docx|.pdf|.rar|.zip|.ppt|.pptx|.xls|.xlsx|.jpg|.png|.gif', UPLOAD_FILE_SOURCE, $file_name)) {
                    $fileUpdate['file_attach'] = $file_attach;
                    $d->where('id', $id_insert);
                    $d->update('contact', $fileUpdate);
                    unset($fileUpdate);
                }
            }

            /* Destroy session captcha */
            unset($_SESSION["captcha"]["contact-" . NAME_SHOP]);
        } else {
            /* Destroy session captcha */
            unset($_SESSION["captcha"]["contact-" . NAME_SHOP]);

            $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
        }

        /* Gán giá trị gửi email */
        $strThongtin = '';
        $emailer->set('tennguoigui', $data['fullname']);
        $emailer->set('emailnguoigui', $data['email']);
        $emailer->set('dienthoainguoigui', $data['phone']);
        $emailer->set('diachinguoigui', $data['address']);
        $emailer->set('tieudelienhe', $data['subject']);
        $emailer->set('noidunglienhe', $data['content']);
        if ($emailer->get('tennguoigui')) {
            $strThongtin .= '<span style="text-transform:capitalize">' . $emailer->get('tennguoigui') . '</span><br>';
        }
        if ($emailer->get('emailnguoigui')) {
            $strThongtin .= '<a href="mailto:' . $emailer->get('emailnguoigui') . '" target="_blank">' . $emailer->get('emailnguoigui') . '</a><br>';
        }
        if ($emailer->get('diachinguoigui')) {
            $strThongtin .= '' . $emailer->get('diachinguoigui') . '<br>';
        }
        if ($emailer->get('dienthoainguoigui')) {
            $strThongtin .= 'Tel: ' . $emailer->get('dienthoainguoigui') . '';
        }
        $emailer->set('thongtin', $strThongtin);

        /* Defaults attributes email */
        $emailDefaultAttrs = $emailer->defaultAttrs();

        /* Variables email */
        $emailVars = array(
            '{emailTitleSender}',
            '{emailInfoSender}',
            '{emailSubjectSender}',
            '{emailContentSender}'
        );
        $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

        /* Values email */
        $emailVals = array(
            $emailer->get('tennguoigui'),
            $emailer->get('thongtin'),
            $emailer->get('tieudelienhe'),
            $emailer->get('noidunglienhe')
        );
        $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

        /* Send email admin */
        $arrayEmail = null;
        $subject = "Thư liên hệ từ " . $setting['name' . $lang];
        $message = str_replace($emailVars, $emailVals, $emailer->markdown('contact/admin'));
        $file = 'file_attach';

        if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
            /* Send email customer */
            $arrayEmail = array(
                "dataEmail" => array(
                    "name" => $emailer->get('tennguoigui'),
                    "email" => $emailer->get('emailnguoigui')
                )
            );
            $subject = "Thư liên hệ từ " . $setting['name' . $lang];
            $message = str_replace($emailVars, $emailVals, $emailer->markdown('contact/customer'));
            $file = 'file_attach';

            if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) $func->transfer("Gửi liên hệ thành công", URL_SHOP);
        } else $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau", URL_SHOP, false);
    } else {
        $func->transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau", URL_SHOP, false);
    }
}

/* Lấy dữ liệu */
$contact = $d->rawQueryOne("select A.id as id, A.name$lang as name$lang, A.photo as photo, A.options as options, B.content$lang as content$lang from #_static as A, #_static_content as B where A.id_shop = $idShop and A.sector_prefix = ? and B.id_parent = A.id and A.type = ? limit 0,1", array($prefixSector, 'lien-he'));

/* SEO */
$seoDB = $seo->getOnDB('*', 'static_seo', $contact['id']);
$seo->set('h1', $contact['name' . $lang]);
if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
else $seo->set('title', $contact['name' . $lang]);
if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
$seo->set('url', $func->getPageURL());
$img_json_bar = (!empty($contact['options'])) ? json_decode($contact['options'], true) : null;
if (empty($img_json_bar) || ($img_json_bar['p'] != $contact['photo'])) {
    $img_json_bar = $func->getImgSize($contact['photo'], UPLOAD_NEWS_SOURCE . $contact['photo']);
    $seo->updateSeoDB(json_encode($img_json_bar), 'static', $contact['id']);
}
if (!empty($img_json_bar)) {
    $seo->set('photo', $configBase . THUMBS_SOURCE . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_NEWS_THUMB . $contact['photo']);
    $seo->set('photo:width', $img_json_bar['w']);
    $seo->set('photo:height', $img_json_bar['h']);
    $seo->set('photo:type', $img_json_bar['m']);
}
