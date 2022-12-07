/* Loader */
NN_FRAMEWORK.toggleClass = function () {
	if (isExist($('.bt_hide'))) {	
		$('body').on('click', '.bt_hide', function () {
			var cont = $(this).data('cont');
			$(this).toggleClass('act');
			$(cont).toggleClass('active');

		});
	}
};
/* Loader */
NN_FRAMEWORK.Loader = function () {
	if (isExist($('.loader-wrapper'))) {
		$('.loader-wrapper').fadeOut('medium');
	}
};

/* Lazys */
NN_FRAMEWORK.Lazys = function () {
	if (isExist($('.lazy'))) {
		var lazyLoadInstance = new LazyLoad({
			elements_selector: '.lazy'
		});
	}
};

/* Load name input file */
NN_FRAMEWORK.loadNameInputFile = function () {
	if (isExist($('.custom-file input[type=file]'))) {
		$('body').on('change', '.custom-file input[type=file]', function () {
			var fileName = $(this).val();
			fileName = fileName.substr(fileName.lastIndexOf('\\') + 1, fileName.length);
			$(this).siblings('label').html(fileName);
		});
	}
};

/* Back to top */
NN_FRAMEWORK.GoTop = function () {
	$(window).scroll(function () {
		if (!$('.scrollToTop').length)
			$('body').append(
				'<div class="scrollToTop transition"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fafafa" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="6 15 12 9 18 15" /></svg></div>'
			);
		if ($(this).scrollTop() > 100) $('.scrollToTop').fadeIn();
		else $('.scrollToTop').fadeOut();
	});

	$('body').on('click', '.scrollToTop', function () {
		$('html, body').animate({ scrollTop: 0 }, 800);
		return false;
	});
};

/* Alt images */
NN_FRAMEWORK.AltImg = function () {
	$('img').each(function (index, element) {
		if (!$(this).attr('alt') || $(this).attr('alt') == '') {
			$(this).attr('alt', WEBSITE_NAME);
		}
	});
};

/* Tooltips */
NN_FRAMEWORK.toolTips = function () {
	if (isExist($('[data-plugin="tooltip"]'))) {
		$('[data-plugin="tooltip"]').tooltip();
	}
};

/* Status */
NN_FRAMEWORK.Status = function () {
	if (isExist($('#modal-status'))) {
		showModal('#modal-status');
	}
};

/* Captcha */
NN_FRAMEWORK.Captcha = function () {
	if (isExist($('.captcha-image'))) {
		$('.captcha-reload').click(function () {
			createCaptcha($(this));
		});
	}
};

/* Subscribe */
NN_FRAMEWORK.Subscribe = function () {
	if (isExist($('.subscribe-button'))) {
		$('.subscribe-button').click(function () {
			$this = $(this);

			if (IS_LOGIN) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'api/subscribe.php',
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						if (result.isSubscribe == true) {
							$this.toggleClass('btn-danger btn-primary');
							$this.attr('title', 'Đã quan tâm');
							$this.text('Đã quan tâm');
						} else if (result.isSubscribe == false) {
							$this.toggleClass('btn-danger btn-primary');
							$this.attr('title', 'Quan tâm trang');
							$this.text('Quan tâm trang');
						}

						/* Show notify */
						showNotify(result.message, 'Thông báo', result.status);

						holdonClose();
					}
				});
			} else {
				redirectDialog('Vui lòng đăng nhập để quan tâm trang', URL_LOGIN + '?back=' + URL_CURRENT, 'Đăng nhập');
			}

			return false;
		});
	}
};

