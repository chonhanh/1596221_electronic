<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man";
if ($act == 'add') $linkFilter = "index.php?com=product&act=add";
else if ($act == 'edit') $linkFilter = "index.php?com=product&act=edit&id=" . $id;
$linkSave = "index.php?com=product&act=save";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-posting"><i class="far fa-save mr-2"></i>Lưu</button>
            <?php if (!empty($item['status']) && in_array($item['status'], array('dangsai', 'vipham'))) { ?>
                <button type="submit" class="btn btn-sm bg-gradient-success submit-posting" name="submit-posting" value="fix-posting"><i class="far fa-save mr-2"></i>Xác nhận chỉnh sửa</button>
            <?php } ?>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <?php if (!empty($item['status']) && in_array($item['status'], array('dangsai', 'vipham'))) { ?>
            <?php if ($item['status'] == 'dangsai') { ?>
                <div class="alert my-alert alert-warning mb-2">Tin đăng đang bị tạm dừng hoạt động do người dùng báo đăng sai. Vui lòng chỉnh sửa lại nội dung và xác nhận để tin đăng được hoạt động được trở lại.</div>
            <?php } else if ($item['status'] == 'vipham') { ?>
                <div class="alert my-alert alert-danger mb-2">Tin đăng đã bị khóa do vi phạm hoặc bị chặn nhiều lần.</div>
            <?php } ?>
        <?php } ?>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?= $k ?>" role="tab" aria-controls="tabs-lang-<?= $k ?>" aria-selected="true"><?= $v ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-body card-article">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                        <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                            <div class="form-group">
                                                <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="content<?= $k ?>">Nội dung (<?= $k ?>):</label>
                                                <textarea class="form-control for-seo text-sm" name="dataContent[content<?= $k ?>]" id="content<?= $k ?>" rows="20" placeholder="Nội dung (<?= $k ?>)" required><?= $func->decodeHtmlChars($flash->get('content' . $k)) ?: $func->decodeHtmlChars(@$itemContent['content' . $k]) ?></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (!empty($configSector['attributes'])) {
                    include_once(TEMPLATE . './product/man/attributes.php');
                }
                ?>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục shop</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group-category row">
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block">Lĩnh vực kinh doanh:</label>
                                <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Lĩnh vực" value="<?= $nameSectorList ?>" readonly>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block">Danh mục cấp 1:</label>
                                <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Danh mục cấp 2" value="<?= $nameSectorCat ?>" readonly>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_item">Danh mục cấp 2:</label>
                                <?= $func->getAjaxCategory('product', 'item') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_sub">Danh mục cấp 3:</label>
                                <?= $func->getAjaxCategory('product', 'sub') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_region">Vùng/miền:</label>
                                <?= $func->getAjaxPlace("region") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_city">Tỉnh/thành phố:</label>
                                <?= $func->getAjaxPlace("city") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_district">Quận/huyện:</label>
                                <?= $func->getAjaxPlace("district") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_wards">Phường/xã:</label>
                                <?= $func->getAjaxPlace("wards") ?>
                            </div>
                            <?php /*
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_tags">Danh mục tags:</label>
                                <?= $func->getProductTags(@$item['id'], $configSector['id'], $configSector['tables']['tag']) ?>
                            </div>
                            */ ?>
                            <?php if (($func->hasCart($configSector) && !isset($item['status_attr'])) || ($func->hasCart($configSector) && isset($item['status_attr']) && !strstr($item['status_attr'], 'dichvu'))) { ?>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block">Danh mục màu sắc:</label>
                                    <?= $func->getSale('color', 'dataColor', @$itemSale['colors']) ?>
                                </div>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block">Danh mục kích cỡ:</label>
                                    <?= $func->getSale('size', 'dataSize', @$itemSale['sizes']) ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $photoDetail = (!empty($item['photo'])) ? UPLOAD_PRODUCT_ADMIN . $item['photo'] : '';
                        $photoDetailCheck = (!empty($item['photo'])) ? UPLOAD_PRODUCT . $item['photo'] : '';
                        $dimension = "Width: " . $config['product']['width'] . " px - Height: " . $config['product']['height'] . " px (" . $config['product']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                        <input type="hidden" name="existPhoto" value="<?= (!empty($photoDetailCheck) && $func->existFile($photoDetailCheck)) ? true : false ?>">
                    </div>
                </div>
            </div>
        </div>

        <?php if (in_array($configSector['type'], array($config['website']['sectors']))) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Album hình ảnh</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="photos-file-uploader">
                            <div class="custom-file-uploader">
                                <input type="file" id="files-uploader" name="files-uploader-product">
                            </div>
                        </div>
                        <?php if (!empty($itemPhoto)) { ?>
                            <div class="photos-detail-uploader">
                                <h3 class="card-title float-none mb-4">Album hiện tại:</h3>
                                <div class="custom-file-uploader">
                                    <?= $func->getGallery($itemPhoto, 'product', $configSector['tables']['photo']) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Nội dung SEO</h3>
                <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
            </div>
            <div class="card-body">
                <?php
                $seoDB = $seo->getOnDB("*", $configSector['tables']['seo'], $id);
                include TEMPLATE . LAYOUT . "seo.php";
                ?>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-posting"><i class="far fa-save mr-2"></i>Lưu</button>
            <?php if (!empty($item['status']) && in_array($item['status'], array('dangsai', 'vipham'))) { ?>
                <button type="submit" class="btn btn-sm bg-gradient-success submit-posting" name="submit-posting" value="fix-posting"><i class="far fa-save mr-2"></i>Xác nhận chỉnh sửa</button>
            <?php } ?>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
            <input type="hidden" name="typeList" value="<?= (!empty($configSector['type'])) ? $configSector['type'] : '' ?>">
        </div>
    </form>
</section>