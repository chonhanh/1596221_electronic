<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Thông tin khác</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <?php
            $status_attr_array = (!empty($item['status_attr'])) ? explode(',', $item['status_attr']) : array();
            if (isset($config['product']['check'])) {
                foreach ($config['product']['check'] as $key => $value) { ?>
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
                        <?php if (!empty($item['id']) && in_array($key, array('dichvu', 'phutung'))) { ?>
                            <div class="form-group d-inline-block mb-2 mr-2" <?= ($key == 'dichvu') ? "data-plugin='tooltip' data-html='true' data-placement='top' title='Tin đăng chuyên về lĩnh vực <span class=\"text-info\">Giấy Tờ</span> <span class=\"text-warning\">(Không khả dụng cho mục Giỏ hàng: Màu sắc, Kích cỡ)</span>'" : "data-plugin='tooltip' data-html='true' data-placement='top' title='Trạng thái chỉ được chọn duy nhất 1 lần'" ?>>
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
            <?php }
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

            <div class="form-group-video form-group col-12">
                <label class="d-block">Video:</label>
                <input type="text" class="form-control text-sm mb-3" name="dataVideo[namevi]" id="name_video" placeholder="Tiêu đề" value="<?= (!empty($flash->has('video_namevi'))) ? $flash->get('video_namevi') : @$itemVideo['namevi'] ?>">
                <?php
                $photoVideoPoster = (!empty($itemVideo['photo'])) ? UPLOAD_PHOTO_ADMIN . $itemVideo['photo'] : '';
                $photoVideoPosterCheck = (!empty($itemVideo['photo'])) ? UPLOAD_PHOTO . $itemVideo['photo'] : '';
                $dimensionVideoPoster = "Width: " . $config['website']['video']['poster']['width'] . " px - Height: " . $config['website']['video']['poster']['height'] . " px (" . $config['website']['video']['poster']['extension'] . ")";
                include TEMPLATE . LAYOUT . "image-poster.php";
                ?>
                <?php if (@$itemVideo['type'] == 'file' && file_exists(UPLOAD_VIDEO . @$itemVideo['video'])) { ?>
                    <?php $videoDetailCheck = (!empty($itemVideo['video'])) ? UPLOAD_VIDEO . $itemVideo['video'] : ''; ?>
                    <div class="mb-2"><a class="btn btn-sm btn-success" target="_blank" href="<?= UPLOAD_VIDEO_ADMIN . @$itemVideo['video'] ?>">Tập tin video hiện tại<i class="fas fa-cloud-download-alt pl-2"></i></a></div>
                <?php } ?>
                <div class="video-config mb-2">
                    <span class="d-block">Định dạng: <strong><?= implode(" | ", $config['website']['video']['extension']) ?></strong></span>
                    <span class="d-block">Tối đa: <strong><?= $config['website']['video']['allow-size'] ?></strong></span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="video-file" id="file_video">
                    <label class="custom-file-label" for="file_video" data-browse="Chọn video">Chọn tập tin video</label>
                </div>
                <input type="hidden" name="existVideo" value="<?= (!empty($videoDetailCheck) && $func->existFile($videoDetailCheck)) ? true : false ?>">
                <input type="hidden" name="existVideoPhoto" value="<?= (!empty($photoVideoPosterCheck) && $func->existFile($photoVideoPosterCheck)) ? true : false ?>">
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