<?php
$linkFilter = "index.php?com=sample&act=update";
$linkSave = "index.php?com=sample&act=save";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $config['sample']['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-sample"><i class="far fa-save mr-2"></i>Lưu</button>
        </div>

        <?= $flash->getMessages('admin') ?>


        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Hình ảnh mẫu</h3>
            </div>
            <div class="card-body">
                <?php if (empty($_REQUEST['id_interface'])) { ?>
                    <div class="my-alert alert alert-info mt-3">Vui lòng chọn giao diện gian hàng</div>
                <?php } else {
                    $configSample = $config['sample']['data'][$_REQUEST['id_interface']]; ?>
                    <div class="row">
                        <?php if (array_key_exists('header', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Header:</strong></div>
                                <?php
                                $photoDetail = UPLOAD_PHOTO . @$item['header'];
                                $dimension = "Width: " . $configSample['header']['width'] . " px - Height: " . $configSample['header']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image.php";
                                ?>
                            </div>
                        <?php } ?>

                        <?php if (array_key_exists('banner', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Banner:</strong></div>
                                <?php
                                $photoDetail2 = UPLOAD_PHOTO . @$item['banner'];
                                $dimension2 = "Width: " . $configSample['banner']['width'] . " px - Height: " . $configSample['banner']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image2.php";
                                ?>
                            </div>
                        <?php } ?>

                        <?php if (array_key_exists('logo', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Logo:</strong></div>
                                <?php
                                $photoDetail3 = UPLOAD_PHOTO . @$item['logo'];
                                $dimension3 = "Width: " . $configSample['logo']['width'] . " px - Height: " . $configSample['logo']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image3.php";
                                ?>
                            </div>
                        <?php } ?>

                        <?php if (array_key_exists('favicon', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Favicon:</strong></div>
                                <?php
                                $photoDetail4 = UPLOAD_PHOTO . @$item['favicon'];
                                $dimension4 = "Width: " . $configSample['favicon']['width'] . " px - Height: " . $configSample['favicon']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image4.php";
                                ?>
                            </div>
                        <?php } ?>

                        <?php /*if (array_key_exists('social', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Social:</strong></div>
                                <?php
                                $photoDetail5 = UPLOAD_PHOTO . @$item['social'];
                                $dimension5 = "Width: " . $configSample['social']['width'] . " px - Height: " . $configSample['social']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image5.php";
                                ?>
                            </div>
                        <?php }*/ ?>

                        <?php /*if (array_key_exists('slideshow', $configSample)) { ?>
                            <div class="col-4 mb-5">
                                <div class="bg-light rounded px-3 py-2 mb-3"><strong>Slideshow:</strong></div>
                                <?php
                                $photoDetail6 = UPLOAD_PHOTO . @$item['slideshow'];
                                $dimension6 = "Width: " . $configSample['slideshow']['width'] . " px - Height: " . $configSample['slideshow']['height'] . " px (" . $config['sample']['img_type'] . ")";
                                include TEMPLATE . LAYOUT . "image6.php";
                                ?>
                            </div>
                        <?php }*/ ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-sample"><i class="far fa-save mr-2"></i>Lưu</button>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>