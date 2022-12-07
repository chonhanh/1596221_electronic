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

/* Confirm */
function confirmDialog(
	action,
	text,
	value,
	title = 'Thông báo',
	icon = 'fas fa-exclamation-triangle',
	type = 'orange'
) {
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
				text: 'Đồng ý',
				btnClass: 'btn-sm btn-warning',
				action: function () {
					if (action == 'delete-shop') deleteShop(value);
					if (action == 'delete-posting') deletePosting(value);
					if (action == 'delete-mails') deleteMails(value);
					if (action == 'delete-groupcart') deleteGroupCart(value);
					if (action == 'delete-procart') deleteCart(value);
					if (action == 'cancel-order') cancelOrder(value);
				}
			},
			cancel: {
				text: 'Hủy',
				btnClass: 'btn-sm btn-danger'
			}
		}
	});
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
		if (obj.indexOf('keyword-shop') >= 0) {
			onSearchShop(obj);
		} else if (obj == 'keyword-video-shop' || obj == 'keyword-video') {
			onSearchVideo(obj);
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
		urlTemp += SECTOR['id']
			? 'sector=' + SECTOR['id'] + '&keyword=' + encodeURI(keyword)
			: 'keyword=' + encodeURI(keyword);
		location.href = 'tim-kiem?' + urlTemp;
	}
}

function onSearchVideo(obj) {
	if (obj.indexOf('-video-shop') > 0) {
		obj = obj.replace('-video-shop', '');
		var keyword = $('.video-search-shop')
			.find('#' + obj)
			.val();
		var urlTemp = 'tim-kiem-cua-hang-video';
	}

	if (keyword == '') {
		notifyDialog(LANG['no_keywords']);
		return false;
	} else {
		urlTemp += '?sector=' + SECTOR['id'] + '&keyword=' + encodeURI(keyword);
		location.href = urlTemp;
	}
}

