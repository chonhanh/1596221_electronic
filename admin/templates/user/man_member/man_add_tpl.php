<?php
$linkMan = "index.php?com=user&act=man_member";
$linkSave = "index.php?com=user&act=save_member";
$linkMails = "index.php?com=user&act=send_mails";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết tài khoản khách</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <?= $flash->getMessages('admin') ?>

    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-user"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin tài khoản</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                            <?php if (isset($config['user']['check_member'])) {
                                foreach ($config['user']['check_member'] as $key => $value) { ?>
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
                            <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">Tài khoản:</label>
                                <?php if ($act == 'edit_member') { ?>
                                    <input type="text" class="form-control text-sm" placeholder="Tài khoản" value="<?= @$item['username'] ?>" readonly>
                                <?php } else { ?>
                                    <input type="text" class="form-control text-sm" name="data[username]" id="username_member" placeholder="Tài khoản" value="<?= (!empty($flash->has('username'))) ? $flash->get('username') : @$item['username'] ?>" required>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Họ tên:</label>
                                <div class="input-group">
                                    <input type="text" class="col-8 form-control text-sm" name="data[first_name]" id="first_name" placeholder="Họ" value="<?= (!empty($flash->has('first_name'))) ? $flash->get('first_name') : @$item['first_name'] ?>" required>
                                    <input type="text" class="col-4 form-control text-sm" name="data[last_name]" id="last_name" placeholder="Tên" value="<?= (!empty($flash->has('last_name'))) ? $flash->get('last_name') : @$item['last_name'] ?>" required>
                                </div>
                            </div>
                            <?php if (!$func->checkRole()) { ?>
                                <div class="form-group col-md-6" data-plugin="tooltip" data-html="true" data-placement="top" title="<ul class='list-unstyled text-warning text-left mb-0'><li class='text-light text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>">
                                    <label for="password">Mật khẩu:</label>
                                    <input type="password" class="form-control text-sm" name="data[password]" id="password" placeholder="Mật khẩu" <?= ($act == "add_member") ? 'required' : ''; ?>>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Nhập lại mật khẩu:</label>
                                    <input type="password" class="form-control text-sm" name="confirm_password" id="confirm_password" placeholder="Nhập lại mật khẩu" <?= ($act == "add_member") ? 'required' : ''; ?>>
                                </div>
                            <?php } ?>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="id_city">Tỉnh/thành phố:</label>
                                <?= $func->getAjaxPlace("city", false) ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="id_district">Quận/huyện:</label>
                                <?= $func->getAjaxPlace("district", false) ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="d-block" for="id_wards">Phường/xã:</label>
                                <?= $func->getAjaxPlace("wards", false) ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone">Điện thoại:</label>
                                <input type="text" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$item['phone'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control text-sm" name="data[email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$item['email'] ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gender">Giới tính:</label>
                                <?php $flashGender = $flash->get('gender'); ?>
                                <select class="custom-select text-sm" name="data[gender]" id="gender" required>
                                    <option value="">Chọn giới tính</option>
                                    <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$item['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                                    <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$item['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthday">Ngày sinh:</label>
                                <input type="text" class="form-control max-date text-sm" name="data[birthday]" id="birthday" placeholder="Ngày sinh" value="<?= (!empty($flash->has('birthday'))) ? date("d/m/Y", $flash->get('birthday')) : ((!empty($item['birthday'])) ? date("d/m/Y", $item['birthday']) : '') ?>" required readonly autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Địa chỉ:</label>
                                <input type="text" class="form-control text-sm" name="data[address]" id="address" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$item['address'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $photoDetail = UPLOAD_USER . @$item['avatar'];
                        $dimension = "Width: " . $config['user']['member']['width'] . " px - Height: " . $config['user']['member']['height'] . " px (" . $config['user']['member']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($act != 'edit_member') { ?>
            <div class="card-footer text-sm sticky-top">
                <button type="submit" class="btn btn-sm bg-gradient-primary submit-user"><i class="far fa-save mr-2"></i>Lưu</button>
                <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            </div>
        <?php } ?>

        <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
    </form>

    <?php if ($act == 'edit_member') { ?>
        <form method="post" action="<?= $linkMails ?>" enctype="multipart/form-data">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Gửi thông báo cho thành viên</h3>
                </div>
                <div class="card-body mb-0">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm bg-gradient-success submit-mails" name="submit-mails" value="send-mails"><i class="fas fa-paper-plane mr-2"></i>Gửi thư</button>
                    </div>
                    <div class="form-group">
                        <label for="title_mails">Tiêu đề:</label>
                        <input type="text" class="form-control text-sm" id="title_mails" name="dataMails[title]" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group">
                        <label for="content_mails">Nội dung:</label>
                        <textarea class="form-control form-control-ckeditor" id="content_mails" name="dataMails[content]" rows="5" placeholder="Nội dung"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm bg-gradient-success submit-mails" name="submit-mails" value="send-mails"><i class="fas fa-paper-plane mr-2"></i>Gửi thư</button>
                    <input type="hidden" name="id_member" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
                    <input type="hidden" name="url_back" value="<?= $func->getCurrentPageURLWithParams() ?>">
                </div>
            </div>
        </form>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Danh sách thông báo</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($mails)) { ?>
                    <div class="accordion" id="accordion-mails">
                        <?php foreach ($mails as $k_mails => $v_mails) { ?>
                            <div class="card card-mails card-info card-outline text-sm">
                                <div class="card-header px-3 py-3" id="heading-mails-<?= $v_mails['id'] ?>">
                                    <div class="d-flex align-items-top justify-content-between">
                                        <button class="btn text-left p-0 pr-5" type="button" data-toggle="collapse" data-target="#collapse-mails-<?= $v_mails['id'] ?>" aria-expanded="true" aria-controls="collapse-mails-<?= $v_mails['id'] ?>"><strong><?= $v_mails['title'] ?></strong></button>
                                        <a class="btn btn-sm ml-auto mr-1 text-secondary" data-toggle="collapse" data-target="#collapse-mails-<?= $v_mails['id'] ?>" aria-expanded="true" aria-controls="collapse-mails-<?= $v_mails['id'] ?>" title="Xem thư"><i class="fas fa-chevron-down align-top pt-1"></i></a>
                                        <a class="btn btn-sm delete-mails text-danger" data-id="<?= $v_mails['id'] ?>" title="Xóa thư này"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                </div>
                                <div id="collapse-mails-<?= $v_mails['id'] ?>" class="collapse" aria-labelledby="heading-mails-<?= $v_mails['id'] ?>" data-parent="#accordion-mails">
                                    <div class="card-body"><?= $func->decodeHtmlChars($v_mails['content']) ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($paging) { ?>
                        <div class="card-footer text-sm pb-0"><?= $paging ?></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</section>