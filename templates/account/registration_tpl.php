<form class="form-account form-registration-account" method="post" action="account/dang-ky" enctype="multipart/form-data">
    <div class="title-account text-primary text-uppercase text-center mb-4">Mời bạn nhập thông tin để đăng ký thông tin chợ nhanh</div>
    <?= $flash->getMessages("frontend") ?>
    <div class="avatar d-flex align-items-center justify-content-start mb-3">
        <div class="avatar-zone mr-3">
            <label class="avatar-label d-block mb-0" id="avatar-account-label" for="avatar-account">
                <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden" id="avatar-account-preview">
                    <?= $func->getImage(['size-error' => '150x150x1', 'upload' => 'assets/images/', 'image' => 'blank-avatar.jpg', 'alt' => 'Blank avatar']) ?>
                </div>
                <input type="file" class="d-none" name="file_avatar" id="avatar-account">
            </label>
        </div>
        <div class="avatar-dimension">
            <p class="mb-0">Kích thước tối đa: <strong>Width: 200px - Height: 200px</strong></p>
            <p class="mb-0">Định dạng: <strong>.jpg, .png</strong></p>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-12">
            <input type="text" class="form-control text-sm font-weight-500" id="username" name="username" placeholder="Tài khoản đăng nhập (Vui lòng nhập chính xác số điện thoại di động của bạn)" value="<?= $flash->get('username') ?>" required autocomplete="off">
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-6">
            <div class="input-group control-password" data-plugin="tooltip" data-html="true" data-placement="top" title="<ul class='list-unstyled text-warning text-left mb-0'><li class='text-light text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>">
                <input type="password" class="form-control text-sm font-weight-500" id="password" name="password" placeholder="Mật khẩu" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group control-password">
                <input type="password" class="form-control text-sm font-weight-500" id="repassword" name="repassword" placeholder="Xác nhận lại mật khẩu" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-5">
            <div class="input-group">
                <input type="text" class="col-8 form-control text-sm font-weight-500" id="first_name" name="first_name" placeholder="Họ & chữ lót" value="<?= $flash->get('first_name') ?>" required>
                <input type="text" class="col-4 form-control text-sm font-weight-500" id="last_name" name="last_name" placeholder="Tên" value="<?= $flash->get('last_name') ?>" required>
            </div>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-center">
            <?php $flashGender = $flash->get('gender'); ?>
            <div class="radio-user custom-control custom-radio mr-3">
                <input type="radio" id="nam" name="gender" class="custom-control-input" value="1" <?= ($flashGender == 1) ? 'checked' : '' ?> required>
                <label class="custom-control-label" for="nam"><?= nam ?></label>
            </div>
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nu" name="gender" class="custom-control-input" value="2" <?= ($flashGender == 2) ? 'checked' : '' ?> required>
                <label class="custom-control-label" for="nu"><?= nu ?></label>
            </div>
        </div>
        <div class="col-4">
            <input type="text" class="form-control max-date text-sm font-weight-500" id="birthday" name="birthday" placeholder="Ngày/tháng/năm sinh" value="<?= $flash->get('birthday') ?>" required readonly autocomplete="off">
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-4">
            <select class="select-city custom-select text-sm cursor-pointer font-weight-500" required id="city" name="city">
                <option value=""><?= tinhthanh ?></option>
                <?php foreach ($city as $k => $v) { ?>
                    <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4">
            <select class="select-district custom-select text-sm cursor-pointer font-weight-500" required id="district" name="district">
                <option value=""><?= quanhuyen ?></option>
            </select>
        </div>
        <div class="col-4">
            <select class="select-wards custom-select text-sm cursor-pointer font-weight-500" required id="wards" name="wards">
                <option value=""><?= phuongxa ?></option>
            </select>
        </div>
    </div>
    <div class="form-row mb-4">
        <div class="col-6">
            <input type="email" class="form-control text-sm font-weight-500" id="email" name="email" placeholder="Email" value="<?= $flash->get('email') ?>" required autocomplete="off">
        </div>
        <div class="col-6">* Vui lòng nhập chính xác email của bạn vì chúng tôi sẽ gửi thông báo và mã kích hoạt của bạn qua Email bạn đã đăng ký !</div>
    </div>
    <div class="rule-account custom-control custom-checkbox mb-4 mx-auto">
        <input type="checkbox" class="custom-control-input" name="rules" id="rules" value="1">
        <label class="custom-control-label" for="rules">Đăng ký thành viên là bạn đã chấp nhận tất cả <a class="text-decoration-none text-primary font-italic font-weight-500 transition" href="dieu-khoan" target="_blank" title="Điều khoản">Điều khoản</a> của Chợ Nhanh dành cho Thành viên.</label>
    </div>
    <div class="captcha-account captcha-registration-account input-group align-items-center captcha-image mb-4 mx-auto">
        <div class="input-group-prepend">
            <span class="input-group-text text-sm rounded-0 border-0">Nhập mã bảo mật</span>
        </div>
        <input type="text" class="form-control text-sm font-weight-500 rounded" id="captcha-registration-account" name="captcha-registration-account" placeholder="Mã bảo mật" required>
        <div class="input-group-append">
            <span class="input-group-text text-sm rounded-0 border-0">
                <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('registration-account') ?>/" alt="Mã bảo mật" />
                <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="registration-account">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </span>
        </div>
    </div>
    <div class="btn-account text-center">
        <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="registration-user" value="Đăng ký thành viên">
    </div>
</form>