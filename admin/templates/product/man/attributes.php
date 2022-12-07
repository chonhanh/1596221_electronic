<?php if (in_array("info-candidate", $configSector['attributes'])) { ?>
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Thông tin ứng viên</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="d-block" for="first_name">Họ và chữ lót:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[first_name]" id="first_name" placeholder="Họ và chữ lót" value="<?= (!empty($flash->has('first_name'))) ? $flash->get('first_name') : @$itemInfo['first_name'] ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="last_name">Tên:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[last_name]" id="last_name" placeholder="Tên" value="<?= (!empty($flash->has('last_name'))) ? $flash->get('last_name') : @$itemInfo['last_name'] ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="birthday">Ngày sinh:</label>
                    <input type="text" class="form-control max-date text-sm" name="dataInfo[birthday]" id="birthday" placeholder="Ngày sinh" value="<?= (!empty($flash->has('birthday'))) ? date("d/m/Y", $flash->get('birthday')) : ((!empty($itemInfo['birthday'])) ? date("d/m/Y", $itemInfo['birthday']) : '') ?>" required readonly autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="gender">Giới tính:</label>
                    <?php $flashGender = $flash->get('gender'); ?>
                    <select class="form-control select2" name="dataInfo[gender]" id="gender" required>
                        <option value="">Chọn giới tính</option>
                        <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$itemInfo['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                        <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$itemInfo['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="phone">Điện thoại:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$itemInfo['phone'] ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="email">Email:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$itemInfo['email'] ?>" required>
                </div>
                <div class="form-group col-12">
                    <label class="d-block" for="address">Địa chỉ:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[address]" id="address" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$itemInfo['address'] ?>" required>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (in_array("info-employer", $configSector['attributes'])) { ?>
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Thông tin nhà tuyển dụng</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="d-block" for="fullname">Tên nhà tuyển dụng:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[fullname]" id="fullname_employer" placeholder="Tên nhà tuyển dụng" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : @$itemInfo['fullname'] ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="phone">Điện thoại:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[phone]" id="phone_employer" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$itemInfo['phone'] ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="d-block" for="email">Email:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[email]" id="email_employer" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$itemInfo['email'] ?>" required>
                </div>
                <div class="form-group col-12">
                    <label class="d-block" for="address">Địa chỉ:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[address]" id="address_employer" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$itemInfo['address'] ?>" required>
                </div>
                <div class="form-group col-12">
                    <label class="d-block" for="introduce">Giới thiệu:</label>
                    <textarea class="form-control text-sm" name="dataInfo[introduce]" id="introduce_employer" placeholder="Giới thiệu" rows="10" required><?= $func->decodeHtmlChars($flash->get('introduce')) ?: $func->decodeHtmlChars(@$itemInfo['introduce']) ?></textarea>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Thông tin khác</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <?php if ($func->hasShop($configSector)) {
                $status_attr_array = (!empty($item['status_attr'])) ? explode(',', $item['status_attr']) : array();
                if (isset($config['product']['check_attr'])) {
                    foreach ($config['product']['check_attr'] as $key => $value) { ?>
                        <?php
                        if ($key == 'dichvu' && !$func->hasService($configSector)) {
                            $showCheckAttr = false;
                        } else if ($key == 'phutung' && !$func->hasAccessary($configSector)) {
                            $showCheckAttr = false;
                        } else {
                            $showCheckAttr = true;
                        }
                        ?>
                        <?php if ($showCheckAttr) { ?>
                            <?php if (empty($item['id_shop'])) { ?>
                                <?php if ($key == 'hienthi') { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2" data-plugin="tooltip" data-html="true" data-placement="top" title="Trạng thái dành cho shop">
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <i class="fas fa-ban align-middle text-primary text-lg align-top p-1"></i>
                                    </div>
                                <?php } else if (!empty($item['id']) && in_array($key, array('dichvu', 'phutung'))) { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2" <?= ($key == 'dichvu') ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "data-plugin='tooltip' data-html='true' data-placement='top' title='Trạng thái dành cho shop'" ?>>
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <i class="<?= (in_array($key, $status_attr_array)) ? 'fas fa-check-square' : 'fas fa-ban' ?> align-middle text-primary text-lg align-top p-1"></i>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2" <?= ($key == 'dichvu') ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "" ?>>
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <div class="custom-control custom-checkbox status-attr-posting d-inline-block align-middle">
                                            <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status_attr[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_attr_array) && empty($item['id']) && $key != 'dichvu') ? 'checked' : ((in_array($key, $status_attr_array)) ? 'checked' : '') ?> value="<?= $key ?>">
                                            <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <?php if (in_array($key, $status_attr_array)) { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2" <?= ($key == 'dichvu') ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "data-plugin='tooltip' data-html='true' data-placement='top' title='Trạng thái dành cho shop'" ?>>
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <i class="fas fa-check-square align-middle text-primary text-lg align-top p-1"></i>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group d-inline-block mb-2 mr-2" <?= ($key == 'dichvu') ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "data-plugin='tooltip' data-html='true' data-placement='top' title='Trạng thái dành cho shop'" ?>>
                                        <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                        <i class="fas fa-ban align-middle text-primary text-lg align-top p-1"></i>
                                    </div>
                                <?php } ?>
                            <?php } ?>
            <?php }
                    }
                }
            } ?>
        </div>

        <div class="form-group">
            <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
            <input type="number" class="form-control form-control-mini d-inline-block align-middle text-sm" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
        </div>

        <div class="row">
            <?php if (in_array("acreage", $configSector['attributes'])) { ?>
                <div class="form-group col-md-4">
                    <label class="d-block" for="acreage">Diện tích:</label>
                    <div class="input-group">
                        <input type="text" class="form-control text-sm" name="data[acreage]" id="acreage" placeholder="Diện tích" value="<?= (!empty($flash->has('acreage'))) ? $flash->get('acreage') : @$item['acreage'] ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text text-sm">M2</div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group col-md-4">
                <label class="d-block" for="regular_price"><?= (in_array("price", $configSector['attributes'])) ? 'Giá' : ((in_array("salary", $configSector['attributes'])) ? 'Mức lương' : '') ?>:</label>
                <div class="input-group">
                    <input type="text" class="form-control text-sm" name="data[regular_price]" id="regular_price" placeholder="<?= (in_array("price", $configSector['attributes'])) ? 'Giá' : ((in_array("salary", $configSector['attributes'])) ? 'Mức lương' : '') ?>" data-label="<?= (in_array("price", $configSector['attributes'])) ? 'Giá' : ((in_array("salary", $configSector['attributes'])) ? 'Mức lương' : '') ?>" value="<?= (!empty($flash->has('regular_price'))) ? $flash->get('regular_price') : @$item['regular_price'] ?>" required>
                    <div class="input-group-append">
                        <?php $flashVariationTypePrice = $flash->get('type-price-id'); ?>
                        <select class="custom-select w-auto rounded-0 text-sm" name="dataVariations[type-price][id]" id="type-price" required>
                            <option value="">Đơn vị</option>
                            <?php if (!empty($typePrice)) {
                                foreach ($typePrice as $v) { ?>
                                    <option <?= ((!empty($itemVariation['loai-gia']) && $itemVariation['loai-gia']['id_variation'] == $v['id']) || ($flashVariationTypePrice == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <input type="hidden" name="dataVariations[type-price][type]" value="loai-gia">
                </div>
            </div>

            <?php if (in_array("info-employer", $configSector['attributes'])) { ?>
                <div class="form-group col-md-4">
                    <label class="d-block" for="gender">Giới tính:</label>
                    <?php $flashGender = $flash->get('gender'); ?>
                    <select class="form-control select2" name="dataInfo[gender]" id="gender_employer" required>
                        <option value="">Chọn giới tính</option>
                        <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$itemInfo['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                        <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$itemInfo['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                        <option <?= (!empty($flashGender) && $flashGender == 3) ? 'selected' : ((@$itemInfo['gender'] == 3) ? 'selected' : '') ?> value="3">Không yêu cầu</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="d-block" for="age_requirement">Yêu cầu độ tuổi:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[age_requirement]" id="age_requirement" placeholder="Yêu cầu độ tuổi" value="<?= (!empty($flash->has('age_requirement'))) ? $flash->get('age_requirement') : @$itemInfo['age_requirement'] ?>" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="d-block" for="application_deadline">Hạn nộp hồ sơ:</label>
                    <input type="text" class="form-control min-date text-sm" name="dataInfo[application_deadline]" id="application_deadline" placeholder="Hạn nộp hồ sơ" value="<?= (!empty($flash->has('application_deadline'))) ? date("d/m/Y", $flash->get('application_deadline')) : ((!empty($itemInfo['application_deadline'])) ? date("d/m/Y", $itemInfo['application_deadline']) : '') ?>" required readonly autocomplete="off">
                </div>

                <div class="form-group col-md-4">
                    <label class="d-block" for="trial_period">Thời gian thử việc:</label>
                    <input type="text" class="form-control text-sm" name="dataInfo[trial_period]" id="trial_period" placeholder="Thời gian thử việc" value="<?= (!empty($flash->has('trial_period'))) ? $flash->get('trial_period') : @$itemInfo['trial_period'] ?>" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="d-block" for="employee_quantity">Số lượng tuyển:</label>
                    <input type="number" class="form-control text-sm" name="dataInfo[employee_quantity]" id="employee_quantity" placeholder="Số lượng tuyển" value="<?= (!empty($flash->has('employee_quantity'))) ? $flash->get('employee_quantity') : @$itemInfo['employee_quantity'] ?>" required>
                </div>
            <?php } ?>

            <div class="form-group-video form-group col-12">
                <label class="d-block">Video:</label>
                <input type="text" class="form-control text-sm mb-3" name="dataVideo[namevi]" id="name_video" placeholder="Tiêu đề" value="<?= (!empty($flash->has('video_namevi'))) ? $flash->get('video_namevi') : @$itemVideo['namevi'] ?>" >
                <?php
                $photoVideoPoster = (!empty($itemVideo['photo'])) ? UPLOAD_PHOTO . $itemVideo['photo'] : '';
                $dimensionVideoPoster = "Width: " . $config['website']['video']['poster']['width'] . " px - Height: " . $config['website']['video']['poster']['height'] . " px (" . $config['website']['video']['poster']['extension'] . ")";
                include TEMPLATE . LAYOUT . "image-poster.php";
                ?>
                <?php if (@$itemVideo['type'] == 'file' && file_exists(UPLOAD_VIDEO . @$itemVideo['video'])) { ?>
                    <?php $videoDetailCheck = (!empty($itemVideo['video'])) ? UPLOAD_VIDEO . $itemVideo['video'] : ''; ?>
                    <div class="mb-2"><a class="btn btn-sm btn-success" target="_blank" href="<?= UPLOAD_VIDEO . @$itemVideo['video'] ?>">Tập tin video hiện tại<i class="fas fa-cloud-download-alt pl-2"></i></a></div>
                <?php } ?>
                <div class="custom-file mb-2">
                    <input type="file" class="custom-file-input" name="video-file" id="file_video" >
                    <label class="custom-file-label" for="file_video" data-browse="Chọn video">Chọn tập tin video</label>
                </div>
                <div class="video-config">
                    <span class="d-block">Định dạng: <strong><?= implode(" | ", $config['website']['video']['extension']) ?></strong></span>
                    <span class="d-block">Tối đa: <strong><?= $config['website']['video']['allow-size'] ?></strong></span>
                </div>
                <input type="hidden" id="existVideo" name="existVideo" value="<?= (!empty($videoDetailCheck) && $func->existFile($videoDetailCheck)) ? true : false ?>">
                <input type="hidden" id="existVideoPhoto" name="existVideoPhoto" value="<?= (!empty($photoVideoPoster) && $func->existFile($photoVideoPoster)) ? true : false ?>">
                <input type="hidden" name="dataVideo[type]" id="video-type" value="file">
            </div>
        </div>
    </div>
</div>

<?php if (in_array("coordinates", $configSector['attributes'])) { ?>
    <?php
    $coordinates = array();
    $coordinates[0] = '10.964127';
    $coordinates[1] = '106.853348';
    $coordsExp = ($flash->has('coordinates')) ? $flash->get('coordinates') : ((!empty($item['coordinates'])) ? $item['coordinates'] : '');
    $coordsExp = (!empty($coordsExp)) ? explode(',', $coordsExp) : '';

    if (is_array($coordsExp)) {
        $coordinates[0] = $coordsExp[0];
        $coordinates[1] = $coordsExp[1];
    }
    ?>
    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Bản đồ</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="alert my-alert alert-info text-sm">Hãy kéo biểu tượng <i class="mb-0 px-1 fas fa-map-marker-alt text-danger"></i> vào đúng vị trí đăng tin của bạn trên bản đồ để khách hàng tiện tìm thấy và tăng độ tin cậy đối với tin đăng của bạn !</div>
            <div id="map-iframe"></div>
            <input type="hidden" id="map-city" name="map-city" />
            <input type="hidden" id="map-IDCity" name="map-IDCity" />
            <input type="hidden" id="map-Latitude" name="map-Latitude" value="<?= $coordinates[0] ?>" />
            <input type="hidden" id="map-Longitude" name="map-Longitude" value="<?= $coordinates[1] ?>" />
            <input type="hidden" id="map-coordinates" name="data[coordinates]" value="" />
            <input type="hidden" id="map-address" name="map-address" />
        </div>
    </div>
<?php } ?>