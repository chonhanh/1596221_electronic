<div class="title-main"><span><?= $contact['name' . $lang] ?></span></div>

<?= $flash->getMessages('frontend') ?>

<div class="content-main">
    <div class="contact-article row">
        <div class="contact-text col-lg-6"><?= $func->decodeHtmlChars($contact['content' . $lang]) ?></div>
        <form class="contact-form col-lg-6" method="post" action="" enctype="multipart/form-data">
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="fullname-contact" name="dataContact[fullname]" placeholder="<?= hoten ?>" value="<?= $flash->get('fullname') ?>" required />
                </div>
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="phone-contact" name="dataContact[phone]" placeholder="<?= sodienthoai ?>" value="<?= $flash->get('phone') ?>" required />
                </div>
            </div>
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="address-contact" name="dataContact[address]" placeholder="<?= diachi ?>" value="<?= $flash->get('address') ?>" required />
                </div>
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="email-contact" name="dataContact[email]" placeholder="Email" value="<?= $flash->get('email') ?>" required />
                </div>
            </div>
            <div class="contact-input">
                <input type="text" class="form-control text-sm" id="subject-contact" name="dataContact[subject]" placeholder="<?= chude ?>" value="<?= $flash->get('subject') ?>" required />
            </div>
            <div class="contact-input">
                <textarea class="form-control text-sm" id="content-contact" name="dataContact[content]" placeholder="<?= noidung ?>" required /><?= $flash->get('content') ?></textarea>
            </div>
            <div class="contact-input custom-file">
                <input type="file" class="custom-file-input" name="file_attach">
                <label class="custom-file-label" for="file_attach" title="<?= chon ?>"><?= dinhkemtaptin ?></label>
            </div>
            <div class="input-group align-items-center captcha-image mb-3">
                <?php /* ?>
                <div class="input-group-prepend">
                    <span class="input-group-text text-sm rounded-0 border-0">Vui lòng nhập mã bảo mật</span>
                </div>
                <?php */ ?>
                <input type="text" class="form-control text-sm rounded-0" id="captcha-contact" name="captcha-contact" placeholder="Mã bảo mật" required>
                <div class="input-group-append">
                    <span class="input-group-text text-sm rounded-0 border-0">
                        <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('contact') ?>/" alt="Mã bảo mật" />
                        <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="contact">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </span>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" name="submit-contact" value="<?= gui ?>" />
            <input type="reset" class="btn btn-secondary" value="<?= nhaplai ?>" />
            <input type="hidden" name="recaptcha_response_contact" id="recaptchaResponseContact">
        </form>
    </div>
    <div class="contact-map"><?= $func->decodeHtmlChars($optsetting['coords_iframe']) ?></div>
</div>