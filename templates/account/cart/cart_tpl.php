<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <div class="form-row text-sm">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="alert alert-primary px-3" role="alert">
                <div class="alert-heading text-uppercase mb-2">
                    <div class="badge badge-light align-top mr-2 p-2"><i class="fas fa-shopping-bag text-primary"></i></div><strong class="d-inline-block align-top mt-1">Mới đặt</strong>
                </div>
                <p class="mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allNewOrder ?></span></p>
                <hr class="my-1">
                <p class="mb-0">Tổng: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalNewOrder) ?></span></p>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="alert alert-info px-3" role="alert">
                <div class="alert-heading text-uppercase mb-2">
                    <div class="badge badge-light align-top mr-2 p-2"><i class="fas fa-thumbs-up text-info"></i></div><strong class="d-inline-block align-top mt-1">Đã xác nhận</strong>
                </div>
                <p class="mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allConfirmOrder ?></span></p>
                <hr class="my-1">
                <p class="mb-0">Tổng: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalConfirmOrder) ?></span></p>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="alert alert-success px-3" role="alert">
                <div class="alert-heading text-uppercase mb-2">
                    <div class="badge badge-light align-top mr-2 p-2"><i class="fas fa-check-circle text-success"></i></div><strong class="d-inline-block align-top mt-1">Đã giao</strong>
                </div>
                <p class="mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allDeliveriedOrder ?></span></p>
                <hr class="my-1">
                <p class="mb-0">Tổng: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalDeliveriedOrder) ?></span></p>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="alert alert-danger px-3" role="alert">
                <div class="alert-heading text-uppercase mb-2">
                    <div class="badge badge-light align-top mr-2 p-2"><i class="fas fa-times-circle text-danger"></i></div><strong class="d-inline-block align-top mt-1">Đã hủy</strong>
                </div>
                <p class="mb-0">Số lượng: <span class="text-danger font-weight-bold"><?= $allCanceledOrder ?></span></p>
                <hr class="my-1">
                <p class="mb-0">Tổng: <span class="text-danger font-weight-bold"><?= $func->formatMoney($totalCanceledOrder) ?></span></p>
            </div>
        </div>
    </div>
    <div class="accordion accordion-dropdown" id="accordion-search-order">
        <div class="card mb-3">
            <label class="card-header d-flex align-items-start justify-content-between mb-0" id="heading-search-order" data-toggle="collapse" data-target="#collapse-search-order" aria-expanded="false"><strong class="text-uppercase">Tìm kiếm đơn hàng</strong><i class="fa fa-chevron-up transition"></i></label>
            <div id="collapse-search-order" class="collapse show" data-parent="#accordion-search-order">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-4">
                            <label><strong>Ngày đặt:</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control text-sm float-right" id="order_date" value="<?= (isset($_GET['order_date'])) ? $_GET['order_date'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label><strong>Tình trạng:</strong></label>
                            <?= $func->orderStatus('other') ?>
                        </div>
                        <div class="form-group col-4">
                            <label><strong>Hình thức thanh toán:</strong></label>
                            <?= $func->orderPayments() ?>
                        </div>
                        <div class="form-group col-4">
                            <label><strong>Tỉnh thành:</strong></label>
                            <select class="select-city custom-select text-sm cursor-pointer" id="order_city">
                                <option value=""><?= tinhthanh ?></option>
                                <?php if (!empty($city)) {
                                    foreach ($city as $v_city) { ?>
                                        <option <?= (!empty($_GET['order_city']) && $_GET['order_city'] == $v_city['id']) ? 'selected' : '' ?> value="<?= $v_city['id'] ?>"><?= $v_city['name'] ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label><strong>Quận huyện:</strong></label>
                            <select class="select-district custom-select text-sm cursor-pointer" id="order_district">
                                <option value=""><?= quanhuyen ?></option>
                                <?php if (!empty($district)) {
                                    foreach ($district as $v_district) { ?>
                                        <option <?= (!empty($_GET['order_district']) && $_GET['order_district'] == $v_district['id']) ? 'selected' : '' ?> value="<?= $v_district['id'] ?>"><?= $v_district['name'] ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label><strong>Phường xã:</strong></label>
                            <select class="select-wards custom-select text-sm cursor-pointer" id="order_wards">
                                <option value=""><?= phuongxa ?></option>
                                <?php if (!empty($wards)) {
                                    foreach ($wards as $v_wards) { ?>
                                        <option <?= (!empty($_GET['order_wards']) && $_GET['order_wards'] == $v_wards['id']) ? 'selected' : '' ?> value="<?= $v_wards['id'] ?>"><?= $v_wards['name'] ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label><strong>Khoảng giá:</strong></label>
                            <div class="px-5"><input type="text" class="primary" id="order_range_price"></div>
                        </div>
                        <div class="form-group text-center mt-2 mb-0 col-12">
                            <a class="btn btn-sm btn-success text-white" id="filter-order" title="Tìm kiếm"><i class="fas fa-search mr-1"></i>Tìm kiếm</a>
                            <a class="btn btn-sm btn-danger text-white ml-1" href="account/dat-hang" title="Hủy lọc"><i class="fas fa-times mr-1"></i>Hủy lọc</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($cartMain)) { ?>
        <div class="table-responsive">
            <table class="table-order table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="order-code border-bottom text-center">Mã đơn hàng</th>
                        <th class="order-datebuy border-bottom text-center">Ngày đặt</th>
                        <th class="order-name border-bottom">Thông tin</th>
                        <th class="order-price border-bottom text-center">Tổng tiền</th>
                        <th class="order-status border-bottom text-center">Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartMain as $v_cartMain) { ?>
                        <tr>
                            <td class="text-center"><a class="text-primary text-decoration-none" target="_blank" href="account/chi-tiet-dat-hang?id=<?= $v_cartMain['id'] ?>" title="Xem đơn hàng: <?= $v_cartMain['code'] ?>"><?= $v_cartMain['code'] ?></a></td>
                            <td class="text-center"><?= date("d/m/Y", $v_cartMain['date_created']) ?></td>
                            <td>
                                <p class="mb-1"><strong class="text-uppercase"><?= $v_cartMain['fullname'] ?></strong><a class="text-danger text-decoration-none pl-1" target="_blank" href="account/chi-tiet-dat-hang?id=<?= $v_cartMain['id'] ?>" title="Chi tiết">(Chi tiết)</a></p><span class="text-info"><?= $v_cartMain['paymentName'] ?></span>
                            </td>
                            <td class="text-center"><span class="text-danger"><?= $func->formatMoney($v_cartMain['total_price']) ?></span></td>
                            <td class="text-center"><span class="<?= $v_cartMain['statusClass'] ?>"><?= $v_cartMain['statusName'] ?></span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
</div>