function onSearchShop(obj) {
	var urlTemp = '';
	var keyword = '';
	var urlFilter = '';

	if (obj.indexOf('|') > 0) {
		obj = obj.split('|');
		keyword = $('#' + obj[0] + '-' + obj[1]).val();
		urlFilter = CONFIG_BASE + 'tim-kiem-cua-hang?sector=' + obj[1];
	} else {
		keyword = $('#' + obj).val();
		urlFilter = URL_CURRENT_ORIGIN + '?sector=' + SECTOR['id'];
	}

	if (keyword == '') {
		notifyDialog(LANG['no_keywords']);
		return false;
	} else {
		if (ID_CITY) urlTemp += '&city=' + ID_CITY;
		if (ID_DISTRICT) urlTemp += '&district=' + ID_DISTRICT;
		if (keyword) urlTemp += '&keyword=' + encodeURI(keyword);

		location.href = urlTemp ? urlFilter + urlTemp : urlFilter;
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

function changeModal(modal, label, data, clear) {
	if ($(modal).length) {
		if (label) {
			$(modal).find('.modal-title').html(label);
		}

		if (data) {
			$(modal).find('.modal-body .modal-data').html(data);
		}

		if (clear) {
			$(modal).on('hidden.bs.modal', function (e) {
				$(modal).find('.modal-title').html('');
				$(modal).find('.modal-body .modal-data').html('');
			});
		}
	}
}


function initVideoJs(element, poster) {
	if (isExist(element)) {
		var player = videojs(element, {
			width: '100%',
			controls: true,
			autoplay: true,
			poster: poster,
			fluid: true,
			fill: true,
			controlBar: {
				fullscreenToggle: true,
				liveDisplay: true,
				pictureInPictureToggle: true
			},
			userActions: {
				doubleClick: true
			},
			responsive: true,
			preload: 'auto',
			aspectRatio: '16:9'
		});

		/* Disabled right click on video js */
		$('#' + element).bind('contextmenu', function (e) {
			return false;
		});
	}
}

function destroyVideoJs(element) {
	var player = document.getElementById(element);

	if (player) {
		videojs(player).dispose();
	}
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

function updateCart(groupCode = '', code = '', quantity = 1) {
	var formCart = $('#form-cart');

	$.ajax({
		type: 'POST',
		url: 'api/cart.php',
		dataType: 'json',
		data: {
			cmd: 'update-cart',
			groupCode: groupCode,
			code: code,
			quantity: quantity
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			if (result.error) {
				showNotify('Dữ liệu không hợp lệ', 'Thông báo', 'error');

				setTimeout(function () {
					location.reload();
				}, 1000);
			} else if (result.warning) {
				showNotify('Vui lòng đăng nhập để tiếp tục', 'Thông báo', 'warning');

				setTimeout(function () {
					window.open(CONFIG_BASE + 'gio-hang', '_self');
				}, 2000);
			} else {
				formCart
					.find('.load-price-' + code)
					.find('strong')
					.html(result.realPrice);
				formCart.find('.load-price-total').html(result.totalText);
			}

			holdonClose();
		}
	});
}

function cancelOrder(obj) {
	var parents = obj.parents('#form-order-account');
	parents.find('input[name="actionOrder"]').val(obj.val());
	parents.submit();
}

function deleteGroupCart(obj) {
	var formCart = $('#form-cart');
	var groupCode = obj.attr('data-group-code');

	$.ajax({
		type: 'POST',
		url: 'api/cart.php',
		dataType: 'json',
		data: {
			cmd: 'delete-group-cart',
			groupCode: groupCode
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			if (result.error) {
				showNotify('Dữ liệu không hợp lệ', 'Thông báo', 'error');

				setTimeout(function () {
					location.reload();
				}, 1000);
			} else if (result.warning) {
				showNotify('Vui lòng đăng nhập để tiếp tục', 'Thông báo', 'warning');

				setTimeout(function () {
					window.open(CONFIG_BASE + 'gio-hang', '_self');
				}, 2000);
			} else if (result.max) {
				formCart.find('.load-price-total').html(result.totalText);
				formCart.find('.group-cart-' + groupCode).remove();
			} else {
				formCart.html(EMPTY_CART);
			}

			holdonClose();
		}
	});
}

function deleteCart(obj) {
	var formCart = $('#form-cart');
	var code = obj.attr('data-code');
	var groupCode = obj.attr('data-group-code');

	$.ajax({
		type: 'POST',
		url: 'api/cart.php',
		dataType: 'json',
		data: {
			cmd: 'delete-cart',
			groupCode: groupCode,
			code: code
		},
		beforeSend: function () {
			holdonOpen();
		},
		success: function (result) {
			if (result.error) {
				showNotify('Dữ liệu không hợp lệ', 'Thông báo', 'error');

				setTimeout(function () {
					location.reload();
				}, 1000);
			} else if (result.warning) {
				showNotify('Vui lòng đăng nhập để tiếp tục', 'Thông báo', 'warning');

				setTimeout(function () {
					window.open(CONFIG_BASE + 'gio-hang', '_self');
				}, 2000);
			} else if (result.max) {
				formCart.find('.load-price-total').html(result.totalText);

				if (result.emptyGroup) {
					formCart.find('.group-cart-' + groupCode).remove();
				} else {
					formCart.find('.procart-' + code).remove();
				}
			} else {
				formCart.html(EMPTY_CART);
			}

			holdonClose();
		}
	});
}

function deleteMails(obj) {
	$this = obj;
	var parents = $this.parents('.card-mails');
	var id = $this.data('id');

	if (id) {
		$.ajax({
			type: 'POST',
			url: 'api/mails.php',
			data: {
				cmd: 'delete',
				id: id
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				parents.remove();
				showNotify('Xóa thành công');
				holdonClose();
			}
		});
	}
}

function deleteShop(obj) {
	if (obj.length) {
		$this = obj;
		var type = $this.data('type');
		var id = $this.data('id');
		var name = $this.data('name');

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: 'api/shop.php',
			async: false,
			data: {
				cmd: 'delete-shop',
				type: type,
				id: id
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				if (result.failed) {
					showNotify('Thất bại. Vui lòng thử lại sau', 'Thông báo', 'error');
				} else if (result.success) {
					$this.parents('.col-shop-account').remove();

					showNotify('Đã xóa ' + name + ' thành công');

					setTimeout(function () {
						location.reload();
					}, 1000);
				}

				holdonClose();
			}
		});
	}

	return false;
}

function deletePosting(obj) {
	if (obj.length) {
		$this = obj;
		var type = $this.data('type');
		var id = $this.data('id');
		var name = $this.data('name');

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: 'api/posting.php',
			async: false,
			data: {
				type: type,
				id: id
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				if (result.failed) {
					showNotify('Thất bại. Vui lòng thử lại sau', 'Thông báo', 'error');
				} else if (result.success) {
					$this.parents('.col-product-account').remove();

					showNotify('Đã xóa ' + name + ' thành công');

					setTimeout(function () {
						location.reload();
					}, 1000);
				}

				holdonClose();
			}
		});
	}

	return false;
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

