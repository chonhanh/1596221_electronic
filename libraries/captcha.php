<?php
$encryptCode = (!empty($encryptCode)) ? base64_decode($encryptCode) : '';

if (!empty($encryptCode)) {
    $encryptCode = explode("|", $encryptCode);
    $type = (!empty($encryptCode[0])) ? $encryptCode[0] : '';
    $reload = (!empty($encryptCode[1]) && $encryptCode[1] == 'reload') ? true : false;
    $code = substr(md5(rand(0, 999)), 15, 6);

    if (empty($type)) {
        return false;
    }

    if (!empty($reload)) {
        unset($_SESSION["captcha"][$type]);
    }

    if (empty($_SESSION["captcha"][$type])) {
        $_SESSION["captcha"][$type] = $code;
    }

    $width = 80;
    $height = 30;
    $image = ImageCreate($width, $height);
    $white = ImageColorAllocate($image, 255, 255, 255);
    $black = ImageColorAllocate($image, 166, 150, 51);

    ImageFill($image, 0, 0, $black);
    ImageString($image, 5, 15, 7, $_SESSION["captcha"][$type], $white);
    header("Content-Type: image/png");
    ImagePng($image);
    ImageDestroy($image);
}

exit();
