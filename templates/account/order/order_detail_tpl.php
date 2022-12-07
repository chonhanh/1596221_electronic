<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb . ' - #' . $orderDetail['code'] ?></strong>
</div>
<div class="content-account pt-1">
    <?= $flash->getMessages('frontend') ?>

    <?php if ($orderDetail['order_status'] == 4) { ?>
        <div class="my-alert alert alert-success">Đơn hàng đã hoàn thành vào lúc <?= date("h:i:s A - d/m/Y", $orderDetail['date_updated']) ?></div>
    <?php } else if ($orderDetail['order_status'] == 5) { ?>
        <div class="alert alert-danger">Đơn hàng đã bị hủy vào lúc <?= date("h:i:s A - d/m/Y", $orderDetail['date_updated']) ?></div>
        <?php } else {
        if (!empty($orderGroup)) { ?>
            <div class="alert alert-info">Đơn hàng có thể thay đổi tùy thuộc vào tình trạng sản phẩm/gian hàng hoặc chủ sở hữu của sản phẩm/gian hàng.</div>
        <?php } else { ?>
            <div class="alert alert-warning">Đơn hàng không tồn tại hoặc đã bị xóa bởi các chủ sở hữu</div>
    <?php }
    } ?>

    <div class="card card-primary card-outline text-sm mb-4">
        <div class="card-header">
            <div class="card-title text-uppercase mb-0"><strong>Thông tin chính</strong></div>
        </div>
        <div class="card-body row">
            <div class="form-group col-4 mb-1">
                <label><strong>Mã đơn hàng:</strong></label>
                <p class="text-primary"><?= $orderDetail['code'] ?></p>
            </div>
            <div class="form-group col-4 mb-1">
                <label><strong>Hình thức thanh toán:</strong></label>
                <?php $order_payment = $func->getInfoDetail('namevi', 'news', $orderDetail['order_payment']); ?>
                <p class="text-info"><?= $order_payment['namevi'] ?></p>
            </div>
            <div class="form-group col-4 mb-1">
                <label><strong>Ngày đặt:</strong></label>
                <p><?= date("h:i:s A - d/m/Y", $orderDetail['date_created']) ?></p>
            </div>
            <div class="form-group col-4 mb-1">
                <label><strong>Họ tên:</strong></label>
                <p class="font-weight-bold text-uppercase text-success"><?= $orderDetail['fullname'] ?></p>
            </div>
            <div class="form-group col-4 mb-1">
                <label><strong>Điện thoại:</strong></label>
                <p><?= $orderDetail['phone'] ?></p>
            </div>
            <div class="form-group col-4 mb-1">
                <label><strong>Email:</strong></label>
                <p><?= $orderDetail['email'] ?></p>
            </div>
            <div class="form-group col-12 mb-0">
                <label><strong>Địa chỉ:</strong></label>
                <p><?= $orderDetail['address'] ?></p>
            </div>
        </div>
    </div>

    <?php if (!empty($orderGroup)) { ?>
        <?php foreach ($orderGroup as $v_orderGroup) { ?>
            <div class="card card-primary card-outline text-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <div class="card-title float-none mb-0">Đơn hàng thuộc: <strong><?= (!empty($v_orderGroup['id_shop'])) ? '<span class="text-danger">Gian hàng</span>' : '<span class="text-danger">Thành viên</span>' ?> - <?= $v_orderGroup['infos']['name'] ?></strong> (Tình trạng: <span class="<?= $v_orderGroup['statusClass'] ?>"><?= $v_orderGroup['statusName'] ?></span>)</div>
                    <div class="order-group-info">
                        <?php if (!empty($v_orderGroup['id_shop'])) { ?>
                            <a class="text-success text-decoration-none small" target="_blank" href="<?= $configBaseShop . $v_orderGroup['infos']['slug_url'] ?>/" title="Xem shop"><i class="fas fa-store mr-1"></i>Xem shop</a>
                        <?php } else { ?>
                            <a class="text-info text-decoration-none small" href="tel:<?= $func->parsePhone($v_orderGroup['infos']['phone']) ?>" title="Liên hệ"><i class="fas fa-mobile-alt mr-1"></i>Liên hệ</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <?php if (!empty($v_orderGroup['notes'])) { ?>
                        <div class="bg-light border-top p-3"><label class="mb-1"><strong>Ghi chú:</strong></label>
                            <div><?= nl2br($func->decodeHtmlChars($v_orderGroup['notes'])) ?></div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($v_orderGroup['detail-lists'])) { ?>
                        <table class="table-order table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-middle text-center" width="10%">STT</th>
                                    <th class="align-middle" style="width:45%">Thông tin</th>
                                    <th class="align-middle text-center">Đơn giá</th>
                                    <th class="align-middle text-center">Số lượng</th>
                                    <th class="align-middle text-right">Tạm tính</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($v_orderGroup['detail-lists'] as $k_orderDetail => $v_orderDetail) { ?>
                                    <tr>
                                        <td class="align-middle text-center"><?= ($k_orderDetail + 1) ?></td>
                                        <td class="align-middle">
                                            <div class="form-row">
                                                <div class="col-2">
                                                    <div class="bg-white border rounded p-1"><?= $func->getImage(['sizes' => '100x100x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_orderDetail['photo'], 'alt' => $v_orderDetail['name']]) ?></div>
                                                </div>
                                                <div class="col-10">
                                                    <p class="mb-1"><?= $v_orderDetail['name'] ?></p>
                                                    <small><?= (!empty($v_orderDetail['color']) && !empty($v_orderDetail['size'])) ? 'Màu sắc: <strong>' . $v_orderDetail['color'] . "</strong> - Kích cỡ: <strong>" . $v_orderDetail['size'] . '</strong>' : ((!empty($v_orderDetail['color'])) ? 'Màu sắc: <strong>' . $v_orderDetail['color'] . '</strong>' : ((!empty($v_orderDetail['size'])) ? 'Kích cỡ: <strong>' . $v_orderDetail['size'] . '</strong>' : '')); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <strong class="text-dark"><?= $func->formatMoney($v_orderDetail['real_price']) ?></strong>
                                        </td>
                                        <td class="align-middle text-center"><?= $v_orderDetail['quantity'] ?></td>
                                        <td class="align-middle text-right">
                                            <strong class="text-danger"><?= $func->formatMoney($v_orderDetail['real_price'] * $v_orderDetail['quantity']) ?></strong>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><strong>Tổng cộng:</strong></td>
                                    <td class="text-right"><strong class="text-danger"><?= $func->formatMoney($v_orderGroup['total_price']) ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="bg-white rounded border shadow-sm text-right mb-3 p-3">
            <h6 class="mb-0"><span class="text-dark pr-2">Tổng giá trị đơn hàng:</span><span class="text-danger"><?= $func->formatMoney($orderDetail['total_price']) ?></span></h6>
        </div>
        <?php if ($orderDetail['order_status'] == 1) { ?>
            <form id="form-order-account" method="post" action="account/cap-nhat-don-hang" enctype="multipart/form-data">
                <div class="action-order text-center">
                    <button type="button" class="btn btn-sm btn-warning text-capitalize font-weight-500 py-2 px-3 mx-2" name="action-order-user" value="cancel-order">Hủy đơn hàng</button>
                    <input type="hidden" name="actionOrder" value="">
                    <input type="hidden" name="IDOrder" value="<?= $orderDetail['id'] ?>">
                </div>
            </form>
        <?php } ?>
    <?php } ?>
</div>