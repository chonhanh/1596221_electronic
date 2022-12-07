<?php
$linkSave = "index.php?com=user&act=info";
$interfaceInfo = $func->getInfoDetail('namevi, photo', 'interface', $shopInfo['id_interface']);
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Thông tin gian hàng</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-info"><i class="far fa-save mr-2"></i>Cập nhật</button>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin admin</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Danh mục lĩnh vực:</label>
                                <input type="text" class="form-control text-sm" placeholder="Danh mục lĩnh vực" value="<?= $shopInfo['sector-cat-name'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Cửa hàng:</label>
                                <input type="text" class="form-control text-sm" placeholder="Cửa hàng" value="<?= $func->getInfoDetail('namevi', 'store', $shopInfo['id_store'])['namevi'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tên gian hàng:</label>
                                <input type="text" class="form-control text-sm" placeholder="Tên gian hàng" value="<?= $shopInfo['name'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Tỉnh thành:</label>
                                <input type="text" class="form-control text-sm" placeholder="Tỉnh thành" value="<?= $func->getInfoDetail('name', 'city', $shopInfo['id_city'])['name'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Quận huyện:</label>
                                <input type="text" class="form-control text-sm" placeholder="Quận huyện" value="<?= $func->getInfoDetail('name', 'district', $shopInfo['id_district'])['name'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Phường xã:</label>
                                <input type="text" class="form-control text-sm" placeholder="Phường xã" value="<?= $func->getInfoDetail('name', 'wards', $shopInfo['id_wards'])['name'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Số điện thoại:</label>
                                <input type="text" class="form-control text-sm" placeholder="Số điện thoại" value="<?= $shopInfo['phone'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Email:</label>
                                <input type="text" class="form-control text-sm" placeholder="Địa chỉ email" value="<?= $shopInfo['email'] ?>" readonly disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mật khẩu:</label>
                                <input type="password" class="form-control text-sm" name="data[password]" id="password" placeholder="Mật khẩu" value="<?= $shopInfo['password'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $photoDetail = (!empty($shopInfo['photo'])) ? UPLOAD_SHOP_ADMIN . $shopInfo['photo'] : '';
                        $photoDetailCheck = (!empty($shopInfo['photo'])) ? UPLOAD_SHOP . $shopInfo['photo'] : '';
                        $dimension = "Width: " . $config['shop']['width'] . " px - Height: " . $config['shop']['height'] . " px (" . $config['shop']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title"><?= $interfaceInfo['namevi'] ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <img class="rounded w-100 mw-100" src="<?= UPLOAD_INTERFACE_ADMIN . $interfaceInfo['photo'] ?>" onerror="src='assets/images/noimage.png'" alt="Alt Photo Interface" />
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-info"><i class="far fa-save mr-2"></i>Cập nhật</button>
            <input type="hidden" name="id" value="<?= (isset($shopInfo['id']) && $shopInfo['id'] > 0) ? $shopInfo['id'] : '' ?>">
        </div>
    </form>
</section>

<!-- User js -->
<script type="text/javascript">
    function randomPassword() {
        var chuoi = "";
        for (i = 0; i < 8; i++) {
            chuoi += "!@#&$*%^()?abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".charAt(Math.floor(Math.random() * 20));
        }
        jQuery('#new-password').val(chuoi);
        jQuery('#renew-password').val(chuoi);
        jQuery('#show-password').html(chuoi);
    }
</script>