function loadCategory(obj) {
	if (obj.length) {
		var id = obj.val();
		var child = obj.data('child');
		var level = parseInt(obj.data('level'));
		var table = obj.data('table');

		if ($('#' + child).length) {
			$.ajax({
				url: 'api/category.php',
				type: 'POST',
				async: false,
				data: {
					level: level,
					id: id,
					idCat: ID_CAT,
					table: table
				},
				beforeSend: function () {
					holdonOpen();
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

					holdonClose();
				}
			});
		}
	}

	return false;
}

function loadStore(obj) {
	if (obj.length) {
		var id_cat = obj.val();

		$.ajax({
			url: 'api/store.php',
			type: 'POST',
			async: false,
			data: {
				id_list: SECTOR['id'],
				id_cat: id_cat
			},
			beforeSend: function () {
				holdonOpen();
			},
			success: function (result) {
				$('#id_store').html(result);
				holdonClose();
			}
		});
	}

	return false;
}

function checkAccount(obj, type, tbl) {
	if (obj.length) {
		var flag ;
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
					id: 0
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
				
					flag = result;
				

					holdonClose();
				}
			});
		}
	}

	return flag;
}

function previewShop() {
	var shopConfirmPreview = TAB_SHOP_CONTENT.find('#shop-confirm');
	var name = TAB_SHOP_CONTENT.find('#shop-info').find('#name');
	var catPreview = TAB_SHOP_CONTENT.find('#shop-info').find('#id_cat').find('option:selected');
	var storePreview = TAB_SHOP_CONTENT.find('#shop-info').find('#id_store').find('option:selected');
	var cityPreview = TAB_SHOP_CONTENT.find('#shop-info').find('#id_city').find('option:selected');
	var districtPreview = TAB_SHOP_CONTENT.find('#shop-info').find('#id_district').find('option:selected');
	var wardsPreview = TAB_SHOP_CONTENT.find('#shop-info').find('#id_wards').find('option:selected');
	var interfaceChecked = TAB_SHOP_CONTENT.find('#shop-interface').find(".interface input[type='radio']:checked");
	var password = TAB_SHOP_CONTENT.find('#shop-info').find('#password');
	var phone = TAB_SHOP_CONTENT.find('#shop-info').find('#phone');
	var email = TAB_SHOP_CONTENT.find('#shop-info').find('#email');
	var urlPreview = changeTitle(name.val());
	urlPreview = urlPreview.replaceAll('-', '');

	holdonOpen();

	if (isExist(catPreview) && getLen(catPreview.val())) {
		shopConfirmPreview.find('#preview-cat').find('input').val(catPreview.text());
	}

	if (isExist(storePreview) && getLen(storePreview.val())) {
		shopConfirmPreview.find('#preview-store').find('input').val(storePreview.text());
	}

	if (isExist(cityPreview) && getLen(cityPreview.val())) {
		shopConfirmPreview.find('#preview-city').find('input').val(cityPreview.text());
	}

	if (isExist(districtPreview) && getLen(districtPreview.val())) {
		shopConfirmPreview.find('#preview-district').find('input').val(districtPreview.text());
	}

	if (isExist(wardsPreview) && getLen(wardsPreview.val())) {
		shopConfirmPreview.find('#preview-wards').find('input').val(wardsPreview.text());
	}

	if (isExist(name) && getLen(name.val())) {
		shopConfirmPreview.find('#preview-name').find('input').val(name.val());
	}

	if (isExist(password) && getLen(password.val())) {
		shopConfirmPreview.find('#preview-password').find('input').val(password.val());
	}

	if (isExist(phone) && getLen(phone.val())) {
		shopConfirmPreview.find('#preview-phone').find('input').val(phone.val());
	}

	if (isExist(email) && getLen(email.val())) {
		shopConfirmPreview.find('#preview-email').find('input').val(email.val());
	}

	if (isExist(interfaceChecked)) {
		var interfaceImg = interfaceChecked.parents('.interface').find('.interface-image').find('img');
		shopConfirmPreview.find('.avatar-label').addClass('w-auto');
		shopConfirmPreview.find('#preview-interface-shop').find('img').attr('src', interfaceImg.attr('src'));
	}

	if (isExist(urlPreview)) {
		shopConfirmPreview
			.find('#preview-url-shop')
			.find('input')
			.val(CONFIG_BASE + 'shop/' + urlPreview + '/');
		shopConfirmPreview
			.find('#preview-url-shop-admin')
			.find('input')
			.val(CONFIG_BASE + 'shop/' + urlPreview + '/admin/');
	}

	holdonClose();
}

