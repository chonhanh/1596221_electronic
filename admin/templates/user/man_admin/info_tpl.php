<?php
if (isset($_GET['changepass']) && ($_GET['changepass'] == 1)) $changepass = "&changepass=1";
else $changepass = "";
$linkSave = "index.php?com=user&act=info_admin" . $changepass;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Thông tin tài khoản</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-info"><i class="far fa-save mr-2"></i>Lưu</button>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin admin</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (isset($changepass) && $changepass != '') { ?>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="old-password">Mật khẩu cũ:</label>
                            <input type="password" class="form-control text-sm" name="old-password" id="old-password" placeholder="Mật khẩu cũ">
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6" data-plugin="tooltip" data-html="true" data-placement="bottom" title="<ul class='list-unstyled text-warning text-left mb-0'><li class='text-light text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>">
                            <label for="new-password">Mật khẩu mới:</label>
                            <input type="password" class="form-control text-sm" name="new-password" id="new-password" placeholder="Mật khẩu mới">
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="renew-password">Nhập lại mật khẩu mới:</label>
                            <input type="password" class="form-control text-sm" name="renew-password" id="renew-password" placeholder="Nhập lại mật khẩu mới">
                        </div>
                    <?php } else { ?>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="username">Tài khoản: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm" name="data[username]" id="username" placeholder="Tài khoản" value="<?= (!empty($flash->has('username'))) ? $flash->get('username') : @$item['username'] ?>" required>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="fullname">Họ tên: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm" name="data[fullname]" id="fullname" placeholder="Họ tên" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : @$item['fullname'] ?>" required>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control text-sm" name="data[email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$item['email'] ?>" required>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="phone">Điện thoại:</label>
                            <input type="text" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$item['phone'] ?>" required>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="gender">Giới tính:</label>
                            <?php $flashGender = $flash->get('gender'); ?>
                            <select class="custom-select text-sm" name="data[gender]" id="gender" required>
                                <option value="">Chọn giới tính</option>
                                <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$item['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                                <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$item['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="birthday">Ngày sinh:</label>
                            <input type="text" class="form-control max-date text-sm" name="data[birthday]" id="birthday" placeholder="Ngày sinh" value="<?= (!empty($flash->has('birthday'))) ? date("d/m/Y", $flash->get('birthday')) : ((!empty($item['birthday'])) ? date("d/m/Y", $item['birthday']) : '') ?>" required readonly autocomplete="off">
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <label for="address">Địa chỉ:</label>
                            <input type="text" class="form-control text-sm" name="data[address]" id="address" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$item['address'] ?>" required>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-info"><i class="far fa-save mr-2"></i>Lưu</button>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
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