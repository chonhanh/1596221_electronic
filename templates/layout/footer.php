<div class="footer">
    <div class="block-content position-relative">
        <div class="bt_hide bt_toggle" data-cont= ".footer">
            <i class="fas fa-caret-up"></i>
        </div>
    </div>
    <div class="footer_info_cont">
        <div class="footer-article">
            <div class="block-content">
                <div class="row">
                    <div class="footer-news col">
                        <div class="overflow-hidden">
                            <?= $addons->set('fanpage-facebook', 'fanpage-facebook', 2); ?>
                        </div>
                    </div>
                    <div class="footer-news col">
                        <h2 class="footer-title">Chính sách hỗ trợ</h2>
                        <?php if (!empty($policy)) { ?>
                            <ul class="footer-ul">
                                <?php foreach ($policy as $v) { ?>
                                    <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="chinh-sach-ho-tro/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="footer-news col">
                        <h2 class="footer-title">Tuyển dụng</h2>
                        <?php if (!empty($recruitment)) { ?>
                            <ul class="footer-ul">
                                <?php foreach ($recruitment as $v) { ?>
                                    <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="tuyen-dung/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="footer-news col">
                        <h2 class="footer-title">Hỗ trợ thanh toán</h2>
                        <?php if (!empty($support)) { ?>
                            <ul class="footer-ul">
                                <?php foreach ($support as $v) { ?>
                                    <li class="mb-1"><a class="text-decoration-none text-primary-hover transition" href="ho-tro-thanh-toan/<?= $v[$sluglang] ?>/<?= $v['id'] ?>" title="<?= $v['name' . $lang] ?>"><?= $v['name' . $lang] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="footer-news col">
                        <h2 class="footer-title">Chứng nhận</h2>
                        <?php if (!empty($ministry)) { ?>
                            <a href="<?= $ministry['link'] ?>" title="Bộ công thương"><?= $func->getImage(['sizes' => '135x50x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $ministry['photo'], 'alt' => 'Bộ công thương']) ?></a>
                        <?php } ?>
                    </div>
                    <div class="footer-news col">
                        <h2 class="footer-title">Kết nối chúng tôi</h2>
                        <ul class="footer-social footer-ul">
                            <?php foreach ($social as $k => $v) { ?>
                                <li class="mb-2">
                                    <a class="text-decoration-none" href="<?= $v['link'] ?>" target="_blank" title="<?= $v['name' . $lang] ?>">
                                        <?= $func->getImage(['sizes' => '25x25x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                                        <span class="text-primary-hover transition"><?= $v['name' . $lang] ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="block-content">CÔNG TY TNHH MTV CHỢ NHANH</div>
        </div>
    </div>
</div>