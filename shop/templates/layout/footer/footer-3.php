<div class="footer">
    <div class="footer-article">
        <div class="block-content py-5">
            <div class="row mb-3">
                <div class="footer-col col">
                    <div class="card card-main">
                        <div class="card-header text-uppercase pb-2"><?= $footer['name' . $lang] ?></div>
                        <div class="card-body">
                            <?= $func->decodeHtmlChars($footer['content' . $lang]) ?>
                            <div id="star-rating"></div>
                        </div>
                    </div>
                </div>
                <div class="footer-col col">
                    <div class="footer-title">Giới thiệu</div>
                    <?php if (!empty($aboutHighlight)) { ?>
                        <ul class="footer-ul list-unstyled">
                            <?php foreach ($aboutHighlight as $v) { ?>
                                <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="gioi-thieu/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="footer-col col">
                    <div class="footer-title">Sản phẩm</div>
                    <?php if (!empty($sectorItemsPage['footer'])) { ?>
                        <ul class="footer-ul list-unstyled">
                            <?php foreach ($sectorItemsPage['footer'] as $v) { ?>
                                <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="san-pham?item=<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="footer-col col">
                    <div class="footer-title">Tin tức</div>
                    <?php if (!empty($newsHighlight)) { ?>
                        <ul class="footer-ul list-unstyled">
                            <?php foreach ($newsHighlight as $v) { ?>
                                <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="tin-tuc/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="footer-col col">
                    <?= $addons->set('fanpage-facebook', 'fanpage-facebook', 2); ?>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-start">
                <a class="footer-report show-report btn btn-sm btn-danger text-light mr-3" href="javascript:void(0)" title="Góp ý/phản hồi"><small class="mr-1">Góp ý/phản hồi</small><i class="far fa-comment-dots ml-1"></i></a>
                <ul class="footer-social p-0 m-0">
                    <?php foreach ($social as $k => $v) { ?>
                        <li class="d-inline-block align-top">
                            <a href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                <?= $func->getImage(['sizes' => '45x45x2', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="block-content text-center font-weight-700 py-3">CÔNG TY TNHH MTV CHỢ NHANH</div>
    </div>
</div>