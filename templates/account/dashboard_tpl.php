<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $func->textConvert($func->getMember('last_name'), 'capitalize') ?> ơi khỏe không !</strong>
</div>
<div class="content-account pt-1">
    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '825x550x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $photoDashboard, 'alt' => $func->textConvert($func->getMember('last_name'), 'capitalize') . ' ơi khỏe không !']) ?>
</div>