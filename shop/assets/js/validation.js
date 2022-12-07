$(document).ready(function () {
	/* Chat */
	if (isExist($('input[name="submit-chat"]'))) {
		$('input[name="submit-chat"]').click(function (e) {
			e.preventDefault();
			var formChat = $('#form-chat');
			var responseEle = formChat.find('.response-chat');
			var captchaOBJ = formChat.find('.captcha-image').find('.captcha-reload');
			var captcha = $('#captcha-chat');
			var flag = true;
			var message = $('#message-chat');
			var has_gallery = $('.chat-file-uploader');
			var files_gallery = $('.chat-file-uploader .fileuploader-items-list li');

			holdonOpen();

			if (isExist(message) && !getLen(message.val())) {
				message.focus();
				notifyDialog('Nội dung tin nhắn không được trống');
				flag = false;
			} else if (isExist(has_gallery) && isExist(files_gallery) && getLen(files_gallery) > 2) {
				notifyDialog('Hình ảnh không được vượt quá 2 hình');
				flag = false;
			} else if (isExist(captcha) && !getLen(captcha.val())) {
				captcha.focus();
				notifyDialog('Mã bảo mật không được trống');
				flag = false;
			}

			/* Post form */
			if (flag) {
				var formChatData = new FormData(formChat[0]);
				responseEle.html('');

				setTimeout(function () {
					$.ajax({
						url: URL_CURRENT_ORIGIN + '?isAjaxChat=1',
						type: 'post',
						enctype: 'multipart/form-data',
						dataType: 'json',
						data: formChatData,
						async: false,
						processData: false,
						contentType: false,
						cache: false
					}).done(function (result) {
						if (result.status) {
							if (result.status == 'success') {
								formChat.trigger('reset');

								showNotify(result.message);

								setTimeout(function () {
									location.reload();
								}, 3000);
							} else if (result.status == 'error') {
								/* Generate captcha */
								generateCaptcha('Chat', 'recaptchaResponseChat');

								/* Show error */
								responseEle.html('<div class="alert alert-danger">' + result.message + '</div>');
							}

							createCaptcha(captchaOBJ);
						}

						holdonClose();
					});
				}, 500);
			} else {
				holdonClose();
			}
		});
	}

	/* Report */
	if (isExist($('input[name="submit-report"]'))) {
		$('input[name="submit-report"]').click(function (e) {
			e.preventDefault();
			var formReport = $('#form-report');
			var responseEle = formReport.find('.response-report');
			var captchaOBJ = formReport.find('.captcha-image').find('.captcha-reload');
			var flag = true;
			var status = formReport.find('.report-status').find("input[type='radio']:checked");
			var fullname = $('#fullname-report');
			var phone = $('#phone-report');
			var email = $('#email-report');
			var content = $('#content-report');
			var captcha = $('#captcha-report');

			holdonOpen();

			if (!isExist(status)) {
				status.focus();
				notifyDialog('Chưa chọn dữ liệu báo xấu');
				flag = false;
			} else if (isExist(fullname) && !getLen(fullname.val())) {
				fullname.focus();
				notifyDialog('Họ tên không được trống');
				flag = false;
			} else if (isExist(phone) && !getLen(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không được trống');
				flag = false;
			} else if (isExist(phone) && !isPhone(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không hợp lệ');
				flag = false;
			} else if (isExist(email) && !getLen(email.val())) {
				email.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email) && !isEmail(email.val())) {
				email.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			} else if (isExist(content) && !getLen(content.val())) {
				content.focus();
				notifyDialog('Nội dung không được trống');
				flag = false;
			} else if (isExist(captcha) && !getLen(captcha.val())) {
				captcha.focus();
				notifyDialog('Mã bảo mật không được trống');
				flag = false;
			}

			/* Post form */
			if (flag) {
				responseEle.html('');

				setTimeout(function () {
					$.ajax({
						url: URL_CURRENT_ORIGIN + '?isAjaxReport=1',
						type: 'post',
						dataType: 'json',
						data: formReport.serialize()
					}).done(function (result) {
						if (result.status) {
							if (result.status == 'success') {
								formReport.trigger('reset');

								showNotify(result.message);

								setTimeout(function () {
									location.reload();
								}, 1000);
							} else if (result.status == 'error') {
								/* Generate captcha */
								generateCaptcha('Report', 'recaptchaResponseReport');

								/* Show error */
								responseEle.html('<div class="alert alert-danger">' + result.message + '</div>');
							}

							createCaptcha(captchaOBJ);
						}

						holdonClose();
					});
				}, 500);
			} else {
				holdonClose();
			}
		});
	}

	/* Contact */
	if (isExist($('input[name="submit-contact"]'))) {
		$('input[name="submit-contact"]').click(function () {
			var flag = true;
			var fullname = $('#fullname-contact');
			var phone = $('#phone-contact');
			var address = $('#address-contact');
			var email = $('#email-contact');
			var subject = $('#subject-contact');
			var content = $('#content-contact');
			var captcha = $('#captcha-contact');

			holdonOpen();

			if (isExist(fullname) && !getLen(fullname.val())) {
				fullname.focus();
				notifyDialog('Họ tên không được trống');
				flag = false;
			} else if (isExist(phone) && !getLen(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không được trống');
				flag = false;
			} else if (isExist(phone) && !isPhone(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không hợp lệ');
				flag = false;
			} else if (isExist(address) && !getLen(address.val())) {
				address.focus();
				notifyDialog('Địa chỉ không được trống');
				flag = false;
			} else if (isExist(email) && !getLen(email.val())) {
				email.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email) && !isEmail(email.val())) {
				email.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			} else if (isExist(subject) && !getLen(subject.val())) {
				subject.focus();
				notifyDialog('Chủ đề không được trống');
				flag = false;
			} else if (isExist(content) && !getLen(content.val())) {
				content.focus();
				notifyDialog('Nội dung không được trống');
				flag = false;
			} else if (isExist(captcha) && !getLen(captcha.val())) {
				captcha.focus();
				notifyDialog('Mã bảo mật không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}
});
