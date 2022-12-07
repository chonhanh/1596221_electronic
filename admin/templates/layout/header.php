<?php
/* Permissions */
$wherePerms = '';

/* Lọc cấp 2 theo Group */
if ($func->getGroup('active')) {
    $idCatByGroup = $func->getGroup('cat');

    if (!empty($idCatByGroup)) {
        $idcat = (!empty($idCatByGroup)) ? implode(',', $idCatByGroup) : '';
        $wherePerms .= " and id_cat in ($idcat)";
    }
}

/* Lọc place theo Group */
if ($func->getGroup('active') && empty($_REQUEST['id_region']) && empty($_REQUEST['id_city'])) {
    $idregion = $func->getGroup('regions');
    $idcity = $func->getGroup('citys');

    $wherePerms .= ' and id_region in (' . $func->getGroup('regions') . ') and id_city in (' . $func->getGroup('citys') . ')';
}

/* Notify variables */
$countNotify = array();

/* Contact */
$contactNotify = $d->rawQuery("select id from #_contact where id_shop = $idShop and status = ''");
$countNotify['contact'] = count($contactNotify);
$countNotify['total'] = $countNotify['contact'];

/* Check access shop */
$is_access_shop = true;
if (!empty($is_permission) && !$func->checkAccessBlock('shop', 'man',$config['website']['sectors'])) {
    $is_access_shop = false;
}

if ($is_access_shop) {
    $is_access_shop_types = array();

    foreach ($defineSectors['hasShop']['types'] as $v) {
        $is_access_shop_types[$v] = (!empty($is_permission) && !$func->checkAccess('shop', 'man', $v) && $func->hasShop($defineSectors['types'][$v])) ? false : true;
    }

    if (!empty($is_access_shop_types)) {
        $shopNotify = array();
        $countNotify['shop'] = array();
        $countNotify['shop']['total'] = 0;

        foreach ($is_access_shop_types as $k => $v) {
            if ($v) {
                $tableShop = $defineSectors['types'][$k]['tables']['shop'];
                $shopNotify[$k]['data'] = $d->rawQuery("select id from #_$tableShop where status = '' $wherePerms");
                $shopNotify[$k]['name_list'] = $defineSectors['types'][$k]['name'];
                $shopNotify[$k]['id_list'] = $defineSectors['types'][$k]['id'];
                $countNotify['shop'][$k] = count($shopNotify[$k]['data']);
                $countNotify['shop']['total'] += $countNotify['shop'][$k];
            }
        }
    }
}

/* Check access product */
$is_access_product = true;
if (!empty($is_permission) && !$func->checkAccessBlock('product', 'man', $config['website']['sectors'])) {
    $is_access_product = false;
}

if ($is_access_product) {
    $is_access_product_types = array();

    foreach ($defineSectors['sectors']['types'] as $v) {
        $is_access_product_types[$v] = (!empty($is_permission) && !$func->checkAccess('product', 'man', $v)) ? false : true;
    }

    if (!empty($is_access_product_types)) {
        $productNotify = $commentNotify = array();
        $countNotify['posting'] = $countNotify['comment'] = array();
        $countNotify['posting']['total'] = $countNotify['comment']['total'] = 0;

        foreach ($is_access_product_types as $k => $v) {
            if ($v) {
                $tableProductMain = $defineSectors['types'][$k]['tables']['main'];
                $tableProductComment = (!empty($defineSectors['types'][$k]['tables']['comment'])) ? $defineSectors['types'][$k]['tables']['comment'] : '';
                $productNotify[$k]['data'] = $d->rawQuery("select id from #_$tableProductMain where status = '' $wherePerms");
                $productNotify[$k]['name_list'] = $defineSectors['types'][$k]['name'];
                $productNotify[$k]['id_list'] = $defineSectors['types'][$k]['id'];
                $countNotify['posting'][$k] = count($productNotify[$k]['data']);
                $countNotify['posting']['total'] += $countNotify['posting'][$k];

                /* Comment */
                if (!empty($tableProductComment)) {
                    $commentNotify[$k]['data'] = $d->rawQuery("select distinct id_product from #_$tableProductComment where find_in_set('new-admin',status)");
                    $commentNotify[$k]['name_list'] = $defineSectors['types'][$k]['name'];
                    $commentNotify[$k]['id_list'] = $defineSectors['types'][$k]['id'];
                    $countNotify['comment'][$k] = count($commentNotify[$k]['data']);
                    $countNotify['comment']['total'] += $countNotify['comment'][$k];
                }
            }
        }
    }
}

/* Check access report */
$is_access_report = true;
if (!empty($is_permission) && !$func->checkAccessBlock('report', 'man_report_posting', $config['website']['sectors'])) {
    $is_access_report = false;
}

