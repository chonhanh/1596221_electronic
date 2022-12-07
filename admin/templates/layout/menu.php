<!-- Main Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 text-sm">
    <!-- Logo -->
    <a class="brand-link" href="index.php">
        <img class="brand-image" src="assets/images/nina.png" alt="Nina">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Bảng điều khiển -->
                <?php
                $active = "";
                if (($com == 'index') || ($com == '')) $active = 'active';
                ?>
                <li class="nav-item <?= $active ?>">
                    <a class="nav-link <?= $active ?>" href="index.php" title="Bảng điều khiển">
                        <i class="nav-icon text-sm fas fa-tachometer-alt"></i>
                        <p>Bảng điều khiển</p>
                    </a>
                </li>

                <!-- Shop -->
                <?php if (!empty($config['shop'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;
                    $array_static_type = array('tim-hieu-gian-hang', 'hoan-tat-gian-hang');

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('shop')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if (($com == 'shop') || ($com == 'sample') || ($com == 'interface') || ($com == 'store') || (($com == 'static') && in_array($_GET['type'], $array_static_type))) {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý gian hàng">
                                <i class="nav-icon text-sm fas fa-store"></i>
                                <p>Quản lý gian hàng<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <?= $config['shop']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $menuopen = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('shop', 'man', 'dien-tu')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'shop') && (in_array($act, $array_act))) {
                                    $active = 'active';
                                    $menuopen = 'menu-open';
                                }
                                ?>
                                <?php if ($is_access) { ?>
                    
                                    <!-- Thời trang -->
                                    <?php
                                    $is_access = true;
                                    $active = "";
                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('shop', 'man', 'dien-tu')) {
                                        $is_access = false;
                                    }

                                    /* Check active */
                                    if (($com == 'shop') && (!empty($_GET['id_list'])) && ($_GET['id_list'] == 20)) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=shop&act=man" title="Thời trang">
                                                <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p>Danh sách gian hàng</p>
                                            </a>
                                        </li>
                                    <?php } ?>
                        
                                <?php } ?>

                                <!-- <?= $config['store']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('store', 'man', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'store') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=store&act=man" title="<?= $config['store']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['store']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['static']['tim-hieu-gian-hang']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('update');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('static', 'update', 'tim-hieu-gian-hang')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'static') && ($type == 'tim-hieu-gian-hang') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=tim-hieu-gian-hang" title="<?= $config['static']['tim-hieu-gian-hang']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['static']['tim-hieu-gian-hang']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['static']['hoan-tat-gian-hang']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('update');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('static', 'update', 'hoan-tat-gian-hang')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'static') && ($type == 'hoan-tat-gian-hang') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=hoan-tat-gian-hang" title="<?= $config['static']['hoan-tat-gian-hang']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['static']['hoan-tat-gian-hang']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['sample']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('update');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('sample', 'update', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'sample') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=sample&act=update&id_interface=1" title="<?= $config['sample']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['sample']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Posting -->
                <?php if (!empty($config['product'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('product')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'product' || $com == 'comment') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý tin đăng">
                                <i class="nav-icon text-sm fas fa-boxes"></i>
                                <p>Quản lý tin đăng<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                            
                                <!-- <?= $config['product']['title_main_cat'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_cat', 'add_cat', 'edit_cat');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_cat', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_cat" title="<?= $config['product']['title_main_cat'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['product']['title_main_cat'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['product']['title_main_item'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_item', 'add_item', 'edit_item');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_item', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_item" title="<?= $config['product']['title_main_item'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['product']['title_main_item'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['product']['title_main_sub'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_sub', 'add_sub', 'edit_sub');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_sub', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_sub" title="<?= $config['product']['title_main_sub'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['product']['title_main_sub'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['product']['title_main_tags'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_tags', 'add_tags', 'edit_tags');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_tags', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_tags" title="<?= $config['product']['title_main_tags'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['product']['title_main_tags'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- Danh mục màu sắc -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_color', 'add_color', 'edit_color');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_color', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_color" title="Danh mục màu sắc">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Danh mục màu sắc</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- Danh mục kích cỡ -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_size', 'add_size', 'edit_size');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('product', 'man_size', '')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_size" title="Danh mục kích cỡ">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Danh mục kích cỡ</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['product']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $menuopen = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('product', 'man', 'bat-dong-san, xay-dung, ung-vien, nha-tuyen-dung, xe-co, dien-tu, thoi-trang')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'product' || $com == 'comment') && (in_array($act, $array_act))) {
                                    $active = 'active';
                                    $menuopen = 'menu-open';
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                 
                                            <!-- Thời trang -->
                                            <?php
                                            $is_access = true;
                                            $active = "";

                                            /* Check access */
                                            if (!empty($is_permission) && !$func->checkAccess('product', 'man', 'dien-tu')) {
                                                $is_access = false;
                                            }

                                            /* Check active */
                                            if (($com == 'product' || $com == 'comment') && (in_array($act, $array_act)) && (!empty($_GET['id_list'])) && ($_GET['id_list'] == 20)) {
                                                $active = "active";
                                            }
                                            ?>
                                            <?php if ($is_access) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man" title="Thời trang">
                                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                        <p>Danh sách tin đăng</p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                     
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Variations -->
                <?php if (!empty($config['variation'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('variation')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'variation') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý biến thể">
                                <i class="nav-icon text-sm fas fa-filter"></i>
                                <p>Quản lý biến thể<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <?= $config['variation']['loai-gia']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('variation', 'man', 'loai-gia')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'variation') && ($_GET['type'] == 'loai-gia')) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=variation&act=man&type=loai-gia" title="<?= $config['variation']['loai-gia']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['variation']['loai-gia']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['variation']['muc-gia']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('variation', 'man', 'muc-gia')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'variation') && ($_GET['type'] == 'muc-gia')) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=variation&act=man&type=muc-gia" title="<?= $config['variation']['muc-gia']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['variation']['muc-gia']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['variation']['thoi-gian-dang-tin']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('variation', 'man', 'thoi-gian-dang-tin')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'variation') && ($_GET['type'] == 'thoi-gian-dang-tin')) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=variation&act=man&type=thoi-gian-dang-tin" title="<?= $config['variation']['thoi-gian-dang-tin']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['variation']['thoi-gian-dang-tin']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['variation']['thuoc-tinh-dong']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('variation', 'man', 'thuoc-tinh-dong')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'variation') && ($_GET['type'] == 'thuoc-tinh-dong')) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=variation&act=man&type=thuoc-tinh-dong" title="<?= $config['variation']['thuoc-tinh-dong']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['variation']['thuoc-tinh-dong']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Report -->
                <?php if (!empty($config['report'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('report')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'report') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý báo xấu">
                                <i class="nav-icon text-sm fas fa-bug"></i>
                                <p>Quản lý báo xấu<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- Report status -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('report', 'man', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if ($com == 'report' && in_array($act, $array_act)) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=report&act=man" title="Tình trạng">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Tình trạng</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- Report posting -->
                                <?php
                                $active = "";
                                $menuopen = "";
                                $is_access = true;
                                $array_act = array('man_report_posting', 'edit_report_posting');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('report', 'man_report_posting', 'bat-dong-san, xay-dung, ung-vien, nha-tuyen-dung, xe-co, dien-tu', 'thoi-trang')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'report') && (in_array($act, $array_act))) {
                                    $active = 'active';
                                    $menuopen = 'menu-open';
                                }
                                ?>
                                <?php if ($is_access) { ?>
                               
                                            <!-- Thời trang -->
                                            <?php
                                            $is_access = true;
                                            $active = "";

                                            /* Check access */
                                            if (!empty($is_permission) && !$func->checkAccess('report', 'man_report_posting', 'dien-tu')) {
                                                $is_access = false;
                                            }

                                            /* Check active */
                                            if (($com == 'report') && (in_array($act, $array_act)) && (!empty($_GET['id_list'])) && ($_GET['id_list'] == 20)) {
                                                $active = "active";
                                            }
                                            ?>
                                            <?php if ($is_access) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?= $active ?>" href="index.php?com=report&act=man_report_posting" title="Thời trang">
                                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                        <p>Tin đăng</p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                    
                                <?php } ?>

                                <!-- Report shop -->
                                <?php
                                $active = "";
                                $menuopen = "";
                                $is_access = true;
                                $array_act = array('man_report_shop', 'edit_report_shop');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('report', 'man_report_shop', 'bat-dong-san, xay-dung, xe-co, dien-tu, thoi-trang')) {
                                    $is_access = false;
                                }

                                /* Check active */
                                if (($com == 'report') && (in_array($act, $array_act))) {
                                    $active = 'active';
                                    $menuopen = 'menu-open';
                                }
                                ?>
                                <?php if ($is_access) { ?>
                          
                                            <!-- Thời trang -->
                                            <?php
                                            $is_access = true;
                                            $active = "";

                                            /* Check access */
                                            if (!empty($is_permission) && !$func->checkAccess('report', 'man_report_shop', 'dien-tu')) {
                                                $is_access = false;
                                            }

                                            /* Check active */
                                            if (($com == 'report') && (in_array($act, $array_act)) && (!empty($_GET['id_list'])) && ($_GET['id_list'] == 20)) {
                                                $active = "active";
                                            }
                                            ?>
                                            <?php if ($is_access) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?= $active ?>" href="index.php?com=report&act=man_report_shop" title="Thời trang">
                                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                        <p>Gian hàng</p>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                    
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Order -->
                <?php
                $active = "";
                $is_access = true;

                /* Check access */
                if (!empty($is_permission) && !$func->checkAccessGroup('order')) {
                    $is_access = false;
                }

                /* Check active */
                if ($com == 'order') {
                    $active = 'active';
                }
                ?>
                <?php if ($is_access) { ?>
                    <li class="nav-item <?= $active ?>">
                        <a class="nav-link <?= $active ?>" href="index.php?com=order&act=man" title="Quản lý đơn hàng">
                            <i class="nav-icon text-sm fas fa-shopping-bag"></i>
                            <p>Quản lý đơn hàng</p>
                        </a>
                    </li>
                <?php } ?>

                <!-- Newsletter -->
                <?php if (!empty($config['newsletter'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('newsletter')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'newsletter') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý nhận tin">
                                <i class="nav-icon text-sm fas fa-envelope"></i>
                                <p>
                                    Quản lý nhận tin
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <?= $config['newsletter']['phan-hoi']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('newsletter', 'man', 'phan-hoi')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'newsletter') && ($type == 'phan-hoi') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=newsletter&act=man&type=phan-hoi" title="<?= $config['newsletter']['phan-hoi']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['newsletter']['phan-hoi']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- News -->
                <?php if (!empty($config['news'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $array_static_type = array('gioi-thieu', 'lien-he');
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('news')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if (($com == 'news') || (($com == 'static') && in_array($_GET['type'], $array_static_type))) {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý bài viết">
                                <i class="nav-icon text-sm far fa-newspaper"></i>
                                <p>
                                    Quản lý bài viết
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <?= $config['static']['gioi-thieu']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('update');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('static', 'update', 'gioi-thieu')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'static') && ($type == 'gioi-thieu') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=gioi-thieu" title="<?= $config['static']['gioi-thieu']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['static']['gioi-thieu']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['static']['lien-he']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('update');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('static', 'update', 'lien-he')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'static') && ($type == 'lien-he') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=lien-he" title="<?= $config['static']['lien-he']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['static']['lien-he']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['news']['thong-bao']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('news', 'man', 'thong-bao')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'news') && ($type == 'thong-bao') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=thong-bao" title="<?= $config['news']['thong-bao']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['news']['thong-bao']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['news']['tuyen-dung']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('news', 'man', 'tuyen-dung')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'news') && ($type == 'tuyen-dung') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=tuyen-dung" title="<?= $config['news']['tuyen-dung']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['news']['tuyen-dung']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['news']['chinh-sach-ho-tro']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('news', 'man', 'chinh-sach-ho-tro')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'news') && ($type == 'chinh-sach-ho-tro') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=chinh-sach-ho-tro" title="<?= $config['news']['chinh-sach-ho-tro']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['news']['chinh-sach-ho-tro']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['news']['ho-tro-thanh-toan']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('news', 'man', 'ho-tro-thanh-toan')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'news') && ($type == 'ho-tro-thanh-toan') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=ho-tro-thanh-toan" title="<?= $config['news']['ho-tro-thanh-toan']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['news']['ho-tro-thanh-toan']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- <?= $config['news']['hinh-thuc-thanh-toan']['title_main'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man', 'add', 'edit');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('news', 'man', 'hinh-thuc-thanh-toan')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'news') && ($type == 'hinh-thuc-thanh-toan') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=hinh-thuc-thanh-toan" title="<?= $config['news']['hinh-thuc-thanh-toan']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['news']['hinh-thuc-thanh-toan']['title_main'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Photo -->
                <?php if (!empty($config['photo'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('photo')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'photo') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý hình ảnh">
                                <i class="nav-icon text-sm fas fa-photo-video"></i>
                                <p>
                                    Quản lý hình ảnh
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('photo', 'photo_static', 'logo,favicon,bo-cong-thuong')) {
                                    $is_access = false;
                                }
                                ?>

                                <?php if ($is_access && !empty($config['photo']['photo_static'])) { ?>
                                    <!-- <?= $config['photo']['photo_static']['logo']['title_main'] ?> -->
                                    <?php
                                    $active = "";
                                    $is_access = true;
                                    $array_act = array('photo_static');

                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('photo', 'photo_static', 'logo')) {
                                        $is_access = false;
                                    }

                                    /* check active */
                                    if (($com == 'photo') && ($_GET['type'] == 'logo') && (in_array($act, $array_act))) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=logo" title="<?= $config['photo']['photo_static']['logo']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p><?= $config['photo']['photo_static']['logo']['title_main'] ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <!-- <?= $config['photo']['photo_static']['favicon']['title_main'] ?> -->
                                    <?php
                                    $active = "";
                                    $is_access = true;
                                    $array_act = array('photo_static');

                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('photo', 'photo_static', 'favicon')) {
                                        $is_access = false;
                                    }

                                    /* check active */
                                    if (($com == 'photo') && ($_GET['type'] == 'favicon') && (in_array($act, $array_act))) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=favicon" title="<?= $config['photo']['photo_static']['favicon']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p><?= $config['photo']['photo_static']['favicon']['title_main'] ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <!-- <?= $config['photo']['photo_static']['bo-cong-thuong']['title_main'] ?> -->
                                    <?php
                                    $active = "";
                                    $is_access = true;
                                    $array_act = array('photo_static');

                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('photo', 'photo_static', 'bo-cong-thuong')) {
                                        $is_access = false;
                                    }

                                    /* check active */
                                    if (($com == 'photo') && ($_GET['type'] == 'bo-cong-thuong') && (in_array($act, $array_act))) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=bo-cong-thuong" title="<?= $config['photo']['photo_static']['bo-cong-thuong']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p><?= $config['photo']['photo_static']['bo-cong-thuong']['title_main'] ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccessBlock('photo', 'man_photo', 'social, advertise-home')) {
                                    $is_access = false;
                                }
                                ?>

                                <?php if ($is_access && !empty($config['photo']['man_photo'])) { ?>
                                    <!-- <?= $config['photo']['man_photo']['social']['title_main_photo'] ?> -->
                                    <?php
                                    $active = "";
                                    $is_access = true;
                                    $array_act = array('man_photo', 'add_photo', 'edit_photo');

                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('photo', 'man_photo', 'social')) {
                                        $is_access = false;
                                    }

                                    /* check active */
                                    if (($com == 'photo') && ($_GET['type'] == 'social') && (in_array($act, $array_act))) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=man_photo&type=social" title="<?= $config['photo']['man_photo']['social']['title_main_photo'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p><?= $config['photo']['man_photo']['social']['title_main_photo'] ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>

                                <?php } ?>


                                    <!-- <?= $config['photo']['man_photo']['advertise-home']['title_main_photo'] ?> -->
                                    <?php
                                    $active = "";
                                    $is_access = true;
                                    $array_act = array('man_photo', 'add_photo', 'edit_photo');

                                    /* Check access */
                                    if (!empty($is_permission) && !$func->checkAccess('photo', 'man_photo', 'advertise-home')) {
                                        $is_access = false;
                                    }

                                    /* check active */
                                    if (($com == 'photo') && ($_GET['type'] == 'advertise-home') && (in_array($act, $array_act))) {
                                        $active = "active";
                                    }
                                    ?>
                                    <?php if ($is_access) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=man_photo&type=advertise-home" title="<?= $config['photo']['man_photo']['advertise-home']['title_main_photo'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                                <p><?= $config['photo']['man_photo']['advertise-home']['title_main_photo'] ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Places -->
                <?php if (!empty($config['places']['active'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('place')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'places') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý địa điểm">
                                <i class="nav-icon text-sm fas fa-building"></i>
                                <p>
                                    Quản lý địa điểm
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- Region -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_region', 'add_region', 'edit_region');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('places', 'man_region', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'places') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=places&act=man_region" title="Vùng miền"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Vùng miền</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- City -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_city', 'add_city', 'edit_city');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('places', 'man_city', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'places') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=places&act=man_city" title="Tỉnh thành"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Tỉnh thành</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- District -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_district', 'add_district', 'edit_district');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('places', 'man_district', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'places') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=places&act=man_district" title="Quận huyện"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Quận huyện</p>
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- Wards -->
                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_wards', 'add_wards', 'edit_wards');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('places', 'man_wards', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'places') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=places&act=man_wards" title="Phường xã"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Phường xã</p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- SEO page -->
                <?php if (!empty($config['seopage'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('seopage')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if ($com == 'seopage') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý SEO page">
                                <i class="nav-icon text-sm fas fa-share-alt"></i>
                                <p>
                                    Quản lý SEO page
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <?= $config['seopage']['page']['thong-bao'] ?> -->
                                <?php
                                $active = "";
                                $is_access = true;

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('seopage', 'update', 'thong-bao')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if (($com == 'seopage') && ($_GET['type'] == 'thong-bao')) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=seopage&act=update&type=thong-bao" title="<?= $config['seopage']['page']['thong-bao'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['seopage']['page']['thong-bao'] ?></p>
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- User -->
                <?php if (!empty($config['user']['active'])) { ?>
                    <?php
                    $none = "";
                    $active = "";
                    $menuopen = "";
                    $array_static_type = array('dieu-khoan');
                    $array_anti_act = array('login', 'logout', 'info_admin');
                    $is_access = true;

                    /* Check access */
                    if (!empty($is_permission) && !$func->checkAccessGroup('user') && !$func->getGroup('loggedByLeader')) {
                        $is_access = false;
                    }

                    /* Check active */
                    if (($com == 'user' && !in_array($act, $array_anti_act)) || (($com == 'static') && in_array($_GET['type'], $array_static_type))) {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <?php if ($is_access) { ?>
                        <li class="nav-item has-treeview <?= $menuopen ?> <?= $none ?>">
                            <a class="nav-link <?= $active ?>" href="#" title="Quản lý user">
                                <i class="nav-icon text-sm fas fa-users"></i>
                                <p>
                                    Quản lý user
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (!$func->checkRole()) { ?>
                                    <!-- <?= $config['static']['dieu-khoan']['title_main'] ?> -->
                                    <?php
                                    $active = "";
                                    $array_act = array('update');
                                    if (($com == 'static') && ($type == 'dieu-khoan') && (in_array($act, $array_act))) $active = "active";
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=dieu-khoan" title="<?= $config['static']['dieu-khoan']['title_main'] ?>">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p><?= $config['static']['dieu-khoan']['title_main'] ?></p>
                                        </a>
                                    </li>

                                    <?php
                                    $active = "";
                                    $array_act = array('man_group', 'add_group', 'edit_group');
                                    if (in_array($act, $array_act)) $active = "active";
                                    ?>
                                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="index.php?com=user&act=man_group" title="Nhóm admin"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Nhóm admin</p>
                                        </a></li>
                                <?php } ?>

                                <?php if ((!$func->checkRole() || $func->getGroup('loggedByLeader')) && !$func->getGroup('virtual')) {
                                    $active = "";
                                    $array_act = array('man_admin', 'add_admin', 'edit_admin', 'add_admin_perms');
                                    if (in_array($act, $array_act)) $active = "active"; ?>
                                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="index.php?com=user&act=man_admin" title="Tài khoản admin"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Tài khoản admin</p>
                                        </a></li>
                                <?php } ?>

                                <?php if (!$func->checkRole() || ($func->getGroup('loggedByLeader') && $func->getGroup('virtual'))) {
                                    $active = "";
                                    $array_act = array('man_admin_virtual', 'add_admin_virtual', 'edit_admin_virtual');
                                    if (in_array($act, $array_act)) $active = "active"; ?>
                                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="index.php?com=user&act=man_admin_virtual" title="Tài khoản admin ảo"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Tài khoản admin ảo</p>
                                        </a></li>
                                <?php } ?>

                                <?php
                                $active = "";
                                $is_access = true;
                                $array_act = array('man_member', 'add_member', 'edit_member');

                                /* Check access */
                                if (!empty($is_permission) && !$func->checkAccess('user', 'man_member', '')) {
                                    $is_access = false;
                                }

                                /* check active */
                                if ($com == 'user' && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <?php if ($is_access) { ?>
                                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="index.php?com=user&act=man_member" title="Tài khoản khách"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Tài khoản khách</p>
                                        </a></li>
                                <?php } ?>

                                <?php if (!$func->checkRole()) {
                                    $active = "";
                                    $array_act = array('update_member_dashboard');
                                    if ($com == 'user' && (in_array($act, $array_act))) $active = "active"; ?>
                                    <li class="nav-item"><a class="nav-link <?= $active ?>" href="index.php?com=user&act=update_member_dashboard" title="Thông báo cá nhân"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>Thông báo cá nhân</p>
                                        </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                <?php }
                } ?>

                <!-- Thiết lập thông tin -->
                <?php
                $active = "";
                $is_access = true;

                /* Check access */
                if (!empty($is_permission) && !$func->checkAccessGroup('setting')) {
                    $is_access = false;
                }

                /* Check active */
                if ($com == 'setting') {
                    $active = 'active';
                }
                ?>
                <?php if ($is_access) { ?>
                    <li class="nav-item <?= $active ?>">
                        <a class="nav-link <?= $active ?>" href="index.php?com=setting&act=update" title="Thiết lập thông tin">
                            <i class="nav-icon text-sm fas fa-cogs"></i>
                            <p>Thiết lập thông tin</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>