<div class="title-main"><span>Chi tiết bài viết</span></div>
<p class="h5 text-uppercase mb-3"><?= $rowDetail['name' . $lang] ?></p>
<div class="time-main"><i class="fas fa-calendar-week"></i><span><?= ngaydang ?>: <?= date("d/m/Y h:i A", $rowDetail['date_created']) ?></span></div>
<?php if (!empty($rowDetail['content' . $lang])) { ?>
    <div class="content-main w-clear"><?= $func->decodeHtmlChars($rowDetail['content' . $lang]) ?></div>
    <div class="share">
        <b><?= chiase ?>:</b>
        <div class="social-plugin w-clear">
            <div class="addthis_inline_share_toolbox_33zg"></div>
            <div class="zalo-share-button" data-href="<?= $func->getCurrentPageURL() ?>" data-oaid="<?= ($optsetting['oaidzalo'] != '') ? $optsetting['oaidzalo'] : '579745863508352884' ?>" data-layout="3" data-color="blue" data-customize=false></div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert">
        <strong><?= noidungdangcapnhat ?></strong>
    </div>
<?php } ?>
<?php if (!empty($news)) { ?>
    <div class="share othernews">
        <b><?= baivietkhac ?>:</b>
        <ul class="list-news-other">
            <?php foreach ($news as $k => $v) { ?>
                <li><a class="text-decoration-none" href="<?= $com ?>/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?> - <?= date("d/m/Y", $v['date_created']) ?></a></li>
            <?php } ?>
        </ul>
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
<?php } ?>