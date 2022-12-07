<a class="sidebar-avatar d-flex align-items-center justify-content-center text-decoration-none mb-3" href="account/dashboard" title="Trang cá nhân">
    <span class="pr-3">Xin chào <strong><?= $func->textConvert($func->getMember('last_name'), 'capitalize') ?></strong></span>
    <?= $func->getImage(['class' => 'lazy rounded-circle', 'image-error' => 'icon-account-dashboard.png', 'sizes' => '60x60x1', 'upload' => UPLOAD_USER_L, 'image' => $func->getMember('avatar'), 'alt' => $func->getMember('fullname')]) ?>
</a>
<div class="sidebar-nav text-left">
    <ul class="mb-0">
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover transition" href="account/newsfeed" title="Trang quan tâm">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-favourite.png', 'alt' => 'Trang quan tâm']) ?>
                </span>
                <strong>Trang quan tâm</strong>
            </a>
        </li>
        <!-- <li class="px-3 py-2 mb-1 transition">
			<a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover transition" href="javascript:void(0)" title="Quản lý tài chính">
				<span class="d-flex align-items-center justify-content-center mr-3">
					<?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-finance.png', 'alt' => 'Quản lý tài chính']) ?>
				</span>
				<strong>Quản lý tài chính</strong>
			</a>
		</li>
		<li class="px-3 py-2 mb-1 transition">
			<a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover transition" href="javascript:void(0)" title="Thẻ tích điểm thưởng">
				<span class="d-flex align-items-center justify-content-center mr-3">
					<?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-point.png', 'alt' => 'Thẻ tích điểm thưởng']) ?>
				</span>
				<strong>Thẻ tích điểm thưởng</strong>
			</a>
		</li> -->
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('gian-hang', 'chi-tiet-gian-hang'))) ? 'active' : '' ?> transition" href="account/gian-hang" title="Danh sách gian hàng">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-shop.png', 'alt' => 'Danh sách gian hàng']) ?>
                </span>
                <strong>Danh sách gian hàng</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('tin-dang', 'chi-tiet-tin-dang'))) ? 'active' : '' ?> transition" href="account/tin-dang" title="Danh sách tin đăng">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-posting.png', 'alt' => 'Danh sách tin đăng']) ?>
                </span>
                <strong>Danh sách tin đăng</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('dat-hang', 'chi-tiet-dat-hang'))) ? 'active' : '' ?> transition" href="account/dat-hang" title="Danh sách đặt hàng">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-cart.png', 'alt' => 'Danh sách đặt hàng']) ?>
                </span>
                <strong>Danh sách đặt hàng</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('don-hang', 'chi-tiet-don-hang'))) ? 'active' : '' ?> transition" href="account/don-hang" title="Đơn hàng của bạn">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-order.png', 'alt' => 'Đơn hàng của bạn']) ?>
                </span>
                <strong>Đơn hàng của bạn</strong>
            </a>
        </li>
        <!-- <li class="px-3 py-2 mb-1 transition">
			<a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover transition" href="javascript:void(0)" title="Tìm quà tặng">
				<span class="d-flex align-items-center justify-content-center mr-3">
					<?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-gift.png', 'alt' => 'Tìm quà tặng']) ?>
				</span>
				<strong>Tìm quà tặng</strong>
			</a>
		</li> -->
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= ($action == 'tin-dang-quan-tam') ? 'active' : '' ?> transition" href="account/tin-dang-quan-tam" title="Tin đăng đã quan tâm">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-favourite.png', 'alt' => 'Tin đăng đã quan tâm']) ?>
                </span>
                <strong>Tin đăng đã quan tâm</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= ($action == 'tin-dang-moi') ? 'active' : '' ?> transition" href="account/tin-dang-moi" title="Thông báo tin đăng mới">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-notify-posting.png', 'alt' => 'Thông báo tin đăng mới']) ?>
                </span>
                <strong>Thông báo tin đăng mới</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('binh-luan', 'chi-tiet-binh-luan'))) ? 'active' : '' ?> transition" href="account/binh-luan" title="Danh sách bình luận">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-comment.png', 'alt' => 'Danh sách bình luận']) ?>
                </span>
                <strong>Danh sách bình luận</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= (in_array($action, array('tro-chuyen', 'chi-tiet-tro-chuyen'))) ? 'active' : '' ?> transition" href="account/tro-chuyen" title="Danh sách trò chuyện">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-chat.png', 'alt' => 'Danh sách trò chuyện']) ?>
                </span>
                <strong>Danh sách trò chuyện</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= ($action == 'thong-bao') ? 'active' : '' ?> transition" href="account/thong-bao" title="Thông báo từ Chợ Nhanh">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-notify-website.png', 'alt' => 'Thông báo từ Chợ Nhanh']) ?>
                </span>
                <strong>Thông báo từ Chợ Nhanh</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= ($action == 'thong-tin') ? 'active' : '' ?> transition" href="account/thong-tin" title="Thông tin cá nhân">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-info.png', 'alt' => 'Thông tin cá nhân']) ?>
                </span>
                <strong>Thông tin cá nhân</strong>
            </a>
        </li>
        <li class="px-3 py-2 mb-1 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover <?= ($action == 'doi-mat-khau') ? 'active' : '' ?> transition" href="account/doi-mat-khau" title="Đổi mật khẩu">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-change-password.png', 'alt' => 'Đổi mật khẩu']) ?>
                </span>
                <strong>Đổi mật khẩu</strong>
            </a>
        </li>
        <li class="px-3 py-2 transition">
            <a class="d-flex align-items-center justify-content-start text-decoration-none text-primary-hover transition" href="account/dang-xuat" title="Đăng xuất">
                <span class="d-flex align-items-center justify-content-center mr-3">
                    <?= $func->getImage(['size-error' => '35x35x1', 'upload' => 'assets/images/', 'image' => 'icon-member-logout.png', 'alt' => 'Đăng xuất']) ?>
                </span>
                <strong>Đăng xuất</strong>
            </a>
        </li>
    </ul>
</div>