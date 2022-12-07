$(document).ready(function () {
	/* Newsletter */
	if (isExist($('input[name="submit-newsletter"]'))) {
		$('input[name="submit-newsletter"]').click(function () {
			var formNewsletter = $('#form-newsletter');
			var flag = true;
			var fullname = $('#fullname-newsletter');
			var email = $('#email-newsletter');
			var content = $('#content-newsletter');

			holdonOpen();

			if (isExist(fullname) && !getLen(fullname.val())) {
				fullname.focus();
				notifyDialog('Họ tên không được trống');
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
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}
});