if ($is_access_report) {
    $is_access_report_types = array();

    foreach ($defineSectors['sectors']['types'] as $v) {
        $is_access_report_types[$v] = (!empty($is_permission) && !$func->checkAccess('report', 'man_report_posting', $v)) ? false : true;
    }

    if (!empty($is_access_report_types)) {
        $reportNotify = array();
        $countNotify['report'] = array();
        $countNotify['report']['total'] = 0;

        foreach ($is_access_report_types as $k => $v) {
            if ($v) {
                $tableProductReport = $defineSectors['types'][$k]['tables']['report-product'];
                $reportNotify[$k]['data'] = $d->rawQuery("select id from #_$tableProductReport where status = 0");
                $reportNotify[$k]['name_list'] = $defineSectors['types'][$k]['name'];
                $reportNotify[$k]['id_list'] = $defineSectors['types'][$k]['id'];
                $countNotify['report'][$k] = count($reportNotify[$k]['data']);
                $countNotify['report']['total'] += $countNotify['report'][$k];
            }
        }
    }
}

/* Check access report shop */
$is_access_report_shop = true;
if (!empty($is_permission) && !$func->checkAccessBlock('report', 'man_report_shop', $config['website']['sectors'])) {
    $is_access_report_shop = false;
}

if ($is_access_report_shop) {
    $is_access_report_shop_types = array();

    foreach ($defineSectors['hasShop']['types'] as $v) {
        $is_access_report_shop_types[$v] = (!empty($is_permission) && !$func->checkAccess('report', 'man_report_shop', $v) && $func->hasShop($defineSectors['types'][$v])) ? false : true;
    }

    if (!empty($is_access_report_shop_types)) {
        $reportShopNotify = array();
        $countNotify['reportShop'] = array();
        $countNotify['reportShop']['total'] = 0;

        foreach ($is_access_report_shop_types as $k => $v) {
            if ($v) {
                $tableShopReport = $defineSectors['types'][$k]['tables']['report-shop'];
                $reportShopNotify[$k]['data'] = $d->rawQuery("select id from #_$tableShopReport where status = 0");
                $reportShopNotify[$k]['name_list'] = $defineSectors['types'][$k]['name'];
                $reportShopNotify[$k]['id_list'] = $defineSectors['types'][$k]['id'];
                $countNotify['reportShop'][$k] = count($reportShopNotify[$k]['data']);
                $countNotify['reportShop']['total'] += $countNotify['reportShop'][$k];
            }
        }
    }
}

/* Check access order */
$is_access_order = true;
if (!empty($is_permission) && !$func->checkAccessGroup('order')) {
    $is_access_order = false;
}

if ($is_access_order) {
    $orderNotify = $d->rawQuery("select id from #_order where order_status = 1");
    $countNotify['order'] = count($orderNotify);
    $countNotify['total'] += $countNotify['order'];
}

/* Check access newsletter */
$is_access_newsletter = true;
if (!empty($is_permission) && !$func->checkAccessGroup('newsletter')) {
    $is_access_newsletter = false;
}

