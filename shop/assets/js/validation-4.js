$(document).ready(function () {
	/* Newsletter */
	if (isExist($('input[name="submit-newsletter"]'))) {
		$('input[name="submit-newsletter"]').click(function () {
			var formNewsletter = $('#form-newsletter');
			var flag = true;
			var email = $('#email-newsletter');

			holdonOpen();

			if (isExist(email) && !getLen(email.val())) {
				email.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email) && !isEmail(email.val())) {
				email.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}
});
