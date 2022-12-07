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

                <!-- Posting -->
                <?php if (!empty($config['product'])) { ?>
                    <?php
                    $active = "";
                    $menuopen = "";

                    /* Check active */
                    if ($com == 'product') {
                        $active = 'active';
                        $menuopen = 'menu-open';
                    }
                    ?>
                    <li class="nav-item has-treeview <?= $menuopen ?>">
                        <a class="nav-link <?= $active ?>" href="#" title="Quản lý tin đăng">
                            <i class="nav-icon text-sm fas fa-boxes"></i>
                            <p>Quản lý tin đăng<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <?= $config['product']['title_main_item'] ?> -->
                            <?php
                            $active = "";
                            $array_act = array('man_item', 'add_item', 'edit_item');

                            /* Check active */
                            if (($com == 'product') && (in_array($act, $array_act))) {
                                $active = "active";
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_item" title="<?= $config['product']['title_main_item'] ?>">
                                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                    <p><?= $config['product']['title_main_item'] ?></p>
                                </a>
                            </li>

                            <!-- <?= $config['product']['title_main_sub'] ?> -->
                            <?php
                            $active = "";
                            $array_act = array('man_sub', 'add_sub', 'edit_sub');

                            /* Check active */
                            if (($com == 'product') && (in_array($act, $array_act))) {
                                $active = "active";
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_sub" title="<?= $config['product']['title_main_sub'] ?>">
                                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                    <p><?= $config['product']['title_main_sub'] ?></p>
                                </a>
                            </li>

                            <?php if ($func->hasCart($sector)) { ?>
                                <!-- Danh mục màu sắc -->
                                <?php
                                $active = "";
                                $array_act = array('man_color', 'add_color', 'edit_color');

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man_color" title="Danh mục màu sắc">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>Danh mục màu sắc</p>
                                    </a>
                                </li>

                                <!-- Danh mục kích cỡ -->
                                <?php
                                $active = "";
                                $array_act = array('man_size', 'add_size', 'edit_size');

                                /* Check active */
                                if (($com == 'product') && (in_array($act, $array_act))) {
                                    $active = "active";
                                }
                                ?>
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
                            $array_act = array('man', 'add', 'edit');

                            /* Check active */
                            if (($com == 'product') && (in_array($act, $array_act))) {
                                $active = 'active';
                                $menuopen = 'menu-open';
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $active ?>" href="index.php?com=product&act=man" title="<?= $config['product']['title_main'] ?>">
                                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                    <p><?= $config['product']['title_main'] ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Order -->
                <?php if ($func->hasCart($sector)) { ?>
                    <?php
                    $active = "";

                    /* Check active */
                    if ($com == 'order') {
                        $active = 'active';
                    }
                    ?>
                    <li class="nav-item <?= $active ?>">
                        <a class="nav-link <?= $active ?>" href="index.php?com=order&act=man" title="Quản lý đơn hàng">
                            <i class="nav-icon text-sm fas fa-shopping-bag"></i>
                            <p>Quản lý đơn hàng</p>
                        </a>
                    </li>
                <?php } ?>

                <!-- Chat -->
                <?php
                $active = "";

                /* Check active */
                if ($com == 'chat') {
                    $active = 'active';
                }
                ?>
                <li class="nav-item <?= $active ?>">
                    <a class="nav-link <?= $active ?>" href="index.php?com=chat&act=man" title="Quản lý trò chuyện">
                        <i class="nav-icon text-sm fas fa-comment-dots"></i>
                        <p>Quản lý trò chuyện</p>
                    </a>
                </li>

                <!-- Menu by interface -->
                <?php require_once TEMPLATE . 'layout/menu/menu-' . INTERFACE_SHOP . '.php'; ?>

                <!-- Thiết lập thông tin -->
                <?php
                $active = "";

                /* Check active */
                if ($com == 'setting') {
                    $active = 'active';
                }
                ?>
                <li class="nav-item <?= $active ?>">
                    <a class="nav-link <?= $active ?>" href="index.php?com=setting&act=update" title="Thiết lập thông tin">
                        <i class="nav-icon text-sm fas fa-cogs"></i>
                        <p>Thiết lập thông tin</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>