/* Validation form */
function validateForm(ele) {
	window.addEventListener(
		'load',
		function () {
			var forms = document.getElementsByClassName(ele);
			var validation = Array.prototype.filter.call(forms, function (form) {
				form.addEventListener(
					'submit',
					function (event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					},
					false
				);
			});
			$('.' + ele)
				.find('input[type=submit],button[type=submit]')
				.removeAttr('disabled');
		},
		false
	);
}

/* onChange Category */
function filterCategory(url) {
	if ($('.filter-category').length > 0 && url != '') {
		var id = '';
		var value = 0;

		$('.filter-category').each(function () {
			id = $(this).attr('id');
			if (id) {
				value = $('#' + id).val();

				if (value) {
					url += '&' + id + '=' + value;
				}
			}
		});
	}

	return url;
}

function onchangeCategory(obj) {
	var keyword = $('#keyword').val();
	var url = LINK_FILTER;

	obj.parents('.form-group')
		.nextAll()
		.each(function () {
			if ($(this) != obj) {
				$(this).find('.filter-category').val('');
			}
		});

	url = filterCategory(url);

	if (keyword) {
		url += '&keyword=' + encodeURI(keyword);
	}

	return (window.location = url);
}

/* Search */
function doEnter(evt, obj, url) {
	if (url == '') {
		notifyDialog('Đường dẫn không hợp lệ');
		return false;
	}

	if (evt.keyCode == 13 || evt.which == 13) onSearch(obj, url);
}
function onSearch(obj, url) {
	if (url == '') {
		notifyDialog('Đường dẫn không hợp lệ');
		return false;
	} else {
		var keyword = $('#' + obj).val();
		url = filterCategory(url);

		if (keyword) {
			url += '&keyword=' + encodeURI(keyword);
		}

		window.location = filterCategory(url);
	}
}

/* Action order (Search - Export excel - Export word) */
function actionOrder(url) {
	var listid = '';
	var order_status = parseInt($('#order_status').val());
	var order_payment = parseInt($('#order_payment').val());
	var order_date = $('#order_date').val();
	var range_price = $('#range_price').val();
	var city = parseInt($('#id_city').val());
	var district = parseInt($('#id_district').val());
	var wards = parseInt($('#id_wards').val());
	var keyword = $('#keyword').val();

	$('input.select-checkbox').each(function () {
		if (this.checked) listid = listid + ',' + this.value;
	});
	listid = listid.substr(1);
	if (listid) url += '&listid=' + listid;
	if (order_status) url += '&order_status=' + order_status;
	if (order_payment) url += '&order_payment=' + order_payment;
	if (order_date) url += '&order_date=' + order_date;
	if (range_price) url += '&range_price=' + range_price;
	if (city) url += '&id_city=' + city;
	if (district) url += '&id_district=' + district;
	if (wards) url += '&id_wards=' + wards;
	if (keyword) url += '&keyword=' + encodeURI(keyword);

	window.location = url;
}

/* Send email */
function sendEmail() {
	var listemail = '';

	$('input.select-checkbox').each(function () {
		if (this.checked) listemail = listemail + ',' + this.value;
	});

	listemail = listemail.substr(1);

	if (listemail == '') {
		notifyDialog('Bạn hãy chọn ít nhất 1 mục để gửi');
		return false;
	}

	$('#listemail').val(listemail);

	document.frmsendemail.submit();
}

/* Delete mails */
function deleteMails(obj) {
	$this = obj;
	var parents = $this.parents('.card-mails');
	var id = $this.data('id');

	$.ajax({
		type: 'POST',
		url: 'api/mails.php',
		data: {
			id: id
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function () {
			parents.remove();
			holdonClose();
		}
	});
}

/* Delete filer */
function deleteFileUploader(value) {
	var value = value.split(',');
	var id = value[0];
	var folder = value[1];
	var table = value[2];

	$.ajax({
		type: 'POST',
		url: 'api/file-uploader.php',
		data: {
			id: id,
			folder: folder,
			table: table
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function () {
			$('.fileuploader-item-detail-' + id).remove();
			if ($('.fileuploader-items ul li').length == 0) $('.gallery-detail-uploader').remove();
			holdonClose();
		}
	});
}

/* Delete item */
function deleteItem(url) {
	holdonOpen();
	document.location = url;
}

/* Delete all */
function deleteAll(url) {
	var listid = '';

	$('input.select-checkbox').each(function () {
		if (this.checked) listid = listid + ',' + this.value;
	});

	listid = listid.substr(1);

	if (listid == '') {
		notifyDialog('Bạn hãy chọn ít nhất 1 mục để xóa');
		return false;
	}

	holdonOpen();
	document.location = url + '&listid=' + listid;
}

/* Go to element */
function goToByScroll(id, minusTop) {
	minusTop = parseInt(minusTop) ? parseInt(minusTop) : 0;
	id = id.replace('#', '');
	$('html,body').animate(
		{
			scrollTop: $('#' + id).offset().top - minusTop
		},
		'slow'
	);
}

/* Show notify */
function showNotify(text = 'Notify text', title = 'Thông báo', status = 'success') {
	new Notify({
		status: status, // success, warning, error
		title: title,
		text: text,
		effect: 'fade',
		speed: 400,
		customClass: null,
		customIcon: null,
		showIcon: true,
		showCloseButton: true,
		autoclose: true,
		autotimeout: 3000,
		gap: 10,
		distance: 10,
		type: 3,
		position: 'right top'
	});
}

/* Notify */
function notifyDialog(content = '', title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'blue') {
	$.alert({
		title: title,
		icon: icon, // font awesome
		type: type, // red, green, orange, blue, purple, dark
		content: content, // html, text
		backgroundDismiss: true,
		animationSpeed: 600,
		animation: 'zoom',
		closeAnimation: 'scale',
		typeAnimated: true,
		animateFromElement: false,
		autoClose: 'accept|3000',
		escapeKey: 'accept',
		buttons: {
			accept: {
				text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
				btnClass: 'btn-blue btn-sm bg-gradient-primary'
			}
		}
	});
}

/* Confirm */
function confirmDialog(action, text, value, title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'blue') {
	$.confirm({
		title: title,
		icon: icon, // font awesome
		type: type, // red, green, orange, blue, purple, dark
		content: text, // html, text
		backgroundDismiss: true,
		animationSpeed: 600,
		animation: 'zoom',
		closeAnimation: 'scale',
		typeAnimated: true,
		animateFromElement: false,
		autoClose: 'cancel|3000',
		escapeKey: 'cancel',
		buttons: {
			success: {
				text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
				btnClass: 'btn-blue btn-sm bg-gradient-primary',
				action: function () {
					if (action == 'create-seo') seoCreate();
					if (action == 'send-email') sendEmail();
					if (action == 'restore-shop') restoreShop(value);
					if (action == 'transfer-shop') transferShop(value);
					if (action == 'send-shop') sendShop(value);
					if (action == 'send-posting') sendPosting(value);
					if (action == 'delete-mails') deleteMails(value);
					if (action == 'delete-file-uploader') deleteFileUploader(value);
					if (action == 'delete-item') deleteItem(value);
					if (action == 'delete-all') deleteAll(value);
					if (action == 'cancel-order') cancelOrder(value);
				}
			},
			cancel: {
				text: '<i class="fas fa-times align-middle mr-2"></i>Hủy',
				btnClass: 'btn-red btn-sm bg-gradient-danger'
			}
		}
	});
}

/* Prompt */
function promptDialog(value) {
	$.confirm({
		title: 'Thông báo',
		icon: 'fas fa-info-circle',
		type: 'red',
		content:
			'<form action="' +
			value +
			'" method="post" enctype="multipart/form-data">' +
			'<textarea class="form-control text-sm" name="reason-to-delete" id="reason-to-delete" rows="5" placeholder="Nhập lý do để xóa" required></textarea>' +
			'</form>',
		backgroundDismiss: true,
		animationSpeed: 600,
		animation: 'zoom',
		closeAnimation: 'scale',
		typeAnimated: true,
		animateFromElement: false,
		buttons: {
			success: {
				text: '<i class="fas fa-trash-alt mr-2"></i>Xóa',
				btnClass: 'btn-blue btn-sm bg-gradient-danger',
				action: function () {
					var text = this.$content.find('textarea#reason-to-delete').val();

					if (!text) {
						$.alert('Vui lòng nhập lý do để xóa');
						return false;
					} else {
						holdonOpen();
						this.$content.find('form').submit();
					}
				}
			},
			cancel: {
				text: '<i class="fas fa-times mr-2"></i>Hủy',
				btnClass: 'btn-red btn-sm bg-gradient-secondary'
			}
		}
	});
}

/* SEO */
function seoExist() {
	var inputs = $('.card-seo input.check-seo');
	var textareas = $('.card-seo textarea.check-seo');
	var flag = false;

	if (!flag) {
		inputs.each(function (index) {
			var input = $(this).attr('id');
			value = $('#' + input).val();
			if (value) {
				flag = true;
				return false;
			}
		});
	}

	if (!flag) {
		textareas.each(function (index) {
			var textarea = $(this).attr('id');
			value = $('#' + textarea).val();
			if (value) {
				flag = true;
				return false;
			}
		});
	}

	return flag;
}
function seoCreate() {
	var flag = true;
	var seolang = $('#seo-create').val();
	var seolangArray = seolang.split(',');
	var seolangCount = seolangArray.length;
	var inputArticle = $('.card-article input.for-seo');
	var textareaArticle = $('.card-article textarea.for-seo');
	var textareaArticleCount = textareaArticle.length;
	var count = 0;
	var inputSeo = $('.card-seo input.check-seo');
	var textareaSeo = $('.card-seo textarea.check-seo');

	/* SEO Create - Input */
	inputArticle.each(function (index) {
		var input = $(this).attr('id');
		var lang = input.substr(input.length - 2);
		if (seolang.indexOf(lang) >= 0) {
			name = $('#' + input).val();
			name = name.substr(0, 70);
			name = name.trim();
			$('#title' + lang + ', #keywords' + lang).val(name);
			seoCount($('#title' + lang));
			seoCount($('#keywords' + lang));
		}
	});

	/* SEO Create - Textarea */
	textareaArticle.each(function (index) {
		var textarea = $(this).attr('id');
		var lang = textarea.substr(textarea.length - 2);
		if (seolang.indexOf(lang) >= 0) {
			if (flag) {
				var content = $('#' + textarea).val();

				if (!content && CKEDITOR.instances[textarea]) {
					content = CKEDITOR.instances[textarea].getData();
				}

				if (content) {
					content = content.replace(/(<([^>]+)>)/gi, '');
					content = content.substr(0, 160);
					content = content.trim();
					content = content.replace(/[\r\n]+/gm, ' ');
					$('#description' + lang).val(content);
					seoCount($('#description' + lang));
					flag = false;
				} else {
					flag = true;
				}
			}
			count++;
			if (count == textareaArticleCount / seolangCount) {
				flag = true;
				count = 0;
			}
		}
	});

	/* SEO Preview */
	for (var i = 0; i < seolangArray.length; i++) if (seolangArray[i]) seoPreview(seolangArray[i]);
}
function seoPreview(lang) {
	var titlePreview = '#title-seo-preview' + lang;
	var descriptionPreview = '#description-seo-preview' + lang;
	var title = $('#title' + lang).val();
	var description = $('#description' + lang).val();

	if ($(titlePreview).length) {
		if (title) $(titlePreview).html(title);
		else $(titlePreview).html('Title');
	}

	if ($(descriptionPreview).length) {
		if (description) $(descriptionPreview).html(description);
		else $(descriptionPreview).html('Description');
	}
}
function seoCount(obj) {
	if (obj.length) {
		var countseo = parseInt(obj.val().toString().length);
		countseo = countseo ? countseo++ : 0;
		obj.parents('div.form-group').children('div.label-seo').find('.count-seo span').html(countseo);
	}
}
function seoChange() {
	var seolang = 'vi,en';
	var elementSeo = $('.card-seo .check-seo');

	elementSeo.each(function (index) {
		var element = $(this).attr('id');
		var lang = element.substr(element.length - 2);
		if (seolang.indexOf(lang) >= 0) {
			if ($('#' + element).length) {
				$('body').on('keyup', '#' + element, function () {
					seoPreview(lang);
				});
			}
		}
	});
}

/* Restore shop */
function restoreShop(value) {
	value = value.split(',');
	var id = value[0] ? value[0] : 0;
	var table = value[1] ? value[1] : '';

	if (id && table) {
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: 'api/shop.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'restore',
					id: id,
					table: table
				},
				success: function (result) {
					holdonClose();

					if (result) {
						notifyDialog('Khôi phục lại gian hàng thành công');
					} else {
						notifyDialog('Khôi phục lại gian hàng thất bại. Vui lòng thử lại sau');
					}

					setTimeout(function () {
						location.reload();
					}, 1000);
				}
			});
		}, 1000);
	}

	return false;
}