if ($is_access_newsletter && !empty($config['newsletter'])) {
    foreach ($config['newsletter'] as $k => $v) {
        $emailNotify = $d->rawQuery("select id from #_newsletter where id_shop = $idShop and type = ? and status = ''", array($k));
        $countNotify['newsletter'][$k] = count($emailNotify);
        $countNotify['total'] += $countNotify['newsletter'][$k];
    }
}
?>
<!-- Header -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item nav-item-hello d-sm-inline-block">
            <a class="nav-link"><span class="text-split">Xin chào, <?= $_SESSION[$loginAdmin]['owner']['username'] ?>!</span></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications -->
        <li class="nav-item d-sm-inline-block">
            <a href="../" target="_blank" class="nav-link"><i class="fas fa-reply"></i></a>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu-info" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-cogs"></i></a>
            <ul aria-labelledby="dropdownSubMenu-info" class="dropdown-menu dropdown-menu-right border-0 shadow">
                <?php if ($config['website']['debug-developer'] && count($config['website']['lang']) >= 2) { ?>
                    <li>
                        <a href="index.php?com=lang&act=man" class="dropdown-item">
                            <i class="fas fa-language"></i>
                            <span>Quản lý ngôn ngữ</span>
                        </a>
                    </li>
                    <div class="dropdown-divider"></div>
                <?php } ?>
                <li>
                    <a href="index.php?com=user&act=info_admin" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Thông tin admin</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=user&act=info_admin&changepass=1" class="dropdown-item">
                        <i class="fas fa-key"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=setting&act=maintenance" class="dropdown-item">
                        <i class="fas fa-tools"></i>
                        <span>Tối ưu database</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=cache&act=delete" class="dropdown-item">
                        <i class="far fa-trash-alt"></i>
                        <span>Xóa bộ nhớ tạm</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php if ($is_access_shop && !empty($is_access_shop_types)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-store"></i>
                    <span class="badge badge-danger"><?= $countNotify['shop']['total'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" style="max-width:300px">
                    <span class="dropdown-item dropdown-header p-0">Gian hàng</span>
                    <?php foreach ($is_access_shop_types as $k => $v) {
                        if (!empty($shopNotify[$k])) { ?>
                            <div class="dropdown-divider"></div>
                            <a href="index.php?com=shop&act=man&id_list=<?= $shopNotify[$k]['id_list'] ?>&shop_status=new" class="dropdown-item"><span class="badge badge-danger mr-1"><?= $countNotify['shop'][$k] ?></span><?= $shopNotify[$k]['name_list'] ?></a>
                    <?php }
                    } ?>
                </div>
            </li>
        <?php } ?>
        <?php if ($is_access_product && !empty($is_access_product_types)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-boxes"></i>
                    <span class="badge badge-danger"><?= $countNotify['posting']['total'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" style="max-width:300px">
                    <span class="dropdown-item dropdown-header p-0">Tin đăng</span>
                    <?php foreach ($is_access_product_types as $k => $v) {
                        if (!empty($productNotify[$k])) { ?>
                            <div class="dropdown-divider"></div>
                            <a href="index.php?com=product&act=man&id_list=<?= $productNotify[$k]['id_list'] ?>&posting_status=new" class="dropdown-item"><span class="badge badge-danger mr-1"><?= $countNotify['posting'][$k] ?></span><?= $productNotify[$k]['name_list'] ?></a>
                    <?php }
                    } ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-comments"></i>
                    <span class="badge badge-danger"><?= $countNotify['comment']['total'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" style="max-width:300px">
                    <span class="dropdown-item dropdown-header p-0">Bình luận</span>
                    <?php foreach ($is_access_product_types as $k => $v) {
                        if (!empty($commentNotify[$k])) { ?>
                            <div class="dropdown-divider"></div>
                            <a href="index.php?com=product&act=man&id_list=<?= $commentNotify[$k]['id_list'] ?>&comment_status=new" class="dropdown-item"><span class="badge badge-danger mr-1"><?= $countNotify['comment'][$k] ?></span><?= $commentNotify[$k]['name_list'] ?></a>
                    <?php }
                    } ?>
                </div>
            </li>
        <?php } ?>
        <?php if (($is_access_report && !empty($is_access_report_types)) || ($is_access_report_shop && !empty($is_access_report_shop_types))) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bug"></i>
                    <span class="badge badge-danger"><?= $countNotify['report']['total'] + $countNotify['reportShop']['total'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow" style="max-width:300px">
                    <span class="dropdown-item dropdown-header p-0">Báo xấu</span>
                    <?php if ($is_access_report_shop) {
                        if (!empty($is_access_report_shop_types)) {
                            foreach ($is_access_report_shop_types as $k => $v) {
                                if (!empty($reportShopNotify[$k])) { ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="index.php?com=report&act=man_report_shop&id_list=<?= $reportShopNotify[$k]['id_list'] ?>" class="dropdown-item"><span class="badge badge-danger mr-1"><?= $countNotify['reportShop'][$k] ?></span><span class="text-success">Shop - <?= $reportShopNotify[$k]['name_list'] ?></span></a>
                    <?php }
                            }
                        }
                    } ?>
                    <?php if ($is_access_report) {
                        if (!empty($is_access_report_types)) {
                            foreach ($is_access_report_types as $k => $v) {
                                if (!empty($reportNotify[$k])) { ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="index.php?com=report&act=man_report_posting&id_list=<?= $reportNotify[$k]['id_list'] ?>" class="dropdown-item"><span class="badge badge-danger mr-1"><?= $countNotify['report'][$k] ?></span><span class="text-primary">Tin đăng - <?= $reportNotify[$k]['name_list'] ?></span></a>
                    <?php }
                            }
                        }
                    } ?>
                </div>
            </li>
        <?php } ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger"><?= $countNotify['total'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow" style="max-width:300px">
                <span class="dropdown-item dropdown-header p-0">Thông báo</span>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=contact&act=man" class="dropdown-item"><i class="fas fa-envelope mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['contact'] ?></span> Liên hệ</a>
                <?php if (!empty($is_access_order)) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="index.php?com=order&act=man" class="dropdown-item"><i class="fas fa-shopping-bag mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['order'] ?></span> Đơn hàng</a>
                <?php } ?>
                <?php if (!empty($is_access_newsletter) && isset($config['newsletter'])) { ?>
                    <div class="dropdown-divider"></div>
                    <?php foreach ($config['newsletter'] as $k => $v) { ?>
                        <a href="index.php?com=newsletter&act=man&type=<?= $k ?>" class="dropdown-item"><i class="fas fa-mail-bulk mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['newsletter'][$k] ?></span> <?= $v['title_main'] ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a href="index.php?com=user&act=logout" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất</a>
        </li>
    </ul>
</nav>