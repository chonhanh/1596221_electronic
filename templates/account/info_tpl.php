<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <form class="form-account form-info-account" method="post" action="account/thong-tin" enctype="multipart/form-data">
        <?= $flash->getMessages("frontend") ?>
        <div class="avatar-account d-flex align-items-center justify-content-start mb-3">
            <div class="avatar-account-zone mr-3">
                <label class="avatar-account-label d-block mb-0" id="avatar-account-label" for="avatar-account">
                    <div class="avatar-account-detail d-flex align-items-center justify-content-center border rounded overflow-hidden" id="avatar-account-preview">
                        <?= $func->getImage(['sizes' => '200x200x1', 'image-error' => 'blank-avatar.jpg', 'upload' => UPLOAD_USER_L, 'image' => $detailMember['avatar'], 'alt' => $detailMember['fullname']]) ?>
                    </div>
                    <input type="file" class="d-none" name="file_avatar" id="avatar-account">
                </label>
            </div>
            <div class="avatar-account-dimension">
                <p class="mb-0">Kích thước tối đa: <strong>Width: 200px - Height: 200px</strong></p>
                <p class="mb-2">Định dạng: <strong>.jpg, .png</strong></p>
                <label class="btn btn-sm btn-success py-2 px-3 mb-0" for="avatar-account">Đổi hình</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group row">
                        <div class="col-8"><label class="label-account font-weight-700" for="first_name">Họ & chữ lót</label></div>
                        <div class="col-4"><label class="label-account font-weight-700" for="last_name">Tên</label></div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="col-8 form-control text-sm font-weight-500" id="first_name" name="first_name" placeholder="Họ & chữ lót" value="<?= (!empty($flash->has('first_name'))) ? $flash->get('first_name') : $detailMember['first_name'] ?>" required>
                        <input type="text" class="col-4 form-control text-sm font-weight-500" id="last_name" name="last_name" placeholder="Tên" value="<?= (!empty($flash->has('last_name'))) ? $flash->get('last_name') : $detailMember['last_name'] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="birthday">Ngày sinh</label>
                    <input type="text" class="form-control max-date text-sm font-weight-500" id="birthday" name="birthday" placeholder="<?= nhapngaysinh ?>" value="<?= (!empty($flash->has('birthday'))) ? $flash->get('birthday') : date("d/m/Y", $detailMember['birthday']) ?>" required readonly autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="address">Địa chỉ</label>
                    <input type="text" class="form-control text-sm font-weight-500" id="address" name="address" placeholder="<?= nhapdiachi ?>" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : $detailMember['address'] ?>" required>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="city"><?= tinhthanh ?></label>
                    <select class="select-city custom-select text-sm font-weight-500 cursor-pointer" required id="city" name="city">
                        <option value=""><?= tinhthanh ?></option>
                        <?php foreach ($city as $k => $v) { ?>
                            <option <?= ($detailMember['id_city'] == $v['id']) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="district"><?= quanhuyen ?></label>
                    <select class="select-district custom-select text-sm font-weight-500 cursor-pointer" required id="district" name="district">
                        <option value=""><?= quanhuyen ?></option>
                        <?php if (!empty($district)) {
                            foreach ($district as $k => $v) { ?>
                                <option <?= ($detailMember['id_district'] == $v['id']) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="wards"><?= phuongxa ?></label>
                    <select class="select-wards custom-select text-sm font-weight-500 cursor-pointer" required id="wards" name="wards">
                        <option value=""><?= phuongxa ?></option>
                        <?php if (!empty($wards)) {
                            foreach ($wards as $k => $v) { ?>
                                <option <?= ($detailMember['id_wards'] == $v['id']) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="label-account font-weight-700">Tên sử dụng đăng nhập</label>
                    <input type="text" class="form-control text-sm text-danger font-weight-500 border-white bg-white" placeholder="Username" value="<?= $detailMember['username'] ?>" readonly disabled>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700">Email</label>
                    <input type="text" class="form-control text-sm text-danger font-weight-500 border-white bg-white" placeholder="Email" value="<?= $detailMember['email'] ?>" readonly disabled>
                </div>
                <div class="form-group">
                    <?php $flashGender = $flash->get('gender'); ?>
                    <label class="label-account font-weight-700" for="gender"><?= gioitinh ?></label>
                    <select class="select-gender custom-select text-sm font-weight-500 cursor-pointer" required id="gender" name="gender">
                        <option value="">Chọn giới tính</option>
                        <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : (($detailMember['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                        <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : (($detailMember['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="phone">Số điện thoại</label>
                    <input type="text" class="form-control text-sm font-weight-500" id="phone" name="phone" placeholder="<?= nhapdienthoai ?>" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : $detailMember['phone'] ?>" required>
                </div>
                <div class="form-group">
                    <label class="label-account font-weight-700" for="captcha-info-account">Mã bảo mật</label>
                    <div class="captcha-account input-group align-items-start captcha-image mw-100">
                        <input type="text" class="form-control text-sm font-weight-500 rounded" id="captcha-info-account" name="captcha-info-account" placeholder="Mã bảo mật" required>
                        <div class="input-group-append">
                            <span class="input-group-text text-sm rounded-0 border-0">
                                <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('info-account') ?>/" alt="Mã bảo mật" />
                                <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="info-account">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-account text-center">
            <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="info-user" value="Lưu thay đổi">
        </div>
    </form>
</div>