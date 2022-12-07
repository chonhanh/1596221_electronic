<?php
$countNotify = array();

/* Contact */
$contactNotify = $d->rawQuery("select id from #_contact where id_shop = $idShop and sector_prefix = ? and status = ''", array($prefixSector));
$countNotify['contact'] = count($contactNotify);
$countNotify['total'] = $countNotify['contact'];

/* Order */
if ($func->hasCart($sector)) {
    $orderNotify = $d->rawQuery("select id from #_order_group where id_shop = $idShop and order_status = 1");
    $countNotify['order'] = count($orderNotify);
    $countNotify['total'] += $countNotify['order'];
}

/* Check newsletter */
if (!empty($config['newsletter'])) {
    foreach ($config['newsletter'] as $k => $v) {
        $emailNotify = $d->rawQuery("select id from #_newsletter where id_shop = $idShop and sector_prefix = ? and type = ? and status = ''", array($prefixSector, $k));
        $countNotify['newsletter'][$k] = count($emailNotify);
        $countNotify['total'] += $countNotify['newsletter'][$k];
    }
}

/* Comment */
$commentNotify = $d->rawQuery("select id from #_$tableProductComment where id_shop = $idShop and find_in_set('new-shop',status) and find_in_set('hienthi',status)");
$countNotify['comment'] = count($commentNotify);
$countNotify['total'] += $countNotify['comment'];

/* Chat */
$chatNotify = $d->rawQuery("select id from #_$tableShopChat where id_shop = $idShop and find_in_set('new-shop',status)");
$countNotify['chat'] = count($chatNotify);
$countNotify['total'] += $countNotify['chat'];
?>
<!-- Header -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item nav-item-hello d-sm-inline-block">
            <a class="nav-link"><span class="text-split">Xin chào !</span></a>
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
                <li>
                    <a href="index.php?com=user&act=info" class="dropdown-item">
                        <i class="fas fa-store"></i>
                        <span>Thông tin gian hàng</span>
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
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger"><?= $countNotify['total'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow">
                <span class="dropdown-item dropdown-header p-0">Thông báo</span>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=contact&act=man" class="dropdown-item"><i class="fas fa-envelope mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['contact'] ?></span> Liên hệ</a>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=product&act=man&comment_status=new" class="dropdown-item"><i class="fas fa-comments mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['comment'] ?></span> Bình luận</a>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=chat&act=man&status=new" class="dropdown-item"><i class="fas fa-comment-dots mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['chat'] ?></span> Trò chuyện</a>
                <?php if ($func->hasCart($sector)) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="index.php?com=order&act=man" class="dropdown-item"><i class="fas fa-shopping-bag mr-2"></i><span class="badge badge-danger mr-1"><?= $countNotify['order'] ?></span> Đơn hàng</a>
                <?php } ?>
                <?php if (isset($config['newsletter'])) { ?>
                    <?php foreach ($config['newsletter'] as $k => $v) { ?>
                        <div class="dropdown-divider"></div>
                        <a href="index.php?com=newsletter&act=man&type=<?= $k ?>" class="dropdown-item"><i class="fas fa-mail-bulk mr-2"></i></i><span class="badge badge-danger mr-1"><?= $countNotify['newsletter'][$k] ?></span> <?= $v['title_main'] ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a href="index.php?com=user&act=logout" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất</a>
        </li>
    </ul>
</nav>