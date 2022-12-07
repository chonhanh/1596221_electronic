<div class="block-intro">
    <div class="block-content py-5">
        <div class="row">
            <div class="col-4">
                <div class="card card-main bg-transparent rounded-0 border-0">
                    <div class="card-header text-uppercase text-center pb-2 mb-3">Video clip</div>
                    <div class="card-body p-0"><?= $addons->set('video-fotorama', 'video-fotorama'); ?></div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-main bg-transparent rounded-0 border-0 h-100 justify-content-between">
                    <div class="card-header text-uppercase text-center pb-2 mb-3">Đăng ký nhận tin</div>
                    <div class="card-body p-0 h-100">
                        <form id="form-newsletter" method="post" action="" enctype="multipart/form-data">
                            <input type="text" class="form-control text-sm" id="fullname-newsletter" name="dataNewsletter[fullname]" placeholder="<?= hoten ?>" value="<?= $flash->get('fullname') ?>" required />
                            <input type="text" class="form-control text-sm" id="email-newsletter" name="dataNewsletter[email]" placeholder="Email" value="<?= $flash->get('email') ?>" required />
                            <textarea class="form-control text-sm" id="content-newsletter" name="dataNewsletter[content]" placeholder="<?= noidung ?>" required /><?= $flash->get('content') ?></textarea>
                            <div class="text-center">
                                <input type="submit" class="btn btn-warning mb-0" name="submit-newsletter" value="Đăng ký" />
                                <input type="hidden" name="recaptcha_response_newsletter" id="recaptchaResponseNewsletter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-main bg-transparent rounded-0 border-0">
                    <div class="card-header text-uppercase text-center pb-2 mb-3">Fanpage facebook</div>
                    <div class="card-body p-0"><?= $addons->set('fanpage-facebook', 'fanpage-facebook'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>