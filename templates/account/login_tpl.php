<form class="form-account form-login-account mx-auto" method="post" action="account/dang-nhap<?= (!empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '' ?>" enctype="multipart/form-data">
    <div class="title-account text-primary text-uppercase text-center mb-3">Mời bạn đăng nhập</div>
    <?= $flash->getMessages("frontend") ?>
    <div class="form-row mb-3">
        <div class="col-12">
            <input type="text" class="form-control text-sm font-weight-500" id="username" name="username" placeholder="Tên đăng nhập (Nhập số điện thoại của bạn)" required autocomplete="off">
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-12">
            <div class="input-group control-password">
                <input type="password" class="form-control text-sm font-weight-500" id="password" name="password" placeholder="<?= matkhau ?>" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="remember-account custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="remember-user" id="remember-user" value="1">
            <label class="custom-control-label" for="remember-user"><?= nhomatkhau ?></label>
        </div>
        <a class="text-decoration-none text-primary transition" href="account/quen-mat-khau" title="Quên mật khẩu">Quên mật khẩu</a>
    </div>
    <div class="btn-account text-center">
        <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="login-user" value="Đăng nhập">
    </div>
</form>