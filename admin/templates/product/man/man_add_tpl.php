<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=product&act=man&id_list=" . $id_list;
if ($act == 'add') $linkFilter = "index.php?com=product&act=add&id_list=" . $id_list;
else if ($act == 'edit') $linkFilter = "index.php?com=product&act=edit&id_list=" . $id_list . "&id=" . $id;
$linkSave = "index.php?com=product&act=save&id_list=" . $id_list;
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
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <?php if (!empty($item['status']) && in_array($item['status'], array('dangsai', 'vipham'))) { ?>
            <?php if ($item['status'] == 'dangsai') { ?>
                <div class="alert my-alert alert-warning mb-2">Tin đăng đang bị tạm dừng hoạt động do người dùng báo đăng sai.</div>
            <?php } else if ($item['status'] == 'vipham') { ?>
                <div class="alert my-alert alert-danger mb-2">Tin đăng đã bị khóa do vi phạm hoặc bị chặn nhiều lần.</div>
            <?php } ?>
            <a class="btn btn-sm bg-gradient-info mb-2" target="_blank" href="index.php?com=report&act=edit_report_posting&id_list=<?= $configSector['id'] ?>&id_shop=<?= $item['id_shop'] ?>&id_product=<?= $item['id'] ?>" title="Xem báo cáo">Xem báo cáo</a>
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
                                                <label for="desc<?= $k ?>">Mô tả (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[desc<?= $k ?>]" id="desc<?= $k ?>" placeholder="Mô tả (<?= $k ?>)" value="<?= (!empty($flash->has('desc' . $k))) ? $flash->get('desc' . $k) : @$item['desc' . $k] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="content<?= $k ?>">Nội dung (<?= $k ?>):</label>
                                                <textarea class="form-control for-seo text-sm" name="dataContent[content<?= $k ?>]" id="content<?= $k ?>" rows="20" placeholder="Nội dung (<?= $k ?>)" required><?= $func->decodeHtmlChars($flash->get('content' . $k)) ?: $func->decodeHtmlChars(@$itemContent['content' . $k]) ?></textarea>
                                            </div>
                                            <div id="properties_<?= $k ?>">
                                            <?php if ($_GET['id_sub']>0) {
                                                $list_opt = $func -> getInfo('properties', 'product_sub', $_GET['id_sub']);

                                                $arr_list_opt=($list_opt!="")?explode(",",$list_opt):false;

                                        
                                                if ($arr_list_opt) {
                                                    $arr_opt = (isset( $itemContent['properties'.$k]) &&  $itemContent['properties'.$k] != '') ? json_decode( @$itemContent['properties'.$k],true) : null;
                                                    foreach ($arr_list_opt as $key => $value) { 
                                                    $name =  $func -> getInfo('namevi', 'variation', $value);
                                                    if ($name) {
                                                ?>
                                                    <div class="form-group">
                                                        <label for="properties<?= $k ?><?=$value?>"><?=$name?> (<?= $k ?>):</label>
                                                        <textarea class="form-control for-seo text-sm" name="dataContent[properties<?= $k ?>][<?=$value?>]" id="properties<?= $k ?><?=$value?>" rows="2" placeholder="Thuộc tính(<?= $k ?>)"><?=$func->decodeHtmlChars(@$arr_opt[$value])?></textarea>
                                                    </div>
                                                    <?php } }
                                                }
                                            } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($act == "edit" && (!empty($item['id_member']) || !empty($item['id_admin']) || !empty($itemOwnerShop['id']))) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chủ sở hữu</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab-owner" role="tablist">
                                        <?php if (!empty($itemOwnerShop['id'])) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tabs-owner" data-toggle="pill" href="#tabs-info-shop" role="tab" aria-controls="tabs-info-shop" aria-selected="true">Thông tin gian hàng</a>
                                            </li>
                                        <?php } ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= (empty($itemOwnerShop['id'])) ? 'active' : '' ?>" id="tabs-owner" data-toggle="pill" href="#tabs-owner-poster" role="tab" aria-controls="tabs-owner-poster" aria-selected="true"><?= (empty($itemOwnerShop['id'])) ? 'Thông tin người đăng' : 'Chủ sở hữu' ?></a>
                                        </li>
                                        <?php if (!empty($item['id_member'])) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tabs-owner" data-toggle="pill" href="#tabs-owner-contact" role="tab" aria-controls="tabs-owner-contact" aria-selected="true">Thông tin liên hệ</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="card-body card-article">
                                    <div class="tab-content" id="custom-tabs-three-tabContent-owner">
                                        <?php if (!empty($itemOwnerShop['id'])) { ?>
                                            <div class="tab-pane fade show active" id="tabs-info-shop" role="tabpanel" aria-labelledby="tabs-owner">
                                                <a class="btn btn-success d-inline-block align-top mb-2" target="_blank" href="<?= $configBaseShop . $itemOwnerShop['slug_url'] ?>/" title="Xem shop">Xem shop</a>
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label for="name">Tên gian hàng:</label>
                                                        <input type="text" class="form-control text-sm" id="name_shop" placeholder="Họ tên" value="<?= $itemOwnerShop['name'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="phone">Số điện thoại:</label>
                                                        <input type="text" class="form-control text-sm" id="phone_shop" placeholder="Số điện thoại" value="<?= @$itemOwnerShop['phone'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="email">Email:</label>
                                                        <input type="text" class="form-control text-sm" id="email_shop" placeholder="Email" value="<?= @$itemOwnerShop['email'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="address">Địa chỉ:</label>
                                                        <input type="text" class="form-control text-sm" id="address_shop" placeholder="Địa chỉ" value="<?= $func->joinPlace($itemOwnerShop) ?>" disabled readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="tab-pane fade show <?= (empty($itemOwnerShop['id'])) ? 'active' : '' ?>" id="tabs-owner-poster" role="tabpanel" aria-labelledby="tabs-owner">
                                            <div class="mb-3"><strong class="pr-1">Người dùng:</strong><strong class="text-uppercase text-danger pr-1"><?= (!empty($itemOwnerShop['id_member']) || !empty($item['id_member'])) ? 'Thành viên' : 'Ban quản trị' ?></strong></div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="fullname">Họ tên:</label>
                                                    <input type="text" class="form-control text-sm" id="fullname_owner" placeholder="Họ tên" value="<?= @$itemOwnerPoster['fullname'] ?>" disabled readonly>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="phone">Số điện thoại:</label>
                                                    <input type="text" class="form-control text-sm" id="phone_owner" placeholder="Số điện thoại" value="<?= @$itemOwnerPoster['phone'] ?>" disabled readonly>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="email">Email:</label>
                                                    <input type="text" class="form-control text-sm" id="email_owner" placeholder="Email" value="<?= @$itemOwnerPoster['email'] ?>" disabled readonly>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="address">Địa chỉ:</label>
                                                    <input type="text" class="form-control text-sm" id="address_owner" placeholder="Địa chỉ" value="<?= @$itemOwnerPoster['address'] ?>" disabled readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (!empty($item['id_member'])) { ?>
                                            <div class="tab-pane fade show" id="tabs-owner-contact" role="tabpanel" aria-labelledby="tabs-owner">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label for="fullname_contact">Họ tên:</label>
                                                        <input type="text" class="form-control text-sm" id="fullname_contact" placeholder="Họ tên" value="<?= @$itemOwnerContact['fullname'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="phone_contact">Số điện thoại:</label>
                                                        <input type="text" class="form-control text-sm" id="phone_contact" placeholder="Số điện thoại" value="<?= @$itemOwnerContact['phone'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="email_contact">Email:</label>
                                                        <input type="text" class="form-control text-sm" id="email_contact" placeholder="Email" value="<?= @$itemOwnerContact['email'] ?>" disabled readonly>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="address_contact">Địa chỉ:</label>
                                                        <input type="text" class="form-control text-sm" id="address_contact" placeholder="Địa chỉ" value="<?= @$itemOwnerContact['address'] ?>" disabled readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php
                if (!empty($configSector['attributes'])) {
                    include_once(TEMPLATE . './product/man/attributes.php');
                }
                ?>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group-category row">
                            <div class="form-group col-sm-6 d-none">
                                <label class="d-block" for="id_list">Danh mục :</label>
                                <?= $func->getAjaxCategory('product', 'list') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_cat">Danh mục cấp 1:</label>
                                <?= $func->getAjaxCategory('product', 'cat') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_item">Danh mục cấp 2:</label>
                                <?= $func->getAjaxCategory('product', 'item') ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_sub">Danh mục cấp 3:</label>
                                <?= $func->getAjaxCategory('product', 'sub',false,false,'','','select-category load_properties') ?>
                            </div>
                            <?php if (in_array("form-work", $configSector['attributes'])) { ?>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block" for="id_form_work">Hình thức làm việc:</label>
                                    <?php $flashVariationFormWork = $flash->get('form-work-id'); ?>
                                    <select class="form-control select2" name="dataVariations[form-work][id]" id="id_form_work" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php if (!empty($formWork)) {
                                            foreach ($formWork as $v) { ?>
                                                <option <?= ((!empty($itemVariation['hinh-thuc-lam-viec']) && $itemVariation['hinh-thuc-lam-viec']['id_variation'] == $v['id']) || ($flashVariationFormWork == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <input type="hidden" name="dataVariations[form-work][type]" value="hinh-thuc-lam-viec">
                                </div>
                            <?php } ?>
                            <?php if (in_array("experience", $configSector['attributes'])) { ?>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block" for="id_experience">Kinh nghiệm:</label>
                                    <?php $flashVariationExperience = $flash->get('experience-id'); ?>
                                    <select class="form-control select2" name="dataVariations[experience][id]" id="id_experience" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php if (!empty($experience)) {
                                            foreach ($experience as $v) { ?>
                                                <option <?= ((!empty($itemVariation['kinh-nghiem']) && $itemVariation['kinh-nghiem']['id_variation'] == $v['id']) || ($flashVariationExperience == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <input type="hidden" name="dataVariations[experience][type]" value="kinh-nghiem">
                                </div>
                            <?php } ?>
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
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_tags">Danh mục tags:</label>
                                <?= $func->getProductTags(@$item['id'], $configSector['id'], $configSector['tables']['tag']) ?>
                            </div>
                            <?php if (($func->hasCart($configSector) && !isset($item['status_attr'])) || ($func->hasCart($configSector) && isset($item['status_attr']) && !strstr($item['status_attr'], 'dichvu'))) { ?>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block">Danh mục màu sắc:</label>
                                    <?= $func->getSale('color', 'dataColor', @$itemSale['colors']) ?>
                                </div>
                                <div class="form-group col-xl-6 col-sm-4">
                                    <label class="d-block">Danh mục kích cỡ:</label>
                                    <?= $func->getSale('size', 'dataSize', @$itemSale['sizes'], $configSector['id']) ?>
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
                        $photoDetail = (!empty($item['photo'])) ? UPLOAD_PRODUCT . $item['photo'] : '';
                        $dimension = "Width: " . $config['product']['width'] . " px - Height: " . $config['product']['height'] . " px (" . $config['product']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                        <input type="hidden" name="existPhoto" value="<?= (!empty($photoDetail) && $func->existFile($photoDetail)) ? true : false ?>">
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
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
            <input type="hidden" name="typeList" value="<?= (!empty($configSector['type'])) ? $configSector['type'] : '' ?>">
        </div>
    </form>
</section>