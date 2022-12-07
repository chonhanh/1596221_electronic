<?php
/* Loại giá */
$nametype = "loai-gia";
$config['variation'][$nametype]['title_main'] = "Loại giá";
$config['variation'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['variation'][$nametype]['list'] = true;
$config['variation'][$nametype]['denominations'] = true;

/* Mức giá */
$nametype = "muc-gia";
$config['variation'][$nametype]['title_main'] = "Mức giá";
$config['variation'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['variation'][$nametype]['list'] = true;
$config['variation'][$nametype]['range_value'] = true;
$config['variation'][$nametype]['range_type'] = true;
$config['variation'][$nametype]['price'] = true;

/* Thời gian đăng tin */
$nametype = "thoi-gian-dang-tin";
$config['variation'][$nametype]['title_main'] = "Thời gian đăng tin";
$config['variation'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['variation'][$nametype]['date'] = true;

/* Thời gian đăng video */
$nametype = "thuoc-tinh-dong";
$config['variation'][$nametype]['title_main'] = "Thuộc tính động";
$config['variation'][$nametype]['check'] = array("hienthi" => "Hiển thị");
$config['variation'][$nametype]['date'] = false;
$config['variation'][$nametype]['images'] = true;
$config['variation'][$nametype]['show_images'] = true;
$config['variation'][$nametype]['width'] = 60;
$config['variation'][$nametype]['height'] = 60;
$config['variation'][$nametype]['thumb'] = '60x60x2';
$config['variation'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';