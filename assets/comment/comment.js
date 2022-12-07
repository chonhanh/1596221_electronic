$.fn.comments = function (options) {
	var wrapper = $(this);
	var wrapperLists = wrapper.find('.comment-lists');
	var base_url = '';

	if (options) {
		if (options.url) {
			base_url = options.url;
		}
	}

	var parseResponse = function (errors) {
		str = '';
		if (errors.length) {
			str += '<div class="text-left">';

			if (errors.length > 1) {
				for (i = 0; i < errors.length; i++) {
					str += '- ' + errors[i] + '</br>';
				}
			} else if (errors.length == 1) {
				str += errors[0];
			}

			str += '</div>';
		}
		return str;
	};

	var posCursor = function (ctrl) {
		var len = ctrl.val();
		ctrl.focus()
			.val('')
			.blur()
			.focus()
			.val(len + ' ');
	};

	var mediaSlid = function () {
		wrapperLists.find('.carousel-comment-media').each(function () {
			$this = $(this);
			$this.on('slid.bs.carousel', function (e) {
				$thisSlid = $(this);
				var videoActive = $thisSlid.find('.carousel-lists .carousel-comment-media-item-video.active');
				var videoItem = $thisSlid.find('.carousel-lists .carousel-comment-media-item-video');

				if (isExist(videoActive)) {
					videoActive.find('#file-video').trigger('play');
				} else {
					videoItem.find('#file-video').trigger('pause');
				}
			});
		});
	};

	var mediaPhoto = function () {
		if (isExist($('#review-file-photo'))) {
			$('#review-file-photo').getEvali({
				limit: 3,
				maxSize: 30,
				extensions: ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG', 'Png'],
				editor: false,
				addMore: true,
				enableApi: false,
				dragDrop: true,
				changeInput:
					'<div class="review-fileuploader">' +
					'<div class="review-fileuploader-caption"><strong>${captions.feedback}</strong></div>' +
					'<div class="review-fileuploader-text mx-3">${captions.or}</div>' +
					'<div class="review-fileuploader-button btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3">${captions.button}</div>' +
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

	var mediaVideo = function () {
		if (isExist($('#review-poster-video'))) {
			photoZone('#review-poster-video-label', '#review-poster-video', '#review-poster-video-preview img', '');
		}
	};

	$(window).on('load', function () {
		mediaPhoto();
		mediaVideo();
		mediaSlid();
	});

	wrapper
		.on('mouseover', 'i.fa-star', function (e) {
			e.preventDefault();
			$this = $(this);
			var id = $this.attr('data-value');
			$this
				.parent('p')
				.children('i')
				.each(function () {
					var val = $this.attr('data-value');
					if (val <= id) {
						$this.removeClass('star-empty');
					}
				});
		})
		.on('mouseout', 'i.fa-star', function (e) {
			e.preventDefault();
			$this
				.parent()
				.children('i')
				.each(function (e) {
					$this.parent().children('i').addClass('star-empty');
				});
		});

	wrapper.on('click', 'i.fa-star', function () {
		$this = $(this);
		var value = $this.attr('data-value');
		$this.parents('.review-rating-star').find('input').attr('value', value);
		var onStar = parseInt($this.data('value'), 10);
		var stars = $this.parent().children('i');

		for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('star-not-empty');
		}

		for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('star-not-empty');
		}

		$this.parent().parent().find('a').show();

		return false;
	});

	wrapper.on('click', '.btn-write-comment', function () {
		if (!IS_LOGIN) {
			redirectDialog('Vui lòng đăng nhập để bình luận', URL_LOGIN + '?back=' + URL_CURRENT_ORIGIN, 'Đăng nhập');
		} else {
			$('.comment-write').toggleClass('comment-show');
		}
	});

	wrapper.on('click', '.btn-reply-comment', function (e) {
		e.preventDefault();

		if (!IS_LOGIN) {
			redirectDialog('Vui lòng đăng nhập để bình luận', URL_LOGIN + '?back=' + URL_CURRENT_ORIGIN, 'Đăng nhập');
		} else {
			$this = $(this);
			$parents = $this.parents('.comment-item-information');
			var form = $parents.find('#form-reply');
			$this.text($this.text() == 'Trả lời' ? 'Hủy bỏ' : 'Trả lời');
			$this.toggleClass('active');
			form.toggleClass('comment-show');
			form.trigger('reset');
			form.find('textarea').val('@' + $this.data('name') + ':');
			posCursor(form.find('textarea'));

			/* Turn off media when reply */
			if ($this.hasClass('active')) {
				var media = $parents.find('.carousel-comment-media .carousel-indicators li.active');

				if (media.length) {
					media.trigger('click');
				}
			}
		}
	});

	wrapper.on('click', '.btn-cancel-reply', function (e) {
		e.preventDefault();
		$this = $(this);
		$parents = $this.parents('.comment-item-information');
		var form = $parents.find('#form-reply');
		form.trigger('reset').toggleClass('comment-show');
		$parents.find('.btn-reply-comment').text('Trả lời');
	});

	wrapper.on('click', '.carousel-comment-media .carousel-indicators li', function (e) {
		$this = $(this);
		$parents = $this.parents('.carousel-comment-media');
		var id = $this.data('id');
		var videoThis = $parents.find('.carousel-lists .carousel-comment-media-item-' + id);
		var videoItem = $parents.find('.carousel-lists .carousel-comment-media-item-video');

		if ($this.hasClass('active')) {
			$parents.find('.carousel-indicators li, .carousel-lists .carousel-item').removeClass('active');
			videoItem.find('#file-video').trigger('pause');
		} else {
			$parents.find('.carousel-indicators li').removeClass('active');
			$this.addClass('active');
			$parents.find('.carousel-lists .carousel-item').removeClass('active');

			/* Video */
			videoThis.addClass('active');

			if (isExist(videoThis.find('#file-video'))) {
				videoThis.find('#file-video').trigger('play');
			} else {
				videoItem.find('#file-video').trigger('pause');
			}
		}
	});

	wrapper.on('click', '.btn-load-more-comment-parent', function (e) {
		e.preventDefault();
		$this = $(this);
		$loadControl = $this.parents('.comment-load-more-control');
		$loadResult = $this.parents('.comment-lists').find('.comment-load');
		var limitFrom = parseInt($loadControl.find('.limit-from').val());
		var limitGet = parseInt($loadControl.find('.limit-get').val());
		var idProduct = parseInt($loadControl.find('.id-product').val());
		var isCheck = parseInt($loadControl.find('.is-check').val()) == 1 ? 1 : 0;
		var isOwner = parseInt($loadControl.find('.is-owner').val()) == 1 ? 1 : 0;
		var variant = $loadControl.find('.variant').val();

		$.ajax({
			url: base_url + '&get=limitLists',
			method: 'GET',
			dataType: 'json',
			async: false,
			data: {
				limitFrom: limitFrom,
				limitGet: limitGet,
				idProduct: idProduct,
				isCheck: isCheck,
				isOwner: isOwner,
				variant: variant
			},
			beforeSend: function () {
				$this.text('Đang tải');
				$this.attr('disabled', true);
			},
			error: function (e) {
				$this.text('Tải thêm bình luận');
				$this.attr('disabled', false);
				showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
			},
			success: function (response) {
				$this.text('Tải thêm bình luận');
				$this.attr('disabled', false);

				if (response.data) {
					$loadResult.append(response.data);
					$loadControl.find('.limit-from').val(limitFrom + limitGet);
					mediaSlid();
					NN_FRAMEWORK.Lazys();
				}

				/* Check to remove load more button */
				var listsLoaded = $loadResult.find('.comment-item').length;

				if (parseInt(listsLoaded) == parseInt(response.total)) {
					$loadControl.remove();
				}
			}
		});
	});

	wrapper.on('click', '.btn-load-more-comment-child', function (e) {
		e.preventDefault();
		$this = $(this);
		$loadControl = $this.parents('.comment-load-more-control');
		$loadResult = $this
			.parents('.comment-item')
			.find('.comment-item-information .comment-replies .comment-replies-load');
		var limitFrom = parseInt($loadControl.find('.limit-from').val());
		var limitGet = parseInt($loadControl.find('.limit-get').val());
		var idParent = parseInt($loadControl.find('.id-parent').val());
		var idProduct = parseInt($loadControl.find('.id-product').val());
		var isCheck = parseInt($loadControl.find('.is-check').val()) == 1 ? 1 : 0;
		var isOwner = parseInt($loadControl.find('.is-owner').val()) == 1 ? 1 : 0;

		$.ajax({
			url: base_url + '&get=limitReplies',
			method: 'GET',
			dataType: 'json',
			async: false,
			data: {
				limitFrom: limitFrom,
				limitGet: limitGet,
				idParent: idParent,
				idProduct: idProduct,
				isCheck: isCheck,
				isOwner: isOwner
			},
			beforeSend: function () {
				$this.text('Đang tải');
				$this.attr('disabled', true);
			},
			error: function (e) {
				$this.text('Xem thêm bình luận');
				$this.attr('disabled', false);
				showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
			},
			success: function (response) {
				$this.text('Xem thêm bình luận');
				$this.attr('disabled', false);

				if (response.data) {
					$loadResult.append(response.data);
					$loadControl.find('.limit-from').val(limitFrom + limitGet);
					NN_FRAMEWORK.Lazys();
				}

				/* Check to remove load more button */
				var listsLoaded = $loadResult.find('.comment-replies-item').length;

				if (parseInt(listsLoaded) == parseInt(response.total)) {
					$loadControl.remove();
				}
			}
		});
	});

	wrapper.on('submit', '#form-comment', function (e) {
		e.preventDefault();
		$this = $(this);
		var form = $this;
		var responseEle = form.find('.response-review');
		var flag = true;
		var star = form.find('#review-star');
		var title = form.find('#review-title');
		var content = form.find('#review-content');
		var poster_video = form.find('#review-poster-video');
		var file_video = form.find('#review-file-video');
		var ext_video = infoFile(file_video, 'ext');
		var size_video = infoFile(file_video, 'size');
		var size_max = formatBytes(MAX_SIZE_VIDEO);

		holdonOpen();

		if (isExist(star) && !getLen(star.val())) {
			star.focus();
			notifyDialog('Vui lòng đánh giá sao');
			flag = false;
		} else if (isExist(title) && !getLen(title.val())) {
			title.focus();
			notifyDialog('Vui lòng nhập tiêu đề đánh giá');
			flag = false;
		} else if (isExist(content) && !getLen(content.val())) {
			content.focus();
			notifyDialog('Vui lòng nhập nội dung đánh giá');
			flag = false;
		} else if (isExist(file_video) && size_video['numb'] && isExist(poster_video) && !getLen(poster_video.val())) {
			notifyDialog('Hình đại diện video không được trống');
			flag = false;
		} else if (isExist(file_video) && !size_video['numb'] && isExist(poster_video) && getLen(poster_video.val())) {
			notifyDialog('Tập tin video không được trống');
			flag = false;
		} else if (isExist(file_video) && size_video['numb'] && !checkExtFile(ext_video, EXTENSION_VIDEO)) {
			notifyDialog('Chi cho phép tập tin video với định dạng: ' + JSON.stringify(EXTENSION_VIDEO));
			flag = false;
		} else if (isExist(file_video) && size_video['numb'] > size_max['numb']) {
			notifyDialog('Tập tin video không được vượt quá ' + size_max['numb'] + ' ' + size_max['ext']);
			flag = false;
		}

		if (flag) {
			var formData = new FormData(form[0]);
			responseEle.html('');

			setTimeout(function () {
				$.ajax({
					url: base_url + '&get=add',
					method: 'POST',
					enctype: 'multipart/form-data',
					dataType: 'json',
					data: formData,
					async: false,
					processData: false,
					contentType: false,
					cache: false,
					error: function (e) {
						holdonClose();
						showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
					},
					success: function (response) {
						if (response.errors) {
							responseEle.html(
								'<div class="alert alert-danger">' + parseResponse(response.errors) + '</div>'
							);
							goToByScroll('comment-write', 140);
							holdonClose();
						} else {
							form.trigger('reset');
							holdonClose();
							showNotify(
								'Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt',
								'Bình luận thành công',
								'success'
							);

							setTimeout(function () {
								location.reload();
							}, 2000);
						}
					}
				});
			}, 500);
		} else {
			holdonClose();
		}

		return false;
	});

	wrapper.on('submit', '#form-reply', function (e) {
		e.preventDefault();
		$this = $(this);
		$parents = $this.parents('.comment-item');
		var form = $this;
		var responseEle = form.find('.response-reply');
		var flag = true;
		var content = form.find('#reply-content');
		var contentDataName = content.data('name');

		holdonOpen();

		if (isExist(content) && (!getLen(content.val()) || content.val().trim() == contentDataName)) {
			content.focus();
			notifyDialog('Vui lòng nhập nội dung đánh giá');
			flag = false;
		}

		if (flag) {
			var formData = new FormData(form[0]);
			responseEle.html('');

			setTimeout(function () {
				$.ajax({
					url: base_url + '&get=add',
					method: 'POST',
					enctype: 'multipart/form-data',
					dataType: 'json',
					data: formData,
					async: false,
					processData: false,
					contentType: false,
					cache: false,
					error: function (e) {
						showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
					},
					success: function (response) {
						if (response.errors) {
							responseEle.html(
								'<div class="alert alert-danger">' + parseResponse(response.errors) + '</div>'
							);
							goToByScroll(form.attr('id'), 140);
							holdonClose();
						} else {
							form.trigger('reset');
							form.find('#reply-content').val(contentDataName + ' ');
							$parents.find('.comment-new').remove();
							holdonClose();
							showNotify(
								'Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt',
								'Bình luận thành công',
								'success'
							);
						}
					}
				});
			}, 500);
		} else {
			holdonClose();
		}

		return false;
	});
};
