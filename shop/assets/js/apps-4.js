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

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Pagings();
});