function validShop(tabStep) {
	var flag = true;

	holdonOpen();

	// if (tabStep == 'shop-interface-tab') {
	// 	var interface = TAB_SHOP_CONTENT.find('#shop-interface').find('.interface').find("input[type='radio']:checked");

	// 	if (!isExist(interface)) {
	// 		notifyDialog('Chưa chọn giao diện gian hàng');
	// 		flag = false;
	// 	}
	// } else 
	if (tabStep == 'shop-info-tab') {
		var interface = TAB_SHOP_CONTENT.find('#shop-interface').find('.interface').find("input[type='radio']:checked");

		if (!isExist(interface)) {
			notifyDialog('Chưa chọn giao diện gian hàng');
			flag = false;
		}

		var cat = TAB_SHOP_CONTENT.find('#shop-info').find('#id_cat');
		var store = TAB_SHOP_CONTENT.find('#shop-info').find('#id_store');
		var city = TAB_SHOP_CONTENT.find('#shop-info').find('#id_city');
		var district = TAB_SHOP_CONTENT.find('#shop-info').find('#id_district');
		var wards = TAB_SHOP_CONTENT.find('#shop-info').find('#id_wards');
		var name = TAB_SHOP_CONTENT.find('#shop-info').find('#name');
		var username = TAB_SHOP_CONTENT.find('#shop-info').find('#username');
		var password = TAB_SHOP_CONTENT.find('#shop-info').find('#password');
		var repassword = TAB_SHOP_CONTENT.find('#shop-info').find('#repassword');
		var phone = TAB_SHOP_CONTENT.find('#shop-info').find('#phone');
		var email = TAB_SHOP_CONTENT.find('#shop-info').find('#email');
		var avatar = TAB_SHOP_CONTENT.find('#shop-info').find('#avatar-shop');
		var existName = checkShop(name, 'name');
		var restrictedName = checkShop(name, 'restricted');
		var existUsername = checkShop(username, 'username');
		var existEmail = checkShop(email, 'email');

		if (isExist(cat) && !cat.val()) {
			cat.focus();
			notifyDialog('Chưa chọn danh mục lĩnh vực');
			flag = false;
		} else if (isExist(store) && !store.val()) {
			store.focus();
			notifyDialog('Chưa chọn danh sách cửa hàng');
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
		} else if (isExist(wards) && !wards.val()) {
			wards.focus();
			notifyDialog('Chưa chọn phường/xã');
			flag = false;
		} else if (isExist(name) && !getLen(name.val())) {
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
		} else if (isExist(username) && !getLen(username.val())) {
			username.focus();
			notifyDialog('Tên đăng nhập không được trống');
			flag = false;
		} else if (isExist(username) && getLen(username.val()) > 50) {
			username.focus();
			notifyDialog('Tên đăng nhập không được vượt quá 50 ký tự');
			flag = false;
		}else if (isExist(username) && existUsername) {
			username.focus();
			notifyDialog('Tên đăng nhập đã tồn tại');
			flag = false;
		} else if (isExist(password) && !getLen(password.val())) {
			password.focus();
			notifyDialog('Mật khẩu không được trống');
			flag = false;
		} else if (isExist(repassword) && !getLen(repassword.val())) {
			repassword.focus();
			notifyDialog('Xác nhận mật khẩu không được trống');
			flag = false;
		} else if (!isMatch(password.val(), repassword.val())) {
			repassword.focus();
			notifyDialog('Mật khẩu không trùng khớp');
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
		} else if (isExist(email) && existEmail) {
			email.focus();
			notifyDialog('Email đã tồn tại');
			flag = false;
		} else if (isExist(avatar) && !getLen(avatar.val())) {
			notifyDialog('Hình đại diện không được trống');
			flag = false;
		}
	} else if (tabStep == 'shop-confirm-tab') {
		var captcha = TAB_SHOP_CONTENT.find('#shop-confirm').find('#captcha-shop');

		if (isExist(captcha) && !getLen(captcha.val())) {
			captcha.focus();
			notifyDialog('Mã bảo mật không được trống');
			flag = false;
		}
	}

	holdonClose();

	return flag;
}

