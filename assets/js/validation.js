$(document).ready(function () {
	/* Registration */
	if (isExist($('input[name="registration-user"]'))) {
		$('input[name="registration-user"]').click(function () {
			var flag = true;
			var username = $('#username');
			var password = $('#password');
			var repassword = $('#repassword');
			var first_name = $('#first_name');
			var last_name = $('#last_name');
			var gender = $("input[name='gender']:checked");
			var birthday = $('#birthday');
			var city = $('#city');
			var district = $('#district');
			var wards = $('#wards');
			var email = $('#email');
			var rules = $("input[name='rules']:checked");
			var captcha = $('#captcha-registration-account');
			var existUsername = checkAccount(username, 'username', 'member');
			var existEmail = checkAccount(email, 'email', 'member');

			holdonOpen();

			if (isExist(username) && !getLen(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không được trống');
				flag = false;
			} else if (isExist(username) && !isPhone(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không hợp lệ');
				flag = false;
			} else if (isExist(username) && Number(existUsername)===1) {
				username.focus();
				notifyDialog('Tài khoản đã tồn tại');
				flag = false;
			}else if (isExist(username) && Number(existUsername)===3) {
				username.focus();
				notifyDialog('Kiểm tra tài khoản lỗi. Vui lòng thử lại sau!');
				flag = false;
			}else if (isExist(password) && !getLen(password.val())) {
				password.focus();
				notifyDialog('Mật khẩu không được trống');
				flag = false;
			} else if (isExist(password) && getLen(password.val()) && !isPassword(password.val())) {
				password.focus();
				notifyDialog(
					"<ul class='list-unstyled text-danger text-left mb-0'><li class='text-dark text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>"
				);
				flag = false;
			} else if (isExist(repassword) && !getLen(repassword.val())) {
				repassword.focus();
				notifyDialog('Xác nhận mật khẩu không được trống');
				flag = false;
			} else if (!isMatch(password.val(), repassword.val())) {
				repassword.focus();
				notifyDialog('Mật khẩu không trùng khớp');
				flag = false;
			} else if (
				(isExist(first_name) && !getLen(first_name.val())) ||
				(isExist(last_name) && !getLen(last_name.val()))
			) {
				if (!getLen(first_name.val())) {
					first_name.focus();
				} else if (!getLen(last_name.val())) {
					last_name.focus();
				}
				notifyDialog('Họ tên không được trống');
				flag = false;
			} else if (!isExist(gender)) {
				gender.focus();
				notifyDialog('Chưa chọn giới tính');
				flag = false;
			} else if (isExist(birthday) && !getLen(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không được trống');
				flag = false;
			} else if (isExist(birthday) && !isDate(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không hợp lệ');
				flag = false;
			} else if (isExist(city) && !city.val()) {
				city.focus();
				notifyDialog('Chưa chọn tỉnh/thành phố');
				flag = false;
			} else if (isExist(district) && !district.val()) {
				district.focus();
				notifyDialog('Chưa chọn quận/huyện');
				flag = false;
			} else if (isExist(wards) && !wards.val()) {
				wards.focus();
				notifyDialog('Chưa chọn phường/xã');
				flag = false;
			} else if (isExist(email) && !getLen(email.val())) {
				email.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email) && !isEmail(email.val())) {
				email.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			}else if (isExist(email) && Number(existEmail)===1) {
				email.focus();
				notifyDialog('Email đã tồn tại');
				flag = false;
			}else if (isExist(email) && Number(existEmail)===3) {
				email.focus();
				notifyDialog('Kiểm tra email lỗi. Vui lòng thử lại sau!');
				flag = false;
			} else if (!isExist(rules)) {
				rules.focus();
				notifyDialog('Chưa đồng ý điều khoản');
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

	/* Info */
	if (isExist($('input[name="info-user"]'))) {
		$('input[name="info-user"]').click(function () {
			var flag = true;
			var first_name = $('#first_name');
			var last_name = $('#last_name');
			var birthday = $('#birthday');
			var address = $('#address');
			var city = $('#city');
			var district = $('#district');
			var wards = $('#wards');
			var gender = $('#gender');
			var phone = $('#phone');
			var captcha = $('#captcha-info-account');

			holdonOpen();

			if (
				(isExist(first_name) && !getLen(first_name.val())) ||
				(isExist(last_name) && !getLen(last_name.val()))
			) {
				if (!getLen(first_name.val())) {
					first_name.focus();
				} else if (!getLen(last_name.val())) {
					last_name.focus();
				}
				notifyDialog('Họ tên không được trống');
				flag = false;
			} else if (isExist(birthday) && !getLen(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không được trống');
				flag = false;
			} else if (isExist(birthday) && !isDate(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không hợp lệ');
				flag = false;
			} else if (isExist(address) && !getLen(address.val())) {
				address.focus();
				notifyDialog('Địa chỉ không được trống');
				flag = false;
			} else if (isExist(city) && !city.val()) {
				city.focus();
				notifyDialog('Chưa chọn tỉnh/thành phố');
				flag = false;
			} else if (isExist(district) && !district.val()) {
				district.focus();
				notifyDialog('Chưa chọn quận/huyện');
				flag = false;
			} else if (isExist(wards) && !wards.val()) {
				wards.focus();
				notifyDialog('Chưa chọn phường/xã');
				flag = false;
			} else if (isExist(gender) && !getLen(gender.val())) {
				gender.focus();
				notifyDialog('Chưa chọn giới tính');
				flag = false;
			} else if (isExist(phone) && !getLen(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không được trống');
				flag = false;
			} else if (isExist(phone) && !isPhone(phone.val())) {
				phone.focus();
				notifyDialog('Số điện thoại không hợp lệ');
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

	/* Activation */
	if (isExist($('input[name="activation-user"]'))) {
		$('input[name="activation-user"]').click(function () {
			var flag = true;
			var confirm_code = $('#confirm_code');

			holdonOpen();

			if (isExist(confirm_code) && !getLen(confirm_code.val())) {
				confirm_code.focus();
				notifyDialog('Mã kích hoạt không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Login */
	if (isExist($('input[name="login-user"]'))) {
		$('input[name="login-user"]').click(function () {
			var flag = true;
			var username = $('#username');
			var password = $('#password');

			holdonOpen();

			if (isExist(username) && !getLen(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không được trống');
				flag = false;
			} else if (isExist(username) && !isPhone(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không hợp lệ');
				flag = false;
			} else if (isExist(password) && !getLen(password.val())) {
				password.focus();
				notifyDialog('Mật khẩu không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Change password */
	if (isExist($('input[name="change-password-user"]'))) {
		$('input[name="change-password-user"]').click(function () {
			var flag = true;
			var old_password = $('#old-password');
			var new_password = $('#new-password');
			var new_password_confirm = $('#new-password-confirm');

			holdonOpen();

			if (isExist(old_password) && !getLen(old_password.val())) {
				old_password.focus();
				notifyDialog('Mật khẩu cũ không được trống');
				flag = false;
			} else if (isExist(new_password) && !getLen(new_password.val())) {
				new_password.focus();
				notifyDialog('Mật khẩu mới không được trống');
				flag = false;
			} else if (isExist(new_password) && getLen(new_password.val()) && !isPassword(new_password.val())) {
				new_password.focus();
				notifyDialog(
					"<ul class='list-unstyled text-danger text-left mb-0'><li class='text-dark text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>"
				);
				flag = false;
			} else if (isExist(new_password_confirm) && !getLen(new_password_confirm.val())) {
				new_password_confirm.focus();
				notifyDialog('Xác nhận mật khẩu mới không được trống');
				flag = false;
			} else if (
				isExist(new_password) &&
				getLen(new_password.val()) &&
				isExist(new_password_confirm) &&
				!getLen(new_password_confirm.val())
			) {
				new_password_confirm.focus();
				notifyDialog('Xác nhận mật khẩu mới không được trống');
				flag = false;
			} else if (
				isExist(new_password) &&
				getLen(new_password.val()) &&
				isExist(new_password_confirm) &&
				getLen(new_password_confirm.val()) &&
				!isMatch(new_password.val(), new_password_confirm.val())
			) {
				new_password_confirm.focus();
				notifyDialog('Mật khẩu mới không trùng khớp');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Forgot password */
	if (isExist($('input[name="forgot-password-user"]'))) {
		$('input[name="forgot-password-user"]').click(function () {
			var flag = true;
			var username = $('#username');
			var email = $('#email');

			holdonOpen();

			if (isExist(username) && !getLen(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không được trống');
				flag = false;
			} else if (isExist(username) && !isPhone(username.val())) {
				username.focus();
				notifyDialog('Tài khoản không hợp lệ');
				flag = false;
			} else if (isExist(email) && !getLen(email.val())) {
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

	/* Update shop user */
	if (isExist($('button[name="action-shop-user"]'))) {
		$('button[name="action-shop-user"]').click(function () {
			var flag = true;
			var shop_member_password = $('#shop_member_password');

			holdonOpen();

			if (isExist(shop_member_password) && !getLen(shop_member_password.val())) {
				shop_member_password.focus();
				notifyDialog('Mật khẩu không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Update posting user */
	if (isExist($('button[name="action-posting-user"]'))) {
		$('button[name="action-posting-user"]').click(function () {
			var flag = true;
			var posting_member_contentvi = $('#posting_member_contentvi');
			var posting_member_introduce_employer = $('#posting_member_introduce_employer');

			holdonOpen();

			if (isExist(posting_member_contentvi) && !getLen(posting_member_contentvi.val())) {
				posting_member_contentvi.focus();
				notifyDialog('Nội dung không được trống');
				flag = false;
			} else if (isExist(posting_member_introduce_employer) && !getLen(posting_member_introduce_employer.val())) {
				posting_member_introduce_employer.focus();
				notifyDialog('Giới thiệu không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* New posting */
	if (isExist($('input[name="new-posting"]'))) {
		$('input[name="new-posting"]').click(function () {
			$this = $(this);
			$parents = $this.parents('.form-new-posting');
			var inputs = $parents.find('input[type=checkbox]:checked');
			var flag = true;

			holdonOpen();

			if (!isExist(inputs)) {
				notifyDialog('Chưa chọn lĩnh vực');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Chat */
	if (isExist($('button[name="action-chat-user"]'))) {
		$('button[name="action-chat-user"]').click(function () {
			var flag = true;
			var message = $('#message');

			holdonOpen();

			if (isExist(message) && !getLen(message.val())) {
				message.focus();
				notifyDialog('Nội dung tin nhắn không được trống');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
		});
	}

	/* Postings */
	if (isExist($('input[name="submit-posting"]'))) {
		$('input[name="submit-posting"]').click(function (e) {
			e.preventDefault();
			var cardPosting = $('#card-posting');
			var formPosting = $('#form-posting');
			var responseEle = cardPosting.find('.response-posting');
			var flag = true;
			var namevi = $('#namevi');
			var item = $('#id_item');
			var form_work = $('#id_form_work');
			var experience = $('#id_experience');
			var city = $('#id_city');
			var district = $('#id_district');
			var wards = $('#id_wards');
			var contentvi = $('#contentvi');
			var contentvi_label = $('#contentvi').data('label');
			var name_video = $('#name_video');
			var poster_video = $('#avatar-poster');
			var file_video = $('#file_video');
			var ext_video = infoFile(file_video, 'ext');
			var size_video = infoFile(file_video, 'size');
			var size_max = formatBytes(MAX_SIZE_VIDEO);
			var type_video = $('.form-group-video').find('input[type=hidden]#video-type').val();
			var regular_price = $('#regular_price');
			var regular_price_label = $('#regular_price').data('label');
			var type_price = $('#type-price');
			var acreage = $('#acreage');
			var coordinates = $('#map-coordinates-posting');
			var first_name = $('#first_name');
			var last_name = $('#last_name');
			var birthday = $('#birthday');
			var gender = $('#gender');
			var phone = $('#phone');
			var email = $('#email');
			var address = $('#address');
			var avatar_employer = $('#avatar-employer');
			var fullname_employer = $('#fullname_employer');
			var phone_employer = $('#phone_employer');
			var email_employer = $('#email_employer');
			var address_employer = $('#address_employer');
			var introduce_employer = $('#introduce_employer');
			var gender_employer = $('#gender_employer');
			var age_requirement = $('#age_requirement');
			var application_deadline = $('#application_deadline');
			var trial_period = $('#trial_period');
			var employee_quantity = $('#employee_quantity');
			var has_gallery = $('.posting-file-uploader');
			var files_gallery = $('.posting-file-uploader .fileuploader-items-list li');
			var fullname_contact = $('#fullname_contact');
			var phone_contact = $('#phone_contact');
			var address_contact = $('#address_contact');
			var email_contact = $('#email_contact');

			holdonOpen();

			if (isExist(item) && !item.val()) {
				item.focus();
				notifyDialog('Chưa chọn danh mục lĩnh vực');
				flag = false;
			} else if (isExist(namevi) && !getLen(namevi.val())) {
				namevi.focus();
				notifyDialog('Tiêu đề không được trống');
				flag = false;
			} else if (isExist(has_gallery) && !isExist(files_gallery)) {
				notifyDialog('Album hình ảnh không được trống');
				flag = false;
			} else if (isExist(has_gallery) && isExist(files_gallery) && getLen(files_gallery) > 6) {
				notifyDialog('Album hình ảnh không được vượt quá 6 hình');
				flag = false;
			} else if (
				isExist(name_video) &&
				!getLen(name_video.val()) &&
				((isExist(file_video) && size_video['numb']) || (isExist(poster_video) && getLen(poster_video.val())))
			) {
				name_video.focus();
				notifyDialog('Tiêu đề video không được trống');
				flag = false;
			} else if (
				isExist(name_video) &&
				isExist(file_video) &&
				type_video == 'file' &&
				getLen(name_video.val()) &&
				isExist(poster_video) &&
				!getLen(poster_video.val())
			) {
				notifyDialog('Hình đại diện video không được trống');
				flag = false;
			} else if (
				isExist(name_video) &&
				isExist(file_video) &&
				type_video == 'file' &&
				getLen(name_video.val()) &&
				!size_video['numb']
			) {
				notifyDialog('Tập tin video không được trống');
				flag = false;
			} else if (
				isExist(name_video) &&
				isExist(file_video) &&
				type_video == 'file' &&
				getLen(name_video.val()) &&
				!checkExtFile(ext_video, EXTENSION_VIDEO)
			) {
				notifyDialog('Chi cho phép tập tin video với định dạng: ' + JSON.stringify(EXTENSION_VIDEO));
				flag = false;
			} else if (
				isExist(name_video) &&
				isExist(file_video) &&
				type_video == 'file' &&
				getLen(name_video.val()) &&
				size_video['numb'] > size_max['numb']
			) {
				notifyDialog('Tập tin video không được vượt quá ' + size_max['numb'] + ' ' + size_max['ext']);
				flag = false;
			} else if (isExist(contentvi) && !getLen(contentvi.val())) {
				contentvi.focus();
				notifyDialog(contentvi_label + ' không được trống');
				flag = false;
			} else if (isExist(first_name) && !getLen(first_name.val())) {
				first_name.focus();
				notifyDialog('Họ và chữ lót không được trống');
				flag = false;
			} else if (isExist(last_name) && !getLen(last_name.val())) {
				last_name.focus();
				notifyDialog('Tên không được trống');
				flag = false;
			} else if (isExist(birthday) && !getLen(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không được trống');
				flag = false;
			} else if (isExist(birthday) && !isDate(birthday.val())) {
				birthday.focus();
				notifyDialog('Ngày sinh không hợp lệ');
				flag = false;
			} else if (isExist(gender) && !getLen(gender.val())) {
				gender.focus();
				notifyDialog('Chưa chọn giới tính');
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
			} else if (isExist(address) && !getLen(address.val())) {
				address.focus();
				notifyDialog('Địa chỉ không được trống');
				flag = false;
			} else if (isExist(avatar_employer) && !getLen(avatar_employer.val())) {
				notifyDialog('Hình ảnh đại diện cho nhà tuyển dụng không được trống');
				flag = false;
			} else if (isExist(fullname_employer) && !getLen(fullname_employer.val())) {
				fullname_employer.focus();
				notifyDialog('Tên nhà tuyển dụng không được trống');
				flag = false;
			} else if (isExist(phone_employer) && !getLen(phone_employer.val())) {
				phone_employer.focus();
				notifyDialog('Số điện thoại không được trống');
				flag = false;
			} else if (isExist(phone_employer) && !isPhone(phone_employer.val())) {
				phone_employer.focus();
				notifyDialog('Số điện thoại không hợp lệ');
				flag = false;
			} else if (isExist(email_employer) && !getLen(email_employer.val())) {
				email_employer.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email_employer) && !isEmail(email_employer.val())) {
				email_employer.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			} else if (isExist(address_employer) && !getLen(address_employer.val())) {
				address_employer.focus();
				notifyDialog('Địa chỉ không được trống');
				flag = false;
			} else if (isExist(introduce_employer) && !getLen(introduce_employer.val())) {
				introduce_employer.focus();
				notifyDialog('Giới thiệu không được trống');
				flag = false;
			} else if (isExist(form_work) && !form_work.val()) {
				form_work.focus();
				notifyDialog('Chưa chọn hình thức làm việc');
				flag = false;
			} else if (isExist(experience) && !experience.val()) {
				experience.focus();
				notifyDialog('Chưa chọn kinh nghiệm');
				flag = false;
			} else if (isExist(acreage) && !getLen(acreage.val())) {
				acreage.focus();
				notifyDialog('Diện tích không được trống');
				flag = false;
			} else if (isExist(acreage) && (!isDecimal(acreage.val()) || isZero(acreage.val()))) {
				acreage.focus();
				notifyDialog('Diện tích không hợp lệ');
				flag = false;
			} else if (isExist(regular_price) && !getLen(regular_price.val())) {
				regular_price.focus();
				notifyDialog(regular_price_label + ' không được trống');
				flag = false;
			} else if (isExist(regular_price) && (!isDecimal(regular_price.val()) || isZero(regular_price.val()))) {
				regular_price.focus();
				notifyDialog(regular_price_label + ' không hợp lệ');
				flag = false;
			} else if (isExist(type_price) && !getLen(type_price.val())) {
				type_price.focus();
				notifyDialog('Chưa chọn đơn vị ' + regular_price_label.toLowerCase());
				flag = false;
			} else if (isExist(gender_employer) && !getLen(gender_employer.val())) {
				gender_employer.focus();
				notifyDialog('Chưa chọn giới tính');
				flag = false;
			} else if (isExist(age_requirement) && !getLen(age_requirement.val())) {
				age_requirement.focus();
				notifyDialog('Yêu cầu độ tuổi không được trống');
				flag = false;
			} else if (isExist(application_deadline) && !getLen(application_deadline.val())) {
				application_deadline.focus();
				notifyDialog('Hạn nộp hồ sơ không được trống');
				flag = false;
			} else if (isExist(application_deadline) && !isDate(application_deadline.val())) {
				application_deadline.focus();
				notifyDialog('Hạn nộp hồ sơ không hợp lệ');
				flag = false;
			} else if (isExist(trial_period) && !getLen(trial_period.val())) {
				trial_period.focus();
				notifyDialog('Thời gian thử việc không được trống');
				flag = false;
			} else if (isExist(employee_quantity) && !getLen(employee_quantity.val())) {
				employee_quantity.focus();
				notifyDialog('Số lượng tuyển dụng không được trống');
				flag = false;
			} else if (
				isExist(employee_quantity) &&
				(!isNumber(employee_quantity.val()) || isZero(employee_quantity.val()))
			) {
				employee_quantity.focus();
				notifyDialog('Số lượng tuyển dụng không hợp lệ');
				flag = false;
			} else if (isExist(fullname_contact) && !getLen(fullname_contact.val())) {
				fullname_contact.focus();
				notifyDialog('Họ tên liên hệ không được trống');
				flag = false;
			} else if (isExist(phone_contact) && !getLen(phone_contact.val())) {
				phone_contact.focus();
				notifyDialog('Số điện thoại liên hệ không được trống');
				flag = false;
			} else if (isExist(phone_contact) && !isPhone(phone_contact.val())) {
				phone_contact.focus();
				notifyDialog('Số điện thoại liên hệ không hợp lệ');
				flag = false;
			} else if (isExist(email_contact) && !getLen(email_contact.val())) {
				email_contact.focus();
				notifyDialog('Email liên hệ không được trống');
				flag = false;
			} else if (isExist(email_contact) && !isEmail(email_contact.val())) {
				email_contact.focus();
				notifyDialog('Email liên hệ không hợp lệ');
				flag = false;
			} else if (isExist(address_contact) && !getLen(address_contact.val())) {
				address_contact.focus();
				notifyDialog('Địa chỉ liên hệ không được trống');
				flag = false;
			} else if (isExist(city) && !city.val()) {
				city.focus();
				notifyDialog('Chưa chọn tỉnh/thành phố');
				flag = false;
			} else if (isExist(district) && !district.val()) {
				district.focus();
				notifyDialog('Chưa chọn quận/huyện');
				flag = false;
			} else if (isExist(wards) && !wards.val()) {
				wards.focus();
				notifyDialog('Chưa chọn phường/xã');
				flag = false;
			} else if (isExist(coordinates) && !getLen(coordinates.val())) {
				coordinates.focus();
				notifyDialog('Tọa độ không được trống');
				flag = false;
			} else if (isExist(coordinates) && !isCoords(coordinates.val())) {
				coordinates.focus();
				notifyDialog('Tọa độ không hợp lệ');
				flag = false;
			}

			/* Post form */
			if (flag) {
				var formPostingData = new FormData(formPosting[0]);
				responseEle.html('');

				setTimeout(function () {
					$.ajax({
						url: CONFIG_BASE + 'dang-tin?sector=' + SECTOR['id'] + '&cat=' + ID_CAT + '&isAjaxPosting=1',
						type: 'post',
						enctype: 'multipart/form-data',
						dataType: 'json',
						data: formPostingData,
						async: false,
						processData: false,
						contentType: false,
						cache: false
					}).done(function (result) {
						if (result.status) {
							if (result.status == 'success') {
								formPosting.trigger('reset');

								showNotify(result.message);

								setTimeout(function () {
									location.reload();
								}, 2000);
							} else if (result.status == 'error') {
								responseEle.html('<div class="alert alert-danger">' + result.message + '</div>');
								goToByScroll('card-posting', 20);
							}
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

	/* Booking */
	if (isExist($('input[name="submit-booking"]'))) {
		$('input[name="submit-booking"]').click(function (e) {
			e.preventDefault();
			var formBooking = $('#form-booking');
			var responseEle = formBooking.find('.response-booking');
			var captchaOBJ = formBooking.find('.captcha-image').find('.captcha-reload');
			var flag = true;
			var fullname = $('#fullname-booking');
			var phone = $('#phone-booking');
			var email = $('#email-booking');
			var address = $('#address-booking');
			var content = $('#content-booking');
			var captcha = $('#captcha-booking');

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
			} else if (isExist(email) && !getLen(email.val())) {
				email.focus();
				notifyDialog('Email không được trống');
				flag = false;
			} else if (isExist(email) && !isEmail(email.val())) {
				email.focus();
				notifyDialog('Email không hợp lệ');
				flag = false;
			} else if (isExist(address) && !getLen(address.val())) {
				address.focus();
				notifyDialog('Địa chỉ không được trống');
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
						url: URL_CURRENT_ORIGIN + '?isAjaxBooking=1',
						type: 'post',
						dataType: 'json',
						data: formBooking.serialize()
					}).done(function (result) {
						if (result.status) {
							if (result.status == 'success') {
								formBooking.trigger('reset');

								showNotify(result.message);

								setTimeout(function () {
									location.reload();
								}, 1000);
							} else if (result.status == 'error') {
								/* Generate captcha */
								generateCaptcha('Booking', 'recaptchaResponseBooking');

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

	/* Feedback */
	if (isExist($('input[name="submit-feedback"]'))) {
		$('input[name="submit-feedback"]').click(function (e) {
			e.preventDefault();
			var formFeedback = $('#form-feedback');
			var responseEle = formFeedback.find('.response-feedback');
			var captchaOBJ = formFeedback.find('.captcha-image').find('.captcha-reload');
			var flag = true;
			var fullname = $('#fullname-feedback');
			var phone = $('#phone-feedback');
			var email = $('#email-feedback');
			var content = $('#content-feedback');
			var captcha = $('#captcha-feedback');

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
						url: CONFIG_BASE + 'index.php?isAjaxFeedback=1',
						type: 'post',
						dataType: 'json',
						data: formFeedback.serialize()
					}).done(function (result) {
						if (result.status) {
							if (result.status == 'success') {
								formFeedback.trigger('reset');

								showNotify(result.message);

								setTimeout(function () {
									location.reload();
								}, 1000);
							} else if (result.status == 'error') {
								/* Generate captcha */
								generateCaptcha('Feedback', 'recaptchaResponseFeedback');

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

	/* Cart */
	if (isExist($('input[name="submit-cart"]'))) {
		$('input[name="submit-cart"]').click(function () {
			var flag = true;
			var payments = $('.payments-cart').first().find("input[type='radio']");
			var payments_checked = $("input[name='dataOrder[payments]']:checked");
			var fullname = $('#fullname-cart');
			var phone = $('#phone-cart');
			var email = $('#email-cart');
			var city = $('#city-cart');
			var district = $('#district-cart');
			var wards = $('#wards-cart');
			var address = $('#address-cart');

			holdonOpen();

			if (!isExist(payments_checked)) {
				payments.focus();
				notifyDialog('Chưa chọn hình thức thanh toán');
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
			} else if (isExist(address) && !getLen(address.val())) {
				address.focus();
				notifyDialog('Địa chỉ không được trống');
				flag = false;
			} else if (isExist(city) && !city.val()) {
				city.focus();
				notifyDialog('Chưa chọn tỉnh/thành phố');
				flag = false;
			} else if (isExist(district) && !district.val()) {
				district.focus();
				notifyDialog('Chưa chọn quận/huyện');
				flag = false;
			} else if (isExist(wards) && !wards.val()) {
				wards.focus();
				notifyDialog('Chưa chọn phường/xã');
				flag = false;
			}

			if (!flag) {
				holdonClose();
			}

			return flag;
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
