<!-- Basehref -->
<base href="<?= URL_SHOP ?>" />

<!-- UTF-8 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Title, Keywords, Description -->
<title><?= $seo->get('title') ?></title>
<meta name="keywords" content="<?= $seo->get('keywords') ?>" />
<meta name="description" content="<?= $seo->get('description') ?>" />

<!-- Robots -->
<meta name="robots" content="index,follow" />

<!-- Favicon -->
<link href="<?= ASSET . UPLOAD_PHOTO_THUMB . $favicon['photo'] ?>" rel="shortcut icon" type="image/x-icon" />

<!-- GEO -->
<meta name="geo.region" content="VN" />
<meta name="geo.placename" content="Hồ Chí Minh" />
<meta name="geo.position" content="10.823099;106.629664" />
<meta name="ICBM" content="10.823099, 106.629664" />

<!-- Author - Copyright -->
<meta name='revisit-after' content='1 days' />
<meta name="author" content="<?= $setting['name' . $lang] ?>" />
<meta name="copyright" content="<?= $setting['name' . $lang] . " - [" . $optsetting['email'] . "]" ?>" />

<!-- Facebook -->
<meta property="og:type" content="<?= $seo->get('type') ?>" />
<meta property="og:site_name" content="<?= $setting['name' . $lang] ?>" />
<meta property="og:title" content="<?= $seo->get('title') ?>" />
<meta property="og:description" content="<?= $seo->get('description') ?>" />
<meta property="og:url" content="<?= $seo->get('url') ?>" />
<meta property="og:image" content="<?= $seo->get('photo') ?>" />
<meta property="og:image:alt" content="<?= $seo->get('title') ?>" />
<meta property="og:image:type" content="<?= $seo->get('photo:type') ?>" />
<meta property="og:image:width" content="<?= $seo->get('photo:width') ?>" />
<meta property="og:image:height" content="<?= $seo->get('photo:height') ?>" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?= $optsetting['email'] ?>" />
<meta name="twitter:creator" content="<?= $setting['name' . $lang] ?>" />
<meta property="og:url" content="<?= $seo->get('url') ?>" />
<meta property="og:title" content="<?= $seo->get('title') ?>" />
<meta property="og:description" content="<?= $seo->get('description') ?>" />
<meta property="og:image" content="<?= $seo->get('photo') ?>" />

<!-- Canonical -->
<link rel="canonical" href="<?= $func->getCurrentPageURL() ?>" />

<!-- Chống đổi màu trên IOS -->
<meta name="format-detection" content="telephone=no">

<!-- Viewport -->
<meta name="viewport" content="width=1349, user-scalable=no">

<?php if (!empty($themeColor)) { ?>
    <!-- Theme color -->
    <meta name="theme-color" content="<?= $themeColor ?>">
<?php } ?>