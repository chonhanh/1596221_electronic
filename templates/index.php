<!DOCTYPE html>
<html lang="<?= $config['website']['lang-doc'] ?>">

<head>
    <?php include TEMPLATE . LAYOUT . "head.php"; ?>
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body class="<?= ($source == 'order') ? 'page-order' : '' ?>">
    <?php
    // include TEMPLATE.LAYOUT."loader.php";
    include TEMPLATE . LAYOUT . "seo.php";
    include TEMPLATE . LAYOUT . "header.php";
    ?>
    <div class="main <?= ($source == 'index') ? 'home' : '' ?> w-clear">
        <div class="block-content">
            <div class="row side">
                <div class="left col col-side"><?php include TEMPLATE . LAYOUT . "advertise-left.php"; ?></div>
                <div class="center col col-center  px-2">
                    
                    <?php if (!empty($hasAdvertise)) { ?>
                     
                            <?php /*<div class="left col col-side"><?php // include TEMPLATE . LAYOUT . "advertise-left.php"; ?></div>*/ ?>
                            <div class=""><?php include TEMPLATE . $template . "_tpl.php"; ?></div>
                            <?php /*<div class="right col col-side"><?php // include TEMPLATE . LAYOUT . "advertise-right.php"; ?></div>*/ ?>
                      
                    <?php } else if (!empty($manageMember)) { ?>
                        <div class="row">
                            <div class="col-3"><?php include TEMPLATE . "account/sidebar.php"; ?></div>
                            <div class="col-9 pt-2 mt-1"><?php include TEMPLATE . $template . "_tpl.php"; ?></div>
                        </div>
                    <?php } else {
                        include TEMPLATE . $template . "_tpl.php";
                    } ?>
                    <?php
                    if ($template == 'product/product_detail') {
                        if (!empty($IDVideo)) {
                            include TEMPLATE . "video/videoSeen.php";
                            include TEMPLATE . "video/videoSimilar.php";
                        } else {
                            include TEMPLATE . "product/productSeen.php";
                            include TEMPLATE . "product/productSimilar.php";
                        }
                    }
                    ?>
                </div>
                <div class="right col col-side"><?php include TEMPLATE . LAYOUT . "advertise-right.php"; ?></div>
            </div>
        </div>
    </div>
    <?php
    include TEMPLATE . LAYOUT . "footer.php";
    include TEMPLATE . LAYOUT . "modals.php";
    include TEMPLATE . LAYOUT . "js.php";
    ?>
</body>

</html>