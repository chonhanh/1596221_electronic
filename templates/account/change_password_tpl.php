<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <form class="form-account form-change-password-account mx-auto" method="post" action="account/doi-mat-khau" enctype="multipart/form-data">
        <?= $flash->getMessages("frontend") ?>
        <div class="form-group">
            <label class="label-account font-weight-700" for="old-password">Mật khẩu cũ</label>
            <div class="input-group control-password">
                <input type="password" class="form-control text-sm font-weight-500" id="old-password" name="old-password" placeholder="Nhập mật khẩu cũ" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="label-account font-weight-700" for="new-password">Mật khẩu mới</label>
            <div class="input-group control-password" data-plugin="tooltip" data-html="true" data-placement="top" title="<ul class='list-unstyled text-warning text-left mb-0'><li class='text-light text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>">
                <input type="password" class="form-control text-sm font-weight-500" id="new-password" name="new-password" placeholder="Nhập mật khẩu mới" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="label-account font-weight-700" for="new-password-confirm">Xác nhận mật khẩu mới</label>
            <div class="input-group control-password">
                <input type="password" class="form-control text-sm font-weight-500" id="new-password-confirm" name="new-password-confirm" placeholder="Nhập lại mật khẩu mới" required>
                <div class="input-group-append">
                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="btn-account text-center">
            <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="change-password-user" value="Đổi mật khẩu">
        </div>
    </form>
</div>