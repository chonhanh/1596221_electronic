<div class="block-product mb-4">
    <div class="block-content">
        <div class="title-main">
            <span>Nhà đất nổi bật</span>
        </div>
        <div class="paging-product"></div>
    </div>
</div>

<?php if (!empty($aboutHome)) { ?>
    <div class="block-about text-center mx-auto">
        <div class="block-content">
            <h3 class="about-title mb-3"><a class="text-uppercase text-decoration-none" href="gioi-thieu" title="<?= $aboutHome['name' . $lang] ?>"><?= $aboutHome['name' . $lang] ?></a></h3>
            <div class="about-text"><?= $func->decodeHtmlChars($aboutHome['desc' . $lang]) ?></div>
            <a class="btn btn-warning text-sm" href="gioi-thieu" title="Xem thêm">Xem thêm</a>
        </div>
    </div>
<?php } ?>