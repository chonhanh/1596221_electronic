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
                    <a class="footer-report show-report btn btn-sm btn-danger text-light mr-3" href="javascript:void(0)" title="Góp ý/phản hồi"><small class="mr-1">Góp ý/phản hồi</small><i class="far fa-comment-dots ml-1"></i></a>
                </div>
                <div class="col-right col-4">
                    <div class="footer-title text-uppercase font-weight-500 mb-3">Đăng ký nhận tin</div>
                    <p class="mb-2">Vui lòng nhập email của bạn để nhận các thông báo mới nhất từ chúng tôi</p>
                    <form class="d-flex align-items-stretch mb-3" id="form-newsletter" method="post" action="" enctype="multipart/form-data">
                        <input type="text" class="form-control text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Email của bạn" value="<?= $flash->get('email') ?>" required />
                        <input type="submit" class="btn btn-warning mb-0" name="submit-newsletter" value="Đăng ký" />
                        <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                    </form>
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
                <div class="col-right col-2">
                    <div class="footer-title text-uppercase font-weight-500 mb-3">Danh mục liên kết</div>
                    <ul class="footer-ul list-unstyled">
                        <li class="mb-2"><a class="text-decoration-none font-weight-500 text-dark transition" href="" title="Trang chủ">Trang chủ</a></li>
                        <li class="mb-2"><a class="text-decoration-none font-weight-500 text-dark transition" href="gioi-thieu" title="Giới thiệu">Giới thiệu</a></li>
                        <li class="mb-2"><a class="text-decoration-none font-weight-500 text-dark transition" href="nha-dat" title="Nhà đất">Nhà đất</a></li>
                        <li class="mb-2"><a class="text-decoration-none font-weight-500 text-dark transition" href="tin-tuc" title="Tin tức">Tin tức</a></li>
                        <li class="mb-2"><a class="text-decoration-none font-weight-500 text-dark transition" href="thong-bao" title="Thông báo">Thông báo</a></li>
                        <li><a class="text-decoration-none font-weight-500 text-dark transition" href="lien-he" title="Liên hệ">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="block-content text-center text-white font-weight-700 py-3">CÔNG TY TNHH MTV CHỢ NHANH</div>
    </div>
</div>