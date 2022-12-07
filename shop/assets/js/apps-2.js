/* Pagings */
NN_FRAMEWORK.Pagings = function () {
	if (isExist($('.paging-sector-item'))) {
		$('.paging-sector-item').each(function () {
			var item = $(this).data('item');
			loadPaging(
				'api/product.php?perpage=12&idItem=' + item,
				'.paging-sector-item-' + item,
				'.block-sector-item'
			);
		});
	}
};

/* Slideshow */
NN_FRAMEWORK.Slideshow = function () {
	/* Slideshow menu */
	if (isExist($('.slideshow-menu'))) {
		$('.slideshow-menu-lists ul li a').each(function () {
			$this = $(this);

			if (!isExist($this.next('ul').find('li'))) {
				$this.removeClass('is-dropdown');
			}
		});
	}
};

/* Dom Change */
NN_FRAMEWORK.DomChange = function () {
	/* Video Fotorama */
	$('#video-fotorama').one('DOMSubtreeModified', function () {
		$('#fotorama-videos').fotorama();
	});
};

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Slideshow();
	NN_FRAMEWORK.Pagings();
	NN_FRAMEWORK.DomChange();
});
