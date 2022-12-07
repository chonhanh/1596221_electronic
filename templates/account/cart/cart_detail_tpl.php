<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb . ' - #' . $orderGroupDetail['code'] ?></strong>
</div>
<div class="content-account pt-1">
    <?= $flash->getMessages('frontend') ?>

    <?php if ($orderGroupDetail['order_status'] == 4) { ?>
        <div class="alert alert-success">Đơn hàng đã hoàn thành vào lúc <?= date("h:i:s A - d/m/Y", $orderGroupDetail['date_updated']) ?></div>
    <?php } else if ($orderGroupDetail['order_status'] == 5) { ?>
        <div class="alert alert-danger">Đơn hàng đã bị hủy vào lúc <?= date("h:i:s A - d/m/Y", $orderGroupDetail['date_updated']) ?></div>
    <?php } ?>

    <form method="post" action="account/cap-nhat-dat-hang" enctype="multipart/form-data">
        <div class="card card-primary card-outline text-sm mb-4">
            <div class="card-header">
                <div class="card-title text-uppercase mb-0"><strong>Thông tin chính</strong></div>
            </div>
            <div class="card-body row">
                <div class="form-group col-4 mb-1">
                    <label><strong>Mã đơn hàng:</strong></label>
                    <p class="text-primary"><?= $orderGroupDetail['code'] ?></p>
                </div>
                <div class="form-group col-4 mb-1">
                    <label><strong>Hình thức thanh toán:</strong></label>
                    <p class="text-info"><?= $orderGroupDetail['paymentName'] ?></p>
                </div>
                <div class="form-group col-4 mb-1">
                    <label><strong>Ngày đặt:</strong></label>
                    <p><?= date("h:i:s A - d/m/Y", $orderGroupDetail['date_created']) ?></p>
                </div>
                <div class="form-group col-4 mb-1">
                    <label><strong>Họ tên:</strong></label>
                    <p class="font-weight-bold text-uppercase text-success"><?= $orderGroupDetail['fullname'] ?></p>
                </div>
                <div class="form-group col-4 mb-1">
                    <label><strong>Điện thoại:</strong></label>
                    <p><?= $orderGroupDetail['phone'] ?></p>
                </div>
                <div class="form-group col-4 mb-1">
                    <label><strong>Email:</strong></label>
                    <p><?= $orderGroupDetail['email'] ?></p>
                </div>
                <div class="form-group col-12 mb-0">
                    <label><strong>Địa chỉ:</strong></label>
                    <p><?= $orderGroupDetail['address'] ?></p>
                </div>
                <div class="form-group col-12">
                    <label for="order_status"><strong>Tình trạng:</strong></label>
                    <?php if (in_array($orderGroupDetail['order_status'], array(4, 5))) { ?>
                        <?php $orderStatus = $func->getInfoDetail('namevi, class_order', 'order_status', $orderGroupDetail['order_status']); ?>
                        <strong class="<?= $orderStatus['class_order'] ?>"><?= $orderStatus['namevi'] ?></strong>
                    <?php } else { ?>
                        <?= $func->orderStatus('other', $orderGroupDetail['order_status']) ?>
                    <?php } ?>
                </div>
                <div class="form-group col-12">
                    <label for="notes"><strong>Ghi chú:</strong></label>
                    <?php if (in_array($orderGroupDetail['order_status'], array(4, 5))) { ?>
                        <textarea class="form-control text-sm" rows="5" placeholder="Ghi chú" readonly disabled><?= $orderGroupDetail['notes'] ?></textarea>
                    <?php } else { ?>
                        <textarea class="form-control text-sm" name="data[notes]" id="notes" rows="5" placeholder="Ghi chú"><?= $orderGroupDetail['notes'] ?></textarea>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if (!empty($orderDetail)) { ?>
            <div class="table-responsive">
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
                        <?php foreach ($orderDetail as $k_orderDetail => $v_orderDetail) { ?>
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
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <div class="bg-white border-top-0 border shadow-sm text-right mb-3 p-3">
            <h6 class="mb-0"><span class="text-dark pr-2">Tổng giá trị đơn hàng:</span><span class="text-danger"><?= $func->formatMoney($orderGroupDetail['total_price']) ?></span></h6>
        </div>
        <?php if (!in_array($orderGroupDetail['order_status'], array(4, 5))) { ?>
            <div class="action-order text-center">
                <button type="submit" class="btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3 mx-2" name="submit-order-group-user">Cập nhật đơn hàng</button>
                <input type="hidden" name="IDOrderGroup" value="<?= $orderGroupDetail['id'] ?>">
            </div>
        <?php } ?>
    </form>
</div>