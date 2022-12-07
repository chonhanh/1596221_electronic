<?php
include "config.php";

$type = (!empty($_GET["type"])) ? htmlspecialchars($_GET["type"]) : '';
?>
<?php if ($type == 'video-fotorama') {
    $videos = $cache->get("select link_video, id, name$lang from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act <> ? and find_in_set('hienthi',status) order by numb, id desc", array($prefixSector, 'video', 'photo_static'), 'result', 7200);
    if (count($videos)) { ?>
        <div id="fotorama-videos" data-width="100%" data-thumbmargin="10" data-height="270" data-fit="cover" data-thumbwidth="100" data-thumbheight="85" data-allowfullscreen="false" data-nav="false" data-autoplay="3000">
            <?php foreach ($videos as $k => $v) { ?>
                <a href="https://youtube.com/watch?v=<?= $func->getYoutube($v['link_video']) ?>" title="<?= $v['name' . $lang] ?>"></a>
            <?php } ?>
        </div>
<?php }
} ?>

<?php if ($type == 'branch') {
    $branch = $cache->get("select A.id as id, A.name$lang as name$lang, B.content$lang as content$lang from #_news as A, #_news_content as B where A.id_shop = $idShop and A.sector_prefix = ? and A.id = B.id_parent and A.type = ? and find_in_set('hienthi',A.status) order by A.numb,A.id desc", array($prefixSector, 'chi-nhanh'), 'result', 7200);
    if (!empty($branch)) { ?>
        <div class="tabs-main">
            <ul class="nav nav-tabs" id="tabsBranch" role="tablist">
                <?php foreach ($branch as $k => $v) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($k == 0) ? 'active' : '' ?>" id="info-branch-<?= $v['id'] ?>-tab" data-toggle="tab" href="#info-branch-<?= $v['id'] ?>" role="tab"><?= $v['name' . $lang] ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content" id="tabsBranchContent">
                <?php foreach ($branch as $k => $v) { ?>
                    <div class="tab-pane fade <?= ($k == 0) ? 'show active' : '' ?>" id="info-branch-<?= $v['id'] ?>" role="tabpanel">
                        <?= $func->decodeHtmlChars($v['content' . $lang]) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<?php if ($type == 'fanpage-facebook') {
    $fanpage = !empty($optsetting['fanpage']) ? $optsetting['fanpage'] : ''; ?>
    <div class="fb-page" data-href="<?= $fanpage ?>" data-tabs="timeline" data-width="<?= (INTERFACE_SHOP == 2) ? '385' : ((INTERFACE_SHOP == 3) ? '300' : '') ?>" data-height="<?= (INTERFACE_SHOP == 2) ? '270' : ((INTERFACE_SHOP == 3) ? '220' : '') ?>" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
        <div class="fb-xfbml-parse-ignore">
            <blockquote cite="<?= $fanpage ?>">
                <a href="<?= $fanpage ?>">Facebook</a>
            </blockquote>
        </div>
    </div>
<?php } ?>

<?php if ($type == 'script-main') { ?>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.async = true;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="//sp.zalo.me/plugins/sdk.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c"></script>
<?php } ?>