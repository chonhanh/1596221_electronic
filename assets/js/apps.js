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
NN_FRAMEWORK.Boxscroll = function(){
	if (isExist($('.addPos'))) {
		var d_top = $(".addPos").height();
	    $(window).scroll(function(){

	        $(".addPos").each(function() {
	            // var d_top = $('#slider').offset().top + $('#slider').height();
	            // var d_top =   $(this).prev().offset().top+ $(this).prev().height();
	   
	            var w_offset = $(window).scrollTop(); 
	            if($(window).scrollTop()> d_top + 70) {
	            	$(this).find('.box-menu').hide();
	            	$(this).prev().css('min-height', d_top );
	                $(this).addClass('scroll-fix');     
	                $(this).removeClass('scroll-relative'); 
	            }else{
	            	$(this).find('.box-menu').show();
	            	$(this).prev().css('min-height', 0 );
	                $(this).removeClass('scroll-fix'); 
	                $(this).addClass('scroll-relative');     
	            }
	        });
	    });
	}
};
/* Loader */
NN_FRAMEWORK.Loader = function () {
	if (isExist($('.loader-wrapper'))) {
		$('.loader-wrapper').fadeOut('medium');
	}
};

/* Screen mix */
NN_FRAMEWORK.screenMix = function () {
	/* Main */
	if (isExist($('.main'))) {
		var obj = $('.main');
		var win = $(window).height();
		var header = $('.header').height();
		var footer = $('.footer').height();
		var other =
			parseFloat(obj.css('marginTop').replace('px', '')) + parseFloat(obj.css('marginBottom').replace('px', ''));
		var total = win - (header + other);// + footer
		obj.css({ minHeight: total + 'px' });
	}


	/* Chat */
	if (isExist($('.direct-chat-messages-scroll'))) {
		var obj = $('.direct-chat-messages-scroll');
		var sidebarNav = $('.sidebar-nav').height();
		obj.css({ height: sidebarNav + 'px' });
		obj.scrollTop(obj[0].scrollHeight);
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

/* barTools */
NN_FRAMEWORK.barTools = function () {
	if (isExist($('.block-bar'))) {
		const bar = $('.block-bar');
		const topPage = $('.header').height() + bar.height() + 20;
		const scrollUp = 'scroll-up';
		const scrollDown = 'scroll-down';
		let lastScroll = 0;

		window.addEventListener('scroll', () => {
			const currentScroll = window.pageYOffset;

			if (currentScroll <= 0) {
				bar.removeClass(scrollUp);
				return;
			}

			if (currentScroll > topPage) {
				if (currentScroll > lastScroll && !bar.hasClass(scrollDown)) {
					bar.removeClass(scrollUp);
					bar.addClass(scrollDown);
				} else if (currentScroll < lastScroll && bar.hasClass(scrollDown)) {
					bar.removeClass(scrollDown);
					bar.addClass(scrollUp);
				}
			}

			lastScroll = currentScroll;
		});
	}
};

/* Subscribe */
NN_FRAMEWORK.Subscribe = function () {
	$('body').on('click', '.subscribe-button', function () {
		$this = $(this);
		var parents = $this.parents('.shop-panel');
		var info = parents.find('.shop-panel-info');
		var loadSubscribe, activeSubscribe;
		var idShop = parseInt($this.data('id'));

		if (IS_LOGIN) {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'api/subscribe.php',
				data: {
					sector: SECTOR,
					idShop: idShop
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (result.status != 'error') {
						if (isExist($this.parents('.newsfeed-account'))) {
							var parentsNewsfeed = $this.parents('.newsfeed-account');

							parentsNewsfeed.find('.newsfeed').each(function () {
								$thisNewsfeed = $(this);
								var newsfeedShop = $thisNewsfeed.find('.newsfeed-owner-variant.is-shop');
								var btnSubscribe = newsfeedShop.find('.subscribe-button');
								var idShopNewsfeed = btnSubscribe.attr('data-id');
								loadSubscribe = $thisNewsfeed
									.find('.newsfeed-owner-variant-params #subscribe')
									.find('span');
								activeSubscribe = $thisNewsfeed
									.find('.newsfeed-owner-variant-params #subscribe')
									.find('i.fa-heart');

								if (idShopNewsfeed == idShop) {
									if (result.isSubscribe == true) {
										btnSubscribe.toggleClass('btn-danger btn-primary');
										btnSubscribe.attr('title', 'Đã quan tâm');
										btnSubscribe.text('Đã quan tâm');
									} else if (result.isSubscribe == false) {
										btnSubscribe.toggleClass('btn-danger btn-primary');
										btnSubscribe.attr('title', 'Quan tâm trang');
										btnSubscribe.text('Quan tâm trang');
									}

									/* Load subscribe */
									loadSubscribe.text(result.subscribeNumb + ' người quan tâm trang');

									/* Active subscribe */
									if (result.subscribeActive) {
										activeSubscribe.addClass('active');
									} else {
										activeSubscribe.removeClass('active');
									}
								}
							});
						} else {
							if (result.isSubscribe == true) {
								$this.toggleClass('btn-danger btn-primary');
								$this.attr('title', 'Đã quan tâm');
								$this.text('Đã quan tâm');
							} else if (result.isSubscribe == false) {
								$this.toggleClass('btn-danger btn-primary');
								$this.attr('title', 'Quan tâm trang');
								$this.text('Quan tâm trang');
							}

							if (isExist(info.find('.shop-panel-params #subscribe'))) {
								loadSubscribe = info.find('.shop-panel-params #subscribe').find('span');
								activeSubscribe = info.find('.shop-panel-params #subscribe').find('i.fa-heart');
							} else if (isExist($this.parents('.posting-detail-owner-variant-control'))) {
								loadSubscribe = $this
									.parents('.posting-detail-owner-variant-control')
									.find('.posting-detail-owner-variant-params #subscribe')
									.find('span');
								activeSubscribe = $this
									.parents('.posting-detail-owner-variant-control')
									.find('.posting-detail-owner-variant-params #subscribe')
									.find('i.fa-heart');
							}

							/* Load subscribe */
							loadSubscribe.text(result.subscribeNumb + ' người quan tâm trang');

							/* Active subscribe */
							if (result.subscribeActive) {
								activeSubscribe.addClass('active');
							} else {
								activeSubscribe.removeClass('active');
							}
						}
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
};

/* Rating */
NN_FRAMEWORK.Rating = function () {
	if (isExist($('.shop-rating'))) {
		$('.shop-rating').each(function () {
			$this = $(this);
			var idRating = $this.attr('data-id');
			var eRating = $this.find('#star-rating-' + idRating);
			var scoreRating = eRating.attr('data-rating');

			eRating.starRating({
				totalStars: 5,
				initialRating: scoreRating,
				strokeColor: '#ffac3d',
				emptyColor: 'lightgray',
				hoverColor: '#ffac3d',
				activeColor: '#ffac3d',
				strokeWidth: 10,
				starSize: 19,
				minRating: 1,
				readOnly: true,
				useFullStars: false,
				disableAfterRate: true
			});
		});
	}
};

/* Account */
NN_FRAMEWORK.Account = function () {

	/* Chat */
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
					url: URL_CURRENT,
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
								NN_FRAMEWORK.Lazys();
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

	/* Avatar */
	if (isExist($('#avatar-account'))) {
		photoZone('#avatar-account-label', '#avatar-account', '#avatar-account-preview img', '200x200');
	}

	/* Avatar shop */
	if (isExist($('#avatar-shop-account'))) {
		photoZone('#avatar-shop-account-label', '#avatar-shop-account', '#avatar-shop-account-preview img', '');
	}

	/* Mails */
	if (isExist($('.card-mails'))) {
		/* Read mails */
		$('.read-mails').click(function () {
			$this = $(this);
			var parents = $this.parents('.card-mails');
			var id = $this.data('id');

			if (id && !$this.hasClass('readed')) {
				$.ajax({
					type: 'POST',
					url: 'api/mails.php',
					data: {
						cmd: 'read',
						id: id
					},
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						parents.find('.title-mails, .read-mails').addClass('readed');
						holdonClose();
					}
				});
			}
		});

		/* Delete mails */
		$('.delete-mails').click(function () {
			confirmDialog('delete-mails', 'Bạn muốn xóa thư này ?', $(this));
		});
	}

	/* New posting */
	if (isExist($('.product-new-post'))) {
		/* Read mails */
		$('.product-new-post .product-image, .product-new-post .product-name a').click(function (e) {
			e.preventDefault();
			$this = $(this);
			var product = $this.parents('.col-product-account');
			var type = product.find('.product-image, .product-name a').data('type');
			var id = product.find('.product-image, .product-name a').data('id');
			var target = product.find('.product-image, .product-name a').data('target');
			var urlTemp = product.find('.product-image, .product-name a').attr('href');

			if (type && id) {
				holdonOpen();

				setTimeout(function () {
					$.ajax({
						type: 'post',
						dataType: 'html',
						url: 'api/new-posting.php',
						async: false,
						data: {
							type: type,
							id: id
						},
						success: function (result) {
							product.remove();
							window.open(CONFIG_BASE + urlTemp, target);
							location.href = location.href;
						}
					});
				}, 500);
			} else {
				window.open(CONFIG_BASE + urlTemp, target);
			}
		});
	}

	/* Shop switch */
	if (isExist($('.shop-switch'))) {
		$('.shop-switch .custom-control-label').click(function () {
			$this = $(this);
			var parents = $this.parents('.shop-switch');
			var input = parents.find("input[type='checkbox']");
			var label = parents.find('.custom-control-label');
			var id = input.val();
			var text = label.text().trim();
			var name = input.data('name');

			if (!input.attr('disabled')) {
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: 'api/member.php',
					async: false,
					data: {
						cmd: 'shop-status',
						sector: SECTOR,
						id: id
					},
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						if (result.failed) {
							showNotify('Thất bại. Vui lòng thử lại sau', 'Thông báo', 'error');
						} else if (result.success) {
							if (input.is(':checked')) {
								label.text('Tạm ẩn');
							} else {
								label.text('Hiển thị');
							}

							showNotify(name, result.message, result.status);
						}

						holdonClose();
					}
				});
			}
		});
	}

	/* Shop delete */
	if (isExist($('.delete-shop-account'))) {
		$('.delete-shop-account').click(function () {
			confirmDialog(
				'delete-shop',
				"<strong class='d-block text-danger mb-1'>Các dữ liệu liên quan đến gian hàng này sẽ không còn khả dụng trên Chợ Nhanh.</strong> Bạn muốn xóa gian hàng này ?",
				$(this)
			);
		});
	}

	/* Posting switch */
	if (isExist($('.product-switch'))) {
		$('.product-switch .custom-control-label').click(function () {
			$this = $(this);
			var parents = $this.parents('.product-switch');
			var input = parents.find("input[type='checkbox']");
			var label = parents.find('.custom-control-label');
			var id = input.val();
			var text = label.text().trim();
			var name = input.data('name');

			if (!input.attr('disabled')) {
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: 'api/member.php',
					async: false,
					data: {
						cmd: 'posting-status',
						sector: SECTOR,
						id: id
					},
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						if (result.failed) {
							showNotify('Thất bại. Vui lòng thử lại sau', 'Thông báo', 'error');
						} else if (result.success) {
							if (input.is(':checked')) {
								label.text('Tạm ẩn');
							} else {
								label.text('Hiển thị');
							}

							showNotify(name, result.message, result.status);
						}

						holdonClose();
					}
				});
			}
		});
	}

	/* Posting delete */
	if (isExist($('.delete-posting-account'))) {
		$('.delete-posting-account').click(function () {
			confirmDialog('delete-posting', 'Bạn muốn xóa tin đăng này ?', $(this));
		});
	}

	/* Cancel order */
	if (isExist($('button[name="action-order-user"]'))) {
		$('button[name="action-order-user"]').click(function (e) {
			$this = $(this);
			var action = $this.val();

			if (action == 'cancel-order') {
				e.preventDefault();
				confirmDialog('cancel-order', 'Bạn muốn hủy đơn hàng này ?', $(this));
			}
		});
	}

	/* Date range picker order */
	if (isExist($('#order_date'))) {
		$('#order_date').daterangepicker({
			callback: this.render,
			autoUpdateInput: false,
			timePicker: false,
			timePickerIncrement: 30,
			cancelButtonClasses: 'btn-warning',
			locale: {
				format: 'DD/MM/YYYY'
			}
		});
		$('#order_date').on('apply.daterangepicker', function (ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		});
		$('#order_date').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
		});
	}

	/* rangeSlider order */
	if (isExist($('#order_range_price'))) {
		$('#order_range_price').ionRangeSlider({
			skin: 'flat',
			min: MIN_TOTAL_ORDER,
			max: MAX_TOTAL_ORDER,
			from: PRICE_FROM_ORDER,
			to: PRICE_TO_ORDER,
			type: 'double',
			step: 1,
			postfix: ' đ',
			prettify: true,
			hasGrid: true
		});
	}

	/* Filter order */
	if (isExist($('#filter-order'))) {
		$('#filter-order').click(function () {
			var order_status = parseInt($('#order_status').val());
			var order_payment = parseInt($('#order_payment').val());
			var order_date = $('#order_date').val();
			var order_range_price = $('#order_range_price').val();
			var city = parseInt($('#order_city').val());
			var district = parseInt($('#order_district').val());
			var wards = parseInt($('#order_wards').val());
			var urlFilter = URL_CURRENT_ORIGIN;
			var urlTemp = '';

			if (order_status) urlTemp += '&order_status=' + order_status;
			if (order_payment) urlTemp += '&order_payment=' + order_payment;
			if (order_date) urlTemp += '&order_date=' + order_date;
			if (order_range_price) {
				order_range_price = order_range_price.replace(';', ':');
				urlTemp += '&order_range_price=' + order_range_price;
			}
			if (city) urlTemp += '&order_city=' + city;
			if (district) urlTemp += '&order_district=' + district;
			if (wards) urlTemp += '&order_wards=' + wards;

			if (urlTemp) {
				urlTemp = urlTemp.substring(1);
				urlFilter += '?' + urlTemp;
				window.location = urlFilter;
			} else {
				showNotify('Vui lòng chọn điều kiện để lọc', 'Thông báo', 'warning');
			}
		});
	}
};

