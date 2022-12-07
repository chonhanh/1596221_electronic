/* sectors scroll */
NN_FRAMEWORK.sectorsScroll = function () {
	if (isExist($('.sector-scroll'))) {
		$('.sector-scroll').mCustomScrollbar({
			axis: 'x',
			advanced: {
				autoExpandHorizontalScroll: true
			}
		});
	}
};

/* Sectors active scroll */
NN_FRAMEWORK.sectorsActiveScroll = function () {
	if (isExist($('.sector-scroll-items')) && isExist($('.sectors-item.active'))) {
		$('.sector-scroll-items').mCustomScrollbar('scrollTo', '.sectors-item.active');
	}
	if (isExist($('.sector-scroll-subs')) && isExist($('.sectors-sub.active'))) {
		$('.sector-scroll-subs').mCustomScrollbar('scrollTo', '.sectors-sub.active');
	}
};

/* Pagings */
NN_FRAMEWORK.Pagings = function () {
	if (isExist($('.paging-product'))) {
		loadPaging('api/product.php?perpage=12', '.paging-product', '.block-product');
	}
};

/* Onload */
$(window).on('load', function () {
	setTimeout(function () {
		NN_FRAMEWORK.sectorsScroll();
	}, 200);

	setTimeout(function () {
		NN_FRAMEWORK.sectorsActiveScroll();
	}, 500);
});