function saveShop() {
	var formShopData = new FormData(FORM_SHOP[0]);
	var responseEle = FORM_SHOP.find('.response-shop');
	var captchaOBJ = FORM_SHOP.find('.captcha-image').find('.captcha-reload');

	responseEle.html('');
	holdonOpen();

	setTimeout(function () {
		$.ajax({
			url: CONFIG_BASE + 'dang-ky-gian-hang?sector=' + SECTOR['id'] + '&isAjaxShop=1',
			type: 'post',
			enctype: 'multipart/form-data',
			dataType: 'json',
			data: formShopData,
			async: false,
			processData: false,
			contentType: false,
			cache: false
		}).done(function (result) {
			if (result.status) {
				if (result.status == 'success') {
					TAB_SHOP_CONTENT
						.find('.response-shop, #shop-interface, #shop-info, #shop-confirm, .shop-control')
						.remove();
					TAB_SHOP_NAV.find('#shop-interface-tab, #shop-info-tab, #shop-confirm-tab').addClass('disabled');
					TAB_SHOP_NAV.find('li a#shop-complete-tab').removeClass('disabled');
					TAB_SHOP_NAV.find('li a#shop-complete-tab').tab('show');

					setTimeout(function () {
						// location.href = location.href;
						window.location = URL_BACK_SUCCCESS_SHOP;
					}, 5000);
				} else if (result.status == 'error') {
					responseEle.html('<div class="alert alert-danger">' + result.message + '</div>');
					goToByScroll('form-shop', 80);
				}

				createCaptcha(captchaOBJ);
			}

			holdonClose();
		});
	}, 500);
}

function prevShop(tabMove) {
	if (tabMove) {
		TAB_SHOP_CONTROL_NEXT.attr('value', 'Tiếp theo');
		TAB_SHOP_CONTROL_NEXT.html('<span>Tiếp theo</span><i class="fas fa-arrow-right ml-2"></i>');
		TAB_SHOP_CONTROL_NEXT.attr('data-now', tabMove);
		TAB_SHOP_NAV.find('li a#' + tabMove).tab('show');
	}
}

function nextShop(tabMove, isOrder) {
	if (tabMove) {
		if (isOrder) {
			if (tabMove == 'shop-interface-tab') {
				TAB_SHOP_NAV.find('li a#shop-interface-tab').removeClass('disabled');
				TAB_SHOP_NAV.find('li a#shop-interface-tab').tab('show');
			} else if (tabMove == 'shop-info-tab') {
				TAB_SHOP_NAV.find('li a#shop-info-tab').removeClass('disabled');
				TAB_SHOP_NAV.find('li a#shop-info-tab').tab('show');
			} else if (tabMove == 'shop-confirm-tab') {
				TAB_SHOP_NAV.find('li a#shop-confirm-tab').removeClass('disabled');
				TAB_SHOP_NAV.find('li a#shop-confirm-tab').tab('show');
			}
		} else {
			if (tabMove == 'shop-interface-tab') {
				TAB_SHOP_CONTROL_PREV.removeClass('d-none');
				TAB_SHOP_CONTROL_NEXT.attr('data-now', 'shop-info-tab');
				TAB_SHOP_NAV.find('li a#shop-info-tab').removeClass('disabled');
				TAB_SHOP_NAV.find('li a#shop-info-tab').tab('show');
			} else if (tabMove == 'shop-info-tab') {
				TAB_SHOP_CONTROL_NEXT.attr('data-now', 'shop-confirm-tab');
				TAB_SHOP_CONTROL_NEXT.attr('value', 'Xác nhận');
				TAB_SHOP_CONTROL_NEXT.html('<span>Xác nhận</span><i class="fas fa-check ml-2"></i>');
				TAB_SHOP_NAV.find('li a#shop-confirm-tab').removeClass('disabled');
				TAB_SHOP_NAV.find('li a#shop-confirm-tab').tab('show');
			}
		}
	}
}

function checkShop(obj, type) {
	if (obj.length) {
		var flag = true;
		var text = obj.val();

		if (getLen(text)) {
			$.ajax({
				url: 'api/shop.php',
				type: 'POST',
				async: false,
				data: {
					cmd: 'check-shop',
					text: text,
					type: type,
					id: 0
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
