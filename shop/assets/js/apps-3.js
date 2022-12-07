/* Menu */
NN_FRAMEWORK.Menu = function () {
	/* Remove empty block sector sub */
	if (isExist($('.menu-nav'))) {
		$('.menu-nav ul li a').each(function () {
			$this = $(this);
			$navBlock = $this.next('.menu-nav-block');

			if (!isExist($navBlock.find('ul li'))) {
				$navBlock.remove();
			}
		});
	}

	/* Load product by sector item */
	if (isExist($('.menu-nav-block'))) {
		$('.menu-nav-block ul li a').click(function () {
			$this = $(this);
			$parents = $this.parents('.menu-nav-block');
			$parents.find('ul li a').removeClass('active');
			$this.addClass('active');
			var item = $this.attr('data-item');
			var sub = $this.attr('data-sub');
			loadPaging('api/product.php?perpage=12&idItem=' + item + '&idSub=' + sub, '.menu-nav-item-' + item);
		});
	}
};

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Menu();
});
