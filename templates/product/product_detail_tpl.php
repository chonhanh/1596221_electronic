<div class="posting-detail-article">
    <div class="posting-detail-article-left position-relative ">

        <?php if (!empty($rowDetail['rowDetailShop'])) { ?>
            <div class="posting-detail-owner-variant is-shop border-bottom  bg-f px-3 py-3">
                <div class="posting-detail-owner-variant-avatar">
                    <a class="posting-detail-owner-variant-avatar-image shop-logo-image" href="<?= $rowDetail['rowDetailShop']['href'] ?>" title="<?= $rowDetail['rowDetailShop']['name'] ?>">
                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '140x140x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $rowDetail['rowDetailShop']['logo'], 'alt' => $rowDetail['rowDetailShop']['name']]) ?>
                    </a>
                </div>
                <div class="posting-detail-owner-variant-info ">
                    <div class="posting-detail-owner-variant-attrs">
                        <ul class="posting-detail-attrs icon-poster-attrs list-unstyled m-0 p-0">
                            <li class="mb-2"><a href="<?= $rowDetail['rowDetailShop']['href'] ?>"><div class="posting-detail-owner-variant-name font-weight-bold text-uppercase mb-2"><?= $rowDetail['rowDetailShop']['name'] ?></div></a></li>
                            <li class="mb-2" id="email-poster">Email: <strong><?= (!empty($rowDetail['rowDetailShop']['email'])) ? $rowDetail['rowDetailShop']['email'] : 'Chưa có thông tin' ?></strong></li>
                            <li class="mb-2" id="phone-poster">Điện thoại: <strong><?= (!empty($rowDetail['rowDetailShop']['phone'])) ? $func->formatPhone($rowDetail['rowDetailShop']['phone']) : 'Chưa có thông tin' ?></strong></li>
                            <li id="address-poster">Địa chỉ: <strong><?= $func->joinPlace($rowDetail['rowDetailShop']) ?></strong></li>
                        </ul>
                    </div>
                </div>
                <div class="posting-detail-owner-variant-control ml-3">
                    <?php /*
                    <div class="posting-detail-owner-variant-params text-center mb-2">
                        <div id="subscribe"><i class="fas fa-heart <?= $rowDetail['rowDetailShop']['subscribeActive'] ?> align-top mr-2"></i><span class="d-inline-block font-weight-500"><?= $func->shortNumber($rowDetail['rowDetailShop']['subscribeNumb']) ?> người quan tâm trang</span></div>
                    </div>
                    */ ?>
                    <?php if (empty($ownedShop)) { ?>
                        <div class="mb-2">
                            <a class="posting-detail-owner-variant-subscribe text-decoration-none <?= (!empty($rowDetail['rowDetailShop']['subscribeActive'])) ? 'subscribe' : 'no-subscribe' ?> subscribe-button text-capitalize" href="javascript:void(0)" data-id="<?= $rowDetail['rowDetailShop']['id'] ?>" title="<?= (!empty($rowDetail['rowDetailShop']['subscribeActive'])) ? 'Đã quan tâm' : 'Quan tâm trang' ?>">
                                <i class="fas fa-heart "></i><br>
                                <?= (!empty($rowDetail['rowDetailShop']['subscribeActive'])) ? 'Đã quan tâm' : 'Quan tâm' ?>
                            </a>
                        </div>
                        <div>
                            <a class="chiduong text-decoration-none text-capitalize" href="" title="Chỉ đường">
                                <?= $func->getImage(['class' => 'lazy', 'size-error' => '28x40x2', 'upload' => 'assets/images/', 'image' => 'ic_chiduong.png', 'alt' => 'Chỉ đường']) ?><br>
                                Chỉ đường
                            </a>
                        </div>
                    <?php } ?>
                </div>

            </div>
        <?php } else if (!empty($rowDetail['rowDetailPoster'])) { ?>
            <div class="posting-detail-owner-variant is-personal border-bottom  bg-f px-3 py-3">
                <div class="posting-detail-owner-variant-avatar">
                    <a class="posting-detail-owner-variant-avatar-image" href="javascript:void(0)" title="<?= $rowDetail['rowDetailPoster']['fullname'] ?>">
                        <?= $func->getImage(['class' => 'lazy border rounded-circle w-100 mr-3', 'image-error' => 'user.png', 'sizes' => '85x85x2', 'upload' => UPLOAD_USER_L, 'image' => $rowDetail['rowDetailPoster']['avatar'], 'alt' => $rowDetail['rowDetailPoster']['fullname']]) ?>
                    </a>
                </div>
                <div class="posting-detail-owner-variant-info">
                    <?php if (@$rowDetail['rowDetailContact']) { ?>
                        <div class="posting-detail-owner-variant-name font-weight-bold text-uppercase mb-2"><?= $rowDetail['rowDetailContact']['fullname'] ?></div>
                        <ul class="posting-detail-attrs icon-poster-attrs list-unstyled m-0 p-0">
                            <li class="mb-1" id="email-poster">Email: <strong><?= (!empty($rowDetail['rowDetailContact']['email'])) ? $rowDetail['rowDetailContact']['email'] : 'Chưa có thông tin' ?></strong></li>
                            <li class="mb-1" id="phone-poster">Điện thoại: <strong><?= (!empty($rowDetail['rowDetailContact']['phone'])) ? $func->formatPhone($rowDetail['rowDetailContact']['phone']) : 'Chưa có thông tin' ?></strong></li>
                            <li id="address-poster">Địa chỉ: <strong><?= (!empty($rowDetail['rowDetailContact']['address'])) ? $rowDetail['rowDetailContact']['address'] : 'Chưa có thông tin' ?></strong></li>
                        </ul>
                    <?php }else{ ?>
                        <div class="posting-detail-owner-variant-name font-weight-bold text-uppercase mb-2"><?= $rowDetail['rowDetailPoster']['fullname'] ?></div>
                        <ul class="posting-detail-attrs icon-poster-attrs list-unstyled m-0 p-0">
                            <li class="mb-1" id="email-poster">Email: <strong><?= (!empty($rowDetail['rowDetailPoster']['email'])) ? $rowDetail['rowDetailPoster']['email'] : 'Chưa có thông tin' ?></strong></li>
                            <li class="mb-1" id="phone-poster">Điện thoại: <strong><?= (!empty($rowDetail['rowDetailPoster']['phone'])) ? $func->formatPhone($rowDetail['rowDetailPoster']['phone']) : 'Chưa có thông tin' ?></strong></li>
                            <li id="address-poster">Địa chỉ: <strong><?= (!empty($rowDetail['rowDetailPoster']['address'])) ? $rowDetail['rowDetailPoster']['address'] : 'Chưa có thông tin' ?></strong></li>
                        </ul>
                    <?php } ?>
                </div>
                
            </div>
        <?php } ?>
        <h3 class="posting-detail-name text-break text-capitalize bg-f text-center m-0 p-3"><?= $rowDetail['name' . $lang] ?></h3>

        <?php if (!empty($videoOwnerSimilar)) { ?>
            <div class="posting-owner-similar-lists custom-mcsrcoll-y border">
                <?php foreach ($videoOwnerSimilar as $k_video => $v_video) { ?>
                    <div class="posting-owner-similar-item card border-0 <?= ($k_video < count($videoOwnerSimilar) - 1) ? 'mb-3' : '' ?>">
                        <div class="form-row">
                            <div class="col-5">
                                <a class="card-image scale-img" target="_blank" href="<?= $sector['type'] . '/' . $v_video[$sluglang] . '/' . $v_video['id'] . '?video=' . $v_video['videoId'] ?>" title="<?= $v_video['videoName' . $lang] ?>">
                                    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '165x120x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $v_video['videoPhoto'], 'alt' => $v_video['videoName' . $lang]]) ?>
                                </a>
                            </div>
                            <div class="col-7">
                                <div class="posting-owner-similar-item-name mb-1"><a class="text-decoration-none text-primary-hover transition" target="_blank" href="<?= $sector['type'] . '/' . $v_video[$sluglang] . '/' . $v_video['id'] . '?video=' . $v_video['videoId'] ?>" title="<?= $v_video['videoName' . $lang] ?>"><strong><?= $v_video['videoName' . $lang] ?></strong></a></div>
                                <div class="posting-owner-similar-item-attrs"><?= $func->postDate($v_video['date_created']) ?> | <strong><?= $func->shortNumber($v_video['videoViews']) ?></strong> lượt xem</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else if (!empty($productOwnerSimilar)) { ?>
            <div class="posting-owner-similar-lists custom-mcsrcoll-y border">
                <?php foreach ($productOwnerSimilar as $k_product => $v_product) { ?>
                    <div class="posting-owner-similar-item card border-0 <?= ($k_product < count($productOwnerSimilar) - 1) ? 'mb-3' : '' ?>">
                        <div class="form-row">
                            <div class="col-5">
                                <a class="card-image scale-img" target="_blank" href="<?= $sector['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'] ?>" title="<?= $v_product['name' . $lang] ?>">
                                    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '165x120x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_product['photo'], 'alt' => $v_product['name' . $lang]]) ?>
                                </a>
                            </div>
                            <div class="col-7">
                                <div class="posting-owner-similar-item-name mb-1"><a class="text-decoration-none text-primary-hover transition" target="_blank" href="<?= $sector['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'] ?>" title="<?= $v_product['name' . $lang] ?>"><strong><?= $v_product['name' . $lang] ?></strong></a></div>
                                <div class="posting-owner-similar-item-attrs"><?= $func->postDate($v_product['date_created']) ?> | <strong><?= $func->shortNumber($v_product['views']) ?></strong> lượt xem</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="posting-detail-article-right bg-f">
        <?php
        if (!empty($rowDetail['rowDetailVideo'])) {
            $dataVideo = array();
            $dataVideo['name'] = $rowDetail['rowDetailVideo']['name' . $lang];
            $dataVideo['video'] = ASSET . UPLOAD_VIDEO_L . $rowDetail['rowDetailVideo']['video'];
            $dataVideo['poster'] = ASSET . THUMBS . '/885x500x2/' . UPLOAD_PHOTO_L . $rowDetail['rowDetailVideo']['photo'];
            $dataVideo['photo'] = $rowDetail['rowDetailVideo']['photo'];
            $dataVideo['type'] = $rowDetail['rowDetailVideo']['type'];
        }
        ?>

        <?php if (in_array($sector['type'], array($config['website']['sectors'])) && (!empty($rowDetail['rowDetailVideo']) || !empty($rowDetail['rowDetailPhoto']))) { ?>
            <div class="posting-detail-gallery">
                <div class="carousel slide" id="carousel-posting-gallery" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-control">
                            <a class="carousel-control-prev w-auto" href="#carousel-posting-gallery" role="button" data-slide="prev">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-left" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="#fafafa" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(270 12 12)" />
                                    </svg>
                                </span>
                            </a>
                            <a class="carousel-control-next w-auto" href="#carousel-posting-gallery" role="button" data-slide="next">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-right" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="#fafafa" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(90 12 12)" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="carousel-lists">
                            <div id="posting-light-gallery">
                                <?php if (!empty($rowDetail['rowDetailVideo'])) { ?>
                                    <div class="carousel-item carousel-item-gallery-video active" data-lg-size="1280-720" data-video='{"source": [{"src":"<?= $dataVideo['video'] ?>", "type":"video/mp4"}], "attributes": {"preload": true, "controls": true}}' data-poster="<?= $dataVideo['poster'] ?>" data-sub-html="<?= $rowDetail['rowDetailVideo']['name' . $lang] ?>">
                                        <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '885x500x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $dataVideo['photo'], 'alt' => $rowDetail['rowDetailVideo']['name' . $lang]]) ?>
                                        <div class="play-icon">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="80px" width="80px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                                <path class="play-icon-stroke-solid" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                                                C97.3,23.7,75.7,2.3,49.9,2.5" />
                                                <path class="play-icon-stroke-dotted" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                                                C97.3,23.7,75.7,2.3,49.9,2.5" />
                                                <path class="play-icon-icon" fill="white" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z" />
                                            </svg>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php foreach ($rowDetail['rowDetailPhoto'] as $k_photo => $v_photo) { ?>
                                    <div class="carousel-item carousel-item-gallery-<?= $v_photo['id'] ?> <?= (empty($rowDetail['rowDetailVideo']) && ($k_photo == 0)) ? 'active' : '' ?>" data-src="<?= ASSET . UPLOAD_PRODUCT_L . $v_photo['photo'] ?>">
                                        <a class="d-block" href="javascript:void(0)" title="<?= $rowDetail['name' . $lang] ?>">
                                            <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '885x500x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_photo['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <ol class="carousel-indicators posting-indicators-scroll custom-mcsrcoll-x d-flex align-items-start justify-content-start mt-2 m-0 w-clear">
                        <?php if (!empty($rowDetail['rowDetailVideo'])) { ?>
                            <li class="position-relative float-left mr-2 active" data-target="#carousel-posting-gallery" data-slide-to="0" data-id="video">
                                <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '165x100x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $dataVideo['photo'], 'alt' => $rowDetail['rowDetailVideo']['name' . $lang]]) ?>
                                <div class="play-icon">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="40px" width="40px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                        <path class="play-icon-stroke-solid" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                                        C97.3,23.7,75.7,2.3,49.9,2.5" />
                                        <path class="play-icon-stroke-dotted" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
                                        C97.3,23.7,75.7,2.3,49.9,2.5" />
                                        <path class="play-icon-icon" fill="white" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z" />
                                    </svg>
                                </div>
                            </li>
                        <?php } ?>
                        <?php foreach ($rowDetail['rowDetailPhoto'] as $k_photo => $v_photo) { ?>
                            <li class="float-left mr-2 <?= (empty($rowDetail['rowDetailVideo']) && ($k_photo == 0)) ? 'active' : '' ?>" data-target="#carousel-posting-gallery" data-slide-to="<?= (!empty($rowDetail['rowDetailVideo'])) ? ($k_photo + 1) : $k_photo ?>" data-id="<?= $v_photo['id'] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '165x100x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_photo['photo'], 'alt' => $rowDetail['name' . $lang]]) ?>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
            </div>

        <?php } ?>
        <div class="p-3">
            <?php if (!empty($rowDetail['rowDetailContent']['content' . $lang])) { ?>
                <div class="posting-detail-block py-3">
                    <div class="posting-detail-block-content"><?= nl2br($func->decodeHtmlChars($rowDetail['rowDetailContent']['content' . $lang])) ?></div>
                </div>
            <?php } ?>


            <div class="posting-detail-block py-2">
                <div class="posting-detail-block-label border-bottom pb-2 d-flex justify-content-between">
                    <strong class=" text-uppercase">Thông số kỹ thuật</strong>
                    <a class="posting-detail-report show-report nav-awesome text-decoration-none" href="javascript:void(0)" title="Báo vi phạm"><span class="">Báo cáo vi phạm</span><i class="fas fa-exclamation-triangle text-warning ml-1"></i></a>
                </div>
                <div class="posting-detail-block-content py-1">

                    <?php if ($arr_list_opt) {
                        $arr_opt = (isset( $rowDetail['rowDetailContent']['properties'.$lang]) &&  $rowDetail['rowDetailContent']['properties'.$lang] != '') ? json_decode( @$rowDetail['rowDetailContent']['properties'.$lang],true) : null;              
                        
                        foreach ($arr_list_opt as $key => $value) { 
                            $name = $func -> getInfo('namevi', 'variation', $value);
                            $icon = $func -> getInfo('photo', 'variation', $value);
                            if ($name && $arr_opt[$value]!="") {
                                ?>
                                <div class="py-1">
                                    <b><?=($icon)?$func->getImage(['class'=>'lazy mr-1','sizes' => '20x20x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $icon, 'alt' => $name]):''?><?=$name?>:</b> <?=$arr_opt[$value]?>
                                </div>
                                <div class="py-1">
                                    <b><?=($icon)?$func->getImage(['class'=>'lazy mr-1','sizes' => '20x20x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $icon, 'alt' => $name]):''?><?=$name?>:</b> <?=$arr_opt[$value]?>
                                </div>
                            <?php } }
                        } ?>
                    </div>
                </div>
                <hr>
                <div class="posting-detail-block px-3 py-2">
                    <div class="posting-detail-block-label pb-2 text-center">
                        <strong class="name text-uppercase">Đặt mua sản phẩm</strong>
                        <div>Vui lòng chọn đúng loại sản phẩm để đặt mua!</div>
                    </div>
                </div>

                <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
                    <ul class="posting-detail-attrs list-unstyled p-0 m-0 mb-3">
                        <li class="mb-2 price text-uppercase">Giá: <strong class="text-danger"><?= $rowDetail['regular_price'] . ' ' . $variation->get($tableProductVariation, $rowDetail['id'], 'loai-gia', $lang) ?></strong></li>
                        <?php if (in_array("acreage", $sector['attributes'])) { ?>
                            <li class="mb-2">Diện tích: <strong><?= $rowDetail['acreage'] . ' m2' ?></strong></li>
                        <?php } ?>
                        <hr>
                        <?php if ($isLogin && (($idMember == $rowDetail['id_member']) || (!empty($rowDetail['rowDetailShop']) && $idMember == $rowDetail['rowDetailShop']['id_member']))) { ?>
                            <li class="mt-2">
                                <div class="alert alert-warning">Tin đăng thuộc quyền sở hửu của bạn</div>
                            </li>
                        <?php } else if ($func->hasCart($sector) && !strstr($rowDetail['status_attr'], 'dichvu')) { ?>
                            <?php if (!empty($rowDetail['id_admin'])) { ?>
                                <li class="mt-2">
                                    <div class="posting-detail-contact mb-3">
                                        <a class="btn btn-success text-capitalize text-sm rounded-0" href="tel:<?= $func->parsePhone($rowDetail['rowDetailPoster']['phone']) ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="Tin đăng thuộc sở hữu của Ban Quản Trị Chợ Nhanh"><i class="fas fa-phone-alt mr-2"></i><span>Liên hệ</span></a>
                                    </div>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <div class="d-flex">
                                        <div class="w-clear">
                                            <?php if (!empty($rowDetail['rowDetailSale']['colors'])) { ?>
                                                <div class="mb-1">
                                                    <div class="posting-detail-sale-color posting-detail-sale">
                                                        <p class="mb-1 label">Màu sắc:</p>
                                                        <div class="sale-lists">
                                                            <?php foreach ($rowDetail['rowDetailSale']['colors'] as $v_color) { ?>
                                                                <label class="sale-color sale-item border mr-1 transition" for="sale-color-<?= $v_color['id'] ?>"><input type="radio" class="d-none" name="sale-color" id="sale-color-<?= $v_color['id'] ?>" value="<?= $v_color['id'] ?>"><?= $v_color['namevi'] ?></label>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($rowDetail['rowDetailSale']['sizes'])) { ?>
                                                <div class="mb-1">
                                                    <div class="posting-detail-sale-size posting-detail-sale">
                                                        <p class="mb-1 label">Kích cỡ:</p>
                                                        <div class="sale-lists">
                                                            <?php foreach ($rowDetail['rowDetailSale']['sizes'] as $v_size) { ?>
                                                                <label class="sale-size sale-item border mr-1 transition" for="sale-size-<?= $v_size['id'] ?>"><input type="radio" class="d-none" name="sale-size" id="sale-size-<?= $v_size['id'] ?>" value="<?= $v_size['id'] ?>"><?= $v_size['namevi'] ?></label>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="w-clear">
                                            <div class="mb-1">
                                                <div class="posting-detail-sale">
                                                    <p class="mb-1 label">Số lượng:</p>
                                                    <div class="quantity-pro-detail">
                                                        <span class="quantity-minus-pro-detail border border-right-0">-</span>
                                                        <input type="number" class="qty-pro border" min="1" value="1" readonly />
                                                        <span class="quantity-plus-pro-detail border border-left-0">+</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="posting-detail-cart mb-3">
                                                    <a class="btn btn-success add-cart text-capitalize text-sm rounded-0" href="javascript:void(0)" data-id="<?= $rowDetail['id'] ?>" title="Đặt hàng"><i class="fas fa-shopping-basket mr-2"></i><span>Đặt hàng</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } else if ($func->hasService($sector) && strstr($rowDetail['status_attr'], 'dichvu')) { ?>
                            <li class="mt-2">
                                <div class="posting-detail-booking mb-3">
                                    <a class="btn btn-success text-capitalize text-sm rounded-0" href="javascript:void(0)" data-toggle="modal" data-target="#modal-booking" title="Đăng ký"><i class="far fa-bookmark mr-2"></i><span>Đăng ký</span></a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>

                <?php } ?>

                <div class="posting-detail-social d-flex align-items-center justify-content-between">
                    <div class="posting-detail-views text-center">
                        <i class="far fa-eye  mb-1 fa-2x"></i>
                        <div><strong><?= $func->shortNumber((!empty($IDVideo)) ? $videoDetail['views'] : $rowDetail['views'],'en','s') ?></strong> lượt xem</div>
                    </div>
                    <div class="posting-detail-comment-counts text-center ">
                      
                        <i class="far fa-comments mb-1 fa-2x"></i>
                        <div><strong><?= $func->shortNumber($comment->totalByID($rowDetail['id']),'en','s') ?></strong> bình luận</div>
                    </div>
                    <a class="posting-detail-mail  mail-share text-decoration-none text-center " href="javascript:void(0)" data-subject="<?= $sector['name'] . ': ' . $rowDetail['name' . $lang] ?>" data-url="<?= $func->getCurrentOriginURL() ?>" title="Chia sẻ">
                        <i class="fa fa-2x d-inline-block icon mb-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M400 255.4V240 208c0-8.8-7.2-16-16-16H352 336 289.5c-50.9 0-93.9 33.5-108.3 79.6c-3.3-9.4-5.2-19.8-5.2-31.6c0-61.9 50.1-112 112-112h48 16 32c8.8 0 16-7.2 16-16V80 64.6L506 160 400 255.4zM336 240h16v48c0 17.7 14.3 32 32 32h3.7c7.9 0 15.5-2.9 21.4-8.2l139-125.1c7.6-6.8 11.9-16.5 11.9-26.7s-4.3-19.9-11.9-26.7L409.9 8.9C403.5 3.2 395.3 0 386.7 0C367.5 0 352 15.5 352 34.7V80H336 304 288c-88.4 0-160 71.6-160 160c0 60.4 34.6 99.1 63.9 120.9c5.9 4.4 11.5 8.1 16.7 11.2c4.4 2.7 8.5 4.9 11.9 6.6c3.4 1.7 6.2 3 8.2 3.9c2.2 1 4.6 1.4 7.1 1.4h2.5c9.8 0 17.8-8 17.8-17.8c0-7.8-5.3-14.7-11.6-19.5l0 0c-.4-.3-.7-.5-1.1-.8c-1.7-1.1-3.4-2.5-5-4.1c-.8-.8-1.7-1.6-2.5-2.6s-1.6-1.9-2.4-2.9c-1.8-2.5-3.5-5.3-5-8.5c-2.6-6-4.3-13.3-4.3-22.4c0-36.1 29.3-65.5 65.5-65.5H304h32zM72 32C32.2 32 0 64.2 0 104V440c0 39.8 32.2 72 72 72H408c39.8 0 72-32.2 72-72V376c0-13.3-10.7-24-24-24s-24 10.7-24 24v64c0 13.3-10.7 24-24 24H72c-13.3 0-24-10.7-24-24V104c0-13.3 10.7-24 24-24h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H72z"/></svg></i>
                        <div class="">Chia sẻ</div>
                    </a>
                    <a class="posting-detail-favourite favourite-action text-center <?= (!empty($rowDetail['isOwned'])) ? 'is-owned' : '' ?>  text-decoration-none" href="javascript:void(0)" data-type="<?= $sector['type'] ?>" data-variant="product" data-id="<?= $rowDetail['id'] ?>" data-text="<?= $rowDetail['name' . $lang] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<?= $func->get('favourite-title') ?>">
                        <i class="fas fa-heart <?= $func->get('favourite-active') ?> fa-2x"></i>
                        <div><strong class="pr-1">Lưu tin</strong></div>
                    </a>
                <?php /*
                <div class="posting-detail-social social-plugin mt-0 mr-3 w-clear">
                    <div class="addthis_inline_share_toolbox_33zg"></div>
                    <div class="zalo-share-button" data-href="<?= $func->getCurrentPageURL() ?>" data-oaid="<?= ($optsetting['oaidzalo'] != '') ? $optsetting['oaidzalo'] : '579745863508352884' ?>" data-layout="3" data-color="blue" data-customize=false></div>
                </div>
                */ ?>
            </div>
        </div>
        <?php if (!empty($rowDetail['rowDetailTags'])) { ?>
            <div class="posting-detail-block mb-4">
                <div class="posting-detail-block-label bg-light border rounded text-uppercase px-3"><strong>Từ khóa liên quan</strong></div>
                <div class="posting-detail-block-content px-3">
                    <?php foreach ($rowDetail['rowDetailTags'] as $v_tags) { ?>
                        <a class="btn btn-sm btn-primary mr-1 mb-2 px-3" href="tags/<?= $v_tags[$sluglang] ?>/<?= $v_tags['id'] ?>?sector=<?= $sector['id'] ?>" title="<?= $v_tags['name' . $lang] ?>"><?= $v_tags['name' . $lang] ?></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>


    </div>
</div>

<div class="bg-f">
    <?php /*if (in_array("coordinates", $sector['attributes'])) { ?>
        <div class="posting-detail-block">
     
            <div class="posting-detail-block-label bg-light border rounded text-uppercase px-3"><strong>Bản đồ</strong></div>
     
            <div class="posting-detail-block-content">
                <iframe src="https://maps.google.com/maps?q=<?= $rowDetail['coordinates'] ?>&z=15&output=embed" width="100%" height="350" frameborder="0"></iframe>
            </div>
        </div>
    <?php }*/ ?>

    <?php include TEMPLATE . "product/comment.php"; ?>
</div>
<?php /*if (!empty($rowDetail['rowDetailContact'])) { ?>
    <div class="posting-detail-block mb-3">
        <div class="posting-detail-block-label bg-light border rounded text-uppercase px-3"><strong>Thông tin liên hệ</strong></div>
        <div class="posting-detail-block-content px-3">
            <div class="posting-detail-attrs list-unstyled p-0 m-0">
                <div class="form-row">
                    <div class="col-6 mb-2">Họ và tên: <strong class="text-capitalize"><?= $rowDetail['rowDetailContact']['fullname'] ?></strong></div>
                    <div class="col-6 mb-2">Email: <strong><?= (!empty($rowDetail['rowDetailContact']['email'])) ? $rowDetail['rowDetailContact']['email'] : 'Chưa có thông tin' ?></strong></div>
                    <div class="col-6 mb-2">Điện thoại: <strong><?= (!empty($rowDetail['rowDetailContact']['phone'])) ? $func->formatPhone($rowDetail['rowDetailContact']['phone']) : 'Chưa có thông tin' ?></strong></div>
                    <div class="col-6 mb-2">Địa chỉ: <strong><?= (!empty($rowDetail['rowDetailContact']['address'])) ? $rowDetail['rowDetailContact']['address'] : 'Chưa có thông tin' ?></strong></div>
                </div>
            </div>
        </div>
    </div>
<?php }*/ ?>

