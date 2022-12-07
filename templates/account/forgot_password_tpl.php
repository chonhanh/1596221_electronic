<form class="form-account form-forgot-password-account mx-auto" method="post" action="account/quen-mat-khau" enctype="multipart/form-data">
    <div class="title-account text-primary text-uppercase text-center mb-3"><?= $title_crumb ?></div>
    <?= $flash->getMessages("frontend") ?>
    <div class="form-row mb-3">
        <div class="col-12">
            <input type="text" class="form-control text-sm font-weight-500" id="username" name="username" placeholder="Tên đăng nhập (Nhập số điện thoại của bạn)" required autocomplete="off">
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-12">
            <input type="text" class="form-control text-sm font-weight-500" id="email" name="email" placeholder="Nhập địa chỉ email của bạn" required autocomplete="off">
        </div>
    </div>
    <div class="btn-account text-center">
        <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="forgot-password-user" value="Lấy lại mật khẩu">
    </div>
</form>