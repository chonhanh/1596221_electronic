<!-- Newsletter -->
<?php if (!empty($config['newsletter'])) { ?>
    <?php
    $active = "";
    $menuopen = "";

    /* Check active */
    if ($com == 'newsletter') {
        $active = 'active';
        $menuopen = 'menu-open';
    }
    ?>
    <li class="nav-item has-treeview <?= $menuopen ?>">
        <a class="nav-link <?= $active ?>" href="#" title="Quản lý nhận tin">
            <i class="nav-icon text-sm fas fa-envelope"></i>
            <p>
                Quản lý nhận tin
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <!-- <?= $config['newsletter']['dang-ky-hen']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('man', 'add', 'edit');

            /* check active */
            if (($com == 'newsletter') && ($type == 'dang-ky-hen') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=newsletter&act=man&type=dang-ky-hen" title="<?= $config['newsletter']['dang-ky-hen']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['newsletter']['dang-ky-hen']['title_main'] ?></p>
                </a>
            </li>

            <!-- <?= $config['newsletter']['dang-ky-nhan-tin']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('man', 'add', 'edit');

            /* check active */
            if (($com == 'newsletter') && ($type == 'dang-ky-nhan-tin') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=newsletter&act=man&type=dang-ky-nhan-tin" title="<?= $config['newsletter']['dang-ky-nhan-tin']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['newsletter']['dang-ky-nhan-tin']['title_main'] ?></p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>

<!-- News -->
<?php if (!empty($config['news'])) { ?>
    <?php
    $active = "";
    $menuopen = "";
    $array_static_type = array('gioi-thieu', 'lien-he', 'footer');

    /* Check active */
    if (($com == 'news') || (($com == 'static') && in_array($_GET['type'], $array_static_type))) {
        $active = 'active';
        $menuopen = 'menu-open';
    }
    ?>
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
            $array_act = array('update');

            /* check active */
            if (($com == 'static') && ($type == 'gioi-thieu') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=gioi-thieu" title="<?= $config['static']['gioi-thieu']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['static']['gioi-thieu']['title_main'] ?></p>
                </a>
            </li>

            <!-- <?= $config['static']['lien-he']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('update');

            /* check active */
            if (($com == 'static') && ($type == 'lien-he') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=lien-he" title="<?= $config['static']['lien-he']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['static']['lien-he']['title_main'] ?></p>
                </a>
            </li>

            <!-- <?= $config['static']['footer']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('update');

            /* check active */
            if (($com == 'static') && ($type == 'footer') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=static&act=update&type=footer" title="<?= $config['static']['footer']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['static']['footer']['title_main'] ?></p>
                </a>
            </li>

            <!-- <?= $config['news']['tin-tuc']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('man', 'add', 'edit');

            /* check active */
            if (($com == 'news') && ($type == 'tin-tuc') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=tin-tuc" title="<?= $config['news']['tin-tuc']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['news']['tin-tuc']['title_main'] ?></p>
                </a>
            </li>

            <!-- <?= $config['news']['thong-bao']['title_main'] ?> -->
            <?php
            $active = "";
            $array_act = array('man', 'add', 'edit');

            /* check active */
            if (($com == 'news') && ($type == 'thong-bao') && (in_array($act, $array_act))) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=news&act=man&type=thong-bao" title="<?= $config['news']['thong-bao']['title_main'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['news']['thong-bao']['title_main'] ?></p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>

<!-- Photo -->
<?php if (!empty($config['photo'])) { ?>
    <?php
    $active = "";
    $menuopen = "";

    /* Check active */
    if ($com == 'photo') {
        $active = 'active';
        $menuopen = 'menu-open';
    }
    ?>
    <li class="nav-item has-treeview <?= $menuopen ?>">
        <a class="nav-link <?= $active ?>" href="#" title="Quản lý hình ảnh">
            <i class="nav-icon text-sm fas fa-photo-video"></i>
            <p>
                Quản lý hình ảnh
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php if (!empty($config['photo']['photo_static'])) { ?>
                <!-- <?= $config['photo']['photo_static']['header']['title_main'] ?> -->
                <?php
                $active = "";
                $array_act = array('photo_static');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'header') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=header" title="<?= $config['photo']['photo_static']['header']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['photo_static']['header']['title_main'] ?></p>
                    </a>
                </li>

                <!-- <?= $config['photo']['photo_static']['logo']['title_main'] ?> -->
                <?php
                $active = "";
                $array_act = array('photo_static');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'logo') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=logo" title="<?= $config['photo']['photo_static']['logo']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['photo_static']['logo']['title_main'] ?></p>
                    </a>
                </li>

                <!-- <?= $config['photo']['photo_static']['banner']['title_main'] ?> -->
                <?php
                $active = "";
                $array_act = array('photo_static');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'banner') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=banner" title="<?= $config['photo']['photo_static']['banner']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['photo_static']['banner']['title_main'] ?></p>
                    </a>
                </li>

                <!-- <?= $config['photo']['photo_static']['favicon']['title_main'] ?> -->
                <?php
                $active = "";
                $array_act = array('photo_static');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'favicon') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=photo_static&type=favicon" title="<?= $config['photo']['photo_static']['favicon']['title_main'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['photo_static']['favicon']['title_main'] ?></p>
                    </a>
                </li>
            <?php } ?>

            <?php if (!empty($config['photo']['man_photo'])) { ?>
                <!-- <?= $config['photo']['man_photo']['slideshow']['title_main_photo'] ?> -->
                <?php
                $active = "";
                $array_act = array('man_photo', 'add_photo', 'edit_photo');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'slideshow') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=man_photo&type=slideshow" title="<?= $config['photo']['man_photo']['slideshow']['title_main_photo'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['man_photo']['slideshow']['title_main_photo'] ?></p>
                    </a>
                </li>

                <!-- <?= $config['photo']['man_photo']['social']['title_main_photo'] ?> -->
                <?php
                $active = "";
                $array_act = array('man_photo', 'add_photo', 'edit_photo');

                /* check active */
                if (($com == 'photo') && ($_GET['type'] == 'social') && (in_array($act, $array_act))) {
                    $active = "active";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active ?>" href="index.php?com=photo&act=man_photo&type=social" title="<?= $config['photo']['man_photo']['social']['title_main_photo'] ?>"><i class="nav-icon text-sm far fa-caret-square-right"></i>
                        <p><?= $config['photo']['man_photo']['social']['title_main_photo'] ?></p>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>

<!-- SEO page -->
<?php if (!empty($config['seopage'])) { ?>
    <?php
    $active = "";
    $menuopen = "";

    /* Check active */
    if ($com == 'seopage') {
        $active = 'active';
        $menuopen = 'menu-open';
    }
    ?>
    <li class="nav-item has-treeview <?= $menuopen ?>">
        <a class="nav-link <?= $active ?>" href="#" title="Quản lý SEO page">
            <i class="nav-icon text-sm fas fa-share-alt"></i>
            <p>
                Quản lý SEO page
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <!-- <?= $config['seopage']['page']['nha-dat'] ?> -->
            <?php
            $active = "";

            /* check active */
            if (($com == 'seopage') && ($_GET['type'] == 'nha-dat')) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=seopage&act=update&type=nha-dat" title="<?= $config['seopage']['page']['nha-dat'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['seopage']['page']['nha-dat'] ?></p>
                </a>
            </li>

            <!-- <?= $config['seopage']['page']['tin-tuc'] ?> -->
            <?php
            $active = "";

            /* check active */
            if (($com == 'seopage') && ($_GET['type'] == 'tin-tuc')) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=seopage&act=update&type=tin-tuc" title="<?= $config['seopage']['page']['tin-tuc'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['seopage']['page']['tin-tuc'] ?></p>
                </a>
            </li>

            <!-- <?= $config['seopage']['page']['thong-bao'] ?> -->
            <?php
            $active = "";

            /* check active */
            if (($com == 'seopage') && ($_GET['type'] == 'thong-bao')) {
                $active = "active";
            }
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $active ?>" href="index.php?com=seopage&act=update&type=thong-bao" title="<?= $config['seopage']['page']['thong-bao'] ?>">
                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                    <p><?= $config['seopage']['page']['thong-bao'] ?></p>
                </a>
            </li>
        </ul>
    </li>
<?php } ?>