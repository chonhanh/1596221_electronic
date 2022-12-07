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

	<?php if (@$IDItem && !empty($sectorSubs)) { ?>
		<div class="modal-right bg-f">
			<div class="modal-title">
				Danh mục cấp 3 <?=$config['website']['name']?>
			</div>
			<div class="modal-body scroll-y">
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
				<?php require_once TEMPLATE . "product/sectorSub.php"; ?>
			</div>
		</div>

	<?php }elseif (!empty($advertisesHome)) { ?>
		<div class="advertise-side" id="advertise-right">
			<div class="position-relative rounded overflow-hidden">
				<div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:1" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-advertise-home">
					<?php foreach ($advertisesHome as $v_advertise) { ?>
						<a class="advertise-home" target="_blank" href="<?= $v_advertise['link'] ?>" title="<?= $v_advertise['name' . $lang] ?>">
							<?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '220x435x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $v_advertise['photo'], 'alt' => $v_advertise['name' . $lang]]) ?>
						</a>
					<?php } ?>
				</div>
				<div class="control-advertise-home control-owl transition <?= (count($advertisesHome) <= 1) ? 'd-none' : '' ?>"></div>
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
