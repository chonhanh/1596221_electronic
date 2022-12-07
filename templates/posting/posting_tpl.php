<div class="card-posting card bg-light" id="card-posting">
    <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
        <strong class="label-posting-company text-uppercase">Chợ Nhanh</strong>
        <strong class="label-posting-main text-uppercase"><?= $func->get('sector-label-posting-main') ?></strong>
        <div class="label-posting-city text-capitalize">Toàn quốc</div>
    </div>
    <div class="card-body pb-0">
        <?= $flash->getMessages('frontend') ?>
        <div class="response-posting"></div>

        <!-- Preview posting -->
        <div class="d-none" id="form-preview">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-12"><label class="form-label">Danh mục lĩnh vực:</label></div>
                    <div class="col-6" id="preview-item">
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                    <?php if ($func->get('hasSectorSub')) { ?>
                        <div class="col-6" id="preview-sub">
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group" id="preview-name">
                <label class="form-label">Tiêu đề:</label>
                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
            </div>

            <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
                <div class="form-group mb-0">
                    <div class="card bg-light border-0">
                        <div class="card-header bg-primary d-flex align-items-center justify-content-between rounded text-sm text-white mb-3">
                            <span class="text-uppercase font-weight-700"><?= $func->get('photo-label') ?></span>
                            <span>Tối đa 6 tệp</span>
                        </div>
                        <div id="preview-file-uploader"></div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Video</div>
                    <div class="card-body">
                        <div class="mb-2" id="preview-video-poster">
                            <label class="avatar-label d-block mb-0">
                                <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden" id="avatar-poster-preview">
                                    <?= $func->getImage(['class' => 'rounded', 'sizes' => '150x150x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Blank video poster']) ?>
                                </div>
                            </label>
                        </div>
                        <div id="preview-video-name">
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm mb-1" placeholder="Tiêu đề video" readonly disabled>
                        </div>
                        <div id="preview-video-source">
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Tập tin video" readonly disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700"><?= $func->get('content-label') ?></div>
                    <div class="card-body" id="preview-content">
                        <textarea class="form-control-plaintext border rounded font-weight-500 text-sm p-2" placeholder="Chưa có thông tin" rows="10" readonly disabled /></textarea>
                    </div>
                </div>
            </div>

            <?php
            if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                include TEMPLATE . "posting/employer-preview.php";
            } else if (in_array($sector['type'], array('ung-vien'))) {
                include TEMPLATE . "posting/candidate-preview.php";
            }
            ?>

            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin khác</div>
                    <div class="card-body">
                        <?php if ($func->hasService($sector) || $func->hasAccessary($sector)) { ?>
                            <div class="form-group">
                                <div id="preview-status-attr"></div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="form-row">
                                <?php if ($func->hasCart($sector)) { ?>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Danh mục màu sắc:</label>
                                        <div id="preview-colors"></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Danh mục kích cỡ:</label>
                                        <div id="preview-sizes"></div>
                                    </div>
                                <?php } ?>

                                <?php if (in_array($sector['type'], array('nha-tuyen-dung', 'ung-vien'))) { ?>
                                    <div class="col-6 mb-3" id="preview-form-work">
                                        <label class="form-label">Hình thức làm việc:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3" id="preview-experience">
                                        <label class="form-label">Kinh nghiệm:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                <?php } ?>

                                <?php if (in_array("acreage", $sector['attributes'])) { ?>
                                    <div class="col-6 mb-3" id="preview-acreage">
                                        <label class="form-label">Diện tích:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                <?php } ?>

                                <div class="col-6 mb-3" id="preview-regular-price">
                                    <label class="form-label"><?= $func->get('price-label') ?>:</label>
                                    <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                </div>

                                <?php if (in_array($sector['type'], array('nha-tuyen-dung'))) { ?>
                                    <div class="col-6 mb-3" id="preview-gender-employer">
                                        <label class="form-label">Giới tính:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3" id="preview-age-requirement">
                                        <label class="form-label">Yêu cầu độ tuổi:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3" id="preview-application-deadline">
                                        <label class="form-label">Hạn nộp hồ sơ:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3" id="preview-trial-period">
                                        <label class="form-label">Thời gian thử việc:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                    <div class="col-6 mb-3" id="preview-employee-quantity">
                                        <label class="form-label">Số lượng tuyển:</label>
                                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sectorTags)) { ?>
                <div class="form-group">
                    <div class="card">
                        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Từ khóa liên quan</div>
                        <div class="card-body">
                            <div id="preview-tags"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-4" id="preview-city">
                        <label class="form-label"><?= tinhthanh ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                    <div class="col-4" id="preview-district">
                        <label class="form-label"><?= quanhuyen ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                    <div class="col-4" id="preview-wards">
                        <label class="form-label"><?= phuongxa ?>:</label>
                        <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                    </div>
                </div>
            </div>

            <?php if (in_array("coordinates", $sector['attributes'])) { ?>
                <div class="form-group">
                    <div class="card">
                        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Bản đồ</div>
                        <div class="card-body">
                            <div id="preview-map"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group mb-0">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin liên hệ</div>
                    <div class="card-body">
                        <div class="form-group" id="preview-fullname-contact">
                            <label class="form-label">Họ tên:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                        </div>
                        <div class="form-group" id="preview-phone-contact">
                            <label class="form-label">Số điện thoại:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                        </div>
                        <div class="form-group" id="preview-address-contact">
                            <label class="form-label">Địa chỉ:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                        </div>
                        <div class="form-group" id="preview-email-contact">
                            <label class="form-label">Email:</label>
                            <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-posting position-sticky d-flex align-items-center justify-content-center bg-light w-100 p-3">
                <input type="button" class="btn btn-sm btn-info text-white text-capitalize font-weight-500 py-2 px-3 mx-2" name="preview-posting" value="Trở lại đăng tin">
            </div>
        </div>

        <!-- Main posting -->
        <form id="form-posting" method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <select class="select-item custom-select text-sm cursor-pointer" id="id_item" name="dataPosting[id_item]" data-level="2" data-table="table_product_sub" data-child="id_sub" required>
                            <option value=""><?= $func->get('sector-label-posting-item') ?></option>
                            <?php if (!empty($sectorItems)) {
                                foreach ($sectorItems as $v_item) { ?>
                                    <option value="<?= $v_item['id'] ?>"><?= $v_item['name' . $lang] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <?php if ($func->get('hasSectorSub')) { ?>
                        <div class="col-6">
                            <select class="select-sub custom-select text-sm cursor-pointer" id="id_sub" name="dataPosting[id_sub]" data-level="" data-table="" data-child="" required>
                                <option value=""><?= $func->get('sector-label-posting-sub') ?></option>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label font-weight-500" for="namevi">Tiêu đề:</label>
                <input type="text" class="form-control text-sm" id="namevi" name="dataPosting[namevi]" placeholder="Tiêu đề tin đăng" required>
            </div>

            <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
                <div class="form-group">
                    <div class="card bg-light border-0">
                        <div class="card-header bg-primary d-flex align-items-center justify-content-between rounded text-sm text-white mb-3">
                            <span class="text-uppercase font-weight-700"><?= $func->get('photo-label') ?></span>
                            <span>Tối đa 6 tệp</span>
                        </div>
                        <div class="posting-file-uploader custom-file-uploader">
                            <input type="file" id="files-uploader-posting" name="files-uploader-posting">
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group-video form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Video</div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="avatar d-flex align-items-center justify-content-start">
                                <div class="avatar-zone mr-3">
                                    <label class="avatar-label d-block mb-0" id="avatar-poster-label" for="avatar-poster">
                                        <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden" id="avatar-poster-preview">
                                            <?= $func->getImage(['class' => 'lazy rounded', 'sizes' => '150x150x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Blank video poster']) ?>
                                        </div>
                                        <input type="file" class="d-none" name="file-poster" id="avatar-poster">
                                    </label>
                                </div>
                                <div class="avatar-dimension">
                                    <p class="mb-0">Hình ảnh đại diện cho <strong>Video</strong></p>
                                    <p class="mb-0">Định dạng: <strong><?= $config['website']['video']['poster']['extension'] ?></strong></p>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="form-control text-sm mb-2" name="dataPostingVideo[namevi]" id="name_video" placeholder="Tiêu đề">
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" name="video-file" id="file_video">
                            <label class="custom-file-label" for="file_video" data-browse="Chọn video">Chọn tập tin video</label>
                        </div>
                        <div class="video-config">
                            <span class="d-inline-block mr-2">Định dạng: <strong><?= implode(" | ", $config['website']['video']['extension']) ?></strong></span>
                            <span class="d-inline-block">Tối đa: <strong><?= $config['website']['video']['allow-size'] ?></strong></span>
                        </div>
                        <input type="hidden" name="dataPostingVideo[type]" id="video-type" value="file">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700"><?= $func->get('content-label') ?></div>
                    <div class="card-body">
                        <textarea class="form-control text-sm" id="contentvi" name="dataPostingContent[contentvi]" placeholder="<?= $func->get('content-desc') ?>" rows="10" data-label="<?= $func->get('content-label') ?>" required /></textarea>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin khác</div>
                    <div class="card-body">
                        <?php if ($func->hasService($sector) || $func->hasAccessary($sector)) { ?>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox d-inline-block align-top status-attr-posting mb-1" <?= ($func->hasService($sector)) ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "" ?>>
                                    <input type="checkbox" class="custom-control-input" id="status_attr" name="dataPosting[status_attr]" value="<?= ($func->hasService($sector)) ? 'service' : (($func->hasAccessary($sector)) ? 'accessary' : '') ?>">
                                    <label class="custom-control-label" for="status_attr"><?= ($func->hasService($sector)) ? '<span>Tin đăng thuộc lĩnh vực</span><strong class="text-danger pl-1">Dịch vụ giấy tờ</strong>' : (($func->hasAccessary($sector)) ? '<span>Tin đăng thuộc lĩnh vực</span><strong class="text-danger pl-1">Phụ tùng</strong>' : '') ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($func->hasCart($sector)) { ?>
                            <div class="form-group mb-3">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label class="form-label font-weight-500">Danh mục màu sắc:</label>
                                        <?= $func->getSale('color', 'dataPostingColor') ?>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label font-weight-500">Danh mục kích cỡ:</label>
                                        <?= $func->getSale('size', 'dataPostingSize', 0, $sector['id']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="form-row">
                                <?php if (in_array("acreage", $sector['attributes'])) { ?>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="acreage">Diện tích:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-sm" id="acreage" name="dataPosting[acreage]" placeholder="Diện tích" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text text-sm">M2</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-6 mb-3">
                                    <label class="form-label font-weight-500" for="regular_price"><?= $func->get('price-label') ?>:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-sm" name="dataPosting[regular_price]" id="regular_price" placeholder="<?= $func->get('price-label') ?>" data-label="<?= $func->get('price-label') ?>" value="" required="">
                                        <div class="input-group-append">
                                            <select class="select-type-price custom-select cursor-pointer w-auto rounded-0 text-sm" name="dataPostingVariations[type-price][id]" id="type-price" required>
                                                <option value="">Đơn vị</option>
                                                <?php if (!empty($typePrice)) {
                                                    foreach ($typePrice as $v_typeprice) { ?>
                                                        <option value="<?= $v_typeprice['id'] ?>"><?= $v_typeprice['name' . $lang] ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <input type="hidden" name="dataPostingVariations[type-price][type]" value="loai-gia">
                                    </div>
                                </div>

                                <?php if (in_array($sector['type'], array('nha-tuyen-dung'))) { ?>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="gender_employer">Giới tính:</label>
                                        <select class="select-gender custom-select text-sm cursor-pointer" name="dataPostingInfo[gender]" id="gender_employer" required>
                                            <option value="">Chọn giới tính</option>
                                            <option value="1">Nam</option>
                                            <option value="2">Nữ</option>
                                            <option value="3">Không yêu cầu</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="age_requirement">Yêu cầu độ tuổi:</label>
                                        <input type="text" class="form-control text-sm" id="age_requirement" name="dataPostingInfo[age_requirement]" placeholder="Yêu cầu độ tuổi" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="application_deadline">Hạn nộp hồ sơ:</label>
                                        <input type="text" class="form-control min-date text-sm" id="application_deadline" name="dataPostingInfo[application_deadline]" placeholder="Hạn nộp hồ sơ" required readonly>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="trial_period">Thời gian thử việc:</label>
                                        <input type="text" class="form-control text-sm" id="trial_period" name="dataPostingInfo[trial_period]" placeholder="Thời gian thử việc" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label font-weight-500" for="employee_quantity">Số lượng tuyển:</label>
                                        <input type="number" class="form-control text-sm" id="employee_quantity" name="dataPostingInfo[employee_quantity]" placeholder="Số lượng tuyển" required>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($sectorTags)) { ?>
                <div class="form-group">
                    <div class="card">
                        <div class="card-header bg-primary text-sm text-white text-uppercase font-weight-700">Từ khóa liên quan</div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($sectorTags as $v_tag) { ?>
                                    <div class="col-4">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input" id="tags-<?= $v_tag['id'] ?>" name="dataPostingTags[]" value="<?= $v_tag['id'] ?>">
                                            <label class="custom-control-label" for="tags-<?= $v_tag['id'] ?>"><?= $v_tag['name' . $lang] ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-4">
                        <label class="form-label font-weight-500" for="id_city"><?= tinhthanh ?>:</label>
                        <select class="select-city custom-select text-sm cursor-pointer" id="id_city" name="dataPosting[id_city]" data-load-title="true" data-title-element=".label-posting-city" required>
                            <option value=""><?= tinhthanh ?></option>
                            <?php if (!empty($city)) {
                                foreach ($city as $v_city) { ?>
                                    <option value="<?= $v_city['id'] ?>"><?= $v_city['name'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label font-weight-500" for="id_district"><?= quanhuyen ?>:</label>
                        <select class="select-district custom-select text-sm cursor-pointer" id="id_district" name="dataPosting[id_district]" required>
                            <option value=""><?= quanhuyen ?></option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label font-weight-500" for="id_wards"><?= phuongxa ?>:</label>
                        <select class="select-wards custom-select text-sm cursor-pointer" id="id_wards" name="dataPosting[id_wards]" required>
                            <option value=""><?= phuongxa ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <?php /*if (in_array("coordinates", $sector['attributes'])) { ?>
                <div class="form-group">
                    <div class="card">
                        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Bản đồ</div>
                        <div class="card-body">
                            <div class="alert alert-info text-sm">Hãy kéo biểu tượng <i class="h6 mb-0 px-1 fas fa-map-marker-alt text-danger"></i> vào đúng vị trí đăng tin của bạn trên bản đồ để khách hàng tiện tìm thấy và tăng độ tin cậy đối với tin đăng của bạn !</div>
                            <div id="map-posting"></div>
                            <input type="hidden" id="map-city-posting" name="city-posting" />
                            <input type="hidden" id="map-IDCity-posting" name="map-IDCity-posting" />
                            <input type="hidden" id="map-Latitude-posting" name="Latitude" value="10.964127" />
                            <input type="hidden" id="map-Longitude-posting" name="Longitude" value="106.853348" />
                            <input type="hidden" id="map-coordinates-posting" name="dataPosting[coordinates]" value="" />
                            <input type="hidden" id="map-address-posting" name="map-address-posting" />
                        </div>
                    </div>
                </div>
            <?php }*/ ?>

            <div class="form-group mb-0">
                <div class="card">
                    <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Thông tin liên hệ</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label font-weight-500" for="fullname_contact">Họ tên:</label>
                            <input type="text" class="form-control text-sm" id="fullname_contact" name="dataPostingContact[fullname]" placeholder="Họ tên liên hệ" value="<?= $func->getMember('fullname') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-weight-500" for="phone_contact">Số điện thoại:</label>
                            <input type="text" class="form-control text-sm" id="phone_contact" name="dataPostingContact[phone]" placeholder="Số điện thoại liên hệ" value="<?= $func->getMember('phone') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-weight-500" for="address_contact">Địa chỉ:</label>
                            <input type="text" class="form-control text-sm" id="address_contact" name="dataPostingContact[address]" placeholder="Địa chỉ liên hệ" value="<?= $func->getMember('address') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-weight-500" for="email_contact">Email:</label>
                            <input type="text" class="form-control text-sm" id="email_contact" name="dataPostingContact[email]" placeholder="Email liên hệ" value="<?= $func->getMember('email') ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-posting position-sticky d-flex align-items-center justify-content-center bg-light w-100 p-3">
                <input type="button" class="btn btn-sm btn-info text-white text-capitalize font-weight-500 py-2 px-3 mx-2" name="preview-posting" value="Xem trước tin đăng">
                <input type="submit" class="btn btn-sm btn-primary text-white text-capitalize font-weight-500 py-2 px-3 mx-2" name="submit-posting" value="Hoàn tất tin đăng">
            </div>
        </form>
    </div>
</div>