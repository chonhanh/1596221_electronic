<?php if (!empty($aboutHome)) { ?>
    <div class="block-about mb-5">
        <div class="block-content">
            <div class="about-content">
                <span class="about-icon" id="top-left"></span>
                <span class="about-icon" id="top-center"></span>
                <span class="about-icon" id="top-right"></span>
                <span class="about-icon" id="bottom-left"></span>
                <span class="about-icon" id="bottom-right"></span>
                <div class="about-text pt-5 pb-3 px-4"><?= $func->decodeHtmlChars($aboutHome['desc' . $lang]) ?></div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="block-product">
    <div class="block-content">
        <div class="title-main">
            <span>Dịch vụ của chúng tôi</span>
        </div>
        <div class="paging-product"></div>
    </div>
</div>