/* Rating */
NN_FRAMEWORK.Rating = function () {
	if (isExist($('#star-rating'))) {
		/* Encryted shop info */
		var keyStore = btoa(SHOP_INFO['id'] + '-' + SHOP_INFO['slug_url'] + '-' + SHOP_INFO['sector-prefix']);
		var valueStore = btoa(keyStore);

		/* Get local store shop */
		var retrieveStore = getLocalStore(keyStore);

		/* Load rating */
		$('#star-rating').starRating({
			totalStars: 5,
			initialRating: RATING_SCORE,
			strokeColor: '#ffac3d',
			emptyColor: 'lightgray',
			hoverColor: '#ffac3d',
			activeColor: '#ffac3d',
			strokeWidth: 10,
			starSize: 20,
			minRating: 1,
			useFullStars: false,
			disableAfterRate: true,
			callback: function (score, $el) {
				if (valueStore != retrieveStore) {
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: 'api/rating.php',
						data: {
							score: score
						},
						beforeSend: function () {
							holdonOpen();
						},
						success: function (result) {
							if (result.status == 'success') {
								/* Set local store shop */
								setLocalStore(keyStore, valueStore);
							}

							/* Show notify */
							showNotify(result.message, 'Thông báo', result.status);

							holdonClose();
						}
					});
				} else {
					showNotify('Bạn đã đánh giá gian hàng này', 'Thông báo', 'warning');
				}
			}
		});
	}
};

/* Report */
NN_FRAMEWORK.Report = function () {
	if (isExist($('.report-status'))) {
		$('.report-status label').click(function () {
			$this = $(this);
			var formReport = $this.parents('#form-report');
			var text = $this.find('#report-status-text').html();
			formReport.find('textarea#content-report').attr('placeholder', text);
		});
	}
};