/* Pagings */
NN_FRAMEWORK.Pagings = function () {
	if (isExist($('.paging-product'))) {
		$('.paging-product').each(function () {
			loadPaging('api/product.php?perpage=12', '.paging-product', '.block-product');
		});
	}
};
NN_FRAMEWORK.Sectors = function () {
	/* Main */

	if (isExist($('.sectors-by-list'))) {	
		$('body').on('click', '.sectors-by-list,.btn-back-sectors-cat', function () {
			$this = $(this);
			var active = (href = str = '');
			var idList = $this.attr('data-id');
			var nameList = $this.attr('data-name');
			// var slugList = $this.attr('data-slug');
			var slugList = '';
			var back = $this.attr('data-back');

			/* Read json */
			$.ajax({
				dataType: 'json',
				url: PATH_JSON + 'sector-cats-' + idList + '.json?v=' + stringRandom(5),
				async: false,
				beforeSend: function () {
					holdonOpen();
				},
				success: function (data) {
					/* Button back */
					// str += '<div class="col-12 mb-3">';
					// str +=
					// 	'<a class="btn btn-back btn-back-sectors-list btn-sm btn-primary"  data-back="true" href="javascript:void(0)" title="Quay lại"><i class="fas fa-chevron-left"></i><span>Quay lại</span></a>';
					// str += '</div>';

					/* Merge data */
					for (var i = 0; i < data.length; i++) {
						/* Active */
						active =  '';

						/* Href */
						href = slugList + '?cat=' + data[i]['id'];

						str += '<div class="col-2 mb-3">';
						str += '<div class="sectors sectors-cat" data-name="' +
							data[i]['name' + LANG_MAIN] +
							'" data-slug="' +
							data[i]['slug' + LANG_MAIN] +
							'" data-id="' +
							data[i]['id'] +
							'">';
						str +=
							'<a class="sectors-image scale-img rounded-circle mb-3" href="javascript:void(0)" title="' +
							data[i]['name' + LANG_MAIN] +
							'">';
						str +=
							'<img class="w-100 rounded-circle" onerror="this.src=\'' +
							ASSET +
							THUMBS +
							'/300x300x2/assets/images/noimage.png\'" src="' +
							ASSET +
							THUMBS +
							'/300x300x2/' +
							UPLOAD_PRODUCT_L +
							data[i]['photo'] +
							'" alt="' +
							data[i]['name' + LANG_MAIN] +
							'"/>';
						str += '</a>';
						str +=
							'<h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">';
						str +=
							'<a class="text-decoration-none text-primary-hover ' +
							active +
							' text-uppercase transition" href="javascript:void(0)" title="' +
							data[i]['name' + LANG_MAIN] +
							'">' +
							data[i]['name' + LANG_MAIN] +
							'</a>';
						str += '</h3>';
						str += '</div>';
						str += '</div>';
					}

					if (str) {
						if (back) {
							changeModal('#modal-sectors', 'Danh mục ' + nameList, str);
						} else {
							showModal('#modal-sectors', 'w-dialog-1190', 'Danh mục ' + nameList, str);
						}
					} else {
						notifyDialog('Không tìm thấy dữ liệu');
					}


					/* Holdon close */
					holdonClose();
				},
				error: function () {
					notifyDialog('Không tìm thấy dữ liệu');
					holdonClose();
				}
			});

			return false;
		});
		$('body').on('click', '.sectors-cat', function () {
			$this = $(this);
			var active = (href = str = '');
			var idCat = $this.attr('data-id');
			var nameCat = $this.attr('data-name');
			var slugCat = $this.attr('data-slug');
			var back = $this.attr('data-back');

			/* Read json */
			$.ajax({
				dataType: 'json',
				url: PATH_JSON + 'sector-items-' + idCat + '.json?v=' + stringRandom(5),
				async: false,
				beforeSend: function () {
					holdonOpen();
				},
				success: function (data) {
					/* Button back */
					str += '<div class="col-12 pos-relative">';
					str +=
						'<a class="btn-back btn-back-sectors-cat text-decoration-none" data-id = "' + 
						SECTOR['id'] + '" data-name = "' + 
						SECTOR['name'] + '" data-slug = "' + 
						SECTOR['type'] + 
						'" data-back="true" href="javascript:void(0)" title="Quay lại"><i class="fas fa-chevron-left"></i><span>Trở lại</span></a>';
					str += '</div>';

					/* Merge data */
					for (var i = 0; i < data.length; i++) {
						/* Active */
						active = ID_ITEM && ID_ITEM == data[i]['id'] ? 'active' : '';

						/* Href */
						href = SECTOR['type'] + '?cat='+ idCat +'&item=' + data[i]['id'];

						str += '<div class="col-2 mb-3">';
						str += '<div class="sectors sectors-item" data-name="' +
							data[i]['name' + LANG_MAIN] +
							'" data-slug="' +
							data[i]['slug' + LANG_MAIN] +
							'" data-id="' +
							data[i]['id'] +
							'">';
						str +=
							'<a class="sectors-image scale-img mb-3" href="' + href + '" title="' +
							data[i]['name' + LANG_MAIN] +
							'">';
						str +=
							'<img class="w-100" onerror="this.src=\'' +
							ASSET +
							THUMBS +
							'/315x230x2/assets/images/noimage.png\'" src="' +
							ASSET +
							THUMBS +
							'/315x230x2/' +
							UPLOAD_PRODUCT_L +
							data[i]['photo'] +
							'" alt="' +
							data[i]['name' + LANG_MAIN] +
							'"/>';
						str += '</a>';
						str +=
							'<h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">';
						str +=
							'<a class="text-decoration-none text-primary-hover ' +
							active +
							' text-uppercase transition" href="' + href + '" title="' +
							data[i]['name' + LANG_MAIN] +
							'">' +
							data[i]['name' + LANG_MAIN] +
							'</a>';
						str += '</h3>';
						str += '</div>';
						str += '</div>';
					}

					if (str) {
						if (back) {
							changeModal('#modal-sectors', 'Danh mục ' + nameCat, str);
						} else {
							showModal('#modal-sectors', 'w-dialog-1190', 'Danh mục ' + nameCat, str);
						}
					} else {
						notifyDialog('Không tìm thấy dữ liệu');
					}

					/* Holdon close */
					holdonClose();
				},
				error: function () {
					notifyDialog('Không tìm thấy dữ liệu');
					holdonClose();
				}
			});

			return false;
		});
	}

	/* Load more */
	if (isExist($('.load-more-button#sector'))) {
		$('.load-more-button#sector').click(function () {
			$this = $(this);
			$sectorContent = $this.parents('.sectors-content');
			$loadControl = $this.parents('.load-more-control#sector');
			$loadSector = $sectorContent.find('.sector-group-cat-loader').attr('id');
			$loadResult = $sectorContent.find('.sector-group-cat-loader#' + $loadSector).find('.row');
			var idList = $loadControl.find('.id-list').val();
			var limitFrom = $loadControl.find('.limit-from').val();
			var limitGet = $loadControl.find('.limit-get').val();

			$.ajax({
				url: 'api/group-cat.php',
				type: 'POST',
				dataType: 'json',
				async: false,
				data: {
					idList: idList,
					limitFrom: limitFrom,
					limitGet: limitGet
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (result.error) {
						showNotify('Dữ liệu không hợp lệ', 'Thông báo', 'error');
					} else if (result.html) {
						$loadResult.append(result.html);
						$loadControl.find('.limit-from').val(parseInt(limitFrom) + parseInt(limitGet));
						NN_FRAMEWORK.Lazys();
					}
				}
			}).done(function (result) {
				if (!result.error) {
					var listsLoaded = $loadResult.find('[class*=col-]').length;

					if (parseInt(listsLoaded) == parseInt(result.all)) {
						$this.parents('.load-more-control#sector').remove();
					}
				}

				holdonClose();
			});
		});
	}
};
NN_FRAMEWORK.checkExcute = function () {

	/* Shop */
	if (isExist($('.go-shop'))) {
		$('.go-shop').click(function () {
			var URL_REDIRECT =
				CONFIG_BASE + 'dang-ky-gian-hang?sector=' + SECTOR['id'];

			if (!IS_LOGIN) {
				redirectDialog(
					'Vui lòng đăng nhập để đăng ký gian hàng',
					URL_LOGIN + '?back=' + URL_REDIRECT,
					'Đăng nhập'
				);
			} else {
				window.open(URL_REDIRECT, '_self');
			}

			return false;
		});
	}

	/* Posting */
	if (isExist($('.go-posting'))) {
		$('.go-posting').click(function () {
			var URL_REDIRECT = CONFIG_BASE + 'dang-tin?sector=' + SHOP_INFO['id_list'];
			var LISTS_SECTOR_CAT = '';

			/* Check exist CAT */
			if (SECTOR_CAT) {
				LISTS_SECTOR_CAT += '<div class="form-row">';

				for (var i = 0; i < SECTOR_CAT.length; i++) {
					LISTS_SECTOR_CAT +=
						'<div class="col-6 mb-3"><a class="btn btn-sm btn-primary text-center text-capitalize w-100 py-2 px-3" href="' +
						URL_REDIRECT +
						'&cat=' +
						SECTOR_CAT[i]['id'] +
						'" title="' +
						SECTOR_CAT[i]['name' + LANG_MAIN] +
						'">' +
						SECTOR_CAT[i]['name' + LANG_MAIN] +
						'</a></div>';
				}

				LISTS_SECTOR_CAT += '</div>';
			}

			/* Check exist CAT and Is Login */
	
			showModal(
				'#modal-sector-posting',
				'w-dialog-630',
				'Vui lòng chọn lĩnh vực để đăng tin',
				LISTS_SECTOR_CAT,
				true
			);

			if (!IS_LOGIN) {
				redirectDialog('Vui lòng đăng nhập để đăng tin', URL_LOGIN + '?back=' + URL_REDIRECT, 'Đăng nhập');
			} else {
				window.open(URL_REDIRECT, '_self');
			}

			return false;
		});
	}

	/* New posting */
	if (isExist($('.show-new-posting'))) {
		$('.show-new-posting').click(function () {
			if (IS_LOGIN) {
				NN_FRAMEWORK.newPosting();
			} else {
				redirectDialog(
					'Vui lòng đăng nhập để đăng ký nhận tin mới',
					URL_LOGIN + '?back=' + URL_CURRENT,
					'Đăng nhập'
				);
			}

			return false;
		});
	}

	/* Report */
	if (isExist($('.show-report'))) {
		$('.show-report').click(function () {
			if (IS_LOGIN) {
				showModal('#modal-report');
			} else {
				redirectDialog(
					'Vui lòng đăng nhập để báo xấu tin đăng',
					URL_LOGIN + '?back=' + URL_CURRENT,
					'Đăng nhập'
				);
			}

			return false;
		});
	}
};

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.checkExcute();
	NN_FRAMEWORK.Sectors();
	NN_FRAMEWORK.Pagings();
});
