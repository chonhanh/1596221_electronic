<?php if (!empty($static)) { ?>
    <div class="title-main"><span><?= $static['name' . $lang] ?></span></div>
    <div class="content-main w-clear"><?= (!empty($static['content' . $lang])) ? $func->decodeHtmlChars($static['content' . $lang]) : '' ?></div>
    <div class="share">
        <b><?= chiase ?>:</b>
        <div class="social-plugin w-clear">
            <div class="addthis_inline_share_toolbox_33zg"></div>
            <div class="zalo-share-button" data-href="<?= $func->getCurrentPageURL() ?>" data-oaid="<?= (@$optsetting['oaidzalo'] != '') ? $optsetting['oaidzalo'] : '579745863508352884' ?>" data-layout="3" data-color="blue" data-customize=false></div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong>Dữ liệu đang được cập nhật</strong>
    </div>
<?php } ?>