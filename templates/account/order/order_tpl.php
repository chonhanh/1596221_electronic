<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if (!empty($orderMain)) { ?>
        <div class="table-responsive">
            <table class="table-order table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="order-code border-bottom text-center">Mã đơn hàng</th>
                        <th class="order-datebuy border-bottom text-center">Ngày mua</th>
                        <th class="order-name border-bottom">Sản phẩm</th>
                        <th class="order-price border-bottom text-center">Tổng tiền</th>
                        <th class="order-status border-bottom text-center">Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderMain as $v_orderMain) {
                        $detailCount = (!empty($v_orderMain['detailLists'])) ? $v_orderMain['detailLists'] - 1 : 0;
                        $detailLists = ($detailCount >= 1) ? ' <strong>... và ' . $detailCount . ' sản phẩm khác</strong>' : ''; ?>
                        <tr>
                            <td class="text-center"><a class="text-primary text-decoration-none" target="_blank" href="account/chi-tiet-don-hang?id=<?= $v_orderMain['id'] ?>" title="Xem đơn hàng: <?= $v_orderMain['code'] ?>"><?= $v_orderMain['code'] ?></a></td>
                            <td class="text-center"><?= date("d/m/Y", $v_orderMain['date_created']) ?></td>
                            <td><?= $v_orderMain['detailFirst'] . $detailLists ?><a class="text-danger text-decoration-none pl-1" target="_blank" href="account/chi-tiet-don-hang?id=<?= $v_orderMain['id'] ?>" title="Chi tiết">(Chi tiết)</a></td>
                            <td class="text-center"><span class="text-danger"><?= $func->formatMoney($v_orderMain['total_price']) ?></span></td>
                            <td class="text-center"><span class="<?= $v_orderMain['statusClass'] ?>"><?= $v_orderMain['statusName'] ?></span></td>
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