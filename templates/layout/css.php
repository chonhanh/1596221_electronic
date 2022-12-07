<!-- Css Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<!-- Css Files -->
<?php
$css->set("css/animate.min.css");
$css->set("bootstrap/bootstrap.css");
$css->set("fontawesome512/all.css");
$css->set("confirm/confirm.css");
$css->set("holdon/HoldOn.css");
$css->set("holdon/HoldOn-style.css");
$css->set("lightgallery/lightgallery.css");
$css->set("lightgallery/lg-transitions.css");
$css->set("lightgallery/lg-thumbnail.css");
$css->set("lightgallery/lg-zoom.css");
$css->set("lightgallery/lg-autoplay.css");
$css->set("lightgallery/lg-fullscreen.css");
$css->set("lightgallery/lg-pager.css");
$css->set("lightgallery/lg-rotate.css");
$css->set("lightgallery/lg-video.css");
$css->set("simplenotify/simple-notify.css");
$css->set("rating/star-rating-svg.css");
$css->set("scrollbar/mCustomScrollbar.css");
$css->set("sumoselect/sumoselect.css");
$css->set("sumoselect/sumoselect-style.css");
$css->set("datetimepicker/jquery.datetimepicker.css");
$css->set("daterangepicker/daterangepicker.css");
$css->set("rangeSlider/ion.rangeSlider.css");
$css->set("videojs/video-js.min.css");
$css->set("owlcarousel2/owl.carousel.css");
$css->set("owlcarousel2/owl.theme.default.css");
$css->set("fileuploader/font-fileuploader.css");
$css->set("fileuploader/jquery.fileuploader.min.css");
$css->set("fileuploader/jquery.fileuploader-theme-dragdrop.css");
$css->set("comment/comment.css");
$css->set("chat/chat.css");
$css->set("css/cart.css");
$css->set("css/style.css");
echo $css->get();
?>

<!-- Js Google Analytic -->
<?= $func->decodeHtmlChars($setting['analytics']) ?>

<!-- Js Head -->
<?= $func->decodeHtmlChars($setting['headjs']) ?>