/* Datetimes */
NN_FRAMEWORK.dateTimes = function () {
	/* Max date */
	maxDate('.max-date');

	/* Min date */
	minDate('.min-date');
};

/* Mail share */
NN_FRAMEWORK.mailShare = function () {
	if (isExist($('.mail-share'))) {
		$('.mail-share').click(function () {
			$this = $(this);
			var subject = $this.data('subject');
			var url = $this.data('url');
			window.open(
				'mailto:?subject=' + subject + '&body=Xin chào. Gửi bạn xem và mong bạn sẽ thích tin này: ' + url,
				'_blank'
			);
		});
	}
};

/* Social share */
NN_FRAMEWORK.socialShare = function () {
	$('body').on('click', '.simple-share li a', function () {
		$this = $(this);
		var parents = $this.parents('.simple-share');
		var id = $this.attr('id');
		var title = parents.attr('data-title');
		var summary = parents.attr('data-summary');
		var image = parents.attr('data-image');
		var url = encodeURI(parents.attr('data-url'));
		var href = '';

		if (id == 'ss-facebook') {
			href =
				'https://www.facebook.com/sharer.php?s=100&p[title]=' +
				title +
				'&p[summary]=' +
				summary +
				'&p[url]=' +
				url +
				'&p[images][0]=' +
				image;
		} else if (id == 'ss-twitter') {
			href = 'https://twitter.com/intent/tweet?text=' + summary + '&url=' + url;
		} else if (id == 'ss-pinterest') {
			href = 'https://pinterest.com/pin/create/link/?media=' + image + '&description=' + summary + '&url=' + url;
		} else if (id == 'ss-linkedin') {
			href = 'https://www.linkedin.com/shareArticle?mini=true&title=' + title + '&url=' + url;
		}

		if (href) {
			var width = 600;
			var height = 600;
			var left = screen.width / 2 - width / 2;
			var top = screen.height / 2 - height / 2;
			window.open(
				href,
				id + '-window',
				'left=' +
					left +
					', top=' +
					top +
					', width=' +
					width +
					', height=' +
					height +
					', toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no'
			);
		}
	});
};

/* Control pass */
NN_FRAMEWORK.controlPass = function () {
	if (isExist($('.control-password'))) {
		$('.control-password')
			.find('.show-hide-password')
			.click(function () {
				$this = $(this);
				var parents = $this.parents('.control-password');

				if (isExist(parents.find("input[type='password']"))) {
					parents.find("input[type='password']").attr('type', 'text');
				} else {
					parents.find("input[type='text']").attr('type', 'password');
				}

				parents.find('i').toggleClass('far fa-eye fas fa-eye-slash');
			});
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

/* Videos */
NN_FRAMEWORK.Videos = function () {
	/* Show modal video */
	var titlePage = document.title;

	$('body').on('click', '.show-video', function () {
		var label = $(this).attr('data-label');
		var type = $(this).attr('data-type');
		var poster = $(this).attr('data-poster');
		var video = $(this).attr('data-video');

		if (label && type && video) {
			if (type == 'youtube') {
				var iframe =
					'<div class="video-iframe"><iframe src="https://www.youtube.com/embed/' +
					video +
					'?&autoplay=1" frameborder="0" allow="accelerometer; autoplay; fullscreen"></iframe></div>';
				showModal('#modal-video', 'w-dialog-800', label, iframe, true);
			} else if (type == 'file') {
				var blockVideo =
					'<video class="video-js" id="video-object"><source src="' +
					video +
					'" type="video/mp4"></source></video>';

				/* Change title meta */
				document.title = label;

				/* Show video js */
				showModal('#modal-video', 'w-dialog-800', label, blockVideo, true);

				/* Init video Js */
				initVideoJs('video-object', poster);
			}
		} else {
			notifyDialog('Dữ liệu không hợp lệ');
		}

		return false;
	});

	/* Destroy video when modal video hidden */
	$('#modal-video').on('hidden.bs.modal', function (e) {
		document.title = titlePage;
		destroyVideoJs('video-object');
	});
};

/* Load more video */
NN_FRAMEWORK.loadMoreVideo = function () {
	if (isExist($('.load-more-button#video'))) {
		$('.load-more-button#video').click(function () {
			$this = $(this);
			$loadControl = $this.parents('.load-more-control#video');
			$loadResult = $('.video-loader').find('.form-row');
			var limitFrom = parseInt($loadControl.find('.limit-from').val());
			var limitGet = parseInt($loadControl.find('.limit-get').val());

			$.ajax({
				url: URL_CURRENT,
				type: 'GET',
				dataType: 'json',
				async: false,
				data: {
					limitFrom: limitFrom,
					limitGet: limitGet
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (result.data) {
						$loadResult.append(result.data);
						$loadControl.find('.limit-from').val(limitFrom + limitGet);
						NN_FRAMEWORK.Lazys();
						NN_FRAMEWORK.toolTips();
					}

					/* Check to remove load more button */
					var listsLoaded = $loadResult.find('[class*=col-]').length;

					if (parseInt(listsLoaded) == parseInt(result.total)) {
						$loadControl.remove();
					}

					holdonClose();
				}
			});
		});
	}
};

/* Criteria video */
NN_FRAMEWORK.videoCriteria = function () {
	/* Shop */
	if (isExist($('.filter-shop-video'))) {
		$('body').on('click', '.filter-shop-video .shop-video', function () {
			$('.lists-video-id').find("input[type='hidden']#id-shop").val('');

			/* Filters */
			NN_FRAMEWORK.videoFilters();
		});
	}

	/* Cats */
	if (isExist($('.filter-cat-video'))) {
		$('body').on('click', '.filter-cat-video .sectors-cat:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-cat-video');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-video-id').find("input[type='hidden']#id-cat").val('');
			} else {
				$('.lists-video-id').find("input[type='hidden']#id-cat").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.sectors-cat').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.videoFilters();
		});
	}

	/* Posting as variant video */
	if (isExist($('.filter-variant-video'))) {
		$('body').on('click', '.filter-variant-video .variant-post:not(.active)', function () {
			$this = $(this);
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-video-id').find("input[type='hidden']#id-variant-post").val('');
			} else {
				$('.lists-video-id').find("input[type='hidden']#id-variant-post").val($this.attr('data-variant-post'));
			}

			/* Active this */
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.videoFilters();
		});
	}

	/* Datepost */
	if (isExist($('.filter-date-post-video'))) {
		$('body').on('click', '.filter-date-post-video .date-post:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-date-post-video');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-video-id').find("input[type='hidden']#id-date-post").val('');
			} else {
				$('.lists-video-id').find("input[type='hidden']#id-date-post").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.date-post').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.videoFilters();
		});
	}

	/* Remove all filter */
	if (isExist($('.filter-remove-all-video-criteria'))) {
		$('body').on('click', '.filter-remove-all-video-criteria .filter-remove', function () {
			/* Remove */
			$('.lists-video-id').find("input[type='hidden']#id-cat").val('');
			$('.lists-video-id').find("input[type='hidden']#id-variant-post").val('');
			$('.lists-video-id').find("input[type='hidden']#id-date-post").val('');

			/* Filters */
			NN_FRAMEWORK.videoFilters();
		});
	}
};

