<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if ($productDetail['status'] == 'vipham') { ?>
        <div class="alert alert-danger">Tin đăng đã bị khóa do vi phạm hoặc bị chặn nhiều lần.</div>
        <div class="text-center">
            <a class="btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3 mx-2" href="account/tin-dang?sector=<?= $IDSector ?>" title="Quay lại tin đăng">Quay lại tin đăng</a>
        </div>
    <?php } else { ?>
        <div class="lists-sector mb-4">
            <?php foreach ($sectors as $v_sector) { ?>
                <a class="btn btn-sm <?= ($IDSector == $v_sector['id']) ? 'btn-primary' : 'btn-outline-primary' ?> d-inline-block text-capitalize py-2 px-3 mr-2" href="account/tin-dang?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
            <?php } ?>
        </div>

        <?= $flash->getMessages('frontend') ?>

        <form class="form-posting-account" method="post" action="account/cap-nhat-tin-dang" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Tiêu đề:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['namevi'] ?>" readonly disabled>
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-12"><label class="form-label">Danh mục lĩnh vực:</label></div>
                    <div class="<?= ($func->get('hasSectorSub')) ? 'col-4' : 'col-6' ?>">
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['sectorCatDetail']['name' . $lang] ?>" readonly disabled>
                    </div>
                    <div class="<?= ($func->get('hasSectorSub')) ? 'col-4' : 'col-6' ?>">
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['sectorItemDetail']['name' . $lang] ?>" readonly disabled>
                    </div>
                    <?php if ($func->get('hasSectorSub')) { ?>
                        <div class="col-4">
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['sectorSubDetail']['name' . $lang] ?>" readonly disabled>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php if (in_array($sector['type'], array('nha-tuyen-dung', 'ung-vien'))) { ?>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-6">
                            <label class="form-label">Hình thức làm việc:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $variation->get($tableProductVariation, $productDetail['id'], 'hinh-thuc-lam-viec', $lang) ?>" readonly disabled>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kinh nghiệm:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $variation->get($tableProductVariation, $productDetail['id'], 'kinh-nghiem', $lang) ?>" readonly disabled>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                        <label class="form-label"><?= tinhthanh ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['cityDetail']['name'] ?>" readonly disabled>
                    </div>
                    <div class="col-4">
                        <label class="form-label"><?= quanhuyen ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['districtDetail']['name'] ?>" readonly disabled>
                    </div>
                    <div class="col-4">
                        <label class="form-label"><?= phuongxa ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['wardsDetail']['name'] ?>" readonly disabled>
                    </div>
                </div>
            </div>

            <?php if ($func->hasCart($sector) && !strstr($productDetail['status_attr'], 'dichvu')) { ?>
                <div class="card mb-3">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700"><strong class="text-capitalize">Thông tin bán hàng</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Màu sắc:</label>
                            <div>
                                <?php if (!empty($productDetail['rowDetailSale']['colors'])) {
                                    foreach ($productDetail['rowDetailSale']['colors'] as $v_color) { ?>
                                        <label class="border mr-1 px-2 py-1"><?= $v_color['namevi'] ?></label>
                                    <?php }
                                } else { ?>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Kích cỡ:</label>
                            <div>
                                <?php if (!empty($productDetail['rowDetailSale']['sizes'])) {
                                    foreach ($productDetail['rowDetailSale']['sizes'] as $v_color) { ?>
                                        <label class="border mr-1 px-2 py-1"><?= $v_color['namevi'] ?></label>
                                    <?php }
                                } else { ?>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                include TEMPLATE . "account/posting/employer.php";
            } else if (in_array($sector['type'], array('ung-vien'))) {
                include TEMPLATE . "account/posting/candidate.php";
            }
            ?>

            <div class="card mb-3">
                <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700"><strong class="text-capitalize">Từ khóa liên quan</strong></div>
                <div class="card-body">
                    <?php if (!empty($productDetail['rowDetailTags'])) { ?>
                        <div class="row">
                            <?php foreach ($productDetail['rowDetailTags'] as $v_tags) { ?>
                                <div class="col-4">
                                    <div class="nav-awesome"><i class="far fa-check-square text-success mr-1"></i><?= $v_tags['name' . $lang] ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="text-center text-secondary text-sm"><strong>Chưa có thông tin</strong></div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin khác</div>
                    <div class="card-body">
                        <?php if ($func->hasService($sector)) { ?>
                            <div class="form-group">
                                <div class="nav-awesome"><?= (strstr($productDetail['status_attr'], 'dichvu')) ? '<i class="far fa-check-square text-success mr-1"></i>' : '<i class="fas fa-ban text-secondary mr-1"></i>' ?><span>Tin đăng thuộc lĩnh vực</span><strong class="text-danger pl-1">Dịch vụ giấy tờ</strong></div>
                            </div>
                        <?php } else if ($func->hasAccessary($sector)) { ?>
                            <div class="form-group">
                                <div class="nav-awesome"><?= (strstr($productDetail['status_attr'], 'phutung')) ? '<i class="far fa-check-square text-success mr-1"></i>' : '<i class="fas fa-ban text-secondary mr-1"></i>' ?><span>Tin đăng thuộc lĩnh vực</span><strong class="text-danger pl-1">Phụ tùng</strong></div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="form-row">
                                <?php if (in_array("acreage", $sector['attributes'])) { ?>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Diện tích:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['acreage'] . ' m2' ?>" readonly disabled>
                                    </div>
                                <?php } ?>
                                <div class="col-6 mb-3">
                                    <label class="form-label"><?= $func->get('price-label') ?>:</label>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['regular_price'] . ' ' . $variation->get($tableProductVariation, $productDetail['id'], 'loai-gia', $lang) ?>" readonly disabled>
                                </div>
                                <?php if (in_array($sector['type'], array('nha-tuyen-dung'))) { ?>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Giới tính:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['gender'])) ? $func->getGender($productDetail['rowDetailInfo']['gender']) : '' ?>" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Yêu cầu độ tuổi:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['age_requirement'])) ? $productDetail['rowDetailInfo']['age_requirement'] : '' ?>" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Hạn nộp hồ sơ:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['application_deadline'])) ? date("d/m/Y", $productDetail['rowDetailInfo']['application_deadline']) : '' ?>" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Thời gian thử việc:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['trial_period'])) ? $productDetail['rowDetailInfo']['trial_period'] : '' ?>" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Số lượng tuyển:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= (!empty($productDetail['rowDetailInfo']['employee_quantity'])) ? $productDetail['rowDetailInfo']['employee_quantity'] : '' ?>" readonly disabled>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($productDetail['rowDetailVideo'])) { ?>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Video:</label>
                                        <?php if ($productDetail['rowDetailVideo']['type'] == 'file') { ?>
                                            <div class="mb-2"><?= $func->getImage(['class' => 'lazy rounded', 'sizes' => '290x220x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $productDetail['rowDetailVideo']['photo'], 'alt' => $productDetail['rowDetailVideo']['video']]) ?></div>
                                        <?php } ?>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Tiêu đề video (Chưa có thông tin)" value="<?= $productDetail['rowDetailVideo']['name' . $lang] ?>" readonly disabled>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Đường dẫn/tập tin video (Chưa có thông tin)" value="<?= $productDetail['rowDetailVideo']['video'] ?>" readonly disabled>
                                    </div>
                                <?php } ?>
                                <div class="col-12">
                                    <label class="form-label"><?= $func->get('content-label') ?>:</label>
                                    <textarea class="form-control text-sm font-weight-500" id="posting_member_contentvi" name="dataPostingMemberContent[contentvi]" placeholder="Chưa có thông tin" rows="10" required /><?= $func->decodeHtmlChars($productDetail['rowDetailContent']['content' . $lang]) ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
                <div class="form-group mb-0">
                    <div class="card bg-light border-0">
                        <div class="card-header bg-primary rounded text-sm text-white mb-3">
                            <span class="text-uppercase font-weight-700"><?= $func->get('photo-label') ?></span>
                        </div>
                        <?php if (!empty($productDetail['rowDetailPhoto'])) { ?>
                            <div class="posting-account-file-uploader custom-file-uploader">
                                <div class="fileuploader-items">
                                    <ul class="fileuploader-items-list mt-0">
                                        <?php foreach ($productDetail['rowDetailPhoto'] as $v_photo) { ?>
                                            <li class="fileuploader-item">
                                                <div class="columns">
                                                    <div class="column-thumbnail">
                                                        <div class="fileuploader-item-image"><?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '205x205x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_photo['photo'], 'alt' => $v_photo['photo']]) ?></div>
                                                        <span class="fileuploader-action-popup"></span>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="text-center text-secondary text-sm mb-3"><strong>Chưa có hình ảnh</strong></div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if (in_array("coordinates", $sector['attributes'])) { ?>
                <div class="form-group">
                    <div class="card">
                        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Bản đồ</div>
                        <div class="card-body">
                            <iframe src="https://maps.google.com/maps?q=<?= $productDetail['coordinates'] ?>&z=15&output=embed" width="100%" height="350" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group mb-0">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin liên hệ</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Họ tên:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailContact']['fullname'] ?>" readonly disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Số điện thoại:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailContact']['phone'] ?>" readonly disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Địa chỉ:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailContact']['address'] ?>" readonly disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" value="<?= $productDetail['rowDetailContact']['email'] ?>" readonly disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-posting position-sticky d-flex align-items-center justify-content-center bg-light w-100 p-3">
                <button type="submit" class="btn btn-sm btn-primary text-white text-capitalize font-weight-500 py-2 px-3 mx-2" name="action-posting-user" value="update-posting">Cập nhật tin đăng</button>
                <?php if ($productDetail['status'] == 'dangsai') { ?>
                    <button type="submit" class="btn btn-sm btn-warning text-dark text-capitalize font-weight-500 py-2 px-3 mx-2" name="action-posting-user" value="fix-posting">Xác nhận chỉnh sửa</button>
                <?php } ?>
                <input type="hidden" name="IDSector" value="<?= $sector['id'] ?>">
                <input type="hidden" name="IDPosting" value="<?= $productDetail['id'] ?>">
            </div>
        </form>
    <?php } ?>
</div>