<?php
$linkMan = "index.php?com=product&act=man_cat";
$linkSave = "index.php?com=product&act=save_cat";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

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
                        <div class="form-group">
                            <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                            <?php if (isset($config['product']['check_cat'])) {
                                foreach ($config['product']['check_cat'] as $key => $value) { ?>
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
                                                <label for="name_store<?= $k ?>">Tiêu đề công ty (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[name_store<?= $k ?>]" id="name_store<?= $k ?>" placeholder="Tiêu đề công ty (<?= $k ?>)" value="<?= (!empty($flash->has('name_store' . $k))) ? $flash->get('name_store' . $k) : @$item['name_store' . $k] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="label_posting_main<?= $k ?>">Tiêu đề đăng tin (Chính) (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[label_posting_main<?= $k ?>]" id="label_posting_main<?= $k ?>" placeholder="Tiêu đề đăng tin (Chính) (<?= $k ?>)" value="<?= (!empty($flash->has('label_posting_main' . $k))) ? $flash->get('label_posting_main' . $k) : @$item['label_posting_main' . $k] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="label_posting_item<?= $k ?>">Tiêu đề đăng tin (Cấp 2) (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[label_posting_item<?= $k ?>]" id="label_posting_item<?= $k ?>" placeholder="Tiêu đề đăng tin (Cấp 3) (<?= $k ?>)" value="<?= (!empty($flash->has('label_posting_item' . $k))) ? $flash->get('label_posting_item' . $k) : @$item['label_posting_item' . $k] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="label_posting_sub<?= $k ?>">Tiêu đề đăng tin (Cấp 3) (<?= $k ?>):</label>
                                                <input type="text" class="form-control for-seo text-sm" name="data[label_posting_sub<?= $k ?>]" id="label_posting_sub<?= $k ?>" placeholder="Tiêu đề đăng tin (Cấp 3) (<?= $k ?>)" value="<?= (!empty($flash->has('label_posting_sub' . $k))) ? $flash->get('label_posting_sub' . $k) : @$item['label_posting_sub' . $k] ?>">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
        
                <div class="card card-primary card-outline text-sm d-none">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục cấp</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group-category">
                            <?= $func->getAjaxCategory('product', 'list') ?>
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
                        $photoDetail = UPLOAD_PRODUCT . @$item['photo'];
                        $dimension = "Width: " . $config['product']['width_cat'] . " px - Height: " . $config['product']['height_cat'] . " px (" . $config['product']['img_type_cat'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh 2</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $photoDetail2 = UPLOAD_PRODUCT . @$item['photo2'];
                        $dimension2 = "Width: " . $config['product']['width2_cat'] . " px - Height: " . $config['product']['height2_cat'] . " px (" . $config['product']['img_type_cat'] . ")";
                        include TEMPLATE . LAYOUT . "image2.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Nội dung SEO</h3>
                <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
            </div>
            <div class="card-body">
                <?php
                $seoDB = $seo->getOnDB('*', 'product_cat_seo', $id);
                include TEMPLATE . LAYOUT . "seo.php";
                ?>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>