<?= $flash->getMessages('frontend') ?>
<form id="form-shop" method="post" action="" enctype="multipart/form-data">
    <div class="response-shop"></div>
    <div class="tab-content mb-4" id="tabShopContent">
        <?php /*
        <div class="tab-pane fade show active" id="shop-interface" role="tabpanel" aria-labelledby="shop-interface-tab">
            <div class="card">
                <h6 class="card-header bg-primary text-uppercase text-center text-white font-weight-500">Bước 1: Chọn mẫu giao diện</h6>
                <div class="card-body bg-light">
                    <?php if (!empty($interfaces)) { ?>
                        <div class="position-relative">
                            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:15">
                                <?php foreach ($interfaces as $v_interface) { ?>
                                    <div class="interface <?= (!empty($interfacesID) && !in_array($v_interface['id'], $interfacesID)) ? 'disabled' : '' ?> text-center" <?= (!empty($interfacesID) && !in_array($v_interface['id'], $interfacesID)) ? 'data-plugin="tooltip" data-placement="top" title="Giao diện gian hàng không phù hợp"' : '' ?>>
                                        <h6 class="interface-name bg-warning text-uppercase rounded px-2 py-3 mb-3"><?= $v_interface['name' . $lang] ?></h6>
                                        <a class="interface-image <?= (!empty($interfacesID) && in_array($v_interface['id'], $interfacesID)) ? 'show-interface' : '' ?> position-relative border d-block" href="javascript:void(0)" data-photo="<?= ASSET . UPLOAD_INTERFACE_L . $v_interface['photo2'] ?>" title="<?= $v_interface['name' . $lang] ?>">
                                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '380x280x1', 'upload' => UPLOAD_INTERFACE_L, 'image' => $v_interface['photo'], 'alt' => $v_interface['name' . $lang]]) ?>
                                            <?php if (!empty($interfacesID) && in_array($v_interface['id'], $interfacesID)) { ?>
                                                <div class="interface-demo transition position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus rounded-circle border border-white" width="35" height="35" viewBox="0 0 24 24" stroke-width="1" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <line x1="12" y1="5" x2="12" y2="19" />
                                                        <line x1="5" y1="12" x2="19" y2="12" />
                                                    </svg>
                                                    <strong class="text-uppercase mt-2">Xem demo</strong>
                                                </div>
                                            <?php } ?>
                                        </a>
                                        <div class="interface-desc mt-3 mb-3 px-1">
                                            <div class="text-split"><?= $v_interface['desc' . $lang] ?></div>
                                        </div>
                                        <div class="interface-check text-center">
                                            <?php if (!empty($interfacesID) && in_array($v_interface['id'], $interfacesID)) { ?>
                                                <input type="radio" id="id_interface_<?= $v_interface['id'] ?>" name="dataShop[id_interface]" value="<?= $v_interface['id'] ?>">
                                            <?php } ?>
                                            <label class="position-relative mb-0 w-100" for="id_interface_<?= $v_interface['id'] ?>"><span class="d-block mt-1">Chọn giao diện</span></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        */ ?>

        <div class="tab-pane fade show active" id="shop-info" role="tabpanel" aria-labelledby="shop-info-tab">
            <div class="hidden" id="shop-interface" aria-labelledby="shop-interface-tab">
                <div class="interface">
                    <input type="radio" id="id_interface_1" name="dataShop[id_interface]" value="1" checked="checked">
                </div>
            </div>

            <div class="card">
                <h6 class="card-header bg-primary text-uppercase text-center text-white font-weight-500">Bước 1: Nhập thông tin</h6>
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="id_cat">Danh mục lĩnh vực:</label>
                                        <select class="select-cat-for-store custom-select text-sm cursor-pointer" id="id_cat" name="dataShop[id_cat]" data-level="" data-table="" data-child="" required>
                                            <option value="">Chọn danh mục</option>
                                            <?php if (!empty($sectorCats)) {
                                                foreach ($sectorCats as $v_cat) { ?>
                                                    <option value="<?= $v_cat['id'] ?>"><?= $v_cat['name' . $lang] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="id_store">Danh sách cửa hàng:</label>
                                        <select class="custom-select text-sm cursor-pointer" id="id_store" name="dataShop[id_store]" required>
                                            <option value="">Chọn cửa hàng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label class="form-label font-weight-500" for="id_city"><?= tinhthanh ?>:</label>
                                        <select class="select-city custom-select text-sm cursor-pointer" id="id_city" name="dataShop[id_city]" data-load-title="true" data-title-element=".card-label span" required>
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
                                        <select class="select-district custom-select text-sm cursor-pointer" id="id_district" name="dataShop[id_district]" required>
                                            <option value=""><?= quanhuyen ?></option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label font-weight-500" for="id_wards"><?= phuongxa ?>:</label>
                                        <select class="select-wards custom-select text-sm cursor-pointer" id="id_wards" name="dataShop[id_wards]" required>
                                            <option value=""><?= phuongxa ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="name">Tên gian hàng:</label>
                                        <input type="text" class="form-control text-sm" id="name" name="dataShop[name]" placeholder="Tên gian hàng" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="username">Tên đăng nhập:</label>
                                        <input type="text" class="form-control text-sm" id="username" name="dataShop[username]" placeholder="Tên đăng nhập" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="password">Mật khẩu:</label>
                                        <div class="input-group control-password">
                                            <input type="password" class="form-control text-sm" id="password" name="dataShop[password]" placeholder="Mật khẩu" required>
                                            <div class="input-group-append">
                                                <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="repassword">Nhập lại mật khẩu:</label>
                                        <div class="input-group control-password">
                                            <input type="password" class="form-control text-sm" id="repassword" name="repassword" placeholder="Nhập lại mật khẩu" required>
                                            <div class="input-group-append">
                                                <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="phone">Số điện thoại:</label>
                                        <input type="text" class="form-control text-sm" id="phone" name="dataShop[phone]" placeholder="Số điện thoại" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label font-weight-500" for="email">Email:</label>
                                        <input type="text" class="form-control text-sm" id="email" name="dataShop[email]" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="avatar avatar-shop mb-2">
                                <div class="avatar-zone text-center">
                                    <label class="avatar-label d-inline-block align-top mx-auto mb-0" id="avatar-shop-label" for="avatar-shop">
                                        <label class="form-label w-100 text-uppercase font-weight-500" for="avatar-shop">Hình đại diện</label>
                                        <div class="avatar-detail d-flex align-items-center justify-content-center border rounded overflow-hidden p-2" id="avatar-shop-preview">
                                            <?= $func->getImage(['class' => 'lazy rounded', 'sizes' => '255x255x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Blank avatar shop']) ?>
                                        </div>
                                        <input type="file" class="d-none" name="file_shop" id="avatar-shop">
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <label class="btn btn-primary rounded-0 text-sm pt-2 px-4 m-2" for="avatar-shop">Chọn hình</label>
                                <a class="btn btn-info show-learn-shop rounded-0 text-sm pt-2 px-4 m-2" href="javascript:void(0)" title="Tìm hiểu gian hàng">Tìm hiểu gian hàng</a>
                            </div>
                            <div class="learn-shop-text d-none"><?= $learnShop['content' . $lang] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="shop-confirm" role="tabpanel" aria-labelledby="shop-confirm-tab">
            <div class="card">
                <h6 class="card-header bg-primary text-uppercase text-center text-white font-weight-500">Bước 2: Xác nhận thông tin</h6>
                <div class="card-body bg-light">
                    <div class="form-group">
                 
                            <div class="">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <label class="form-label">Danh mục lĩnh vực:</label>
                                            <div id="preview-cat">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Danh sách cửa hàng:</label>
                                            <div id="preview-store">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-4">
                                            <label class="form-label"><?= tinhthanh ?>:</label>
                                            <div id="preview-city">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label"><?= quanhuyen ?>:</label>
                                            <div id="preview-district">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label"><?= phuongxa ?>:</label>
                                            <div id="preview-wards">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <label class="form-label">Tên gian hàng:</label>
                                            <div id="preview-name">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Mật khẩu:</label>
                                            <div id="preview-password">
                                                <div class="input-group control-password">
                                                    <input type="password" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                                    <div class="input-group-append">
                                                        <a class="input-group-text show-hide-password text-decoration-none" href="javascript:void(0)"><i class="far fa-eye"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-6">
                                            <label class="form-label">Số điện thoại:</label>
                                            <div id="preview-phone">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Email:</label>
                                            <div id="preview-email">
                                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php /*
                            <div class="col-5">
                                <div class="avatar avatar-shop mb-2" id="preview-interface-shop">
                                    <div class="avatar-zone text-center">
                                        <label class="avatar-label d-inline-block align-top mx-auto mb-0">
                                            <label class="form-label bg-warning w-100 text-uppercase rounded-top font-weight-700 px-2 py-3 mb-0">Mẫu gian hàng đã chọn</label>
                                            <div class="avatar-detail d-flex align-items-center justify-content-center border border-top-0 rounded-bottom overflow-hidden" id="interface-shop-preview"><?= $func->getImage(['isLazy' => false, 'sizes' => '380x280x2', 'upload' => 'assets/images/', 'image' => 'noimage.png', 'alt' => 'Preview interface shop']) ?></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            */ ?>
               
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="form-label font-weight-700 text-uppercase text-danger">Địa chỉ gian hàng của bạn:</label>
                            <div id="preview-url-shop">
                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 font-italic text-primary text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                <small class="form-text text-muted">(Địa chỉ này dùng để truy cập hoặc giới thiệu khách hàng vào trang gian hàng của bạn)</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label font-weight-700 text-uppercase text-danger">Địa chỉ quản trị gian hàng của bạn:</label>
                            <div id="preview-url-shop-admin">
                                <input type="text" class="form-control-plaintext border-bottom font-weight-500 font-italic text-primary text-sm" placeholder="Chưa có thông tin" readonly disabled>
                                <small class="form-text text-muted">(Địa chỉ sẽ được sử dụng để truy cập vào trang quản trị "điều hành" gian hàng của bạn)</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group align-items-center captcha-shop captcha-image mx-auto">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-sm rounded-0 border-0">Vui lòng nhập mã bảo mật</span>
                            </div>
                            <input type="text" class="form-control text-sm rounded-0" id="captcha-shop" name="captcha-shop" placeholder="Mã bảo mật" required>
                            <div class="input-group-append">
                                <span class="input-group-text text-sm rounded-0 border-0">
                                    <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('shop') ?>/" alt="Mã bảo mật" />
                                    <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="shop">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="shop-complete" role="tabpanel" aria-labelledby="shop-complete-tab">
            <div class="card">
                <h6 class="card-header bg-primary text-uppercase text-center text-white font-weight-500">Bước 3: Hoàn tất</h6>
                <div class="card-body bg-light">
                    <div><?= $func->decodeHtmlChars($completeShop['content' . $lang]) ?></div>
                </div>
            </div>
        </div>
        <div class="shop-control text-center mt-3">
            <a class="btn btn-danger btn-prev rounded-0 text-uppercase text-sm font-weight-500 pt-2 px-4 mr-2 d-none" href="javascript:void(0)" title="Trở lại"><i class="fas fa-arrow-left mr-2"></i><span>Trở lại</span></a>
            <button type="submit" class="btn btn-primary btn-next rounded-0 text-uppercase text-sm font-weight-500 pt-2 px-4" id="submit-shop" name="submit-shop" value="Tiếp theo" data-now="shop-info-tab"><span>Tiếp theo</span><i class="fas fa-arrow-right ml-2"></i></button>
        </div>
    </div>
</form>
<ul class="shop-nav-tabs nav nav-tabs justify-content-center bg-light border rounded px-2 py-3" id="tabShop" role="tablist">
    <?php /*
    <li class="nav-item" role="presentation">
        <a class="nav-link pr-0 pt-0 pb-0 mb-0 border-0 text-center text-capitalize transition active" id="shop-interface-tab" data-toggle="tab" href="#shop-interface" role="tab" aria-controls="shop-interface" aria-selected="true">
            <span class="d-block mb-1">Chọn mẫu</span>
            <strong class="d-block bg-warning mx-auto rounded-circle font-weight-700 border border-secondary text-dark">01</strong>
        </a>
    </li>
    */ ?>
    <li class="nav-item" role="presentation">
        <a class="nav-link pr-0 pt-0 pb-0 mb-0 border-0 text-center text-capitalize transition active" id="shop-info-tab" data-toggle="tab" href="#shop-info" role="tab" aria-controls="shop-info" aria-selected="true">
            <span class="d-block mb-1">Thông tin</span>
            <strong class="d-block bg-warning mx-auto rounded-circle font-weight-700 border border-secondary text-dark">01</strong>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link pr-0 pt-0 pb-0 mb-0 border-0 text-center text-capitalize transition disabled" id="shop-confirm-tab" data-toggle="tab" href="#shop-confirm" role="tab" aria-controls="shop-confirm" aria-selected="false">
            <span class="d-block mb-1">Xác nhận</span>
            <strong class="d-block bg-warning mx-auto rounded-circle font-weight-700 border border-secondary text-dark">02</strong>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link pr-0 pt-0 pb-0 mb-0 border-0 text-center text-capitalize transition disabled" id="shop-complete-tab" data-toggle="tab" href="#shop-complete" role="tab" aria-controls="shop-complete" aria-selected="false">
            <span class="d-block mb-1">Hoàn tất</span>
            <strong class="d-block bg-warning mx-auto rounded-circle font-weight-700 border border-secondary text-dark">03</strong>
        </a>
    </li>
</ul>