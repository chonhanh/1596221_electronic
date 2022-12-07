<div class="form-group">
    <div class="card">
        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Hồ sơ nhà tuyển dụng</div>
        <div class="card-body">
            <div class="form-group">
                <div class="avatar d-flex align-items-center justify-content-center mb-3" id="preview-avatar-employer">
                    <div class="avatar-zone mr-3">
                        <label class="avatar-label d-block mb-0">
                            <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden">
                                <?= $func->getImage(['sizes' => '150x150x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Preview avatar employer']) ?>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group" id="preview-fullname-employer">
                <label class="form-label">Tên nhà tuyển dụng:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6" id="preview-phone-employer">
                        <label class="form-label">Điện thoại:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                    <div class="col-6" id="preview-email-employer">
                        <label class="form-label">Email:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                </div>
            </div>
            <div class="form-group" id="preview-address-employer">
                <label class="form-label">Địa chỉ:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
            </div>
            <div class="form-group" id="preview-introduce-employer">
                <label class="form-label">Giới thiệu:</label>
                <textarea class="form-control-plaintext border rounded font-weight-500 text-sm p-2" placeholder="Chưa có thông tin" rows="10" readonly disabled /></textarea>
            </div>
        </div>
    </div>
</div>