/* Filter video */
NN_FRAMEWORK.videoFilters = function () {
	var shop = parseInt($(".lists-video-id input[type='hidden']#id-shop").val());
	var cat = parseInt($(".lists-video-id input[type='hidden']#id-cat").val());
	var variantpost = String($(".lists-video-id input[type='hidden']#id-variant-post").val());
	var datepost = parseInt($(".lists-video-id input[type='hidden']#id-date-post").val());
	var urlFilter = CONFIG_BASE + 'video?sector=' + SECTOR['id'];
	var urlTemp = '';

	if (shop) urlTemp += '&shop=' + shop;
	if (cat) urlTemp += '&cat=' + cat;
	if (variantpost) urlTemp += '&variantpost=' + variantpost;
	if (datepost) urlTemp += '&datepost=' + datepost;
	if (urlTemp) urlFilter += urlTemp;

	window.location = urlFilter;
};

/* Sectors */
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
						active = ID_CAT && ID_CAT == data[i]['id'] ? 'active' : '';

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

					// /* Export data */
					// if (str) {
					// 	changeModal('#modal-sectors', 'Danh mục ', str);
					// } else {
					// 	notifyDialog('Không tìm thấy dữ liệu');
					// }

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

/* Stores */
NN_FRAMEWORK.Stores = function () {
	/* Search */
	if (isExist($('.store-search-remove'))) {
		$('body').on('click', '.store-search-remove', function () {
			$('.store-search').find("input[type='text']").val('');

			/* Filters */
			NN_FRAMEWORK.storeFilters();
		});
	}

	/* Cats */
	if (isExist($('.filter-cat-store'))) {
		$('body').on('click', '.filter-cat-store .sectors-cat:not(.active)', function () {
			$this = $(this);
			var id = $this.data('id');
			window.location = URL_SECTOR + '?cat=' + id;
		});
	}

	/* Filter shop by City */
	if (isExist($('.filter-city-store'))) {
		$('body').on('click', '.filter-city-store .city:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-city-store');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
	
			$('.lists-store-id').find("input[type='hidden']#id-city").val($this.attr('data-id'));
			
			/* Unactive district */
			$('.lists-store-id').find("input[type='hidden']#id-district").val('');
			$('.lists-store-id').find("input[type='hidden']#id-ward").val('');
			/* Filters */
			if ($this.hasClass('city') && !$this.hasClass('active') ) {
				$parents.find('.city').removeClass('active');
				$this.addClass('active');

				/* Filters */
				NN_FRAMEWORK.storeFilters();
			}

		});

		/* District */
		$('body').on('click', '.filter-city-store .district:not(.active),.filter-city-store .show-ward', function () {
			$this = $(this);
			$parents = $this.parents('.filter-city-store');

			/* Excute or remove */
			$('.lists-store-id').find("input[type='hidden']#id-city").val($parents.find('.city').attr('data-id'));
			$('.lists-store-id').find("input[type='hidden']#id-district").val($this.attr('data-id'));	
			$('.lists-store-id').find("input[type='hidden']#id-ward").val('');
			/* Filters */
			NN_FRAMEWORK.storeFilters();
			
		});

	}

	/* Remove all filter */
	if (isExist($('.filter-remove-all-store-criteria'))) {
		$('body').on('click', '.filter-remove-all-store-criteria .filter-remove', function () {
			/* Remove */
			$('.store-search').find("input[type='text']").val('');
			$('.lists-store-id').find("input[type='hidden']#id-city").val('');
			$('.lists-store-id').find("input[type='hidden']#id-district").val('');

			/* Filters */
			NN_FRAMEWORK.storeFilters();
		});
	}
};

/* Filter store */
NN_FRAMEWORK.storeFilters = function () {
	var keyword = encodeURI($('.store-search').find("input[type='text']").val());
	var city = parseInt($(".lists-store-id input[type='hidden']#id-city").val());
	var district = parseInt($(".lists-store-id input[type='hidden']#id-district").val());
	var urlFilter = URL_CURRENT_ORIGIN + '?sector=' + SECTOR['id'];
	var urlTemp = '';

	if (keyword) urlTemp += '&keyword=' + keyword;
	if (city) urlTemp += '&city=' + city;
	if (district) urlTemp += '&district=' + district;
	if (urlTemp) {
		urlFilter += urlTemp;
	}

	window.location = urlFilter;
};

