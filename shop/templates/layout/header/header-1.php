<div class="header-shop lazy" data-src="<?= ASSET . UPLOAD_PHOTO_THUMB . $header['photo'] ?>">
    <div class="block-content text-center">
    
        <a class="header-banner" href="" title="<?= $setting['name' . $lang] ?>">
            <?= $func->getImage(['sizes' => '560x90x2', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $banner['photo'], 'alt' => $setting['name' . $lang]]) ?>
        </a>
     
    </div>
    <div class="block-content d-flex align-items-center justify-content-between py-3">
        <div class="header-info">      
            <?php if (!$shopInfo['isOwned']) { ?>
                <a class="btn btn-sm <?= (!empty($subscribeMember)) ? 'btn-danger' : 'btn-primary' ?> subscribe-button rounded-0 mt-3 py-2 px-3" href="javascript:void(0)" title="<?= (!empty($subscribeMember)) ? 'Đã quan tâm' : 'Quan tâm trang' ?>"><i class="fas fa-heart"></i> <?= (!empty($subscribeMember)) ? 'Đã quan tâm' : 'Quan tâm' ?></a>
            <?php } ?>

        
        </div>  

        <a class="header-logo d-flex justify-content-center logo-shop  text-decoration-none" href="" title="<?= $setting['name' . $lang] ?>">
            <span><div class="shop-logo-image"><?= $func->getImage(['sizes' => '120x120x2', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $logo['photo'], 'alt' => $setting['name' . $lang]]) ?></div></span>
            <div class="w-100 mt-2"><?=$setting['name' . $lang]?></div>
        </a>
            
        <div class="header-info">
            <div id="star-rating"></div>

            <a class="footer-report show-report btn btn-sm btn-danger mt-3 rounded-0  py-2 px-3" href="javascript:void(0)" title="Góp ý/phản hồi"><i class="far fa-check-circle"></i> Phản hồi</a>
        </div>
    </div>
</div>
<div class="block-content d-flex align-items-center justify-content-between py-3">
    <div>
        <a class="show-chat text-decoration-none  transition" href="javascript:void(0)"><i class="far fa-comment-dots"></i> Nhắn tin với Cửa hàng</a>
    </div>
 
        <a href="" class="align-items-center text-decoration-none ">
            <?= $func->getImage(['class' => 'lazy mr-1 align-middle', 'size-error' => '33x31x2', 'upload' => 'assets/images/', 'image' => 'ic_map.png', 'alt' => 'Chỉ đường']) ?>
            Chỉ đường
        </a>
   
    <div>
        <div class="align-items-center text-decoration-none subscribeNumb d-flex ">
            <i class="fas fa-heart"></i>
            <div><b><?=$func->formatMoney($shopDetail['subscribeNumb'], ' ', $html = false)?></b> Khách hàng<br>Quan tâm cửa hàng</div>
        </div>
    </div>
</div>