/* Transfer shop */
function transferShop(value) {
	value = value.split(',');
	var id = value[0] ? value[0] : 0;
	var table = value[1] ? value[1] : '';

	if (id && table) {
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: 'api/shop.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'transfer',
					id: id,
					table: table
				},
				success: function (result) {
					holdonClose();

					if (result) {
						notifyDialog(
							'Chuyển thông tin gian hàng và thông tin thành viên trở thành thông tin chính thức thành công'
						);
					} else {
						notifyDialog(
							'Chuyển thông tin gian hàng và thông tin thành viên trở thành thông tin chính thức thất bại. Vui lòng thử lại sau'
						);
					}

					setTimeout(function () {
						location.reload();
					}, 1000);
				}
			});
		}, 1000);
	}

	return false;
}

/* Send shop */
function sendShop(value) {
	value = value.split(',');
	var id = value[0] ? value[0] : 0;
	var table = value[1] ? value[1] : '';

	if (id && table) {
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: 'api/shop.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'send-info',
					id: id,
					table: table
				},
				success: function (result) {
					holdonClose();

					if (result == true) {
						notifyDialog('Gửi thông tin thành công');
					} else {
						notifyDialog('Gửi thông tin thất bại. Vui lòng thử lại sau');
					}
				}
			});
		}, 1000);
	}

	return false;
}

/* Check shop */
function checkShop(obj, type, id) {
	if (obj.length) {
		var flag = true;
		var text = obj.val();

		if (getLen(text)) {
			$.ajax({
				url: 'api/shop.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'valid-data',
					text: text,
					type: type,
					id: id
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (!result) {
						flag = false;
					}

					holdonClose();
				}
			});
		}
	}

	return flag;
}

/* Send posting */
function sendPosting(value) {
	value = value.split(',');
	var id = value[0] ? value[0] : 0;
	var table = value[1] ? value[1] : '';

	if (id && table) {
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: 'api/posting.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'send-info',
					id: id,
					table: table
				},
				success: function (result) {
					holdonClose();

					if (result) {
						notifyDialog('Gửi thông báo duyệt thành công');
					} else {
						notifyDialog('Gửi thông báo duyệt thất bại. Vui lòng thử lại sau');
					}
				}
			});
		}, 1000);
	}

	return false;
}

/* Check has permission */
function hasPermission() {
	if (MAIN_PERMISSION.length) {
		var count = 0;
		var flag = true;

		for (var i = 0; i < MAIN_PERMISSION.length; i++) {
			if ($("input[name='permissionLists[" + MAIN_PERMISSION[i] + "][]']:checked").length) {
				break;
			}
			count++;
		}

		if (count == MAIN_PERMISSION.length) {
			flag = false;
		}

		return flag;
	}
}

/* Check account */
function checkAccount(obj, type, tbl, id) {
	if (obj.length) {
		var flag = true;
		var text = obj.val();

		if (getLen(text)) {
			$.ajax({
				url: 'api/account.php',
				type: 'POST',
				async: false,
				data: {
					text: text,
					type: type,
					tbl: tbl,
					id: id
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (!result) {
						flag = false;
					}

					holdonClose();
				}
			});
		}
	}

	return flag;
}

/* Cancel order */
function cancelOrder(obj) {
	var parents = obj.parents('#form-order');
	parents.find('input[name="actionOrder"]').val(obj.val());
	parents.submit();
}