/* Places */
NN_FRAMEWORK.Places = function () {
	/* City */
	if (isExist($('.show-city'))) {
		$('body').on('click', '.show-city', function () {
			var str = (active = '');

			/* Read json */
			$.ajax({
				dataType: 'json',
				url: PATH_JSON + 'city-group.json?v=' + stringRandom(5),
				async: false,
				beforeSend: function () {
					holdonOpen();
				},
				success: function (data) {
					/* Merge data: City Central */
					if (data['citysCentral']) {
						str += '<div class="place-block mb-3">';
						str +=
							'<h2 class="place-name mb-3">' +
							data['citysCentral'].length +
							' thành phố trực thuộc trung ương</h2>';
						str += '<div class="form-row">';
						for (var i = 0; i < data['citysCentral'].length; i++) {
							var city = data['citysCentral'][i];
							active = ID_CITY && ID_CITY == city['id'] ? '' : '';

							str += '<div class="col mb-3">';
							str += '<div class=" show-district ' + active + '" data-id="' + city['id'] + '" data-label="'+city['name']+'">';
							str +=
								'<a class="city-image rounded-main scale-img" href="javascript:void(0)" title="' +
								city['name'] +
								'">';
							str +=
								'<img class="w-100" onerror="this.src=\'' +
								ASSET +
								THUMBS +
								'/170x170x1/assets/images/noimage.png\'" src="' +
								ASSET +
								THUMBS +
								'/170x170x1/' +
								UPLOAD_PHOTO_L +
								city['photo'] +
								'" alt="' +
								city['name'] +
								'"/>';
							str += '</a>';
							str +=
								'<h3 class="city-name d-flex align-items-center justify-content-center w-100 mb-0 px-2 text-center">';
							str +=
								'<a class="text-decoration-none text-primary-hover ' +
								active +
								' text-uppercase transition" href="javascript:void(0)" title="' +
								city['name'] +
								'">' +
								city['name'] +
								'</a>';
							str += '</h3>';
							str += '</div>';
							str += '</div>';
						}
						str += '</div>';
						str += '</div>';
					}

					/* Merge data: City Region */
					if (data['citysRegion']) {
						for (var i = 0; i < data['citysRegion'].length; i++) {
							var region = data['citysRegion'][i];
							str += '<div class="place-block mb-3">';
							str += '<h2 class="place-name mb-3">' + region['name'] + '</h2>';
							str += '<div class="form-row">';
							for (var j = 0; j < region['citys'].length; j++) {
								var city = region['citys'][j];
								active = ID_CITY && ID_CITY == city['id'] ? '' : '';

								str += '<div class="col mb-3">';
								str += '<div class="show-district' + active + '" data-id="' + city['id'] + '" data-label="'+city['name']+'">';
								str +=
									'<a class="city-image rounded-main scale-img" href="javascript:void(0)" title="' +
									city['name'] +
									'">';
								str +=
									'<img class="w-100" onerror="this.src=\'' +
									ASSET +
									THUMBS +
									'/170x170x1/assets/images/noimage.png\'" src="' +
									ASSET +
									THUMBS +
									'/170x170x1/' +
									UPLOAD_PHOTO_L +
									city['photo'] +
									'" alt="' +
									city['name'] +
									'"/>';
								str += '</a>';
								str +=
									'<h3 class="city-name d-flex align-items-center justify-content-center w-100 mb-0 px-2 text-center">';
								str +=
									'<a class="text-decoration-none text-primary-hover text-uppercase transition" href="javascript:void(0)" title="' +
									city['name'] +
									'">' +
									city['name'] +
									'</a>';
								str += '</h3>';
								str += '</div>';
								str += '</div>';
							}
							str += '</div>';
							str += '</div>';
						}
					}

					/* Export data */
					if (str) {
						showModal('#modal-places', 'w-dialog-1190', 'Việt Nam', str, true);
					} else {
						notifyDialog('Không tìm thấy dữ liệu về tỉnh/thành phố');
					}

					/* Holdon close */
					holdonClose();
				},
				error: function () {
					notifyDialog('Không tìm thấy dữ liệu về tỉnh/thành phố');
					holdonClose();
				}
			});

			return false;
		});
		/* District */
		$('body').on('click', '.show-district', function () {
		
			var str = (active = '');
			var label = $(this).attr('data-label');
			var id_city = $(this).attr('data-id');
			var back = $(this).attr('data-back');
				/* Read json */
			if (id_city) {
				$.ajax({
					dataType: 'json',
					url: PATH_JSON + 'district-' + id_city + '.json?v=' + stringRandom(5),
					async: false,
					beforeSend: function () {
						holdonOpen();
					},
					success: function (data) {
						/* Merge data */
						active = !ID_DISTRICT ? 'active' : '';
						active_ct = ID_CITY && ID_CITY == id_city ? 'active' : '';

						str += '<div class="form-row modal-grid">';
						str += '<div class="pos-relative col-12">';
						str +=
						'<a class="btn-back text-decoration-none show-city" data-label = "Việt Nam" data-back="true" href="javascript:void(0)" title="Quay lại"><i class="fas fa-chevron-left"></i><span>Quay lại</span></a>';

						str += '</div>';

						str += '<a class="col-grid col-4 city d-block text-decoration-none text-primary-hover transition py-2 ' + 
						active_ct +
						'" href="javascript:void(0)" data-remove="true" data-id="'+
							id_city + '" data-label = "' + 
							label + '" title="Tất cả">Tất cả</a>';

						for (var i = 0; i < data.length; i++) {
							var district = data[i];
							active = ID_DISTRICT && ID_DISTRICT == district['id'] ? 'active' : '';
							str +=
								'<a class="col-grid col-4 show-ward text-decoration-none text-primary-hover transition py-2 ' +
								active +
								'" href="javascript:void(0)" data-id="' +
								district['id'] + '"data-label="' +
								district['name'] +
								'" title="' +
								district['name'] +
								'">' +
								district['name'] +
								'</a>';
						}
						str += '</div>';

						/* Export data */
						if (str) {
							if (back) {
								changeModal('#modal-places',label, str);
							} else {
								changeModal('#modal-places', label, str);
							}
				
						} else {
							notifyDialog('Không tìm thấy dữ liệu về quận/huyện');
						}

						// if (str) {
						// 	showModal('#modal-districts', 'w-dialog-800', label, str, true);
						// } else {
						// 	notifyDialog('Không tìm thấy dữ liệu về quận/huyện');
						// }

						/* Holdon close */
						holdonClose();
					},
					error: function () {
						notifyDialog('Không tìm thấy dữ liệu về quận/huyện');
						holdonClose();
					}
				});
			} else {
				notifyDialog('Vui lòng chọn tỉnh/thành phố');
			}

			return false;
		});
		/* Ward */
		$('body').on('click', '.filter-city .show-ward', function () {
			var str = (active = '');
			var label = $(this).attr('data-label');
			var id_city = $(this).parents('.filter-city').find('.city').attr('data-id') ;
			var name_city = $(this).parents('.filter-city').find('.city').attr('data-label');
			var id_district = $(this).attr('data-id') ;
			if (id_city && id_district) {
				
				/* Read json */
				$.ajax({
					dataType: 'json',
					url: PATH_JSON + 'wards-' + id_city + '-' + id_district + '.json?v=' + stringRandom(5),
					async: false,
					beforeSend: function () {
						holdonOpen();
					},
					success: function (data) {
						/* Merge data */
						active = !ID_WARD ? 'active' : '';
						active_dt = ID_DISTRICT && ID_DISTRICT == id_district ? 'active' : '';
						str += '<div class="form-row modal-grid">';
						str += '<div class="col-12">';
						str += '<a class="btn-back text-decoration-none show-district" data-id="'+ id_city +'" data-label = "' + name_city + '" data-back="true" href="javascript:void(0)" title="Quay lại"><i class="fas fa-chevron-left"></i><span>Quay lại</span></a>';
						str += '</div>';
						str +=
							'<a class="col-grid col-4 district text-decoration-none text-primary-hover transition p-2 ' +
							active_dt + '" data-id="' +
							id_district +
							'" href="javascript:void(0)" data-remove="true" title="Tất cả">Tất cả</a>';
						for (var i = 0; i < data.length; i++) {
							var ward = data[i];

							if (ward['id_district'] == id_district) {
								active = ID_WARD && ID_WARD == ward['id'] ? 'active' : '';
								str +=
									'<a class="col-grid col-4 ward text-decoration-none text-primary-hover transition p-2 ' +
									active +
									'" href="javascript:void(0)" data-id="' +
									ward['id'] +
									'" title="' +
									ward['name'] +
									'">' +
									ward['name'] +
									'</a>';
							}
						}
						str += '</div>';

						/* Export data */

						if (str) {
							changeModal('#modal-places', label, str);
						} else {
							notifyDialog('Không tìm thấy dữ liệu về phường/xã');
						}


						/* Holdon close */
						holdonClose();
					},
					error: function () {
						notifyDialog('Không tìm thấy dữ liệu về phường/xã');
						holdonClose();
					}
				});
			} else if (!id_city) {
				notifyDialog('Vui lòng chọn tỉnh/thành phố');
			} else if (!id_district) {
				notifyDialog('Vui lòng chọn quận/huyện');
			}

			return false;
		});
	}


	/* City select */
	if (isExist($('.select-city'))) {
		$('.select-city').change(function () {
			$this = $(this);
			var id = $this.val();
			var loadTitle = $this.data('load-title');
			var loadElement = $this.data('title-element');

			/* Load title */
			if (loadTitle && loadElement && isExist($this.find('option:selected'))) {
				var title = id ? $this.find('option:selected').text() : 'Toàn quốc';
				$(loadElement).text(title);
			}

			/* Load district */
			loadDistrict(id);
		});
	}

	/* District select */
	if (isExist($('.select-district'))) {
		$('.select-district').change(function () {
			$this = $(this);
			var id = $this.val();
			loadWards(id);
		});
	}
};

