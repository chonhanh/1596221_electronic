<?php
$linkMan = $linkFilter = "index.php?com=product&act=man_item";
$linkAdd = "index.php?com=product&act=add_item";
$linkEdit = "index.php?com=product&act=edit_item";
$linkDelete = "index.php?com=product&act=delete_item";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $config['product']['title_main_item'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer form-group-category text-sm bg-light row">
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Lĩnh vực kinh doanh</label>
            <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Lĩnh vực" value="<?= $nameSectorList ?>" readonly>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block"><?=$config['product']['title_main_cat']?></label>
            <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Danh mục cấp 2" value="<?= $nameSectorCat ?>" readonly>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><?= $config['product']['title_main_item'] ?></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle">Hình</th>
                        <!-- <th class="align-middle">Hình 2</th> -->
                        <th class="align-middle" style="width:50%">Tiêu đề</th>
                        <?php if (isset($config['product']['check_shop_item'])) {
                            foreach ($config['product']['check_shop_item'] as $key => $value) { ?>
                                <th class="align-middle text-center"><?= $value ?></th>
                        <?php }
                        } ?>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) {
                            $linkID = "";
                            if ($items[$i]['id_list']) $linkID .= "&id_list=" . $items[$i]['id_list'];
                            if ($items[$i]['id_cat']) $linkID .= "&id_cat=" . $items[$i]['id_cat']; ?>
                            <tr>
                                <td class="align-middle">
                                    <img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/<?= $config['product']['thumb_item'] ?>/<?= UPLOAD_PRODUCT_THUMB . $items[$i]['photo'] ?>" alt="<?= $items[$i]['namevi'] ?>">
                                </td>
                                <?php /* ?>
                                <td class="align-middle">
                                    <img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?=THUMBS?>/<?=$config['product']['thumb2_item']?>/<?=UPLOAD_PRODUCT_THUMB.$items[$i]['photo2']?>" alt="<?=$items[$i]['namevi']?>">
                                </td>
                                <?php */ ?>
                                <td class="align-middle">
                                    <p class="mb-1"><?= $items[$i]['namevi'] ?></p>
                                    <?php if (empty($items[$i]['status']) || !strstr($items[$i]['status'], 'hienthi')) { ?>
                                        <a class="btn btn-sm btn-info text-white" title="Đang chờ duyệt">Đang chờ duyệt</a>
                                    <?php } ?>
                                </td>
                                <?php $status_array = (!empty($items[$i]['statusShop']) && !empty($items[$i]['statusShop'])) ? explode(',', $items[$i]['statusShop']) : array(); ?>
                                <?php if (isset($config['product']['check_shop_item'])) {
                                    foreach ($config['product']['check_shop_item'] as $key => $value) { ?>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input show-checkbox-shop" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="product_item_status" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                                <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                <?php }
                                } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
    </div>
</section>