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
					if (action == 'delete-file-uploader') deleteFileUploader(value);
					if (action == 'delete-item') deleteItem(value);
					if (action == 'delete-all') deleteAll(value);
				}
			},
			cancel: {
				text: '<i class="fas fa-times align-middle mr-2"></i>Hủy',
				btnClass: 'btn-red btn-sm bg-gradient-danger'
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

/* Onload + resize */
$(window).on('load resize', function () {
	/* Chat */
	if (isExist($('.direct-chat-messages-scroll'))) {
		var obj = $('.direct-chat-messages-scroll');
		obj.scrollTop(obj[0].scrollHeight);
	}
});

/* Ready */
$(document).ready(function () {
	/* Validation form chung */
	validateForm('validation-form');

	/* Tooltips */
	if (isExist($('[data-plugin="tooltip"]'))) {
		$('[data-plugin="tooltip"]').tooltip();
	}

	/* Chat */
	if (IS_CHAT) {
		/* Photo */
		if (isExist($('.card-chat-photo'))) {
			$('.card-chat-photo')
				.find('img')
				.click(function () {
					$this = $(this);
					var photo = $this.attr('data-photo');
					var alt = $this.attr('alt');
					notifyDialog(
						'<img class="w-100" src="' + ASSET + UPLOAD_PHOTO_THUMB + photo + '" alt="' + alt + '">',
						'Hình ảnh',
						'fas fa-image',
						'blue'
					);
				});
		}

		/* Scroll */
		if (isExist($('.direct-chat'))) {
			var busyScroll = false;

			$('.direct-chat-messages-scroll').scroll(function () {
				$this = $(this);
				$loadLists = $('.direct-chat-messages');
				$loadResult = $loadLists.find('.direct-chat-messages-result');
				$loading = $loadLists.find('.direct-chat-messages-loading');
				var limitFrom = parseInt($loadLists.find('.limit-from').val());
				var limitGet = parseInt($loadLists.find('.limit-get').val());
				var limitTotal = parseInt($loadLists.find('.limit-total').val());

				if ($this.scrollTop() == 0 && limitFrom < limitTotal && !busyScroll) {
					busyScroll = true;
					$loading.removeClass('d-none');

					$.ajax({
						url: LINK_FILTER,
						type: 'GET',
						dataType: 'json',
						async: true,
						data: {
							limitFrom: limitFrom,
							limitGet: limitGet
						},
						success: function (result) {
							setTimeout(function () {
								if (result.error) {
									showNotify(result.message, 'Thông báo', 'error');
									clearTimeout();
									setTimeout(function () {
										location.href = location.href;
									}, 1000);
								} else {
									$loadResult.prepend(result.data);
									$loadLists.find('.limit-from').val(limitFrom + limitGet);
								}

								busyScroll = false;
								$this.scrollTop(2);
								$loading.addClass('d-none');
							}, 800);
						}
					});
				}
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
					size_video['numb'] > size_max['numb']
				) {
					notifyDialog('Tập tin video không được vượt quá ' + size_max['numb'] + ' ' + size_max['ext']);
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

	/* Order */
	if (IS_ORDER) {
		/* Submit order */
		if ($('.submit-order').length) {
			$('.submit-order').click(function () {
				var flag = true;
				var order_status = $('#order_status');

				/* Holdon */
				holdonOpen();

				if (isExist(order_status) && !order_status.val()) {
					order_status.focus();
					notifyDialog('Chưa chọn tình trạng đơn hàng');
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
				var address = $('#address');
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
				var fanpage = $('#fanpage');
				var coords = $('#coords');
				var namevi = $('#namevi');

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

	/* Ckeditor */
	if ($('.form-control-ckeditor').length) {
		$('.form-control-ckeditor').each(function () {
			var id = $(this).attr('id');
			CKEDITOR.replace(id);
		});
	}

	/* Comment */
	if ($('.comment-manager').length) {
		$('.comment-manager').comments({
			url:
				'api/comment.php?tables=' +
				btoa(
					SECTOR['tables']['shop'] +
						'|' +
						SECTOR['tables']['comment'] +
						'|' +
						SECTOR['tables']['comment-photo'] +
						'|' +
						SECTOR['tables']['comment-video']
				)
		});
	}

	/* Ajax category main */
	if ($('.select-category-main').length) {
		$('body').on('change', '.select-category-main', function () {
			var id = $(this).val();
			var main = $(this).data('main');
			var child = $(this).data('child');
			var level = parseInt($(this).data('level'));
			var table = $(this).data('table');
			var type = $(this).data('type');

			if ($('#' + child).length) {
				$.ajax({
					url: 'api/category.php',
					type: 'POST',
					data: {
						main: main,
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

			return false;
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
							$('#id_cat_shop').html(op);
							$('#id_item_shop').html(op);
							$('#id_sub_shop').html(op);
						} else if (level == 1) {
							$('#id_item_shop').html(op);
							$('#id_sub_shop').html(op);
						} else if (level == 2) {
							$('#id_sub_shop').html(op);
						}
						$('#' + child).html(result);
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
			confirmDialog('delete-item', 'Bạn có chắc muốn xóa mục này ?', url);
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

	/* Change status shop */
	if ($('.show-checkbox-shop').length) {
		$('body').on('click', '.show-checkbox-shop', function () {
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var attr = $(this).attr('data-attr');
			var $this = $(this);

			$.ajax({
				url: 'api/status-shop.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id,
					table: table,
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
			afterSelect: function () {},
			onEmpty: function () {},
			onRemove: function () {}
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
			config.contentsCss = [BASE_SHOP_ADMIN + 'ckeditor/contents.css'];

			/* All Plugins */
			config.extraPlugins =
				'texttransform,copyformatting,html5video,html5audio,flash,youtube,wordcount,tableresize,widget,lineutils,clipboard,dialog,dialogui,widgetselection,lineheight,video,videodetector';

			/* Config Lineheight */
			config.line_height = '1;1.1;1.2;1.3;1.4;1.5;2;2.5;3;3.5;4;4.5;5';

			/* Config Word */
			config.pasteFromWordRemoveFontStyles = false;
			config.pasteFromWordRemoveStyles = false;

			/* Config CKFinder - ELFinder */
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/)) {
				var folderCkfinder = PHP_VERSION >= 8 ? 'ckfinder8' : 'ckfinder7';
				config.filebrowserBrowseUrl = folderCkfinder + '/ckfinder.html?token=' + TOKEN_SHOP;
				config.filebrowserUploadUrl =
					folderCkfinder +
					'/core/connector/php/connector.php?command=QuickUpload&type=Files&token=' +
					TOKEN_SHOP;
			} else {
				config.filebrowserBrowseUrl = 'elfinder/index.php?token=' + TOKEN_SHOP;
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
