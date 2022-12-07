<form class="form-account form-activation-account mx-auto" method="post" action="account/kich-hoat?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
    <div class="title-account text-primary text-uppercase text-center mb-3"><?= $title_crumb ?></div>
    <?= $flash->getMessages("frontend") ?>
    <p class="text-center mb-1">Chúng tôi đã gửi <strong class="text-danger">Mã Xác Nhận</strong> qua địa chỉ email của bạn.</p>
    <p class="text-center mb-4">Nếu không tìm thấy mã xác thực trên <strong class="text-danger">Hộp Thư Đến</strong> thì bạn vui lòng tìm trên <strong class="text-danger">Spam</strong> và nhập mã xác nhận để hoàn thành các thao tác đăng ký Thành viên của bạn.</p>
    <div class="form-row mb-3">
        <div class="col-12">
            <input type="text" class="form-control text-sm font-weight-500" id="confirm_code" name="confirm_code" placeholder="<?= nhapmakichhoat ?>" required>
        </div>
    </div>
    <div class="btn-account text-center">
        <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="activation-user" value="Kích hoạt thành viên">
    </div>
</form>