/* Favourite */
NN_FRAMEWORK.Favourite = function () {
	if (isExist($('.favourite-action'))) {
		$('body').on('click', '.favourite-action:not(.is-owned)', function () {
			if (!IS_LOGIN) {
				redirectDialog(
					'Vui lòng đăng nhập để quan tâm tin này',
					URL_LOGIN + '?back=' + URL_CURRENT,
					'Đăng nhập'
				);
			} else {
				$this = $(this);
				var variant = $this.data('variant');
				var type = $this.data('type');
				var id = $this.data('id');
				var text = $this.data('text');
				var icon = $this.find('i.fa-heart');

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: 'api/favourite.php',
					async: false,
					data: {
						variant: variant,
						type: type,
						id_variant: id
					},
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						if (result.failed) {
							showNotify('Thất bại. Vui lòng thử lại sau', 'Thông báo', 'error');
						} else if (result.owned) {
							showNotify('Tin đăng thuộc quyền sở hữu của bạn', 'Thông báo', 'warning');
						} else if (result.added) {
							showNotify(text, 'Đã quan tâm');
							icon.addClass('active');
							$this.attr({
								title: 'Bỏ quan tâm (' + text + ')',
								'data-original-title': 'Bỏ quan tâm (' + text + ')'
							});
						} else if (result.deleted) {
							showNotify(text, 'Đã bỏ quan tâm', 'warning');
							icon.removeClass('active');
							$this.attr({
								title: 'Quan tâm (' + text + ')',
								'data-original-title': 'Quan tâm (' + text + ')'
							});
						}

						holdonClose();
					}
				});
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

/* Comment */
NN_FRAMEWORK.Comment = function () {
	if (isExist($('.comment-page'))) {
		var data = '';
		data += SECTOR['prefix'] ? SECTOR['prefix'] + '|' : '|';
		data += SECTOR['tables']['shop'] ? SECTOR['tables']['shop'] + '|' : '|';
		data += SECTOR['tables']['comment'] ? SECTOR['tables']['comment'] + '|' : '|';
		data += SECTOR['tables']['comment-photo'] ? SECTOR['tables']['comment-photo'] + '|' : '|';
		data += SECTOR['tables']['comment-video'] ? SECTOR['tables']['comment-video'] : '';

		$('.comment-page').comments({
			url: 'api/comment.php?data=' + btoa(data)
		});
	}
};

/* Posting detail */
NN_FRAMEWORK.postingDetail = function () {
	/* Cats */
	if (isExist($('.filter-cat-posting-detail'))) {
		$('body').on('click', '.filter-cat-posting-detail .sectors-cat', function () {
			$this = $(this);
			var id = $this.data('id');
			window.location = URL_SECTOR + '?cat=' + id;
		});
	}

	/* Product owner similar lists */
	if (isExist($('.posting-owner-similar-lists'))) {
		$('.posting-owner-similar-lists').mCustomScrollbar({
			axis: 'y'
		});
	}

	/* Gallery */
	if (isExist($('.posting-detail-gallery'))) {
		/* Disabled right click on gallery */
		$('.posting-detail-gallery').bind('contextmenu', function (e) {
			return false;
		});

		/* Light gallery */
		lightGallery(document.getElementById('posting-light-gallery'), {
			mode: 'lg-fade',
			addClass: 'lg-posting-detail',
			plugins: [lgZoom, lgAutoplay, lgRotate, lgPager, lgFullscreen, lgThumbnail, lgVideo],
			appendAutoplayControlsTo: '.lg-toolbar',
			autoplay: false,
			autoplayControls: true,
			slideShowAutoplay: true,
			slideShowInterval: 3500,
			allowMediaOverlap: true,
			toggleThumb: true,
			zoom: true,
			scale: 3,
			download: false,
			mousewheel: true,
			videojs: true,
			videojsOptions: {
				width: '100%',
				controls: true,
				autoplay: true,
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
			}
		});

		/* Hover indicators */
		$('#carousel-posting-gallery .carousel-indicators li').hover(function () {
			var id = $(this).data('id');
			$('#carousel-posting-gallery .carousel-inner .carousel-lists .carousel-item').removeClass('active');
			$('.carousel-item-gallery-' + id).addClass('active');
		});

		/* Scroll indicators */
		$('.posting-indicators-scroll').mCustomScrollbar({
			axis: 'x',
			advanced: {
				autoExpandHorizontalScroll: true
			}
		});
	}
};

/* Postings */
NN_FRAMEWORK.Postings = function () {
	/* Item select */
	if (isExist($('.select-item'))) {
		$('.select-item').change(function () {
			loadCategory($(this));
		});
	}

	/* Sub select */
	if (isExist($('.select-sub'))) {
		$('.select-sub').change(function () {
			loadCategory($(this));
		});
	}

	/* Avatar */
	if (isExist($('#avatar-employer'))) {
		photoZone('#avatar-employer-label', '#avatar-employer', '#avatar-employer-preview img', '');
	}

	/* Check status when choose multi select: Color, Size */
	if (isExist($('.multiselect-sale')) && isExist($('.status-attr-posting'))) {
		$('.status-attr-posting input').click(function () {
			$this = $(this);
			var status = $this.val();
			var sumoColor = isExist($('.multiselect-color')) ? $('.multiselect-color')[0].sumo : '';
			var sumoSize = isExist($('.multiselect-size')) ? $('.multiselect-size')[0].sumo : '';

			if ($this.is(':checked') && status == 'service') {
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
	if (isExist($('#avatar-poster'))) {
		photoZone('#avatar-poster-label', '#avatar-poster', '#avatar-poster-preview img', '');
	}

	/* Photos */
	if (isExist($('#files-uploader-posting'))) {
		$('#files-uploader-posting').getEvali({
			limit: 6,
			maxSize: 60,
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

	/* Maps */
	if (isExist($('#map-posting'))) {
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
		var divInfo = "<div id='map-address-posting'>Kéo thả nhà đến vị trí mới</div>";

		function initialize() {
			var olat, olng;
			olat = document.getElementById('map-Latitude-posting').value;
			olng = document.getElementById('map-Longitude-posting').value;

			var mapOptions = {
				center: new google.maps.LatLng(olat, olng),
				zoom: 15,
				scrollwheel: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			latlngs = new google.maps.LatLng(olat, olng);
			map = new google.maps.Map(document.getElementById('map-posting'), mapOptions);
			geocoder = new google.maps.Geocoder();
			infowindow = new google.maps.InfoWindow();
			infowindow.setContent(divInfo);

			var marker = new google.maps.Marker({
				map: map,
				draggable: true,
				icon: gRedIcon
			});

			if (
				document.getElementById('map-Latitude-posting').value != '' &&
				document.getElementById('map-Latitude-posting').value != '0' &&
				document.getElementById('map-Longitude-posting').value != '' &&
				document.getElementById('map-Longitude-posting').value != '0'
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
			$city = $('#map-city-posting').val();
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

			$('#map-address-posting').val(address);

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
			document.getElementById('map-Latitude-posting').value = latlng.lat();
			document.getElementById('map-Longitude-posting').value = latlng.lng();
			document.getElementById('map-coordinates-posting').value = latlng.lat() + ',' + latlng.lng();
		}

		function updateMarkerPosition(latlng) {
			document.getElementById('map-Latitude-posting').value = latlng.lat();
			document.getElementById('map-Longitude-posting').value = latlng.lng();
			document.getElementById('map-coordinates-posting').value = latlng.lat() + ',' + latlng.lng();
			latlngs = latlng;

			var coords = latlng.lat() + ',' + latlng.lng();
			var iframe =
				"<iframe width='100%' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='http://maps.google.com/maps?q=" +
				coords +
				"&amp;z=15&amp;output=embed'></iframe>";

			$('#preview-map').html(iframe);
		}

		function updateMarkerAddress(str) {
			document.getElementById('map-posting').value = str;
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

	/* Previews */
	if (isExist($('input[name="preview-posting"]'))) {
		$('input[name="preview-posting"]').click(function (e) {
			e.preventDefault();
			var formPreview = $('#form-preview');
			var formPosting = $('#form-posting');
			var namevi = $('#namevi');
			var cat = $('#id_cat').find('option:selected');
			var item = $('#id_item').find('option:selected');
			var sub = $('#id_sub').find('option:selected');
			var form_work = $('#id_form_work').find('option:selected');
			var experience = $('#id_experience').find('option:selected');
			var city = $('#id_city').find('option:selected');
			var district = $('#id_district').find('option:selected');
			var wards = $('#id_wards').find('option:selected');
			var status_attr = $('#status_attr');
			var tags = $("input[name='dataPostingTags[]']");
			var colors = $('.multiselect-color');
			var sizes = $('.multiselect-size');
			var contentvi = $('#contentvi');
			var name_video = $('#name_video');
			var poster_video = $('#avatar-poster-preview img').attr('src');
			var file_video = $('#file_video');
			var file_name_video = infoFile(file_video, 'name');
			var size_video = infoFile(file_video, 'size');
			var type_video = $('.form-group-video').find('input[type=hidden]#video-type').val();
			var regular_price = $('#regular_price');
			var type_price = $('#type-price').find('option:selected');
			var type_price_label = type_price.val() ? type_price.text() : '(Chưa chọn đơn vị)';
			var acreage = $('#acreage');
			var first_name = $('#first_name');
			var last_name = $('#last_name');
			var birthday = $('#birthday');
			var gender = $('#gender').find('option:selected');
			var phone = $('#phone');
			var email = $('#email');
			var address = $('#address');
			var avatar_employer = $('#avatar-employer').parents('.avatar-label').find('.avatar-detail').find('img');
			var fullname_employer = $('#fullname_employer');
			var phone_employer = $('#phone_employer');
			var email_employer = $('#email_employer');
			var address_employer = $('#address_employer');
			var introduce_employer = $('#introduce_employer');
			var gender_employer = $('#gender_employer').find('option:selected');
			var age_requirement = $('#age_requirement');
			var application_deadline = $('#application_deadline');
			var trial_period = $('#trial_period');
			var employee_quantity = $('#employee_quantity');
			var lists_gallery = $('.posting-file-uploader .fileuploader-items-list');
			var fullname_contact = $('#fullname_contact');
			var phone_contact = $('#phone_contact');
			var address_contact = $('#address_contact');
			var email_contact = $('#email_contact');

			holdonOpen();

			if (formPreview.hasClass('d-none')) {
				formPreview.removeClass('d-none');
				formPosting.addClass('d-none');
			} else {
				formPosting.removeClass('d-none');
				formPreview.addClass('d-none');
			}

			if (isExist(namevi) && getLen(namevi.val())) {
				formPreview.find('#preview-name').find('input').val(namevi.val());
			}

			if (isExist(cat) && getLen(cat.val())) {
				formPreview.find('#preview-cat').find('input').val(cat.text());
			}

			if (isExist(item) && getLen(item.val())) {
				formPreview.find('#preview-item').find('input').val(item.text());
			}

			if (isExist(sub) && getLen(sub.val())) {
				formPreview.find('#preview-sub').find('input').val(sub.text());
			}

			if (isExist(form_work) && getLen(form_work.val())) {
				formPreview.find('#preview-form-work').find('input').val(form_work.text());
			}

			if (isExist(experience) && getLen(experience.val())) {
				formPreview.find('#preview-experience').find('input').val(experience.text());
			}

			if (isExist(city) && getLen(city.val())) {
				formPreview.find('#preview-city').find('input').val(city.text());
			}

			if (isExist(district) && getLen(district.val())) {
				formPreview.find('#preview-district').find('input').val(district.text());
			}

			if (isExist(wards) && getLen(wards.val())) {
				formPreview.find('#preview-wards').find('input').val(wards.text());
			}

			if (isExist(first_name) && getLen(first_name.val())) {
				formPreview.find('#preview-first-name').find('input').val(first_name.val());
			}

			if (isExist(last_name) && getLen(last_name.val())) {
				formPreview.find('#preview-last-name').find('input').val(last_name.val());
			}

			if (isExist(birthday) && getLen(birthday.val())) {
				formPreview.find('#preview-birthday').find('input').val(birthday.val());
			}

			if (isExist(gender) && getLen(gender.val())) {
				formPreview.find('#preview-gender').find('input').val(gender.text());
			}

			if (isExist(phone) && getLen(phone.val())) {
				formPreview.find('#preview-phone').find('input').val(phone.val());
			}

			if (isExist(email) && getLen(email.val())) {
				formPreview.find('#preview-email').find('input').val(email.val());
			}

			if (isExist(address) && getLen(address.val())) {
				formPreview.find('#preview-address').find('input').val(address.val());
			}

			if (isExist(avatar_employer)) {
				formPreview.find('#preview-avatar-employer').find('img').attr('src', avatar_employer.attr('src'));
			}

			if (isExist(fullname_employer) && getLen(fullname_employer.val())) {
				formPreview.find('#preview-fullname-employer').find('input').val(fullname_employer.val());
			}

			if (isExist(phone_employer) && getLen(phone_employer.val())) {
				formPreview.find('#preview-phone-employer').find('input').val(phone_employer.val());
			}

			if (isExist(email_employer) && getLen(email_employer.val())) {
				formPreview.find('#preview-email-employer').find('input').val(email_employer.val());
			}

			if (isExist(address_employer) && getLen(address_employer.val())) {
				formPreview.find('#preview-address-employer').find('input').val(address_employer.val());
			}

			if (isExist(introduce_employer) && getLen(introduce_employer.val())) {
				formPreview.find('#preview-introduce-employer').find('textarea').val(introduce_employer.val());
			}

			if (isExist(acreage) && getLen(acreage.val())) {
				formPreview
					.find('#preview-acreage')
					.find('input')
					.val(acreage.val() + ' m2');
			}

			if (isExist(regular_price) && getLen(regular_price.val())) {
				formPreview
					.find('#preview-regular-price')
					.find('input')
					.val(regular_price.val() + ' ' + type_price_label);
			}

			if (isExist(gender_employer) && getLen(gender_employer.val())) {
				formPreview.find('#preview-gender-employer').find('input').val(gender_employer.text());
			}

			if (isExist(age_requirement) && getLen(age_requirement.val())) {
				formPreview.find('#preview-age-requirement').find('input').val(age_requirement.val());
			}

			if (isExist(application_deadline) && getLen(application_deadline.val())) {
				formPreview.find('#preview-application-deadline').find('input').val(application_deadline.val());
			}

			if (isExist(trial_period) && getLen(trial_period.val())) {
				formPreview.find('#preview-trial-period').find('input').val(trial_period.val());
			}

			if (isExist(employee_quantity) && getLen(employee_quantity.val())) {
				formPreview.find('#preview-employee-quantity').find('input').val(employee_quantity.val());
			}

			if (isExist(name_video) && getLen(name_video.val())) {
				formPreview.find('#preview-video-name').find('input').val(name_video.val());
			}

			if (type_video == 'file' && isExist(file_video)) {
				formPreview.find('#preview-video-poster').addClass('mb-2');
				formPreview.find('#preview-video-poster').removeClass('d-none');
				formPreview.find('#preview-video-poster').find('.avatar-detail').find('img').attr('src', poster_video);
				formPreview.find('#preview-video-source').find('input').val(file_name_video);
			}

			if (isExist(contentvi) && getLen(contentvi.val())) {
				formPreview.find('#preview-content').find('textarea').val(contentvi.val());
			}

			if (isExist(status_attr)) {
				var status_attr_checked = status_attr.is(':checked') ? true : false;
				var status_attr_text = status_attr.parents('.custom-checkbox').find('.custom-control-label').html();
				var icon_check = '<i class="far fa-check-square text-success mr-1"></i>';
				var icon_uncheck = '<i class="fas fa-ban text-secondary mr-1"></i>';
				var status_attr_html = status_attr_checked
					? icon_check + ' ' + status_attr_text
					: icon_uncheck + ' ' + status_attr_text;

				formPreview
					.find('#preview-status-attr')
					.html('<div class="nav-awesome">' + status_attr_html + '</div>');
			}

			if (isExist(tags)) {
				var tags_html = '';

				tags.each(function () {
					$this = $(this);

					if ($this.is(':checked')) {
						var text = $this.parents('.custom-checkbox').find('.custom-control-label').text();
						tags_html +=
							'<div class="col-4"><div class="nav-awesome"><i class="far fa-check-square text-success mr-1"></i>' +
							text +
							'</div></div>';
					}
				});

				if (tags_html) {
					formPreview.find('#preview-tags').addClass('row').html(tags_html);
				} else {
					formPreview
						.find('#preview-tags')
						.removeClass('row')
						.html(
							'<div class="text-center text-secondary text-sm"><strong>Chưa có thông tin</strong></div>'
						);
				}
			}

			if (isExist(colors)) {
				var colors_html = '';

				colors.find('option:selected').each(function () {
					$this = $(this);
					var text = $this.text();
					colors_html +=
						'<div class="nav-awesome mb-1"><i class="far fa-check-square text-success mr-1"></i>' +
						text +
						'</div>';
				});

				if (status_attr.is(':checked')) {
					formPreview
						.find('#preview-colors')
						.html(
							'<input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Không khả dụng" readonly disabled>'
						);
				} else if (colors_html) {
					formPreview.find('#preview-colors').html(colors_html);
				} else {
					formPreview
						.find('#preview-colors')
						.html(
							'<input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>'
						);
				}
			}

			if (isExist(sizes)) {
				var sizes_html = '';

				sizes.find('option:selected').each(function () {
					$this = $(this);
					var text = $this.text();
					sizes_html +=
						'<div class="nav-awesome mb-1"><i class="far fa-check-square text-success mr-1"></i>' +
						text +
						'</div>';
				});

				if (status_attr.is(':checked')) {
					formPreview
						.find('#preview-sizes')
						.html(
							'<input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Không khả dụng" readonly disabled>'
						);
				} else if (sizes_html) {
					formPreview.find('#preview-sizes').html(sizes_html);
				} else {
					formPreview
						.find('#preview-sizes')
						.html(
							'<input type="text" class="form-control-plaintext border-bottom font-weight-500 text-sm" placeholder="Chưa có thông tin" readonly disabled>'
						);
				}
			}

			if (isExist(lists_gallery)) {
				var li_gallery = '';

				lists_gallery.find('li').each(function () {
					$this = $(this).clone();
					$this.find('.column-actions').remove();
					li_gallery += '<li class="fileuploader-item">' + $this.html() + '</li>';
				});

				if (li_gallery) {
					li_gallery =
						'<div class="custom-file-uploader"><div class="fileuploader-items"><ul class="fileuploader-items-list">' +
						li_gallery +
						'</ul></div></div>';
					formPreview.find('#preview-file-uploader').html(li_gallery);
				} else {
					formPreview
						.find('#preview-file-uploader')
						.html(
							'<div class="text-center text-secondary text-sm mb-3"><strong>Chưa có hình ảnh</strong></div>'
						);
				}
			}

			if (isExist(fullname_contact) && getLen(fullname_contact.val())) {
				formPreview.find('#preview-fullname-contact').find('input').val(fullname_contact.val());
			}

			if (isExist(phone_contact) && getLen(phone_contact.val())) {
				formPreview.find('#preview-phone-contact').find('input').val(phone_contact.val());
			}

			if (isExist(email_contact) && getLen(email_contact.val())) {
				formPreview.find('#preview-email-contact').find('input').val(email_contact.val());
			}

			if (isExist(address_contact) && getLen(address_contact.val())) {
				formPreview.find('#preview-address-contact').find('input').val(address_contact.val());
			}

			holdonClose();

			return true;
		});
	}
};

/* New posting */
NN_FRAMEWORK.newPosting = function () {
	var str = (active = '');
	var listID = ID_NEW_POSTING ? ID_NEW_POSTING.split(',') : '';

	/* Read json */
	$.ajax({
		dataType: 'json',
		url: PATH_JSON + 'sector-cats.json?v=' + stringRandom(5),
		async: false,
		beforeSend: function () {
			holdonOpen();
		},
		success: function (data) {
			/* Merge data */
			str += '<div class="accordion accordion-dropdown" id="accordion-new-posting">';
			for (var i = 0; i < data.length; i++) {
				if (data[i]['cat']) {
					str += '<div class="card border-bottom rounded mb-3">';
					str +=
						'<label class="card-header d-flex align-items-start justify-content-between mb-0" id="heading-new-posting-' +
						data[i]['id'] +
						'" data-toggle="collapse" data-target="#collapse-new-posting-' +
						data[i]['id'] +
						'">';
					str += '<span class="text-primary text-uppercase">' + data[i]['name' + LANG_MAIN] + '</span>';
					str += '<i class="fa fa-chevron-up transition"></i>';
					str += '</label>';
					str +=
						'<div id="collapse-new-posting-' +
						data[i]['id'] +
						'" class="collapse show" data-parent="#accordion-new-posting">';
					str += '<div class="card-body">';
					for (var j = 0; j < data[i]['cat'].length; j++) {
						active = $.inArray(data[i]['cat'][j]['id'], listID) >= 0 ? 'checked' : '';

						str += '<div class="custom-control custom-checkbox mb-1">';
						str +=
							'<input type="checkbox" class="custom-control-input" ' +
							active +
							' name="dataNewPosting[' +
							data[i]['id'] +
							'][]" id="sector-cat-' +
							data[i]['cat'][j]['id'] +
							'" value="' +
							data[i]['cat'][j]['id'] +
							'">';
						str +=
							'<label class="custom-control-label" for="sector-cat-' +
							data[i]['cat'][j]['id'] +
							'">' +
							data[i]['cat'][j]['name' + LANG_MAIN] +
							'</label>';
						str += '</div>';
					}
					str += '</div>';
					str += '</div>';
					str += '</div>';
				}
			}
			str += '</div>';

			/* Export data */
			if (str) {
				showModal('#modal-new-posting', '', 'Đăng ký nhận tin mới', str);
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
};

/* Criteria posting */
NN_FRAMEWORK.postingCriteria = function () {
	/* Cats */
	if (isExist($('.filter-cat'))) {
		$('body').on('click', '.filter-cat .sectors-cat:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-cat');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-cat").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-cat").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.sectors-cat').removeClass('active');
			$this.addClass('active');

			/* Unactive item */
			$('.filter-item .item').removeClass('active');
			$('.filter-sub .sub').removeClass('active');
			$('.lists-posting-id').find("input[type='hidden']#id-item").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-sub").val('');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Items */
	if (isExist($('.filter-item'))) {
		$('body').on('click', '.filter-item .sectors-item:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-item');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-item").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-cat").val($this.attr('data-idcat'));
				$('.lists-posting-id').find("input[type='hidden']#id-item").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.sectors-item').removeClass('active');
			$this.addClass('active');

			/* Unactive sub */
			$('.filter-sub .sub').removeClass('active');
			$('.lists-posting-id').find("input[type='hidden']#id-sub").val('');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Subs */
	if (isExist($('.filter-sub'))) {
		$('body').on('click', '.filter-sub .sectors-sub:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-sub');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-sub").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-cat").val($this.attr('data-idcat'));
				$('.lists-posting-id').find("input[type='hidden']#id-item").val($this.attr('data-iditem'));
				$('.lists-posting-id').find("input[type='hidden']#id-sub").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.sectors-sub').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* City */
	if (isExist($('.filter-city'))) {
		$('body').on('click', '.filter-city .city:not(.active),.filter-city .show-district', function () {
			$this = $(this);
			$parents = $this.parents('.filter-city');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
	
			$('.lists-posting-id').find("input[type='hidden']#id-city").val($this.attr('data-id'));
			

			/* Active this */

			/* Unactive district - ward */
			// $('.filter-district .district').removeClass('active');
			// $('.filter-ward .ward').removeClass('active');
			$('.lists-posting-id').find("input[type='hidden']#id-district").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-ward").val('');
			if ($this.hasClass('city') && !$this.hasClass('active') ) {
				$parents.find('.city').removeClass('active');
				$this.addClass('active');

				/* Filters */
				NN_FRAMEWORK.postingFilters();
			}
		});
		/* District */
		$('body').on('click', '.filter-city .district:not(.active),.filter-city .show-ward', function () {
			$this = $(this);
			$parents = $this.parents('.filter-city');

			/* Excute or remove */
		
			$('.lists-posting-id').find("input[type='hidden']#id-district").val($this.attr('data-id'));
			

			/* Active this */
			/* Unactive ward */
			$('.filter-ward .ward').removeClass('active');
			$('.lists-posting-id').find("input[type='hidden']#id-ward").val('');
			if ($this.hasClass('district') && !$this.hasClass('active') ) {
				$parents.find('.district').removeClass('active');
				$this.addClass('active');

				/* Filters */
				NN_FRAMEWORK.postingFilters();
			}
		});
		/* Ward */
		$('body').on('click', '.filter-city .ward:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-city');

			/* Excute or remove */
		
			$('.lists-posting-id').find("input[type='hidden']#id-ward").val($this.attr('data-id'));
			

			/* Active this */
			$parents.find('.ward').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});

	}


	/* Posting as service or accessary */
	if (isExist($('.status-post'))) {
		$('body').on('click', '.filter-status-post .status-post:not(.active)', function () {
			$this = $(this);
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-status-post").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-status-post").val($this.attr('data-status-post'));
			}

			/* Active this */
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Posting as variant post */
	if (isExist($('.filter-variant-post'))) {
		$('body').on('click', '.filter-variant-post .variant-post:not(.active)', function () {
			$this = $(this);
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-variant-post").val('');
			} else {
				$('.lists-posting-id')
					.find("input[type='hidden']#id-variant-post")
					.val($this.attr('data-variant-post'));
			}

			/* Active this */
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Form work */
	if (isExist($('.filter-form-work'))) {
		$('body').on('click', '.filter-form-work .form-work:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-form-work');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-form-work").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-form-work").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.form-work').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Price range */
	if (isExist($('.filter-price-range'))) {
		$('body').on('click', '.filter-price-range .price-range:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-price-range');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-price-range").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-price-range").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.price-range').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Acreage */
	if (isExist($('.filter-acreage'))) {
		$('body').on('click', '.filter-acreage .acreage:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-acreage');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-acreage").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-acreage").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.acreage').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Datepost */
	if (isExist($('.filter-date-post'))) {
		$('body').on('click', '.filter-date-post .date-post:not(.active)', function () {
			$this = $(this);
			$parents = $this.parents('.filter-date-post');
			$isRemove = $this.attr('data-remove') == 'true' ? true : false;

			/* Excute or remove */
			if ($isRemove) {
				$('.lists-posting-id').find("input[type='hidden']#id-date-post").val('');
			} else {
				$('.lists-posting-id').find("input[type='hidden']#id-date-post").val($this.attr('data-id'));
			}

			/* Active this */
			$parents.find('.date-post').removeClass('active');
			$this.addClass('active');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}

	/* Remove all filter */
	if (isExist($('.filter-remove-all-posting-criteria'))) {
		$('body').on('click', '.filter-remove-all-posting-criteria .filter-remove', function () {
			/* Remove */
			$('.lists-posting-id').find("input[type='hidden']#id-cat").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-item").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-sub").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-city").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-district").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-ward").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-variant-post").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-form-work").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-price-range").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-acreage").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-date-post").val('');
			$('.lists-posting-id').find("input[type='hidden']#id-status-post").val('');

			/* Filters */
			NN_FRAMEWORK.postingFilters();
		});
	}
};

/* Filter posting */
NN_FRAMEWORK.postingFilters = function () {
	var cat = parseInt($(".lists-posting-id input[type='hidden']#id-cat").val());
	var item = parseInt($(".lists-posting-id input[type='hidden']#id-item").val());
	var sub = parseInt($(".lists-posting-id input[type='hidden']#id-sub").val());
	var city = parseInt($(".lists-posting-id input[type='hidden']#id-city").val());
	var district = parseInt($(".lists-posting-id input[type='hidden']#id-district").val());
	var ward = parseInt($(".lists-posting-id input[type='hidden']#id-ward").val());
	var variantpost = String($(".lists-posting-id input[type='hidden']#id-variant-post").val());
	var formwork = parseInt($(".lists-posting-id input[type='hidden']#id-form-work").val());
	var pricerange = parseInt($(".lists-posting-id input[type='hidden']#id-price-range").val());
	var acreage = parseInt($(".lists-posting-id input[type='hidden']#id-acreage").val());
	var datepost = parseInt($(".lists-posting-id input[type='hidden']#id-date-post").val());
	var statuspost = String($(".lists-posting-id input[type='hidden']#id-status-post").val());
	var urlFilter = URL_SECTOR;
	var urlTemp = '';

	if (cat) urlTemp += '&cat=' + cat;
	if (item) urlTemp += '&item=' + item;
	if (sub) urlTemp += '&sub=' + sub;
	if (city) urlTemp += '&city=' + city;
	if (district) urlTemp += '&district=' + district;
	if (ward) urlTemp += '&ward=' + ward;
	if (variantpost) urlTemp += '&variantpost=' + variantpost;
	if (formwork) urlTemp += '&formwork=' + formwork;
	if (pricerange) urlTemp += '&pricerange=' + pricerange;
	if (acreage) urlTemp += '&acreage=' + acreage;
	if (datepost) urlTemp += '&datepost=' + datepost;
	if (statuspost) urlTemp += '&statuspost=' + statuspost;
	if (urlTemp) {
		urlTemp = urlTemp.substring(1);
		urlFilter += '?' + urlTemp;

	}else{
		urlFilter = URL_CURRENT_ORIGIN;
	}

	window.location = urlFilter;
};

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
	/* Sector bar cats */
	if (isExist($('.sector-bar-cats')) && isExist($('.sectors-cat.active'))) {
		$('.sector-bar-cats').mCustomScrollbar('scrollTo', '.sectors-cat.active');
	}

	/* Sector cats */
	if (isExist($('.sector-scroll-cats')) && isExist($('.sectors-cat.active'))) {
		$('.sector-scroll-cats').mCustomScrollbar('scrollTo', '.sectors-cat.active');
	}

	/* Sector items */
	if (isExist($('.sector-scroll-items')) && isExist($('.sectors-item.active'))) {
		$('.sector-scroll-items').mCustomScrollbar('scrollTo', '.sectors-item.active');
	}

	/* Sector subs */
	if (isExist($('.sector-scroll-subs')) && isExist($('.sectors-sub.active'))) {
		$('.sector-scroll-subs').mCustomScrollbar('scrollTo', '.sectors-sub.active');
	}
};

/* Check excute */
NN_FRAMEWORK.checkExcute = function () {
	/* Login */
	if (isExist($('.go-login'))) {
		$('.go-login').click(function () {
			var back = URL_CURRENT != CONFIG_BASE && URL_CURRENT.search('account') < 0 ? '?back=' + URL_CURRENT : '';
			location.href = URL_LOGIN + back;
		});
	}

	/* Shop */
	if (isExist($('.go-shop'))) {
		$('.go-shop').click(function () {
			var URL_REDIRECT =
				CONFIG_BASE + 'dang-ky-gian-hang?sector=' + SECTOR['id'] + '&backSuccessShop=' + URL_CURRENT;

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
			var URL_REDIRECT = CONFIG_BASE + 'dang-tin?sector=' + SECTOR['id'];
			var LISTS_SECTOR_CAT = '';

			/* Check exist CAT */
			if (ID_CAT) {
				URL_REDIRECT += '&cat=' + ID_CAT;
			} else if (SECTOR_CAT) {
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
			if (!ID_CAT) {
				showModal(
					'#modal-sector-posting',
					'w-dialog-630',
					'Vui lòng chọn lĩnh vực để đăng tin',
					LISTS_SECTOR_CAT,
					true
				);
			} else if (!IS_LOGIN) {
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

/* Shops */
NN_FRAMEWORK.Shops = function () {
	if (isExist($('#tabShop'))) {
		/* Disbled form submit when ENTER */
		FORM_SHOP.on('keyup keypress', function (e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				e.preventDefault();
				return false;
			}
		});

		/* Preview for tab interface */
		if (isExist($('.show-interface'))) {
			$('.show-interface').click(function () {
				var photo = $(this).data('photo');
				var title = $(this).attr('title');
				var img =
					'<img class="w-100" onerror="this.src=\'assets/images/noimage.png\';" src="' +
					photo +
					'" alt="' +
					title +
					'"/>';
				showModal('#modal-interface', 'w-dialog-1190', title, img, true);
			});
		}

		/* Get store from sector cat for tab info */
		if (isExist($('.select-cat-for-store'))) {
			$('.select-cat-for-store').change(function () {
				loadStore($(this));
			});
		}

		/* Preview avatar for tab info */
		if (isExist($('#avatar-shop'))) {
			photoZone('#avatar-shop-label', '#avatar-shop', '#avatar-shop-preview img', '');
		}

		/* Action modal for tab info */
		if (isExist($('.show-learn-shop'))) {
			$('.show-learn-shop').click(function () {
				var content = TAB_SHOP_CONTENT.find('#shop-info').find('.learn-shop-text').text();
				showModal(
					'#modal-learn-shop',
					'w-dialog-800',
					'Tìm hiểu về gian hàng',
					'<div class="px-3 py-4">' + content + '</div>',
					true
				);
			});
		}

		/* Control Nav for tab */
		TAB_SHOP_NAV.find('li a').click(function () {
			var tabByNav = $(this).attr('id');
			var tabNow = TAB_SHOP_CONTROL_NEXT.attr('data-now');
			var flag = false;
			var indexTabNow = parseInt(TAB_SHOP_LISTS.indexOf(tabNow));
			var indexTabByNav = parseInt(TAB_SHOP_LISTS.indexOf(tabByNav));

			if (indexTabByNav == 0) {
				TAB_SHOP_CONTROL_PREV.addClass('d-none');
			} else {
				TAB_SHOP_CONTROL_PREV.removeClass('d-none');
			}

			if (indexTabByNav < 2) {
				TAB_SHOP_CONTROL_NEXT.attr('value', 'Tiếp theo');
				TAB_SHOP_CONTROL_NEXT.html('<span>Tiếp theo</span><i class="fas fa-arrow-right ml-2"></i>');
			}

			if (indexTabByNav > indexTabNow) {
				/* Valid shop */
				flag = validShop(tabNow);

				if (flag) {
					if (indexTabByNav == 2) {
						TAB_SHOP_CONTROL_NEXT.attr('value', 'Xác nhận');
						TAB_SHOP_CONTROL_NEXT.html('<span>Xác nhận</span><i class="fas fa-check ml-2"></i>');
					}

					TAB_SHOP_CONTROL_NEXT.attr('data-now', tabByNav);

					/* Preview shop */
					previewShop();

					/* Next shop */
					nextShop(tabByNav, true);
				}
			} else {
				if (indexTabByNav < 2) {
					TAB_SHOP_CONTROL_NEXT.attr('data-now', tabByNav);

					/* Prev shop */
					prevShop(tabByNav);
				}
			}

			return flag;
		});

		/* Control Prev for tab */
		TAB_SHOP_CONTROL_PREV.click(function () {
			$this = $(this);
			var tabNow = TAB_SHOP_CONTROL_NEXT.attr('data-now');
			var tabPrev = '';

			if (tabNow) {
				var indexTabNow = TAB_SHOP_LISTS.indexOf(tabNow);

				if (indexTabNow == 1) {
					tabPrev = TAB_SHOP_LISTS[0];
					TAB_SHOP_CONTROL_PREV.addClass('d-none');
				} else if (indexTabNow > 0) {
					tabPrev = TAB_SHOP_LISTS[indexTabNow - 1];
				}

				if (tabPrev) {
					/* Prev shop */
					prevShop(tabPrev);
				}
			}

			return false;
		});

		/* Control Next for tab */
		TAB_SHOP_CONTROL_NEXT.click(function (e) {
			e.preventDefault();
			$this = $(this);
			var tabNow = $this.attr('data-now');
			var flag = tabNow ? validShop(tabNow) : false;

			if (flag) {
				if (tabNow == 'shop-confirm-tab') {
					/* Save shop */
					saveShop();
				} else {
					/* Preview shop */
					previewShop();

					/* Next shop */
					nextShop(tabNow);
				}
			}

			return false;
		});
	}
};

/* Cart */
NN_FRAMEWORK.Cart = function () {
	/* Add */
	$('body').on('click', '.add-cart', function () {
		var URL_REDIRECT = URL_LOGIN + '?back=' + URL_CURRENT_ORIGIN;

		if (!IS_LOGIN) {
			redirectDialog('Vui lòng đăng nhập để đặt hàng', URL_REDIRECT, 'Đăng nhập');
		} else {
			$this = $(this);
			$parents = $this.parents('.posting-detail-attrs');
			var id = $this.data('id');
			var action = $this.data('action');
			var quantity = $parents.find('.quantity-pro-detail').find('.qty-pro').val();
			quantity = quantity ? quantity : 1;
			var colorEle = $parents.find('.posting-detail-sale-color');
			var colorActive = $parents.find('.posting-detail-sale-color').find('.sale-color input:checked').val();
			color = colorActive ? colorActive : 0;
			var sizeEle = $parents.find('.posting-detail-sale-size');
			var sizeActive = $parents.find('.posting-detail-sale-size').find('.sale-size input:checked').val();
			size = sizeActive ? sizeActive : 0;

			if ((isExist(colorEle) && !color) || (isExist(sizeEle) && !size)) {
				notifyDialog('Vui lòng chọn đầy đủ thuộc tính của sản phẩm');
				return false;
			} else if (id) {
				$.ajax({
					url: 'api/cart.php',
					type: 'POST',
					dataType: 'json',
					async: false,
					data: {
						cmd: 'add-cart',
						sectorType: SECTOR['type'],
						id: id,
						color: color,
						size: size,
						quantity: quantity
					},
					beforeSend: function () {
						holdonOpen();
					},
					success: function (result) {
						if (result.error) {
							showNotify('Dữ liệu không hợp lệ', 'Thông báo', 'error');

							setTimeout(function () {
								location.href = location.href;
							}, 1000);
						} else if (result.warning) {
							showNotify('Vui lòng đăng nhập để tiếp tục', 'Thông báo', 'warning');

							setTimeout(function () {
								window.open(URL_REDIRECT, '_self');
							}, 2000);
						} else if (result.success) {
							var htmlAdd =
								"<div class='text-left mb-2'><i class='far fa-check-circle text-warning mr-1'></i><span class='text-white'>Thêm vào giỏ thành công</span></div><a class='btn btn-sm btn-danger' href='gio-hang'>Xem giỏ hàng và thanh toán</a>";
							var htmlOrigin =
								"<div class='text-left mb-2'><i class='fas fa-shopping-basket text-warning mr-1'></i><span class='text-white'>Giỏ hàng của bạn</span></div><a class='btn btn-sm btn-danger' href='gio-hang'>Xem giỏ hàng và thanh toán</a>";

							$('.header-cart').attr({
								'data-title': htmlAdd,
								'data-original-title': htmlAdd
							});

							$('.header-cart').tooltip('show');

							setTimeout(function () {
								goToByScroll('header');
							}, 1000);

							setTimeout(function () {
								$('.header-cart').attr({
									'data-title': htmlOrigin,
									'data-original-title': htmlOrigin
								});
								$('.header-cart').tooltip('hide');
							}, 5000);

							holdonClose();
						}
					}
				});
			}
		}
	});

	/* Delete group */
	$('body').on('click', '.delete-groupcart', function () {
		confirmDialog('delete-groupcart', 'Bạn muốn xóa đơn này khỏi giỏ hàng ?', $(this));
	});

	/* Delete */
	$('body').on('click', '.delete-procart', function () {
		confirmDialog('delete-procart', 'Bạn muốn xóa sản phẩm này khỏi giỏ hàng ?', $(this));
	});

	/* Counter */
	$('body').on('click', '.counter-procart', function () {
		var $button = $(this);
		var quantity = 1;
		var input = $button.parent().find('input');
		var code = input.attr('data-code');
		var groupCode = input.attr('data-group-code');
		var oldValue = $button.parent().find('input').val();
		var freeze = false;
		if ($button.text() == '+') {
			quantity = parseFloat(oldValue) + 1;
		} else if (oldValue > 1) {
			quantity = parseFloat(oldValue) - 1;
		} else if (oldValue == 1) {
			freeze = true;
			$button.parents('.procart').find('.delete-procart').trigger('click');
		}

		if (!freeze) {
			$button.parent().find('input').val(quantity);
			updateCart(groupCode, code, quantity);
		}
	});

	/* Quantity */
	$('body').on('change', 'input.qty-procart', function () {
		var quantity = $(this).val() < 1 ? 1 : $(this).val();
		$(this).val(quantity);
		var code = $(this).attr('data-code');
		var groupCode = $(this).attr('data-group-code');
		updateCart(groupCode, code, quantity);
	});

	/* City */
	if (isExist($('.select-city-cart'))) {
		$('.select-city-cart').change(function () {
			var id = $(this).val();
			loadDistrict(id);
		});
	}

	/* District */
	if (isExist($('.select-district-cart'))) {
		$('.select-district-cart').change(function () {
			var id = $(this).val();
			loadWards(id);
		});
	}

	/* Wards */
	if (isExist($('.select-wards-cart'))) {
		$('.select-wards-cart').change(function () {
			var id = $(this).val();
		});
	}

	/* Payments */
	if (isExist($('.payments-label'))) {
		$('.payments-label').click(function () {
			var payments = $(this).data('payments');
			$('.payments-cart .payments-label, .payments-info').removeClass('active');
			$(this).addClass('active');
			$('.payments-info-' + payments).addClass('active');
		});
	}

	/* Sale */
	if (isExist($('.sale-item'))) {
		$('.sale-item').click(function () {
			$this = $(this);
			var parents = $this.parents('.sale-lists');

			parents.find('.sale-item').removeClass('active');
			$this.addClass('active');
		});
	}

	/* Quantity detail page */
	if (isExist($('.quantity-pro-detail span'))) {
		$('.quantity-pro-detail span').click(function () {
			var $button = $(this);
			var oldValue = $button.parent().find('input').val();
			if ($button.text() == '+') {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				if (oldValue > 1) var newVal = parseFloat(oldValue) - 1;
				else var newVal = 1;
			}
			$button.parent().find('input').val(newVal);
		});
	}
};

/* Sumoselect */
NN_FRAMEWORK.multiSelect = function () {
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

/* Onload + resize */
$(window).on('load resize', function () {
	NN_FRAMEWORK.screenMix();
});

/* Onload */
$(window).on('load', function () {
	setTimeout(function () {
		NN_FRAMEWORK.Loader();
	}, 300);

	setTimeout(function () {
		NN_FRAMEWORK.sectorsScroll();
	}, 200);

	setTimeout(function () {
		NN_FRAMEWORK.sectorsActiveScroll();
	}, 500);
});

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Lazys();
	NN_FRAMEWORK.Captcha();
	NN_FRAMEWORK.barTools();
	NN_FRAMEWORK.Videos();
	NN_FRAMEWORK.loadMoreVideo();
	NN_FRAMEWORK.videoCriteria();
	NN_FRAMEWORK.Sectors();
	NN_FRAMEWORK.Stores();
	NN_FRAMEWORK.Places();
	NN_FRAMEWORK.postingDetail();
	NN_FRAMEWORK.Postings();
	NN_FRAMEWORK.postingCriteria();
	NN_FRAMEWORK.checkExcute();
	NN_FRAMEWORK.Shops();
	NN_FRAMEWORK.OwlPage();
	NN_FRAMEWORK.multiSelect();
	NN_FRAMEWORK.GoTop();
	NN_FRAMEWORK.AltImg();
	NN_FRAMEWORK.toolTips();
	NN_FRAMEWORK.Account();
	NN_FRAMEWORK.Comment();
	NN_FRAMEWORK.dateTimes();
	NN_FRAMEWORK.Favourite();
	NN_FRAMEWORK.Report();
	NN_FRAMEWORK.Cart();
	NN_FRAMEWORK.mailShare();
	NN_FRAMEWORK.socialShare();
	NN_FRAMEWORK.controlPass();
	NN_FRAMEWORK.Subscribe();
	NN_FRAMEWORK.Rating();
	NN_FRAMEWORK.loadNameInputFile();
	NN_FRAMEWORK.toggleClass();
	NN_FRAMEWORK.Boxscroll();
});
