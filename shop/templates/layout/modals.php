<?php if (!empty($statusShop) && $statusShop == 'dangsai') { ?>
    <!-- Modal status -->
    <div class="modal modal-general fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="modal-status-label" aria-hidden="true">
        <div class="modal-dialog w-dialog-800" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-status-label">Thông báo</div>
                    <div class="modal-close transition" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <div class="alert alert-warning rounded-0 mb-0">Gian hàng đang bị chặn bởi Ban Quản Trị. Các thông tin trên trang này tạm thời không còn khả dụng.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (!$shopInfo['isOwned']) { ?>
    <!-- Modal chat -->
    <?php /*<a class="show-chat text-decoration-none text-uppercase transition" href="javascript:void(0)"></a>
    */ ?>
    <?php if ($func->getMember('active')) { ?>
        <div class="modal modal-general fade" id="modal-chat" tabindex="-1" role="dialog" aria-labelledby="modal-chat-label" aria-hidden="true">
            <div class="modal-dialog w-dialog-630" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="modal-chat-label">Trò chuyện để chúng tôi đến gần với bạn hơn</div>
                        <div class="modal-close transition" data-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="modal-data">
                            <div class="modal-form">
                                <form id="form-chat" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group response-chat"></div>
                                    <div class="form-group">
                                        <textarea class="form-control h-auto text-sm rounded-0" id="message-chat" name="dataChat[message]" placeholder="Nội dung" rows="10" required /></textarea>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="mb-2">Hình ảnh: (Tối đa 2 hình)</label>
                                        <div class="chat-file-uploader">
                                            <input type="file" id="chat-file-photo" name="chat-file-photo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group align-items-center captcha-image">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-sm rounded-0 border-0">Vui lòng nhập mã bảo mật</span>
                                            </div>
                                            <input type="text" class="form-control text-sm" id="captcha-chat" name="captcha-chat" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text rounded-0 border-0">
                                                    <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= BASE_MAIN ?>captcha/<?= base64_encode('chat-' . NAME_SHOP) ?>/" alt="Mã bảo mật" />
                                                    <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="chat-<?= NAME_SHOP ?>">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center mb-0">
                                        <input type="submit" class="btn btn-action btn-sm btn-primary px-3 mx-2" name="submit-chat" value="Gửi" />
                                        <input type="reset" class="btn btn-action btn-sm btn-danger px-3 mx-2" value="Hủy" />
                                        <input type="hidden" name="recaptcha_response_chat" id="recaptchaResponseChat">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<?php if ($func->getMember('active')) { ?>
    <!-- Modal report -->
    <div class="modal modal-general fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modal-report-label" aria-hidden="true">
        <div class="modal-dialog w-dialog-800" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-report-label">Vui lòng thông báo cho chúng tôi biết những gian hàng vi phạm để chúng tôi có hướng giải quyết kịp thời!</div>
                    <div class="modal-close transition" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <form id="form-report" method="post" action="" enctype="multipart/form-data">
                            <div class="modal-form">
                                <div class="row">
                                    <div class="col-4">
                                        <?php if (!empty($reportStatus)) { ?>
                                            <div class="report-status">
                                                <?php foreach ($reportStatus as $v_reportStatus) { ?>
                                                    <label class="btn btn-sm btn-warning custom-control custom-radio text-left text-sm py-2 pr-3 mb-2" for="report-<?= $v_reportStatus['id'] ?>">
                                                        <input type="radio" id="report-<?= $v_reportStatus['id'] ?>" name="dataReport[id_status]" class="custom-control-input" value="<?= $v_reportStatus['id'] ?>">
                                                        <span class="custom-control-label text-dark"><strong><?= $v_reportStatus['name' . $lang] ?></strong></span>
                                                        <div class="d-none" id="report-status-text"><?= $v_reportStatus['desc' . $lang] ?></div>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="response-report"></div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="fullname-report">Họ tên:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="fullname-report" name="dataReport[fullname]" placeholder="Họ tên liên hệ" value="<?= $func->getMember('fullname') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="phone-report">Số điện thoại:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="phone-report" name="dataReport[phone]" placeholder="Số điện thoại liên hệ" value="<?= $func->getMember('phone') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="email-report">Email:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="email-report" name="dataReport[email]" placeholder="Email liên hệ" value="<?= $func->getMember('email') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="content-report">Nội dung:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea class="form-control text-sm rounded-0" id="content-report" name="dataReport[content]" placeholder="Nội dung báo xấu" required /></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="input-group align-items-center captcha-image">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-sm rounded-0 border-0">Mã bảo mật</span>
                                                    </div>
                                                    <input type="text" class="form-control text-sm" id="captcha-report" name="captcha-report" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text rounded-0 border-0">
                                                            <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= BASE_MAIN ?>captcha/<?= base64_encode('report-' . NAME_SHOP) ?>/" alt="Mã bảo mật" />
                                                            <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="report-<?= NAME_SHOP ?>">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-center">
                                                <input type="submit" class="btn btn-action btn-sm btn-primary px-3 mx-2" name="submit-report" value="Ok" />
                                                <input type="reset" class="btn btn-action btn-sm btn-danger px-3 mx-2" value="Hủy" />
                                                <input type="hidden" name="recaptcha_response_report" id="recaptchaResponseReport">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Modal sectors -->
<div class="modal modal-general fade" id="modal-sectors" tabindex="-1" role="dialog" aria-labelledby="modal-sectors-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-sectors-label">Danh mục chính</div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-data form-row"></div>
            </div>
        </div>
    </div>
</div>
