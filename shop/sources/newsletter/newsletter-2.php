<?php
/* Newsletter */
if (!empty($_POST['submit-newsletter'])) {
    $responseCaptcha = $_POST['recaptcha_response_newsletter'];
    $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
    $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
    $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
    $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
    $dataNewsletter = (!empty($_POST['dataNewsletter'])) ? $_POST['dataNewsletter'] : null;

    /* Valid data */
    $errors = array();
    if (empty($dataNewsletter['fullname'])) {
        $errors[] = 'Họ tên không được trống';
    }

    if (empty($dataNewsletter['email'])) {
        $errors[] = 'Email không được trống';
    }

    if (!empty($dataNewsletter['email']) && !$func->isEmail($dataNewsletter['email'])) {
        $errors[] = 'Email không hợp lệ';
    }

    if (empty($dataNewsletter['content'])) {
        $errors[] = 'Nội dung không được trống';
    }

    if (!empty($errors)) {
        $str = '<div class="text-left">';

        foreach ($errors as $v_error) {
            $str .= "- " . $v_error . "</br>";
        }

        $str .= "</div>";

        /* Flash data */
        if (!empty($dataNewsletter)) {
            foreach ($dataNewsletter as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        $func->transfer($str, URL_SHOP, false);
    }

    if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Newsletter') || $testCaptcha == true) {
        if (!empty($dataNewsletter)) {
            $data = array();
            $data['id_shop'] = $idShop;
            $data['sector_prefix'] = $prefixSector;
            $data['fullname'] = htmlspecialchars($dataNewsletter['fullname']);
            $data['email'] = htmlspecialchars($dataNewsletter['email']);
            $data['content'] = htmlspecialchars($dataNewsletter['content']);
            $data['date_created'] = time();
            $data['type'] = 'dang-ky-nhan-tin';

            if ($d->insert('newsletter', $data)) {
                $func->transfer("Đăng ký nhận tin thành công. Chúng tôi sẽ hồi âm tới bạn sớm nhất.", URL_SHOP);
            } else {
                $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
            }
        } else {
            $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
        }
    } else {
        $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.", URL_SHOP, false);
    }
}
