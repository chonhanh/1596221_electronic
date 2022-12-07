<div class="form-group">
    <div class="card">
        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Hồ sơ nhà tuyển dụng</div>
        <div class="card-body">
            <div class="form-group">
                <div class="avatar d-flex align-items-center justify-content-start mb-3">
                    <div class="avatar-zone mr-3">
                        <label class="avatar-label d-block mb-0" id="avatar-employer-label" for="avatar-employer">
                            <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden" id="avatar-employer-preview">
                                <?= $func->getImage(['sizes' => '150x150x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Blank avatar employer']) ?>
                            </div>
                            <input type="file" class="d-none" name="file_employer" id="avatar-employer">
                        </label>
                    </div>
                    <div class="avatar-dimension">
                        <p class="mb-0">Hình ảnh đại diện cho <strong>Nhà tuyển dụng</strong></p>
                        <p class="mb-0">Định dạng: <strong>.jpg, .png</strong></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label font-weight-500">Tên nhà tuyển dụng:</label>
                <input type="text" class="form-control text-sm" id="fullname_employer" name="dataPostingInfo[fullname]" placeholder="Tên nhà tuyển dụng" required>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label font-weight-500" for="phone_employer">Điện thoại:</label>
                        <input type="text" class="form-control text-sm" id="phone_employer" name="dataPostingInfo[phone]" placeholder="Điện thoại" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-500" for="email_employer">Email:</label>
                        <input type="text" class="form-control text-sm" id="email_employer" name="dataPostingInfo[email]" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label font-weight-500" for="address_employer">Địa chỉ:</label>
                <input type="text" class="form-control text-sm" id="address_employer" name="dataPostingInfo[address]" placeholder="Địa chỉ" required>
            </div>
            <div class="form-group">
                <label class="form-label font-weight-500" for="introduce_employer">Giới thiệu:</label>
                <textarea class="form-control text-sm" id="introduce_employer" name="dataPostingInfo[introduce]" placeholder="Giới thiệu về nhà tuyển dụng" rows="10" required /></textarea>
            </div>
        </div>
    </div>
</div>