$(document).ready(function () {
	/* Validation form chung */
	validateForm('validation-form');

	/* Tooltips */
	if (isExist($('[data-plugin="tooltip"]'))) {
		$('[data-plugin="tooltip"]').tooltip();
	}

	/* User */
	if (IS_USER) {
		/* User group */
		if ($('.submit-user-group').length) {
			$('.submit-user-group').click(function () {
				var flag = true;
				var type = $('#id_type');
				var list = $('#id_list');
				var cats = $('select[name="dataMultiCategoryCat[]"]');
				var place_group = $('#place_group').find('option:selected');
				var admin_group = $('#admin_group').find('option:selected');
				var permission_group = $('#permission_group').find('option:selected');
				var name = $('#name');
				var leader = $("input[name='leader']:checked");

				/* Holdon */
				holdonOpen();

				if (isExist(type) && !type.val()) {
					type.focus();
					notifyDialog('Chưa chọn loại nhóm');
					flag = false;
				} else if (isExist(list) && !list.val()) {
					list.focus();
					notifyDialog('Chưa chọn danh mục chính');
					flag = false;
				} else if (isExist(cats) && !cats.val()) {
					cats.focus();
					notifyDialog('Chưa chọn danh mục cấp 2');
					flag = false;
				} else if (!isExist(place_group)) {
					place_group.focus();
					notifyDialog('Chưa chọn tỉnh/thành phố');
					flag = false;
				} else if (!isExist(admin_group)) {
					admin_group.focus();
					notifyDialog('Chưa chọn danh sách quản trị viên');
					flag = false;
				} else if (isExist(admin_group) && getLen(admin_group) < 2) {
					admin_group.focus();
					notifyDialog('Nhóm quản trị viên phải tối thiểu 2 người');
					flag = false;
				} else if (!isExist(permission_group)) {
					permission_group.focus();
					notifyDialog('Chưa chọn danh sách quyền');
					flag = false;
				} else if (!isExist(leader)) {
					notifyDialog('Chưa chọn trưởng nhóm');
					flag = false;
				} else if (isExist(name) && !getLen(name.val())) {
					name.focus();
					notifyDialog('Tên nhóm không được trống');
					flag = false;
				} else if (!hasPermission()) {
					notifyDialog('Chưa chọn quyền cho nhóm');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});

			/* Multi select admins */
			if ($('.multiselect-admins').length) {
				var leaderNow = $('#admin-leader').find('input:checked')
					? $('#admin-leader').find('input:checked').val()
					: 0;

				$('.multiselect-admins').change(function () {
					var options = $(this).find('option:selected');
					var leaderNew = $('#admin-leader').find('input:checked')
						? $('#admin-leader').find('input:checked').val()
						: 0;
					var result = '';

					options.each(function (index) {
						$this = $(this);
						var value = $this.val();
						var text = $this.text();
						var checked = '';

						if (leaderNew == value || leaderNow == value) {
							checked = 'checked';
						}

						result += '<div class="btn btn-sm btn-outline-info mr-2 mb-2">';
						result += '<div class="custom-control custom-radio my-custom-radio d-block text-sm">';
						result +=
							'<input type="radio" class="custom-control-input" name="leader" id="admin-' +
							value +
							'" value="' +
							value +
							'" ' +
							checked +
							'>';
						result +=
							'<label for="admin-' +
							value +
							'" class="custom-control-label font-weight-normal">' +
							text +
							'</label>';
						result += '</div>';
						result += '</div>';
					});

					$('#admin-leader').html(result);
				});
			}

			/* Multi select permissions */
			if ($('.multiselect-permission').length) {
				/* Disabled inputs */
				if ($('.card-perms.d-none').length) {
					$('.card-perms.d-none')
						.find('.card-body input')
						.each(function () {
							$(this).attr('disabled', true);
						});
				}

				$('.multiselect-permission').change(function () {
					var optionsSelected = $(this).find('option:selected');
					var optionsNotSelected = $(this).find('option:not(:selected)');

					if (optionsSelected) {
						optionsSelected.each(function (i) {
							$this = $(this);
							var value = $this.val();
							var perms = '#perms-' + value;

							$(perms).removeClass('d-none');
							$(perms)
								.find('.card-body input')
								.each(function () {
									$(this).attr('disabled', false);
								});
						});
					}

					if (optionsNotSelected) {
						optionsNotSelected.each(function (i) {
							$this = $(this);
							var value = $this.val();
							var perms = '#perms-' + value;

							$(perms).addClass('d-none');
							$(perms)
								.find('.card-body input')
								.each(function () {
									$(this).attr('disabled', true);
								});
						});
					}
				});
			}
		}

		/* User admin - child */
		if ($('.submit-admin-child').length) {
			$('.submit-admin-child').click(function () {
				var flag = true;

				/* Holdon */
				holdonOpen();

				if (!hasPermission()) {
					notifyDialog('Chưa chọn quyền cho nhóm');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}

		/* User admin - info */
		if ($('.submit-admin-info').length) {
			$('.submit-admin-info').click(function () {
				var flag = true;
				var isChangePass = IS_CHANGE_PASS ? true : false;
				var old_password = $('#old-password');
				var new_password = $('#new-password');
				var renew_password = $('#renew-password');
				var username = $('#username');
				var fullname = $('#fullname');
				var email = $('#email');
				var phone = $('#phone');
				var gender = $('#gender');
				var birthday = $('#birthday');
				var address = $('#address');
				var existUsername = checkAccount(username, 'username', 'user', ID_INFO_ADMIN);
				var existEmail = checkAccount(email, 'email', 'user', ID_INFO_ADMIN);

				/* Holdon */
				holdonOpen();

				if (isChangePass) {
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
					} else if (isExist(renew_password) && !getLen(renew_password.val())) {
						renew_password.focus();
						notifyDialog('Xác nhận mật khẩu mới không được trống');
						flag = false;
					} else if (
						isExist(new_password) &&
						getLen(new_password.val()) &&
						isExist(renew_password) &&
						!getLen(renew_password.val())
					) {
						renew_password.focus();
						notifyDialog('Xác nhận mật khẩu mới không được trống');
						flag = false;
					} else if (
						isExist(new_password) &&
						getLen(new_password.val()) &&
						isExist(renew_password) &&
						getLen(renew_password.val()) &&
						!isMatch(new_password.val(), renew_password.val())
					) {
						renew_password.focus();
						notifyDialog('Mật khẩu mới không trùng khớp');
						flag = false;
					}
				} else {
					if (isExist(username) && !getLen(username.val())) {
						username.focus();
						notifyDialog('Tài khoản không được trống');
						flag = false;
					} else if (isExist(username) && !isAlphaNum(username.val())) {
						username.focus();
						notifyDialog(
							'Tài khoản chỉ được nhập chữ thường và số </br> - Chữ thường không dấu </br> - Ghi liền nhau </br> - Không khoảng trắng'
						);
						flag = false;
					} else if (isExist(username) && existUsername) {
						username.focus();
						notifyDialog('Tài khoản đã tồn tại');
						flag = false;
					} else if (isExist(fullname) && !getLen(fullname.val())) {
						fullname.focus();
						notifyDialog('Họ tên không được trống');
						flag = false;
					} else if (isExist(email) && !getLen(email.val())) {
						email.focus();
						notifyDialog('Email không được trống');
						flag = false;
					} else if (isExist(email) && getLen(email.val()) && !isEmail(email.val())) {
						email.focus();
						notifyDialog('Email không hợp lệ');
						flag = false;
					} else if (isExist(email) && existEmail) {
						email.focus();
						notifyDialog('Email đã tồn tại');
						flag = false;
					} else if (isExist(phone) && !getLen(phone.val())) {
						phone.focus();
						notifyDialog('Số điện thoại không được trống');
						flag = false;
					} else if (isExist(phone) && getLen(phone.val()) && !isPhone(phone.val())) {
						phone.focus();
						notifyDialog('Số điện thoại không hợp lệ');
						flag = false;
					} else if (isExist(gender) && !gender.val()) {
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
					} else if (isExist(address) && !getLen(address.val())) {
						address.focus();
						notifyDialog('Địa chỉ không được trống');
						flag = false;
					}
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}

		/* User admin - member */
		if ($('.submit-user').length) {
			$('.submit-user').click(function () {
				var flag = true;
				var username = $('#username');
				var username_member = $('#username_member');
				var first_name = $('#first_name');
				var last_name = $('#last_name');
				var fullname = $('#fullname');
				var id_city = $('#id_city');
				var id_district = $('#id_district');
				var id_wards = $('#id_wards');
				var typeUser = ACT && ACT.search('member') > 0 ? 'member' : 'admin';
				var isAdd = $.inArray(ACT, ['add_admin', 'add_admin_virtual', 'add_member']) >= 0 ? true : false;
				var isEdit = $.inArray(ACT, ['edit_admin', 'edit_admin_virtual', 'edit_member']) >= 0 ? true : false;
				var isAddAdminVirtual = $.inArray(ACT, ['add_admin_virtual']) >= 0 ? true : false;
				var isEditAdminVirtual = $.inArray(ACT, ['edit_admin_virtual']) >= 0 ? true : false;
				var password = $('#password');
				var confirm_password = $('#confirm_password');
				var email = $('#email');
				var phone = $('#phone');
				var gender = $('#gender');
				var birthday = $('#birthday');

				if (typeUser == 'admin') {
					var existUsernameAdmin = checkAccount(username, 'username', 'user', ID);
					var existEmail = checkAccount(email, 'email', 'user', ID);
				} else {
					var existUsernameMember = checkAccount(username_member, 'username', 'member', ID);
					var existEmail = checkAccount(email, 'email', 'member', ID);
				}

				/* Holdon */
				holdonOpen();

				if (isExist(username) && !getLen(username.val())) {
					username.focus();
					notifyDialog('Tài khoản không được trống');
					flag = false;
				} else if (isExist(username) && !isAlphaNum(username.val())) {
					username.focus();
					notifyDialog(
						'Tài khoản chỉ được nhập chữ thường và số </br> - Chữ thường không dấu </br> - Ghi liền nhau </br> - Không khoảng trắng'
					);
					flag = false;
				} else if (isExist(username) && existUsernameAdmin) {
					username.focus();
					notifyDialog('Tài khoản đã tồn tại');
					flag = false;
				} else if (isExist(username_member) && !getLen(username_member.val())) {
					username_member.focus();
					notifyDialog('Tài khoản không được trống');
					flag = false;
				} else if (isExist(username_member) && !isPhone(username_member.val())) {
					username_member.focus();
					notifyDialog('Tài khoản không hợp lệ');
					flag = false;
				} else if (isExist(username_member) && existUsernameMember) {
					username_member.focus();
					notifyDialog('Tài khoản đã tồn tại');
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
				} else if (isExist(fullname) && !getLen(fullname.val())) {
					fullname.focus();
					notifyDialog('Họ tên không được trống');
					flag = false;
				} else if (isAdd == true && isExist(password) && !getLen(password.val())) {
					password.focus();
					notifyDialog('Mật khẩu không được trống');
					flag = false;
				} else if (
					isAdd == true &&
					isExist(password) &&
					getLen(password.val()) &&
					!isPassword(password.val())
				) {
					password.focus();
					notifyDialog(
						"<ul class='list-unstyled text-danger text-left mb-0'><li class='text-dark text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>"
					);
					flag = false;
				} else if (isAdd == true && isExist(confirm_password) && !getLen(confirm_password.val())) {
					confirm_password.focus();
					notifyDialog('Xác nhận mật khẩu không được trống');
					flag = false;
				} else if (isAdd == true && !isMatch(password.val(), confirm_password.val())) {
					confirm_password.focus();
					notifyDialog('Mật khẩu không trùng khớp');
					flag = false;
				} else if (
					isEdit == true &&
					isExist(password) &&
					getLen(password.val()) &&
					!isPassword(password.val())
				) {
					password.focus();
					notifyDialog(
						"<ul class='list-unstyled text-danger text-left mb-0'><li class='text-dark text-capitalize mb-1'><strong>Mật khẩu bắt buộc:</strong></li><li class='mb-1'>- Ít nhất 8 ký tự</li><li class='mb-1'>- Ít nhất 1 chữ thường</li><li class='mb-1'>- Ít nhất 1 chữ hoa</li><li class='mb-1'>- Ít nhất 1 chữ số</li><li class='mb-1'>- Ít nhất 1 ký tự: !, @, #, &, $, *</li></ul>"
					);
					flag = false;
				} else if (
					isEdit == true &&
					isExist(password) &&
					getLen(password.val()) &&
					isExist(confirm_password) &&
					!getLen(confirm_password.val())
				) {
					confirm_password.focus();
					notifyDialog('Xác nhận mật khẩu không được trống');
					flag = false;
				} else if (
					isEdit == true &&
					isExist(password) &&
					getLen(password.val()) &&
					isExist(confirm_password) &&
					getLen(confirm_password.val()) &&
					!isMatch(password.val(), confirm_password.val())
				) {
					confirm_password.focus();
					notifyDialog('Mật khẩu không trùng khớp');
					flag = false;
				} else if (isExist(id_city) && !getLen(id_city.val())) {
					id_city.focus();
					notifyDialog('Chưa chọn tỉnh/thành phố');
					flag = false;
				} else if (isExist(id_district) && !getLen(id_district.val())) {
					id_district.focus();
					notifyDialog('Chưa chọn quận/huyện');
					flag = false;
				} else if (isExist(id_wards) && !getLen(id_wards.val())) {
					id_wards.focus();
					notifyDialog('Chưa chọn phường/xã');
					flag = false;
				} else if (!isAddAdminVirtual && !isEditAdminVirtual && isExist(email) && !getLen(email.val())) {
					email.focus();
					notifyDialog('Email không được trống');
					flag = false;
				} else if (
					!isAddAdminVirtual &&
					!isEditAdminVirtual &&
					isExist(email) &&
					getLen(email.val()) &&
					!isEmail(email.val())
				) {
					email.focus();
					notifyDialog('Email không hợp lệ');
					flag = false;
				} else if (!isAddAdminVirtual && !isEditAdminVirtual && isExist(email) && existEmail) {
					email.focus();
					notifyDialog('Email đã tồn tại');
					flag = false;
				} else if (
					!isAddAdminVirtual &&
					!isEditAdminVirtual &&
					isExist(phone) &&
					getLen(phone.val()) &&
					!isPhone(phone.val())
				) {
					phone.focus();
					notifyDialog('Số điện thoại không hợp lệ');
					flag = false;
				} else if (isExist(gender) && !gender.val()) {
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
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}

		/* User member dashboard */
		if ($('.submit-member-dashboard').length) {
			$('.submit-member-dashboard').click(function () {
				var flag = true;
				var place_group = $('#place_group').find('option:selected');
				var gender_group = $("input[name='gender_group[]']:checked");

				/* Holdon */
				holdonOpen();

				if (!isExist(place_group)) {
					place_group.focus();
					notifyDialog('Chưa chọn tỉnh/thành phố');
					flag = false;
				} else if (!isExist(gender_group)) {
					notifyDialog('Chưa chọn giới tính');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}

		/* User member mails */
		if ($('.submit-mails').length) {
			$('.submit-mails').click(function () {
				var flag = true;
				var title_mails = $('#title_mails');
				var content_mails = CKEDITOR.instances['content_mails'].getData();

				/* Holdon */
				holdonOpen();

				if (isExist(title_mails) && !getLen(title_mails.val())) {
					title_mails.focus();
					notifyDialog('Tiêu đề gửi thư không được trống');
					flag = false;
				} else if (!getLen(content_mails)) {
					$('#content_mails').focus();
					notifyDialog('Nội dung gửi thư không được trống');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}

		/* Delete mails */
		if ($('.delete-mails').length) {
			$('.delete-mails').click(function () {
				confirmDialog('delete-mails', 'Bạn muốn xóa thư này ?', $(this));
			});
		}
	}

	/* Shop */
	if (IS_SHOP) {
		/* Restore shop when member delete it */
		$('body').on('click', '#restore-shop', function () {
			var id = $(this).data('id');
			var table = $(this).data('table');
			var value = id + ',' + table;
			confirmDialog('restore-shop', 'Bạn muốn khôi phục lại gian hàng này ?', value);
		});

		/* Transfer shop when information is virtual */
		$('body').on('click', '#transfer-shop', function () {
			var id = $(this).data('id');
			var table = $(this).data('table');
			var value = id + ',' + table;
			confirmDialog(
				'transfer-shop',
				'Bạn muốn chuyển thông tin gian hàng và thông tin thành viên này trở thành thông tin chính thức ?',
				value
			);
		});

		/* Send email for customer */
		$('body').on('click', '#send-shop:not([disabled])', function () {
			var id = $(this).data('id');
			var table = $(this).data('table');
			var value = id + ',' + table;
			confirmDialog('send-shop', 'Bạn muốn gửi thông tin gian hàng này cho chủ sở hữu ?', value);
		});

		/* Change name */
		$('#name').on('change keypress', function () {
			var url = changeTitle($(this).val());
			url = url.replaceAll('-', '');
			$('#url-shop, #url-shop-admin').val(url + '/');
		});

		/* Filter by user */
		if ($('#shop_user').length) {
			$('#shop_user').change(function () {
				onchangeCategory($(this));
			});
		}

		/* Filter by member */
		if ($('#shop_member').length) {
			$('#shop_member').change(function () {
				onchangeCategory($(this));
			});
		}

		/* Filter by date */
		if ($('#shop_date').length) {
			$('#shop_date').daterangepicker({
				callback: this.render,
				autoUpdateInput: false,
				timePicker: false,
				timePickerIncrement: 30,
				locale: {
					format: 'DD/MM/YYYY'
					// format: 'DD/MM/YYYY hh:mm A'
				}
			});
			$('#shop_date').on('apply.daterangepicker', function (ev, picker) {
				var date = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
				var url = filterCategory(LINK_FILTER);
				$(this).val(date);
				onchangeCategory($(this));
			});
			$('#shop_date').on('cancel.daterangepicker', function (ev, picker) {
				$(this).val('');
				onchangeCategory($(this));
			});
		}

		/* Submit shop */
		if ($('.submit-shop').length) {
			$('.submit-shop').click(function () {
				var flag = true;
				var name = $('#name');
				var email = $('#email');
				var username = $('#username');
				var password = $('#password');
				var phone = $('#phone');
				var cat = $('#id_cat');
				var interface = $('#id_interface');
				var store = $('#id_store');
				var region = $('#id_region');
				var city = $('#id_city');
				var district = $('#id_district');
				var wards = $('#id_wards');
				var avatar = $('#file-zone');
				var existName = checkShop(name, 'name', ID);
				var restrictedName = checkShop(name, 'restricted', ID);
				var existEmail = checkShop(email, 'email', ID);
				var existUsername = checkShop(username, 'username', ID);
				var username_owner_virtual = $('#username_owner_virtual');
				var first_name_owner_virtual = $('#first_name_owner_virtual');
				var last_name_owner_virtual = $('#last_name_owner_virtual');
				var email_owner_virtual = $('#email_owner_virtual');
				var phone_owner_virtual = $('#phone_owner_virtual');
				var gender_owner_virtual = $('#gender_owner_virtual');
				var password_virtual_owner_virtual = $('#password_virtual_owner_virtual');
				var existUsernameOwnerVirtual = checkAccount(
					username_owner_virtual,
					'username',
					'member',
					ID_OWNER_VIRTUAL
				);
				var existEmailOwnerVirtual = checkAccount(email_owner_virtual, 'email', 'member', ID_OWNER_VIRTUAL);

				/* Holdon */
				holdonOpen();

				if (isExist(name) && !getLen(name.val())) {
					name.focus();
					notifyDialog('Tên gian hàng không được trống');
					flag = false;
				} else if (isExist(name) && getLen(name.val()) > 50) {
					name.focus();
					notifyDialog('Tên gian hàng không được vượt quá 50 ký tự');
					flag = false;
				} else if (isExist(name) && existName) {
					name.focus();
					notifyDialog('Tên gian hàng đã tồn tại');
					flag = false;
				} else if (isExist(name) && restrictedName) {
					name.focus();
					notifyDialog('Tên gian hàng không hợp lệ');
					flag = false;
				}  else if (isExist(username) && !getLen(username.val())) {
					username.focus();
					notifyDialog('Tên đăng nhập không được trống');
					flag = false;
				}  else if (isExist(username) && existUsername) {
					username.focus();
					notifyDialog('Tên đăng nhập đã tồn tại');
					flag = false;
				}  else if (isExist(email) && !getLen(email.val())) {
					email.focus();
					notifyDialog('Email không được trống');
					flag = false;
				} else if (isExist(email) && !isEmail(email.val())) {
					email.focus();
					notifyDialog('Email không hợp lệ');
					flag = false;
				} else if (isExist(email) && existEmail) {
					email.focus();
					notifyDialog('Email đã tồn tại');
					flag = false;
				} else if (isExist(password) && !getLen(password.val())) {
					password.focus();
					notifyDialog('Mật khẩu không được trống');
					flag = false;
				} else if (isExist(phone) && !getLen(phone.val())) {
					phone.focus();
					notifyDialog('Số điện thoại không được trống');
					flag = false;
				} else if (isExist(phone) && !isPhone(phone.val())) {
					phone.focus();
					notifyDialog('Số điện thoại không hợp lệ');
					flag = false;
				} else if (isExist(cat) && !cat.val()) {
					cat.focus();
					notifyDialog('Chưa chọn danh mục ngành nghề');
					flag = false;
				} else if (isExist(interface) && !interface.val()) {
					interface.focus();
					notifyDialog('Chưa chọn giao diện gian hàng');
					flag = false;
				} else if (isExist(store) && !store.val()) {
					store.focus();
					notifyDialog('Chưa chọn cửa hàng');
					flag = false;
				} else if (isExist(region) && !region.val()) {
					region.focus();
					notifyDialog('Chưa chọn vùng/miền');
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
				} else if (isExist(avatar) && !getLen(avatar.val()) && !HAS_PHOTO) {
					notifyDialog('Hình đại diện không được trống');
					flag = false;
				}else if (isExist(username_owner_virtual) && !getLen(username_owner_virtual.val())) {
					username_owner_virtual.focus();
					notifyDialog('Tài khoản không được trống');
					flag = false;
				} else if (isExist(username_owner_virtual) && !isPhone(username_owner_virtual.val())) {
					username_owner_virtual.focus();
					notifyDialog('Tài khoản không hợp lệ');
					flag = false;
				} else if (isExist(username_owner_virtual) && existUsernameOwnerVirtual) {
					username_owner_virtual.focus();
					notifyDialog('Tài khoản đã tồn tại');
					flag = false;
				} else if (
					(isExist(first_name_owner_virtual) && !getLen(first_name_owner_virtual.val())) ||
					(isExist(last_name_owner_virtual) && !getLen(last_name_owner_virtual.val()))
				) {
					if (!getLen(first_name_owner_virtual.val())) {
						first_name_owner_virtual.focus();
					} else if (!getLen(last_name_owner_virtual.val())) {
						last_name_owner_virtual.focus();
					}
					notifyDialog('Họ tên không được trống');
					flag = false;
				} else if (isExist(password_virtual_owner_virtual) && !getLen(password_virtual_owner_virtual.val())) {
					password_virtual_owner_virtual.focus();
					notifyDialog('Mật khẩu không được trống');
					flag = false;
				} else if (isExist(email_owner_virtual) && !getLen(email_owner_virtual.val())) {
					email_owner_virtual.focus();
					notifyDialog('Email không được trống');
					flag = false;
				} else if (
					isExist(email_owner_virtual) &&
					getLen(email_owner_virtual.val()) &&
					!isEmail(email_owner_virtual.val())
				) {
					email_owner_virtual.focus();
					notifyDialog('Email không hợp lệ');
					flag = false;
				} else if (isExist(email_owner_virtual) && existEmailOwnerVirtual) {
					email_owner_virtual.focus();
					notifyDialog('Email đã tồn tại');
					flag = false;
				} else if (isExist(phone_owner_virtual) && !getLen(phone_owner_virtual.val())) {
					phone_owner_virtual.focus();
					notifyDialog('Số điện thoại không được trống');
					flag = false;
				} else if (
					isExist(phone_owner_virtual) &&
					getLen(phone_owner_virtual.val()) &&
					!isPhone(phone_owner_virtual.val())
				) {
					phone_owner_virtual.focus();
					notifyDialog('Số điện thoại không hợp lệ');
					flag = false;
				} else if (isExist(gender_owner_virtual) && !gender_owner_virtual.val()) {
					gender_owner_virtual.focus();
					notifyDialog('Chưa chọn giới tính');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Store */
	if (IS_STORE) {
		/* Submit store */
		if ($('.submit-store').length) {
			$('.submit-store').click(function () {
				var flag = true;
				var namevi = $('#namevi');
				var cat = $('#id_cat');
				var list = $('#id_list');

				/* Holdon */
				holdonOpen();

				if (isExist(namevi) && !getLen(namevi.val())) {
					namevi.focus();
					notifyDialog('Tiêu đề không được trống');
					flag = false;
				} else if (isExist(list) && !list.val()) {
					list.focus();
					notifyDialog('Chưa chọn danh mục chính');
					flag = false;
				} else if (isExist(cat) && !cat.val()) {
					cat.focus();
					notifyDialog('Chưa chọn danh mục cấp 2');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Size */
	if (IS_SIZE) {
		/* Submit size */
		if ($('.submit-size').length) {
			$('.submit-size').click(function () {
				var flag = true;
				var namevi = $('#namevi');
				var list = $('#id_list');

				/* Holdon */
				holdonOpen();

				if (isExist(list) && !list.val()) {
					list.focus();
					notifyDialog('Chưa chọn danh mục chính');
					flag = false;
				} else if (isExist(namevi) && !getLen(namevi.val())) {
					namevi.focus();
					notifyDialog('Tiêu đề không được trống');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Posting */
	if (IS_POSTING) {
		/* Send email for customer */
		$('body').on('click', '#send-posting:not([disabled])', function () {
			var id = $(this).data('id');
			var table = $(this).data('table');
			var value = id + ',' + table;
			confirmDialog('send-posting', 'Bạn muốn gửi thông báo duyệt này cho chủ sở hữu ?', value);
		});

		/* Filter by user */
		if ($('#posting_user').length) {
			$('#posting_user').change(function () {
				onchangeCategory($(this));
			});
		}

		/* Filter by member */
		if ($('#posting_member').length) {
			$('#posting_member').change(function () {
				onchangeCategory($(this));
			});
		}

		/* Filter by date */
		if ($('#posting_date').length) {
			$('#posting_date').daterangepicker({
				callback: this.render,
				autoUpdateInput: false,
				timePicker: false,
				timePickerIncrement: 30,
				locale: {
					format: 'DD/MM/YYYY'
					// format: 'DD/MM/YYYY hh:mm A'
				}
			});
			$('#posting_date').on('apply.daterangepicker', function (ev, picker) {
				var date = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
				var url = filterCategory(LINK_FILTER);
				$(this).val(date);
				onchangeCategory($(this));
			});
			$('#posting_date').on('cancel.daterangepicker', function (ev, picker) {
				$(this).val('');
				onchangeCategory($(this));
			});
		}

		/* Check status when choose multi select: Color, Size */
		if (isExist($('.multiselect-sale')) && isExist($('.status-attr-posting'))) {
			$('.status-attr-posting input').click(function () {
				$this = $(this);
				var status = $this.val();
				var sumoColor = isExist($('.multiselect-color')) ? $('.multiselect-color')[0].sumo : '';
				var sumoSize = isExist($('.multiselect-size')) ? $('.multiselect-size')[0].sumo : '';

				if ($this.is(':checked') && status == 'dichvu') {
					if (sumoColor) {
						sumoColor.disable();
					}

					if (sumoSize) {
						sumoSize.disable();
					}
				} else {
					if (sumoColor) {
						sumoColor.enable();
					}

					if (sumoSize) {
						sumoSize.enable();
					}
				}
			});
		}

		/* Poster video */
		if ($('#photo-zone-poster').length) {
			photoZone('#photo-zone-poster', '#file-zone-poster', '#photoUpload-preview-poster img');
		}

		/* Submit posting */
		if ($('.submit-posting').length) {
			$('.submit-posting').click(function () {
				var flag = true;
				var namevi = $('#namevi');
				var contentvi = $('#contentvi');
				var regular_price = $('#regular_price');
				var regular_price_label = $('#regular_price').data('label');
				var type_price = $('#type-price');
				var acreage = $('#acreage');
				var coordinates = $('#map-coordinates');
				var name_video = $('#name_video');
				var poster_video = $('#file-zone-poster');
				var file_video = $('#file_video');
				var ext_video = infoFile(file_video, 'ext');
				var size_video = infoFile(file_video, 'size');
				var size_max = formatBytes(MAX_SIZE_VIDEO);
				var type_video = $('.form-group-video').find('input[type=hidden]#video-type').val();

				var first_name = $('#first_name');
				var last_name = $('#last_name');
				var birthday = $('#birthday');
				var gender = $('#gender');
				var phone = $('#phone');
				var email = $('#email');
				var address = $('#address');

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

				var cat = $('#id_cat');
				var item = $('#id_item');
				var form_work = $('#id_form_work');
				var experience = $('#id_experience');
				var region = $('#id_region');
				var city = $('#id_city');
				var district = $('#id_district');
				var wards = $('#id_wards');
				var photo = $('#file-zone');
				var has_gallery = $('.custom-file-uploader');
				var files_gallery = $('.fileuploader-items-list li');

				/* Holdon */
				holdonOpen();

				if (isExist(namevi) && !getLen(namevi.val())) {
					namevi.focus();
					notifyDialog('Tiêu đề không được trống');
					flag = false;
				} else if (isExist(contentvi) && !getLen(contentvi.val())) {
					contentvi.focus();
					notifyDialog('Nội dung không được trống');
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
				} else if (isExist(coordinates) && !getLen(coordinates.val())) {
					coordinates.focus();
					notifyDialog('Tọa độ không được trống');
					flag = false;
				} else if (isExist(coordinates) && !isCoords(coordinates.val())) {
					coordinates.focus();
					notifyDialog('Tọa độ không hợp lệ');
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
				} else if (
					isExist(name_video) &&
					!getLen(name_video.val()) 
				) {
					name_video.focus();
					notifyDialog('Tiêu đề video không được trống');
					flag = false;
				} else if (
				
			
					isExist(poster_video) &&
					!getLen(poster_video.val()) &&
					!HAS_POSTER_VIDEO
				) {
					notifyDialog('Hình đại diện video không được trống');
					flag = false;
				} else if (
		
					isExist(file_video) &&
					type_video == 'file' &&
					getLen(name_video.val()) &&
					!size_video['numb'] &&
					!HAS_VIDEO
				) {
					notifyDialog('Tập tin video không được trống');
					flag = false;
				} else if (
				
					isExist(file_video) &&
					type_video == 'file' &&
					getLen(name_video.val()) &&
					!checkExtFile(ext_video, EXTENSION_VIDEO)
				) {
					notifyDialog('Chi cho phép tập tin video với định dạng: ' + JSON.stringify(EXTENSION_VIDEO));
					flag = false;
				} else if (
				
					isExist(file_video) &&
					type_video == 'file' &&
					getLen(name_video.val()) &&
					size_video['numb'] > size_max['numb']
				) {
					notifyDialog('Tập tin video không được vượt quá ' + size_max['numb'] + ' ' + size_max['ext']);
					flag = false;
				} else if (isExist(cat) && !cat.val()) {
					cat.focus();
					notifyDialog('Chưa chọn danh mục cấp 2');
					flag = false;
				} else if (isExist(item) && !item.val()) {
					item.focus();
					notifyDialog('Chưa chọn danh mục cấp 3');
					flag = false;
				} else if (isExist(form_work) && !form_work.val()) {
					form_work.focus();
					notifyDialog('Chưa chọn hình thức làm việc');
					flag = false;
				} else if (isExist(experience) && !experience.val()) {
					experience.focus();
					notifyDialog('Chưa chọn kinh nghiệm');
					flag = false;
				} else if (isExist(region) && !region.val()) {
					region.focus();
					notifyDialog('Chưa chọn vùng/miền');
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
				} else if (isExist(photo) && !getLen(photo.val()) && !HAS_PHOTO) {
					notifyDialog('Hình đại diện không được trống');
					flag = false;
				} else if (isExist(has_gallery) && !isExist(files_gallery)) {
					notifyDialog('Album hình ảnh không được trống');
					flag = false;
				} else if (isExist(has_gallery) && isExist(files_gallery) && getLen(files_gallery) > 6) {
					notifyDialog('Album hình ảnh không được vượt quá 6 hình');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Variation */
	if (IS_VARIATION) {
		/* Submit variation */
		if ($('.submit-variation').length) {
			$('.submit-variation').click(function () {
				var flag = true;
				var list = $('#id_list');
				var namevi = $('#namevi');
				var denominations = $('#denominations');
				var value_from = $('#value_from');
				var value_type_from = $('#value_type_from');
				var value_to = $('#value_to');
				var value_type_to = $('#value_type_to');
				var date_filter = $('#date_filter');
				var more_than_date = $('#more-than-date');
				var less_than_date = $('#less-than-date');
				var more_than_date_c = $('#more-than-date:checked');
				var less_than_date_c = $('#less-than-date:checked');

				/* Holdon */
				holdonOpen();

				if (isExist(list) && !list.val()) {
					list.focus();
					notifyDialog('Chưa chọn danh mục chính');
					flag = false;
				} else if (isExist(namevi) && !getLen(namevi.val())) {
					namevi.focus();
					notifyDialog('Tiêu đề không được trống');
					flag = false;
				} else if (isExist(denominations) && !getLen(denominations.val())) {
					denominations.focus();
					notifyDialog('Mệnh giá không được trống');
					flag = false;
				} else if (
					isExist(value_from) &&
					isExist(value_to) &&
					((!getLen(value_from.val()) && !getLen(value_to.val())) ||
						(value_from.val() == 0 && value_to.val() == 0))
				) {
					notifyDialog('Một trong 2 giá trị từ hoặc đến không được trống hoặc bằng 0');
					flag = false;
				} else if (isExist(value_from) && getLen(value_from.val()) && !isDecimal(value_from.val())) {
					value_from.focus();
					notifyDialog('Giá trị từ không hợp lệ');
					flag = false;
				} else if (isExist(value_to) && getLen(value_to.val()) && !isDecimal(value_to.val())) {
					value_to.focus();
					notifyDialog('Giá trị đến không hợp lệ');
					flag = false;
				} else if (VARIATION_HAS_RANGE_TYPE) {
					if (isExist(value_type_from) && !getLen(value_type_from.val())) {
						value_type_from.focus();
						notifyDialog('Chưa chọn đơn vị từ');
						flag = false;
					} else if (isExist(value_type_to) && !getLen(value_type_to.val())) {
						value_type_to.focus();
						notifyDialog('Chưa chọn đơn vị đến');
						flag = false;
					}
				} else if (isExist(date_filter) && !getLen(date_filter.val())) {
					date_filter.focus();
					notifyDialog('Số ngày không được trống');
					flag = false;
				} else if (isExist(date_filter) && !isNumber(date_filter.val())) {
					date_filter.focus();
					notifyDialog('Số ngày không hợp lệ');
					flag = false;
				} else if ((!isExist(more_than_date_c) && !isExist(less_than_date_c)) && (isExist(more_than_date) || isExist(less_than_date))) {
					notifyDialog('Chọn 1 trong 2 điều kiện lọc');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Order */
	if (IS_ORDER) {
		/* Cancel order */
		if (isExist($('button[name="action-order"]'))) {
			$('button[name="action-order"]').click(function (e) {
				$this = $(this);
				var parents = $this.parents('#form-order');
				var action = $this.val();

				if (action == 'save-order') {
					parents.find('input[name="actionOrder"]').val($this.val());
					parents.submit();
				} else if (action == 'cancel-order') {
					e.preventDefault();
					confirmDialog('cancel-order', 'Bạn muốn hủy đơn hàng này ?', $(this));
				}
			});
		}
	}

	/* Report */
	if (IS_REPORT) {
		/* Submit lock/unlock/banned */
		if ($('.report-action').length) {
			$('.submit-lock, .submit-banned').click(function () {
				var flag = true;
				var note = $('#note');

				/* Holdon */
				holdonOpen();

				if (isExist(note) && !getLen(note.val())) {
					note.focus();
					notifyDialog('Mô tả thông tin không được trống');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Newsletter */
	if (IS_NEWSLETTER) {
		/* Submit newsletter */
		if ($('.submit-newsletter').length) {
			$('.submit-newsletter').click(function () {
				var flag = true;
				var fullname = $('#fullname');
				var phone = $('#phone');
				var email = $('#email');
				var content = $('#content');

				/* Holdon */
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
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Contact */
	if (IS_CONTACT) {
		/* Submit contact */
		if ($('.submit-contact').length) {
			$('.submit-contact').click(function () {
				var flag = true;
				var fullname = $('#fullname');
				var phone = $('#phone');
				var email = $('#email');
				var address = $('#address');
				var subject = $('#subject');
				var content = $('#content');

				/* Holdon */
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
				} else if (isExist(subject) && !getLen(subject.val())) {
					subject.focus();
					notifyDialog('Chủ đề không được trống');
					flag = false;
				} else if (isExist(content) && !getLen(content.val())) {
					content.focus();
					notifyDialog('Nội dung không được trống');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* setting */
	if (IS_SETTING) {
		/* Submit setting */
		if ($('.submit-setting').length) {
			$('.submit-setting').click(function () {
				var flag = true;
				var address = $('#address');
				var email = $('#email');
				var hotline = $('#hotline');
				var phone = $('#phone');
				var zalo = $('#zalo');
				var website = $('#website');
				var fanpage = $('#fanpage');
				var coords = $('#coords');
				var namevi = $('#namevi');
				var greeting = $('#greeting');
				var groupStore = $('#group-store');

				/* Holdon */
				holdonOpen();

				if (isExist(address) && !getLen(address.val())) {
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
				} else if (isExist(hotline) && !getLen(hotline.val())) {
					hotline.focus();
					notifyDialog('Hotline không được trống');
					flag = false;
				} else if (isExist(hotline) && !isPhone(hotline.val())) {
					hotline.focus();
					notifyDialog('Hotline không hợp lệ');
					flag = false;
				} else if (isExist(phone) && !getLen(phone.val())) {
					phone.focus();
					notifyDialog('Số điện thoại không được trống');
					flag = false;
				} else if (isExist(phone) && !isPhone(phone.val())) {
					phone.focus();
					notifyDialog('Số điện thoại không hợp lệ');
					flag = false;
				} else if (isExist(zalo) && getLen(zalo.val()) && !isPhone(zalo.val())) {
					zalo.focus();
					notifyDialog('Zalo không hợp lệ');
					flag = false;
				} else if (isExist(website) && !getLen(website.val())) {
					website.focus();
					notifyDialog('Website không được trống');
					flag = false;
				} else if (isExist(website) && !isUrl(website.val())) {
					website.focus();
					notifyDialog('Website không hợp lệ');
					flag = false;
				} else if (isExist(fanpage) && getLen(fanpage.val()) && !isFanpage(fanpage.val())) {
					fanpage.focus();
					notifyDialog('Fanpage không hợp lệ');
					flag = false;
				} else if (isExist(coords) && getLen(coords.val()) && !isCoords(coords.val())) {
					coords.focus();
					notifyDialog('Tọa độ không hợp lệ');
					flag = false;
				} else if (isExist(namevi) && !getLen(namevi.val())) {
					namevi.focus();
					notifyDialog('Tiêu đề không được trống');
					flag = false;
				} else if (isExist(greeting) && !getLen(greeting.val())) {
					greeting.focus();
					notifyDialog('Tiêu đề Lời Chào không được trống');
					flag = false;
				} else if (isExist(groupStore) && !getLen(groupStore.val())) {
					groupStore.focus();
					notifyDialog('Tiêu đề Nhóm Cửa Hàng không được trống');
					flag = false;
				}

				/* Holdon close */
				if (!flag) {
					holdonClose();
				}

				return flag;
			});
		}
	}

	/* Check required form */
	if ($('.submit-check').length) {
		$('.submit-check').click(function () {
			var formCheck = $(this).parents('form.validation-form');

			/* Holdon */
			holdonOpen();

			/* Elements */
			var flag = true;
			var cardOffset = 0;
			var elementsInValid = $('.card :required:invalid');

			/* Check name */
			if (elementsInValid.length) {
				flag = false;

				/* Check elements empty */
				elementsInValid.each(function () {
					$this = $(this);
					cardOffset = $this.parents('.card-body');
					var cardCollapsed = $this.parents('.card.collapsed-card');

					if (cardCollapsed.length) {
						cardCollapsed.find('.card-body').show();
						cardCollapsed.find('.btn-tool i').toggleClass('fas fa-plus fas fa-minus');
						cardCollapsed.removeClass('collapsed-card');
					}

					var tabPane = $this.parents('.tab-pane');
					var tabPaneID = tabPane.attr('id');
					$('.nav-tabs a[href="#' + tabPaneID + '"]').tab('show');

					return false;
				});

				/* Scroll to error */
				if (cardOffset) {
					setTimeout(function () {
						$('html,body').animate({ scrollTop: cardOffset.offset().top - 100 }, 'medium');
					}, 500);
				}
			}

			/* Check form validated */
			if (!flag) {
				/* Holdon close */
				holdonClose();

				formCheck.addClass('was-validated');
			} else {
				formCheck.removeClass('was-validated');
			}

			return flag;
		});
	}

	/* Select 2 */
	if ($('.select2').length) {
		$('.select2').select2();
	}

	/* Format price */
	if ($('.format-price').length) {
		$('.format-price').priceFormat({
			limit: 13,
			prefix: '',
			centsLimit: 0
		});
	}

	/* PhotoZone */
	if ($('#photo-zone').length) {
		photoZone('#photo-zone', '#file-zone', '#photoUpload-preview img');
	}
	if ($('#photo-zone-2').length) {
		photoZone('#photo-zone-2', '#file-zone-2', '#photoUpload-preview-2 img');
	}
	if ($('#photo-zone-3').length) {
		photoZone('#photo-zone-3', '#file-zone-3', '#photoUpload-preview-3 img');
	}
	if ($('#photo-zone-4').length) {
		photoZone('#photo-zone-4', '#file-zone-4', '#photoUpload-preview-4 img');
	}
	if ($('#photo-zone-5').length) {
		photoZone('#photo-zone-5', '#file-zone-5', '#photoUpload-preview-5 img');
	}
	if ($('#photo-zone-6').length) {
		photoZone('#photo-zone-6', '#file-zone-6', '#photoUpload-preview-6 img');
	}

	/* Sumoselect */
	if ($('.multiselect').length) {
		window.asd = $('.multiselect').SumoSelect({
			placeholder: 'Chọn danh mục',
			selectAll: true,
			search: true,
			searchText: 'Tìm kiếm',
			locale: ['OK', 'Hủy', 'Chọn hết'],
			noMatch: 'Không có dữ liệu',
			captionFormat: 'Đã chọn {0} mục',
			captionFormatAllSelected: 'Đã chọn tất cả'
		});
	}

	/* Max Datetime Picker */
	if ($('.max-date').length) {
		maxDate('.max-date');
	}

	/* Min Datetime Picker */
	if ($('.min-date').length) {
		minDate('.min-date');
	}

	/* Ckeditor */
	if ($('.form-control-ckeditor').length) {
		$('.form-control-ckeditor').each(function () {
			var id = $(this).attr('id');
			CKEDITOR.replace(id);
		});
	}

	/* Comment */
	if ($('.comment-manager').length) {
		var data = '';
		data += SECTOR['prefix'] ? SECTOR['prefix'] + '|' : '|';
		data += SECTOR['tables']['shop'] ? SECTOR['tables']['shop'] + '|' : '|';
		data += SECTOR['tables']['comment'] ? SECTOR['tables']['comment'] + '|' : '|';
		data += SECTOR['tables']['comment-photo'] ? SECTOR['tables']['comment-photo'] + '|' : '|';
		data += SECTOR['tables']['comment-video'] ? SECTOR['tables']['comment-video'] : '';

		$('.comment-manager').comments({
			url: 'api/comment.php?data=' + btoa(data)
		});
	}

	/* Ajax category */
	if ($('.select-category').length) {
		$('body').on('change', '.select-category', function () {
			var id = $(this).val();
			var child = $(this).data('child');
			var level = parseInt($(this).data('level'));
			var table = $(this).data('table');
			var type = $(this).data('type');

			if ($('#' + child).length) {
				$.ajax({
					url: 'api/category.php',
					type: 'POST',
					data: {
						level: level,
						id: id,
						table: table,
						type: type
					},
					success: function (result) {
						var op = "<option value=''>Chọn danh mục</option>";

						if (level == 0) {
							$('#id_cat').html(op);
							$('#id_item').html(op);
							$('#id_sub').html(op);
						} else if (level == 1) {
							$('#id_item').html(op);
							$('#id_sub').html(op);
						} else if (level == 2) {
							$('#id_sub').html(op);
						}
						$('#' + child).html(result);
					}
				});
			}

			/* Get store */
			if ($('#id_store').length) {
				$.ajax({
					url: 'api/store.php',
					type: 'POST',
					data: {
						id_list: ID_LIST,
						id_cat: id
					},
					success: function (result) {
						$('#id_store').html(result);
					}
				});
			}
			if ($(this).hasClass('load_properties')) {
				$.ajax({
					url: 'api/properties.php',
					type: 'POST',
					data: {
			
						id_sub: id
					},
					success: function (result) {
						$('#properties_vi').html(result);
					}
				});
			}

			return false;
		});
	}

	/* Ajax place */
	if ($('.select-place').length) {
		$('body').on('change', '.select-place', function () {
			var id = $(this).val();
			var child = $(this).data('child');
			var level = parseInt($(this).data('level'));
			var table = $(this).data('table');

			if ($('#' + child).length) {
				$.ajax({
					url: 'api/place.php',
					type: 'POST',
					data: {
						level: level,
						id: id,
						table: table
					},
					success: function (result) {
						var op = "<option value=''>Chọn danh mục</option>";

						if (level == 0) {
							$('#id_city').html(op);
							$('#id_district').html(op);
							$('#id_wards').html(op);
						} else if (level == 1) {
							$('#id_district').html(op);
							$('#id_wards').html(op);
						} else if (level == 2) {
							$('#id_wards').html(op);
						}
						$('#' + child).html(result);
					}
				});
			}

			return false;
		});
	}

	/* Send email */
	if ($('#send-email').length) {
		$('body').on('click', '#send-email', function () {
			confirmDialog('send-email', 'Bạn muốn gửi thông tin cho các mục đã chọn ?', '');
		});
	}

	/* Check item */
	if ($('.select-checkbox').length) {
		var lastChecked = null;
		var $checkboxItem = $('.select-checkbox');

		$checkboxItem.click(function (e) {
			if (!lastChecked) {
				lastChecked = this;
				return;
			}

			if (e.shiftKey) {
				var start = $checkboxItem.index(this);
				var end = $checkboxItem.index(lastChecked);
				$checkboxItem.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', true);
			}

			lastChecked = this;
		});
	}

	/* Check all */
	if ($('#selectall-checkbox').length) {
		$('body').on('click', '#selectall-checkbox', function () {
			var parentTable = $(this).parents('table');
			var input = parentTable.find('input.select-checkbox');

			if ($(this).is(':checked')) {
				input.each(function () {
					$(this).prop('checked', true);
				});
			} else {
				input.each(function () {
					$(this).prop('checked', false);
				});
			}
		});
	}

	/* Delete item */
	if ($('#delete-item').length) {
		$('body').on('click', '#delete-item', function () {
			var url = $(this).data('url');
			var message = $(this).data('message');
			message = message ? message : 'Bạn có chắc muốn xóa mục này ?';
			confirmDialog('delete-item', message, url);
		});
	}

	/* Delete prompt */
	if ($('#delete-prompt').length) {
		$('body').on('click', '#delete-prompt', function () {
			var url = $(this).data('url');
			promptDialog(url);
		});
	}

	/* Delete all */
	if ($('#delete-all').length) {
		$('body').on('click', '#delete-all', function () {
			var url = $(this).data('url');
			confirmDialog('delete-all', 'Bạn có chắc muốn xóa những mục này ?', url);
		});
	}

	/* Load name input file */
	if ($('.custom-file input[type=file]').length) {
		$('body').on('change', '.custom-file input[type=file]', function () {
			var fileName = $(this).val();
			fileName = fileName.substr(fileName.lastIndexOf('\\') + 1, fileName.length);
			$(this).siblings('label').html(fileName);
		});
	}

	/* Change dropdown status */
	if ($('.dropdown-status .dropdown-item').length) {
		$('body').on('click', '.dropdown-status .dropdown-item', function () {
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var virtual = $(this).attr('data-virtual');
			var attr = $(this).attr('data-attr');
			var cls = $(this).attr('data-cls');
			var text = $(this).attr('data-text');
			var $this = $(this);
			var $tr = $this.parents('tr');
			var $parents = $this.parents('.dropdown-status');
			var clsDropdown = $parents.find('.dropdown-toggle').attr('data-cls');

			$.ajax({
				url: 'api/status-dropdown.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id,
					table: table,
					attr: attr
				},
				success: function () {
					$parents.find('.dropdown-toggle').removeClass('bg-gradient-' + clsDropdown);
					$parents.find('.dropdown-toggle').addClass('bg-gradient-' + cls);
					$parents.find('.dropdown-toggle').attr('data-cls', cls);
					$parents.find('.dropdown-toggle span').text(text);

					if (attr == 'xetduyet') {
						var enableSend = true;

						if (virtual) {
							enableSend = false;
						}

						if (enableSend) {
							$tr.find('.send-info').removeClass('bg-gradient-secondary');
							$tr.find('.send-info').addClass('bg-gradient-info');
							$tr.find('.send-info').attr('disabled', false);
						}
					} else {
						$tr.find('.send-info').addClass('bg-gradient-secondary');
						$tr.find('.send-info').removeClass('bg-gradient-info');
						$tr.find('.send-info').attr('disabled', true);
					}
				}
			});
		});
	}

	/* Change status */
	if ($('.show-checkbox').length) {
		$('body').on('click', '.show-checkbox', function () {
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var col = $(this).attr('data-col');
			var attr = $(this).attr('data-attr');
			var $this = $(this);

			$.ajax({
				url: 'api/status.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id,
					table: table,
					col: col,
					attr: attr
				},
				beforeSend: function () {
					/* Holdon open */
					holdonOpen();
				},
				success: function () {
					if ($this.is(':checked')) {
						$this.prop('checked', false);
					} else {
						$this.prop('checked', true);
					}

					/* Holdon close */
					holdonClose();
				}
			});

			return false;
		});
	}

	/* Change numb */
	if ($('input.update-numb').length) {
		$('body').on('change', 'input.update-numb', function () {
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var value = $(this).val();

			$.ajax({
				url: 'api/numb.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id,
					table: table,
					value: value
				}
			});

			return false;
		});
	}

	/* SEO */
	seoChange();
	if ($('.title-seo').length && $('.keywords-seo').length && $('.description-seo').length) {
		$('body').on('keyup', '.title-seo, .keywords-seo, .description-seo', function () {
			seoCount($(this));
		});
	}
	if ($('.create-seo').length) {
		$('body').on('click', '.create-seo', function () {
			if (seoExist())
				confirmDialog('create-seo', 'Nội dung SEO đã được thiết lập. Bạn muốn tạo lại nội dung SEO ?', '');
			else seoCreate();
		});
	}

	/* File Uploader Remove */
	if ($('.fileuploader-item-detail').length) {
		$('body').on('click', '.fileuploader-item-detail .fileuploader-action-remove', function () {
			$this = $(this);
			$parent = $this.parents('.fileuploader-item-detail');
			$parent = $this.parents('.fileuploader-item-detail');
			var id = $this.attr('data-id');
			var folder = $this.attr('data-folder');
			var table = $this.attr('data-table');
			var value = id + ',' + folder + ',' + table;
			confirmDialog('delete-file-uploader', 'Bạn có chắc muốn xóa hình ảnh này ?', value);
		});
	}

	/* File Uploader Product */
	if ($('#files-uploader').length) {
		$('#files-uploader').getEvali({
			limit: 6 - COUNT_PHOTO_FILEUPLOADER,
			maxSize: (6 - COUNT_PHOTO_FILEUPLOADER) * 10,
			extensions: ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG', 'Png'],
			editor: false,
			addMore: true,
			enableApi: false,
			dragDrop: true,
			changeInput:
				'<div class="fileuploader-input">' +
				'<div class="fileuploader-input-inner">' +
				'<div class="fileuploader-main-icon"></div>' +
				'<h3 class="fileuploader-input-caption"><span>${captions.feedback}</span></h3>' +
				'<p>${captions.or}</p>' +
				'<div class="fileuploader-input-button"><span>${captions.button}</span></div>' +
				'</div>' +
				'</div>',
			theme: 'dragdrop',
			captions: {
				feedback: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
				feedback2: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
				drop: '(Click để tải ảnh hoặc kéo thả ảnh vào đây)',
				or: '-hoặc-',
				button: 'Chọn ảnh'
			},
			thumbnails: {
				popup: false,
				canvasImage: false
			},
			dialogs: {
				alert: function (e) {
					return notifyDialog(e);
				},
				confirm: function (e, t) {
					$.confirm({
						title: 'Thông báo',
						icon: 'fas fa-exclamation-triangle',
						type: 'blue',
						content: e,
						backgroundDismiss: true,
						animationSpeed: 600,
						animation: 'zoom',
						closeAnimation: 'scale',
						typeAnimated: true,
						animateFromElement: false,
						autoClose: 'cancel|3000',
						escapeKey: 'cancel',
						buttons: {
							success: {
								text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
								btnClass: 'btn-blue btn-sm bg-gradient-primary',
								action: function () {
									t();
								}
							},
							cancel: {
								text: '<i class="fas fa-times align-middle mr-2"></i>Hủy',
								btnClass: 'btn-red btn-sm bg-gradient-danger'
							}
						}
					});
				}
			},
			afterSelect: function () { },
			onEmpty: function () { },
			onRemove: function () { }
		});
	}

	/* Maps */
	if (isExist($('#map-iframe'))) {
		var map;
		var markers;
		var latlngs;
		var gRedIcon = new google.maps.MarkerImage(
			'assets/images/icon-map-api.png',
			new google.maps.Size(28, 38),
			new google.maps.Point(0, 0),
			new google.maps.Point(15, 45)
		);
		var infowindow;
		var geocoder;
		var divInfo = "<div id='map-address'>Kéo thả nhà đến vị trí mới</div>";

		function initialize() {
			var olat, olng;
			olat = document.getElementById('map-Latitude').value;
			olng = document.getElementById('map-Longitude').value;

			var mapOptions = {
				center: new google.maps.LatLng(olat, olng),
				zoom: 15,
				scrollwheel: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			latlngs = new google.maps.LatLng(olat, olng);
			map = new google.maps.Map(document.getElementById('map-iframe'), mapOptions);
			geocoder = new google.maps.Geocoder();
			infowindow = new google.maps.InfoWindow();
			infowindow.setContent(divInfo);

			var marker = new google.maps.Marker({
				map: map,
				draggable: true,
				icon: gRedIcon
			});

			if (
				document.getElementById('map-Latitude').value != '' &&
				document.getElementById('map-Latitude').value != '0' &&
				document.getElementById('map-Longitude').value != '' &&
				document.getElementById('map-Longitude').value != '0'
			) {
				marker.setPosition(new google.maps.LatLng(olat, olng));
				infowindow.open(map, marker);
				updateMarkerPosition(marker.getPosition());
				geoCodePosition(marker.getPosition());
				infowindow.setContent(divInfo);
			}

			markers = marker;
			google.maps.event.addListener(marker, 'dragstart', function () {
				var place = map.getCenter();
				updateMarkerPosition(place);

				google.maps.event.addListener(marker, 'drag', function () {
					updateMarkerPosition(marker.getPosition());
				});

				google.maps.event.addListener(marker, 'dragend', function () {
					geoCodePosition(marker.getPosition());
				});

				marker.setPosition(place);
			});

			google.maps.event.addListener(marker, 'click', function () {
				infowindow.setContent(divInfo);
				infowindow.open(map, marker);
			});

			google.maps.event.addListener(map, 'click', function (e) {
				geocoder.geocode(
					{
						latLng: e.latLng
					},
					function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[0]) {
								if (marker) {
									marker.setPosition(e.latLng);
								} else {
									marker = new google.maps.Marker({
										position: e.latLng,
										map: map
									});
								}

								infowindow.setContent(divInfo);
								infowindow.open(map, marker);
								updateMarkerPosition(marker.getPosition());
								geoCodePosition(marker.getPosition());
								infowindow.setContent(divInfo);
							} else {
								document.getElementById('geocoding').innerHTML = 'No results found';
							}
						} else {
							document.getElementById('geocoding').innerHTML = 'Geocoder failed due to: ' + status;
						}
					}
				);
			});
		}

		function geoCodeLoad() {
			var address;
			$city = $('#map-city').val();
			$district = $("select#id_district option[value='" + $('select#id_district').val() + "']").html();
			$wards = $("select#id_wards option[value='" + $('select#id_wards').val() + "']").html();

			if (!$('select#id_city').val()) {
				$city = '';
			}

			if (!$('select#id_district').val()) {
				$district = '';
			}

			if (!$('select#id_wards').val()) {
				$wards = '';
			}

			var address = $wards + ', ' + $district + ', ' + $city;
			var geocoder = new google.maps.Geocoder();

			$('#map-address').val(address);

			geocoder.geocode(
				{
					address: address,
					partialmatch: true
				},
				geoCodeResult
			);
		}

		function geoCodeResult(results, status) {
			if (status == 'OK' && results.length > 0) {
				map.fitBounds(results[0].geometry.viewport);
				updateGeoCodePosition(results[0].geometry.location);
				markers.setPosition(
					new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng())
				);
			} else {
				console.log('Geocode was not successful for the following reason: ' + status);
			}
		}

		function geoCodePosition(pos) {
			geocoder.geocode(
				{
					latLng: pos
				},
				function (responses) {
					if (responses && responses.length > 0) {
						updateMarkerAddress(responses[0].formatted_address);
						infowindow.setContent(responses[0].formatted_address);
					} else {
						updateMarkerAddress('Không thể xác định vị trí');
						infowindow.setContent('Không thể xác định vị trí');
					}
				}
			);
		}

		function updateGeoCodePosition(latlng) {
			document.getElementById('map-Latitude').value = latlng.lat();
			document.getElementById('map-Longitude').value = latlng.lng();
			document.getElementById('map-coordinates').value = latlng.lat() + ',' + latlng.lng();
		}

		function updateMarkerPosition(latlng) {
			document.getElementById('map-Latitude').value = latlng.lat();
			document.getElementById('map-Longitude').value = latlng.lng();
			document.getElementById('map-coordinates').value = latlng.lat() + ',' + latlng.lng();
			latlngs = latlng;

			var coords = latlng.lat() + ',' + latlng.lng();
			var iframe =
				"<iframe width='100%' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='http://maps.google.com/maps?q=" +
				coords +
				"&amp;z=15&amp;output=embed'></iframe>";

			$('#preview-map').html(iframe);
		}

		function updateMarkerAddress(str) {
			document.getElementById('map-iframe').value = str;
		}

		var markers = new Array();
		function callback(results, status) {
			if (status == google.maps.places.PlacesServiceStatus.OK) {
				for (var i = 0; i < results.length; i++) {
					createMarker(results[i]);
				}
			}
		}

		function createMarker(place) {
			var placeLoc = place.geometry.location;
			var marker = new google.maps.Marker({
				map: map,
				position: place.geometry.location
			});

			markers[markers.length] = marker;

			google.maps.event.addListener(marker, 'click', function () {
				infowindow.setContent(place.name);
				infowindow.open(map, this);
			});
		}

		google.maps.event.addDomListener(window, 'load', initialize);
	}

	/* Ckeditor */
	if ($('.form-control-ckeditor').length) {
		CKEDITOR.editorConfig = function (config) {
			/* Config General */
			config.language = 'vi';
			config.skin = 'moono-lisa';
			config.width = 'auto';
			config.height = 620;

			/* Allow element */
			config.allowedContent = true;

			/* Entities */
			config.entities = false;
			config.entities_latin = false;
			config.entities_greek = false;
			config.basicEntities = false;

			/* Config CSS */
			config.contentsCss = [CONFIG_BASE + ADMIN + '/ckeditor/contents.css'];

			/* All Plugins */
			config.extraPlugins =
				'codemirror,texttransform,copyformatting,html5video,html5audio,flash,youtube,wordcount,tableresize,widget,lineutils,clipboard,dialog,dialogui,widgetselection,lineheight,video,videodetector';

			/* Config Lineheight */
			config.line_height = '1;1.1;1.2;1.3;1.4;1.5;2;2.5;3;3.5;4;4.5;5';

			/* Config Word */
			config.pasteFromWordRemoveFontStyles = false;
			config.pasteFromWordRemoveStyles = false;

			/* Config CodeMirror */
			config.codemirror = {
				// Set this to the theme you wish to use (codemirror themes)
				theme: 'default',

				// Whether or not you want to show line numbers
				lineNumbers: true,

				// Whether or not you want to use line wrapping
				lineWrapping: true,

				// Whether or not you want to highlight matching braces
				matchBrackets: true,

				// Whether or not you want tags to automatically close themselves
				autoCloseTags: true,

				// Whether or not you want Brackets to automatically close themselves
				autoCloseBrackets: true,

				// Whether or not to enable search tools, CTRL+F (Find), CTRL+SHIFT+F (Replace), CTRL+SHIFT+R (Replace All), CTRL+G (Find Next), CTRL+SHIFT+G (Find Previous)
				enableSearchTools: true,

				// Whether or not you wish to enable code folding (requires 'lineNumbers' to be set to 'true')
				enableCodeFolding: true,

				// Whether or not to enable code formatting
				enableCodeFormatting: true,

				// Whether or not to automatically format code should be done when the editor is loaded
				autoFormatOnStart: true,

				// Whether or not to automatically format code should be done every time the source view is opened
				autoFormatOnModeChange: true,

				// Whether or not to automatically format code which has just been uncommented
				autoFormatOnUncomment: true,

				// Define the language specific mode 'htmlmixed' for html including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
				mode: 'htmlmixed',

				// Whether or not to show the search Code button on the toolbar
				showSearchButton: true,

				// Whether or not to show Trailing Spaces
				showTrailingSpace: true,

				// Whether or not to highlight all matches of current word/selection
				highlightMatches: true,

				// Whether or not to show the format button on the toolbar
				showFormatButton: true,

				// Whether or not to show the comment button on the toolbar
				showCommentButton: true,

				// Whether or not to show the uncomment button on the toolbar
				showUncommentButton: true,

				// Whether or not to show the showAutoCompleteButton button on the toolbar
				showAutoCompleteButton: true,

				// Whether or not to highlight the currently active line
				styleActiveLine: true
			};

			/* Config CKFinder - ELFinder */
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/)) {
				var folderCkfinder = PHP_VERSION >= 8 ? 'ckfinder8' : 'ckfinder7';
				config.filebrowserBrowseUrl = folderCkfinder + '/ckfinder.html?token=' + TOKEN;
				config.filebrowserUploadUrl =
					folderCkfinder + '/core/connector/php/connector.php?command=QuickUpload&type=Files&token=' + TOKEN;
			} else {
				config.filebrowserBrowseUrl = 'elfinder/index.php?token=' + TOKEN;
			}

			/* Config ToolBar */
			config.toolbar = [
				{ name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
				{
					name: 'clipboard',
					items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'PasteFromExcel', '-', 'Undo', 'Redo']
				},
				{ name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
				{
					name: 'forms',
					items: [
						'Form',
						'Checkbox',
						'Radio',
						'TextField',
						'Textarea',
						'Select',
						'Button',
						'ImageButton',
						'HiddenField'
					]
				},
				'/',
				{
					name: 'basicstyles',
					items: [
						'Bold',
						'Italic',
						'Underline',
						'Strike',
						'Subscript',
						'Superscript',
						'-',
						'CopyFormatting',
						'RemoveFormat'
					]
				},
				{
					name: 'texttransform',
					items: [
						'TransformTextToUppercase',
						'TransformTextToLowercase',
						'TransformTextCapitalize',
						'TransformTextSwitcher'
					]
				},
				{
					name: 'paragraph',
					items: [
						'NumberedList',
						'BulletedList',
						'-',
						'Outdent',
						'Indent',
						'-',
						'Blockquote',
						'CreateDiv',
						'-',
						'JustifyLeft',
						'JustifyCenter',
						'JustifyRight',
						'JustifyBlock',
						'-',
						'BidiLtr',
						'BidiRtl',
						'Language'
					]
				},
				{ name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
				{
					name: 'insert',
					items: [
						'Image',
						'Flash',
						'Youtube',
						'VideoDetector',
						'Html5video',
						'Video',
						'Html5audio',
						'Iframe',
						'Table',
						'HorizontalRule',
						'Smiley',
						'SpecialChar',
						'PageBreak'
					]
				},
				'/',
				{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize', 'lineheight'] },
				{ name: 'colors', items: ['TextColor', 'BGColor'] },
				{ name: 'tools', items: ['Maximize', 'ShowBlocks'] },
				{ name: 'about', items: ['About'] }
			];

			/* Config StylesSet */
			config.stylesSet = [
				{ name: 'Font Seguoe Regular', element: 'span', attributes: { class: 'segui' } },
				{ name: 'Font Seguoe Semibold', element: 'span', attributes: { class: 'seguisb' } },
				{ name: 'Italic title', element: 'span', styles: { 'font-style': 'italic' } },
				{
					name: 'Special Container',
					element: 'div',
					styles: { background: '#eee', border: '1px solid #ccc', padding: '5px 10px' }
				},
				{ name: 'Big', element: 'big' },
				{ name: 'Small', element: 'small' },
				{ name: 'Inline ', element: 'q' },
				{ name: 'marker', element: 'span', attributes: { class: 'marker' } }
			];

			/* Config Wordcount */
			config.wordcount = {
				showParagraphs: true,
				showWordCount: true,
				showCharCount: true,
				countSpacesAsChars: false,
				countHTML: false,
				filter: new CKEDITOR.htmlParser.filter({
					elements: {
						div: function (element) {
							if (element.attributes.class == 'mediaembed') {
								return false;
							}
						}
					}
				})
			};
		};
	}
});
