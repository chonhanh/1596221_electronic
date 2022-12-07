<div class="form-group">
    <div class="card">
        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Hồ sơ ứng viên</div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label">Họ và chữ lót:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['first_name'] ?>" readonly disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tên:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['last_name'] ?>" readonly disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label">Ngày sinh:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['birthday'] ?>" readonly disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Giới tính:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['gender'])) ? $func->getGender($productDetail['rowDetailInfo']['gender']) : '' ?>" readonly disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label">Điện thoại:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['phone'] ?>" readonly disabled>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Email:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['email'] ?>" readonly disabled>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Địa chỉ:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['address'] ?>" readonly disabled>
            </div>
        </div>
    </div>
</div>