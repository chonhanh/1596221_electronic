<div class="box-left box-scroll">
	<div class="title">
		<div class="name"><i class="fas fa-circle"></i> Danh mục ngành nghề</div>
	</div>
	<div class="content">
		<?php if ($dm_list && !empty($dm_list)) { foreach ($dm_list as $k => $v) { 
		?>

		<div class="box-list">
			<a href="<?=$v['link']?>" title="<?=$v['name' . $lang]?>" class="text-decoration-none">
				<div class="images">
					<?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '210x100x2', 'url' => $v['photo']['leftSidebar'], 'alt' =>  $v['name'.$lang]]) ?>			
				</div>
				<div class="name"><?=$v['name' . $lang]?></div>
			</a>
		</div>
		<?php } } ?>
	</div>
</div>
<?php /*if (!empty($advertiseLeft)) { ?>
    <div class="advertise-side" id="advertise-left">
        <?php foreach ($advertiseLeft as $k => $v) { ?>
            <a class="d-block mb-3" href="<?= $v['link'] ?>" title="<?= $v['name' . $lang] ?>"><?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '220x435x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?></a>
        <?php } ?>
    </div>
<?php }*/ ?>