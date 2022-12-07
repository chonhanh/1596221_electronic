<?php
$linkSave = "index.php?com=user&act=save_member_dashboard";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Thông báo cá nhân</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-member-dashboard"><i class="far fa-save mr-2"></i>Lưu</button>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group form-group-category col-md-4">
                        <label class="d-block" for="place_group">Tỉnh/thành phố:</label>
                        <?= $func->getMultiPlace(@$item['id_city']) ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="d-block">Giới tính:</label>
                        <div class="pt-1">
                            <div class="d-inline-block mr-3">
                                <div class="custom-control custom-checkbox d-inline-block align-middle">
                                    <input type="checkbox" class="custom-control-input" name="gender_group[]" id="gender_male" <?= (!empty($item['gender']) && strstr($item['gender'], '1')) ? 'checked' : '' ?> value="1">
                                    <label for="gender_male" class="custom-control-label font-weight-normal text-md">Nam</label>
                                </div>
                            </div>
                            <div class="d-inline-block">
                                <div class="custom-control custom-checkbox d-inline-block align-middle">
                                    <input type="checkbox" class="custom-control-input" name="gender_group[]" id="gender_female" <?= (!empty($item['gender']) && strstr($item['gender'], '2')) ? 'checked' : '' ?> value="2">
                                    <label for="gender_female" class="custom-control-label font-weight-normal text-md">Nữ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Hình ảnh thông báo</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $photoDetail = UPLOAD_PHOTO . @$item['photo1'];
                        $dimension = "Width: " . $config['user']['member_dashboard']['width'] . " px - Height: " . $config['user']['member_dashboard']['height'] . " px (" . $config['user']['member']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $photoDetail2 = UPLOAD_PHOTO . @$item['photo2'];
                        $dimension2 = "Width: " . $config['user']['member_dashboard']['width'] . " px - Height: " . $config['user']['member_dashboard']['height'] . " px (" . $config['user']['member']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image2.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-member-dashboard"><i class="far fa-save mr-2"></i>Lưu</button>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>