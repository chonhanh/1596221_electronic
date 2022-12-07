<?php if (!empty($slider)) { ?>
    <div class="slideshow">
        <div class="block-content">
            <div class="slideshow-content position-relative">
                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:2|margin:10" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="0" data-touchdrag="0" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="5000" data-dots="0" data-nav="1" data-navcontainer=".control-slideshow">
                    <?php foreach ($slider as $v) { ?>
                        <div class="slideshow-item">
                            <a class="slideshow-image" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '600x240x1', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="control-slideshow control-owl transition"></div>
            </div>
        </div>
    </div>
<?php } ?>