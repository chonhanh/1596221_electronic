<!DOCTYPE html>
<html lang="<?= $config['website']['lang-doc'] ?>">

<head>
    <?php include TEMPLATE . LAYOUT . "head.php"; ?>
    <?php include TEMPLATE . LAYOUT . "css.php"; ?>
</head>

<body>
    <?php
    // include TEMPLATE.LAYOUT."loader.php";
    include TEMPLATE . LAYOUT . "seo.php";
    include TEMPLATE . LAYOUT . "header/header-main.php";

?>

<div class="main <?= ($source == 'index') ? 'home' : '' ?> w-clear">
        <div class="block-content">
            <div class="row side">
                <div class="left col col-side"><?php include TEMPLATE . LAYOUT . "advertise-left.php"; ?></div>
                <div class="center col col-center">
                    <div class="w-clear bg-f mb-3">
                    <?php 
                        include TEMPLATE . LAYOUT . "header/header-1.php";
                        include TEMPLATE . LAYOUT . "menu/menu-1.php";
                    ?>
                    </div>
                    <div class="<?= ($source == 'index' || $source == 'product') ? 'home' : 'bg-f p-3' ?> w-clear">
                        <?php include TEMPLATE . $template . "_tpl.php"; ?>
                    </div>
                </div>
                <div class="right col col-side"><?php include TEMPLATE . LAYOUT . "advertise-right.php"; ?></div>
            </div>
        </div>
    </div>

    <?php 

        // if (INTERFACE_SHOP == 4) {
        //     include TEMPLATE . LAYOUT . "menu/menu-" . INTERFACE_SHOP . ".php";
        //     include TEMPLATE . LAYOUT . "header/header-" . INTERFACE_SHOP . ".php";
        // } else {
        //     include TEMPLATE . LAYOUT . "header/header-" . INTERFACE_SHOP . ".php";
        //     include TEMPLATE . LAYOUT . "menu/menu-" . INTERFACE_SHOP . ".php";
        // }

        // if ($source == 'index') {
        //     include TEMPLATE . LAYOUT . "slider/slider-" . INTERFACE_SHOP . ".php";
        // }

        // if (INTERFACE_SHOP == 4) {
        //     include TEMPLATE . LAYOUT . "sectorItem.php";
        // }
    ?>

    <?php
    // include TEMPLATE . LAYOUT . "intro/intro-" . INTERFACE_SHOP . ".php";
    include TEMPLATE_MAIN . LAYOUT . "footer.php";
    ?>


    <?php 
    include TEMPLATE . LAYOUT . "modals.php";
    include TEMPLATE . LAYOUT . "js.php";
    ?>
</body>

</html>