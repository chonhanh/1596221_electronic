<div class="form-group">
    <div class="card">
        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Hồ sơ nhà tuyển dụng</div>
        <div class="card-body">
            <div class="form-group">
                <div class="avatar d-flex align-items-center justify-content-center mb-3">
                    <div class="avatar-zone mr-3">
                        <label class="avatar-label d-block mb-0">
                            <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden">
                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '215x215x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $productDetail['photo'], 'alt' => $productDetail['photo']]) ?>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Tên nhà tuyển dụng:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailInfo']['fullname'] ?>" readonly disabled>
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
            <div class="form-group">
                <label class="form-label">Giới thiệu:</label>
                <textarea class="form-control text-sm font-weight-500" id="posting_member_introduce_employer" name="dataPostingMemberInfo[introduce]" placeholder="Chưa có thông tin" rows="10" required /><?= $func->decodeHtmlChars($productDetail['rowDetailInfo']['introduce']) ?></textarea>
            </div>
        </div>
    </div>
</div>