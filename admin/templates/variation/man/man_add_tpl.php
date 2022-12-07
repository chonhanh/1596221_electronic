<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";
else if ($act == "copy")  $labelAct = "Sao chép";

$linkMan = "index.php?com=variation&act=man&type=" . $type;
if ($act == 'add') $linkFilter = "index.php?com=variation&act=add&type=" . $type;
else if ($act == 'edit') $linkFilter = "index.php?com=variation&act=edit&type=" . $type . "&id=" . $id;
$linkSave = "index.php?com=variation&act=save&type=" . $type;

/* Check cols */
if (!empty($config['variation'][$type]['list'])|| (isset($config['variation'][$type]['images']) && $config['variation'][$type]['images'] == true)) {
    $colLeft = "col-xl-8";
    $colRight = "col-xl-4";
} else {
    $colLeft = "col-12";
    $colRight = "d-none";
}

/* Get type price  */
if (!empty($_GET['id_list'])) {
    $type_price = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? order by numb,id desc", array(htmlspecialchars($_GET['id_list']), 'loai-gia'));
}
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?> <?= $config['variation'][$type]['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-variation"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>
        <div class="row">
            <div class="<?= $colLeft ?>">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?= $config['variation'][$type]['title_main'] ?></h3>
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
                                                <input type="text" class="form-control text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin <?= $config['variation'][$type]['title_main'] ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if (isset($config['variation'][$type]['check'])) {
                        foreach ($config['variation'][$type]['check'] as $key => $value) { ?>
                            <div class="form-group d-inline-block mb-2 mr-2">
                                <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                <div class="custom-control custom-checkbox d-inline-block align-middle">
                                    <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                    <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
                <div class="row">
                    <?php if (!empty($config['variation'][$type]['date'])) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="date_filter">Số ngày:</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-sm" name="data[date_filter]" id="date_filter" placeholder="Số ngày" value="<?= (!empty($flash->has('date_filter'))) ? $flash->get('date_filter') : @$item['date_filter'] ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text text-sm">ngày</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="d-block">Điều kiện lọc:</label>
                            <?php $flashDateComparison = $flash->get('date_comparison'); ?>
                            <div class="custom-control custom-radio d-inline-block text-md mr-4">
                                <input class="custom-control-input" type="radio" id="more-than-date" name="data[date_comparison]" <?= ((@$item['date_comparison'] == 1) || ($flashDateComparison == 1)) ? 'checked' : '' ?> value="1">
                                <label for="more-than-date" class="custom-control-label font-weight-normal">Sau số ngày đã chọn</label>
                            </div>
                            <div class="custom-control custom-radio d-inline-block text-md">
                                <input class="custom-control-input" type="radio" id="less-than-date" name="data[date_comparison]" <?= ((@$item['date_comparison'] == 2) || ($flashDateComparison == 2)) ? 'checked' : '' ?> value="2">
                                <label for="less-than-date" class="custom-control-label font-weight-normal">Trước số ngày đã chọn</label>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($config['variation'][$type]['denominations'])) { ?>
                        <div class="form-group col-md-4">
                            <label class="d-block" for="denominations">Mệnh giá:</label>
                            <div class="input-group">
                                <input type="text" class="form-control format-price denominations text-sm" name="data[denominations]" id="denominations" placeholder="Mệnh giá" value="<?= (!empty($flash->has('denominations'))) ? $flash->get('denominations') : @$item['denominations'] ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($config['variation'][$type]['range_value'])) { ?>
                        <div class="form-group col-md-8">
                            <?php if (!empty($config['variation'][$type]['price'])) { ?>
                                <label class="d-block">Mức giá/lương:</label>
                            <?php } else if (!empty($config['variation'][$type]['acreage'])) { ?>
                                <label class="d-block">Diện tích (m2):</label>
                            <?php } else if (!empty($config['variation'][$type]['experience'])) { ?>
                                <label class="d-block">Kinh nghiệm (năm):</label>
                            <?php } ?>
                            <div class="row">
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-sm">Từ:</span>
                                    </div>
                                    <input type="text" class="form-control text-sm" name="data[value_from]" id="value_from" placeholder="Giá trị từ" value="<?= (!empty($flash->has('value_from'))) ? $flash->get('value_from') : ((!empty($item['value_from'])) ? $item['value_from'] : 0) ?>">
                                    <?php if (!empty($config['variation'][$type]['experience'])) { ?>
                                        <div class="input-group-append text-sm">
                                            <span class="input-group-text">năm</span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($config['variation'][$type]['acreage'])) { ?>
                                        <div class="input-group-append text-sm">
                                            <span class="input-group-text">m2</span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($config['variation'][$type]['range_type'])) { ?>
                                        <?php $flashValueTypeFrom = $flash->get('value_type_from'); ?>
                                        <select class="custom-select w-auto text-sm" name="data[value_type_from]" id="value_type_from">
                                            <option value="">Chọn loại giá từ</option>
                                            <?php if (!empty($type_price)) {
                                                foreach ($type_price as $v) { ?>
                                                    <option <?= ((@$item['value_type_from'] == $v['id']) || ($flashValueTypeFrom == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div class="input-group col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-sm">Đến:</span>
                                    </div>
                                    <input type="text" class="form-control text-sm" name="data[value_to]" id="value_to" placeholder="Giá trị đến" value="<?= (!empty($flash->has('value_to'))) ? $flash->get('value_to') : ((!empty($item['value_to'])) ? $item['value_to'] : 0) ?>">
                                    <?php if (!empty($config['variation'][$type]['experience'])) { ?>
                                        <div class="input-group-append text-sm">
                                            <span class="input-group-text">năm</span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($config['variation'][$type]['acreage'])) { ?>
                                        <div class="input-group-append text-sm">
                                            <span class="input-group-text">m2</span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($config['variation'][$type]['range_type'])) { ?>
                                        <?php $flashValueTypeTo = $flash->get('value_type_to'); ?>
                                        <select class="custom-select w-auto text-sm" name="data[value_type_to]" id="value_type_to">
                                            <option value="">Chọn loại giá đến</option>
                                            <?php if (!empty($type_price)) {
                                                foreach ($type_price as $v) { ?>
                                                    <option <?= ((@$item['value_type_to'] == $v['id']) || ($flashValueTypeTo == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

            </div>
            <div class="<?= $colRight ?>">
                <?php if (isset($config['variation'][$type]['images']) && $config['variation'][$type]['images'] == true) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?= $config['variation'][$type]['title_main'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $photoDetail = ($act != 'copy') ? UPLOAD_PHOTO . @$item['photo'] : '';
                            $dimension = "Width: " . $config['variation'][$type]['width'] . " px - Height: " . $config['variation'][$type]['height'] . " px (" . $config['variation'][$type]['img_type'] . ")";
                            include TEMPLATE . LAYOUT . "image.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-variation"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>