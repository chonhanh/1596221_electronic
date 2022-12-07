<div class="slideshow">
    <div class="block-content">
        <?php if (!empty($slider)) { ?>
            <div class="form-row mb-3">
                <div class="col-3">
                    <?php if (!empty($sectorItemsPage['slideshow'])) { ?>
                        <div class="slideshow-menu">
                            <a class="slideshow-menu-label" href="san-pham" title="Danh mục sản phẩm">
                                <span>Danh mục sản phẩm</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="30" height="30" viewBox="0 0 24 24" stroke-width="3" stroke="#222222" fill="none" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="4" y1="6" x2="20" y2="6" />
                                    <line x1="4" y1="12" x2="20" y2="12" />
                                    <line x1="4" y1="18" x2="20" y2="18" />
                                </svg>
                            </a>
                            <div class="slideshow-menu-lists">
                                <ul>
                                    <?php foreach ($sectorItemsPage['slideshow'] as $kitem => $vitem) { ?>
                                        <li>
                                            <a class="transition is-dropdown" title="<?= $vitem['name' . $lang] ?>" href="san-pham?item=<?= $vitem['id'] ?>"><?= $vitem['name' . $lang] ?></a>
                                            <?php if (!empty($sectorSubsPage['active'])) { ?>
                                                <ul>
                                                    <?php foreach ($sectorSubsPage['active'] as $ksub => $vsub) {
                                                        if ($vsub['id_item'] == $vitem['id']) { ?>
                                                            <li>
                                                                <a class="transition" title="<?= $vsub['name' . $lang] ?>" href="san-pham?item=<?= $vitem['id'] ?>&sub=<?= $vsub['id'] ?>"><?= $vsub['name' . $lang] ?></a>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <div class="slideshow-main position-relative">
                        <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:1" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="0" data-touchdrag="0" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="5000" data-dots="0" data-animations="animate__fadeInDown, animate__backInUp, animate__rollIn, animate__backInRight, animate__zoomInUp, animate__backInLeft, animate__rotateInDownLeft, animate__backInDown, animate__zoomInDown, animate__fadeInUp, animate__zoomIn" data-nav="1" data-navcontainer=".control-slideshow">
                            <?php foreach ($slider as $v) { ?>
                                <div class="slideshow-item" owl-item-animation>
                                    <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '640x380x1', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="control-slideshow control-owl transition"></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="slideshow-advertise position-relative">
                        <?php if (!empty($advertise)) { ?>
                            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:1" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="8000" data-dots="0">
                                <?php foreach ($advertise as $v) { ?>
                                    <div class="advertise-item">
                                        <a class="advertise-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '260x318x1', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($partner)) { ?>
            <div class="slideshow-partner position-relative">
                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:6|margin:10" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="3500" data-dots="0" data-nav="1" data-navcontainer=".control-partner">
                    <?php foreach ($partner as $v) { ?>
                        <div class="partner-item border bg-white p-1">
                            <a class="partner-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '180x95x2', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="control-partner control-owl transition <?= (count($partner) <= 6) ? 'd-none' : '' ?>"></div>
            </div>
        <?php } ?>
    </div>
</div>