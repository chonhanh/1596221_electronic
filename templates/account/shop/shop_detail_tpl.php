<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if ($shopDetail['status'] == 'vipham') { ?>
        <div class="alert alert-danger">Gian hàng đã bị khóa do vi phạm hoặc bị chặn nhiều lần.</div>
        <div class="text-center">
            <a class="btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3 mx-2" href="account/gian-hang?sector=<?= $IDSector ?>" title="Quay lại gian hàng">Quay lại gian hàng</a>
        </div>
    <?php } else { ?>
        <div class="lists-sector mb-4">
            <?php foreach ($sectors as $v_sector) {
                if (in_array($v_sector['type'], $defineSectors['hasShop']['types'])) { ?>
                    <a class="btn btn-sm <?= ($IDSector == $v_sector['id']) ? 'btn-primary' : 'btn-outline-primary' ?> d-inline-block text-capitalize py-2 px-3 mr-2" href="account/gian-hang?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
            <?php }
            } ?>
        </div>

        <?= $flash->getMessages('frontend') ?>

        <form id="form-shop-account" method="post" action="account/cap-nhat-gian-hang" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">Danh mục lĩnh vực:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['nameSectorCat'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cửa hàng:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['nameStore'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?= tinhthanh ?>:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['nameCity'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?= quanhuyen ?>:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['nameDistrict'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?= phuongxa ?>:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['nameWard'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tên gian hàng:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['name'] ?>" readonly disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mật khẩu:</label>
                            <div class="input-group control-password">
                                <input type="password" class="form-control font-weight-500 text-sm" id="shop_member_password" name="dataShopMember[password]" placeholder="Mật khẩu" value="<?= $shopDetail['password'] ?>" required>
                                <div class="input-group-append">
                                    <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-6">
                                    <label class="form-label">Số điện thoại:</label>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['phone'] ?>" readonly disabled>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Email:</label>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $shopDetail['email'] ?>" readonly disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="avatar avatar-shop mb-3">
                            <div class="avatar-zone text-center">
                                <label class="form-label bg-warning w-100 text-uppercase rounded-top font-weight-700 px-1 py-2 mb-0">Hình đại diện</label>
                                <label class="avatar-label d-block mb-0" id="avatar-shop-account-label" for="avatar-shop-account">
                                    <div class="avatar-detail h-auto border border-top-0 rounded-bottom overflow-hidden p-2" id="avatar-shop-account-preview">
                                        <?= $func->getImage(['sizes' => '380x260x1', 'upload' => UPLOAD_SHOP_L, 'image' => $shopDetail['photo'], 'alt' => $shopDetail['photo']]) ?>
                                    </div>
                                    <input type="file" class="d-none" name="file_shop" id="avatar-shop-account">
                                </label>
                            </div>
                            <div class="text-center mt-2"><label class="btn btn-sm btn-success py-2 px-3 mb-0" for="avatar-shop-account">Đổi hình</label></div>
                        </div>
                        <div class="avatar avatar-shop" id="preview-interface-shop">
                            <div class="avatar-zone text-center">
                                <label class="avatar-label d-inline-block align-top mx-auto mb-0">
                                    <label class="form-label bg-warning w-100 text-uppercase rounded-top font-weight-700 px-1 py-2 mb-0"><?= $shopDetail['nameInterface'] ?></label>
                                    <div class="avatar-detail h-auto border border-top-0 rounded-bottom overflow-hidden" id="interface-shop-preview"><?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '380x280x1', 'upload' => UPLOAD_INTERFACE_L, 'image' => $shopDetail['photoInterface'], 'alt' => $shopDetail['nameInterface']]) ?></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label class="form-label font-weight-700 text-uppercase text-danger">Địa chỉ gian hàng của bạn:</label>
                    <a class="d-block border-bottom font-weight-500 font-italic text-primary text-sm text-decoration-none pt-2 pb-2" target="_blank" href="<?= $configBaseShop . $shopDetail['slug_url'] ?>/" title="Địa chỉ gian hàng"><?= $configBaseShop . $shopDetail['slug_url'] ?>/</a>
                    <small class="form-text text-muted">(Địa chỉ này dùng để truy cập hoặc giới thiệu khách hàng vào trang gian hàng của bạn)</small>
                </div>
                <div class="form-group">
                    <label class="form-label font-weight-700 text-uppercase text-danger">Địa chỉ quản trị gian hàng của bạn:</label>
                    <a class="d-block border-bottom font-weight-500 font-italic text-primary text-sm text-decoration-none pt-2 pb-2" target="_blank" href="<?= $configBaseShop . $shopDetail['slug_url'] . '/admin/' ?>" title="Địa chỉ quản trị gian hàng"><?= $configBaseShop . $shopDetail['slug_url'] . '/admin/' ?></a>
                    <small class="form-text text-muted">(Địa chỉ sẽ được sử dụng để truy cập vào trang quản trị "điều hành" gian hàng của bạn)</small>
                </div>
            </div>
            <div class="action-shop position-sticky d-flex align-items-center justify-content-center bg-light w-100 p-3">
                <button type="submit" class="btn btn-sm btn-primary text-white text-capitalize font-weight-500 py-2 px-3 mx-2" name="action-shop-user" value="update-shop">Cập nhật gian hàng</button>
                <?php if ($shopDetail['status'] == 'dangsai') { ?>
                    <button type="submit" class="btn btn-sm btn-warning text-dark text-capitalize font-weight-500 py-2 px-3 mx-2" name="action-shop-user" value="fix-shop">Xác nhận chỉnh sửa</button>
                <?php } ?>
                <input type="hidden" name="IDSector" value="<?= $sector['id'] ?>">
                <input type="hidden" name="IDShop" value="<?= $shopDetail['id'] ?>">
            </div>
        </form>
    <?php } ?>
</div>