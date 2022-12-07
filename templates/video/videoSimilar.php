<!-- Videos similar -->
<?php if (!empty($videoSimilar)) { ?>
    <div class="block-video-similar mt-5">
        <div class="title-main"><span>Video cùng loại</span></div>
        <div class="position-relative">
            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-video-similar">
                <?php foreach ($videoSimilar as $k_video => $v_video) {
                    $v_video['name'] = $v_video['videoName' . $lang];
                    $v_video['photo'] = $v_video['videoPhoto'];
                    $v_video['href'] = $sector['type'] . '/' . $v_video[$sluglang] . '/' . $v_video['id'] . '?video=' . $v_video['videoId'];
                    $v_video['sector'] = $sector;
                    $v_video['favourites'] = (!empty($favourites)) ? $favourites : array();
                    $v_video['idMember'] = $idMember;
                    $v_video['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
                    $v_video['detailShop'] = (!empty($shopDetail)) ? true : false;
                    $v_video['sample'] = (!empty($sampleData)) ? $sampleData : array();
                    echo $func->getVideo($v_video);
                } ?>
            </div>
            <div class="control-video-similar control-owl transition <?= (count($videoSimilar) <= 4) ? 'd-none' : '' ?>"></div>
        </div>
    </div>
<?php } ?>