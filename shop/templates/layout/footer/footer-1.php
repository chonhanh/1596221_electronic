<div class="footer">
    <div class="footer-article">
        <div class="block-content py-5">
            <div class="row">
                <div class="col-left col-6">
                    <div class="card card-main mb-3">
                        <div class="card-header text-uppercase pb-2"><?= $footer['name' . $lang] ?></div>
                        <div class="card-body">
                            <?= $func->decodeHtmlChars($footer['content' . $lang]) ?>
                            <div id="star-rating"></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-start">
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
                <div class="col-right col-6">
                    <?= $addons->set('branch', 'branch', 5); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="block-content text-center text-white font-weight-700 py-3">CÔNG TY TNHH MTV CHỢ NHANH</div>
    </div>
</div>