/* Chat */
NN_FRAMEWORK.Chat = function () {
	if (isExist($('#chat-file-photo'))) {
		$('#chat-file-photo').getEvali({
			limit: 2,
			maxSize: 10,
			extensions: ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG', 'Png'],
			editor: false,
			addMore: true,
			enableApi: false,
			dragDrop: true,
			changeInput:
				'<div class="chat-fileuploader">' +
				'<div class="chat-fileuploader-caption"><strong>${captions.feedback}</strong></div>' +
				'<div class="chat-fileuploader-text mx-3">${captions.or}</div>' +
				'<div class="chat-fileuploader-button btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3">${captions.button}</div>' +
				'</div>',
			theme: 'dragdrop',
			captions: {
				feedback: '(Kéo thả ảnh vào đây)',
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
						type: 'orange',
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
								text: 'Đồng ý',
								btnClass: 'btn-sm btn-warning',
								action: function () {
									t();
								}
							},
							cancel: {
								text: 'Hủy',
								btnClass: 'btn-sm btn-danger'
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
};

/* Check excute */
NN_FRAMEWORK.checkExcute = function () {
	/* Login */
	if (isExist($('.go-login'))) {
		$('.go-login').click(function () {
			location.href = URL_LOGIN + '?back=' + URL_CURRENT;
		});
	}

	/* Chat */
	if (isExist($('.show-chat'))) {
		$('.show-chat').click(function () {
			if (IS_LOGIN) {
				showModal('#modal-chat');
			} else {
				redirectDialog('Vui lòng đăng nhập để trò chuyện', URL_LOGIN + '?back=' + URL_CURRENT, 'Đăng nhập');
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

/* Owl Data */
NN_FRAMEWORK.OwlData = function (obj) {
	if (!isExist(obj)) return false;
	var items = obj.attr('data-items');
	var rewind = Number(obj.attr('data-rewind')) ? true : false;
	var autoplay = Number(obj.attr('data-autoplay')) ? true : false;
	var loop = Number(obj.attr('data-loop')) ? true : false;
	var lazyLoad = Number(obj.attr('data-lazyload')) ? true : false;
	var mouseDrag = Number(obj.attr('data-mousedrag')) ? true : false;
	var touchDrag = Number(obj.attr('data-touchdrag')) ? true : false;
	var animations = obj.attr('data-animations') || false;
	var smartSpeed = Number(obj.attr('data-smartspeed')) || 800;
	var autoplaySpeed = Number(obj.attr('data-autoplayspeed')) || 800;
	var autoplayTimeout = Number(obj.attr('data-autoplaytimeout')) || 5000;
	var dots = Number(obj.attr('data-dots')) ? true : false;
	var responsive = {};
	var responsiveClass = true;
	var responsiveRefreshRate = 200;
	var nav = Number(obj.attr('data-nav')) ? true : false;
	var navContainer = obj.attr('data-navcontainer') || false;
	var navTextTemp =
		"<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>";
	var navText = obj.attr('data-navtext');
	navText =
		nav &&
		navContainer &&
		(((navText === undefined || Number(navText)) && navTextTemp) ||
			(isNaN(Number(navText)) && navText) ||
			(Number(navText) === 0 && false));

	if (items) {
		items = items.split(',');

		if (items.length) {
			var itemsCount = items.length;

			for (var i = 0; i < itemsCount; i++) {
				var options = items[i].split('|'),
					optionsCount = options.length,
					responsiveKey;

				for (var j = 0; j < optionsCount; j++) {
					const attr = options[j].indexOf(':') ? options[j].split(':') : options[j];

					if (attr[0] === 'screen') {
						responsiveKey = Number(attr[1]);
					} else if (Number(responsiveKey) >= 0) {
						responsive[responsiveKey] = {
							...responsive[responsiveKey],
							[attr[0]]: (isNumeric(attr[1]) && Number(attr[1])) ?? attr[1]
						};
					}
				}
			}
		}
	}

	if (nav && navText) {
		navText = navText.indexOf('|') > 0 ? navText.split('|') : navText.split(':');
		navText = [navText[0], navText[1]];
	}

	obj.owlCarousel({
		rewind,
		autoplay,
		loop,
		lazyLoad,
		mouseDrag,
		touchDrag,
		smartSpeed,
		autoplaySpeed,
		autoplayTimeout,
		dots,
		nav,
		navText,
		navContainer: nav && navText && navContainer,
		responsiveClass,
		responsiveRefreshRate,
		responsive
	});

	if (autoplay) {
		obj.on('translate.owl.carousel', function (event) {
			obj.trigger('stop.owl.autoplay');
		});

		obj.on('translated.owl.carousel', function (event) {
			obj.trigger('play.owl.autoplay', [autoplayTimeout]);
		});
	}

	if (animations && isExist(obj.find('[owl-item-animation]'))) {
		var animation_now = '';
		var animation_count = 0;
		var animations_excuted = [];
		var animations_list = animations.indexOf(',') ? animations.split(',') : animations;

		obj.on('changed.owl.carousel', function (event) {
			$(this).find('.owl-item.active').find('[owl-item-animation]').removeClass(animation_now);
		});

		obj.on('translate.owl.carousel', function (event) {
			var item = event.item.index;

			if (Array.isArray(animations_list)) {
				var animation_trim = animations_list[animation_count].trim();

				if (!animations_excuted.includes(animation_trim)) {
					animation_now = 'animate__animated ' + animation_trim;
					animations_excuted.push(animation_trim);
					animation_count++;
				}

				if (animations_excuted.length == animations_list.length) {
					animation_count = 0;
					animations_excuted = [];
				}
			} else {
				animation_now = 'animate__animated ' + animations_list.trim();
			}
			$(this).find('.owl-item').eq(item).find('[owl-item-animation]').addClass(animation_now);
		});
	}
};

/* Owl Page */
NN_FRAMEWORK.OwlPage = function () {
	if (isExist($('.owl-page'))) {
		$('.owl-page').each(function () {
			NN_FRAMEWORK.OwlData($(this));
		});
	}
};

/* Onload */
$(window).on('load', function () {
	setTimeout(function () {
		NN_FRAMEWORK.Loader();
	}, 300);
});

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Lazys();
	NN_FRAMEWORK.Status();
	NN_FRAMEWORK.Captcha();
	NN_FRAMEWORK.Report();
	NN_FRAMEWORK.OwlPage();
	NN_FRAMEWORK.GoTop();
	NN_FRAMEWORK.AltImg();
	NN_FRAMEWORK.toolTips();
	NN_FRAMEWORK.Subscribe();
	NN_FRAMEWORK.Rating();
	NN_FRAMEWORK.Chat();
	NN_FRAMEWORK.checkExcute();
	NN_FRAMEWORK.loadNameInputFile();
	NN_FRAMEWORK.toggleClass();
});
