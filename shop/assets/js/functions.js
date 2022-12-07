function notifyDialog(content = '', title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'orange') {
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
				text: 'Đồng ý',
				btnClass: 'btn-sm btn-warning'
			}
		}
	});
}

function redirectDialog(
	content = '',
	url = '',
	titleAction = '',
	title = 'Thông báo',
	icon = 'fas fa-exclamation-triangle',
	type = 'orange'
) {
	if (url) {
		$.confirm({
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
			autoClose: 'cancel|3000',
			escapeKey: 'cancel',
			buttons: {
				success: {
					text: titleAction ? titleAction : 'Đồng ý',
					btnClass: 'btn-sm btn-warning',
					action: function () {
						location.href = url;
					}
				},
				cancel: {
					text: 'Hủy',
					btnClass: 'btn-sm btn-danger'
				}
			}
		});
	}
	return false;
}

function setLocalStore(key, value) {
	localStorage.setItem(key, value);
}

function getLocalStore(key) {
	return localStorage.getItem(key);
}

function showModal(modal, size, label, data, clear) {
	if ($(modal).length) {
		if (size) {
			$(modal).find('.modal-dialog').addClass(size);
		}

		if (label) {
			$(modal).find('.modal-title').html(label);
		}

		if (data) {
			$(modal).find('.modal-body .modal-data').html(data);
		}

		$(modal).modal('show');

		if (clear) {
			$(modal).on('hidden.bs.modal', function (e) {
				$(modal).find('.modal-dialog').removeClass(size);
				$(modal).find('.modal-title').html('');
				$(modal).find('.modal-body .modal-data').html('');
			});
		}
	}
}

function generateCaptcha(action, id) {
	if (RECAPTCHA_ACTIVE && action && id && $('#' + id).length) {
		grecaptcha.execute(RECAPTCHA_SITEKEY, { action: action }).then(function (token) {
			var recaptchaResponse = document.getElementById(id);
			recaptchaResponse.value = token;
		});
	}
}

function createCaptcha(obj) {
	$parents = obj.parents('.captcha-image');
	$image = $parents.find('img');
	var type = obj.attr('data-type');
	var random = stringRandom(5);
	var encryptCode = btoa(type + '|reload|' + random);

	if (type) {
		$image.attr('src', CONFIG_BASE + 'captcha/' + encryptCode + '/');
	}
}

function doEnter(event, obj) {
	if (event.keyCode == 13 || event.which == 13) {
		if (obj == 'keyword-shop') {
			onSearchShop(obj);
		} else {
			onSearch(obj);
		}
	}
}

function onSearch(obj) {
	var keyword = $('#' + obj).val();
	var urlTemp = '';

	if (keyword == '') {
		notifyDialog(LANG['no_keywords']);
		return false;
	} else {
		if (obj == 'keyword-main') {
			window.open(CONFIG_BASE + 'tim-kiem?keyword=' + encodeURI(keyword), '_blank');
		} else {
			location.href = 'tim-kiem?keyword=' + encodeURI(keyword);
		}
	}
}

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

function loadPaging(url = '', eShow = '', parents = '') {
	if ($(eShow).length && url) {
		$.ajax({
			url: url,
			type: 'GET',
			data: {
				eShow: eShow
			},
			success: function (result) {
				$(eShow).html(result);
				NN_FRAMEWORK.Lazys();

				if (parents && isExist($(eShow).parents(parents).find('.alert.alert-warning'))) {
					$(eShow).parents(parents).remove();
				}
			}
		});
	}
}

function loadDistrict(id = 0) {
	$.ajax({
		type: 'post',
		url: 'api/district.php',
		async: false,
		data: {
			id_city: id
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			$('.select-district').html(result);
			$('.select-wards').html('<option value="">' + LANG['wards'] + '</option>');
			holdonClose();
		}
	});
}

function loadWards(id = 0) {
	$.ajax({
		type: 'post',
		url: 'api/wards.php',
		async: false,
		data: {
			id_district: id
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			$('.select-wards').html(result);
			holdonClose();
		}
	});
}
