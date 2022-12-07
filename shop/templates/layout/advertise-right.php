<div class="box-left box-scroll">

	<a class="button bt-gh d-flex w-100 text-primary-hover text-decoration-none go-shop"  href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="" data-original-title="Tạo gian hàng kinh doanh">
		<span class="icon mr-2">
			<?= $func->getImage(['class' => 'lazy', 'size-error' => '30x30x1', 'upload' => 'assets/images/', 'image' => 'ic_shop.png', 'alt' => 'Thông báo']) ?>
		</span>
		<span class="info">Đăng ký gian hàng </span>
	</a>

	<a class="go-posting button bt-cn d-flex w-100 text-decoration-none" href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="" data-original-title="Đăng tin cá nhân">
		<span class="icon mr-2">
			<?= $func->getImage(['class' => 'lazy', 'size-error' => '30x30x1', 'upload' => 'assets/images/', 'image' => 'ic_user.png', 'alt' => 'Thông báo']) ?>
		</span>
		<span class="info">Đăng tin cá nhân</span>
	</a>

	<?php if ($shopsOther) { ?>
		<div class="modal-right bg-f">
			<div class="modal-title ">
				Cửa hàng cùng loại
			</div>
			<div class="modal-body scroll-y p-0">
				<?php foreach ($shopsOther as $key => $value) { ?>
					<div class="shop-content py-3 px-1">
				        <div class="shop-logo">
				            <a class="shop-logo-image" href="<?=BASE_MAIN?>shop/<?=$value["slug_url"]?>/" title="<?=$value['name']?>">
				                <img class="lazy w-100 loaded" onerror="this.src='http://localhost/chonhanh_thoitrang/thumbs/70x70x2/assets/images/noimage.png';" data-src="http://localhost/chonhanh_thoitrang/thumbs/70x70x2/upload/photo/logo-15675.jpg" alt="<?=$value['name']?>" src="http://localhost/chonhanh_thoitrang/thumbs/70x70x2/upload/photo/logo-15675.jpg" data-was-processed="true">            
				            </a>
				        </div>

				        <div class="shop-info">
				            <h3 class="shop-name m-0"><a class="text-decoration-none text-uppercase text-primary-hover transition" href="<?=BASE_MAIN?>shop/<?=$value["slug_url"]?>/" title="<?=$value['name']?>"><?=$value['name']?></a></h3>			            
				            <div class="shop-subscribe-count"><span class="text-capitalize"><?=($value['subscribeNumb'])?$value['subscribeNumb']:0?></span> <strong>người quan tâm</strong><i class="fas fa-heart  ml-1"></i></div>
				        </div>
				    </div>
				<?php } ?>
				<?php /*foreach ($sectorSubs as $key => $value) { ?>
					<div class="sectors sectors-sub vehicle mb-2 " >
						<a class="sectors-image scale-img" href="javascript:void(0)" title="FORD EXPLORER">
							<img class="w-100 mCS_img_loaded" onerror="this.src='http://cdn.chonhanh.vn/thumbs/315x230x1/assets/images/noimage.png';" src="http://cdn.chonhanh.vn/thumbs/315x230x1/upload/product/3-ford-explorer-32182.png" alt="FORD EXPLORER">                
						</a>
						<div class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
							<a class="text-decoration-none text-primary-hover  text-uppercase transition" href="javascript:void(0)" title="FORD EXPLORER">FORD EXPLORER</a>
						</div>
					</div>
				<?php }*/ ?>
			</div>
		</div>

	<?php } ?>

</div>
<?php /*if (!empty($advertisesHome)) { ?>
    <div class="block-advertise-home mb-4">
   
            
	        <?php foreach ($advertisesHome as $k => $v) { ?>
	            <a class="d-block mb-3" href="<?= $v['link'] ?>" title="<?= $v['name' . $lang] ?>"><?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '220x435x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?></a>
	        <?php } ?>
    
    </div>
<?php }*/ ?>
