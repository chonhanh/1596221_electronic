<?php
$linkMan = "index.php?com=report&act=man_report_posting&id_list=" . $id_list;
$linkSave = "index.php?com=report&act=save_report_posting&id_list=" . $id_list;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?= $linkMan ?>" title="Quản lý báo xấu - Tin đăng">Quản lý báo xấu - Tin đăng</a></li>
                <li class="breadcrumb-item active">Chi tiết báo xấu</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin Tin Đăng</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <p>Tiêu đề: <strong class="text-uppercase"><?= $productDetail['namevi'] ?></strong></p>
                </div>
                <div class="form-group mb-0">
                    <a class="btn btn-md bg-gradient-primary mr-1" href="<?= $configBase . $configSector['type'] ?>/<?= $productDetail['slugvi'] ?>/<?= $productDetail['id'] ?>" target="_blank" title="Xem chi tiết">Xem chi tiết</a>
                    <a class="btn btn-md bg-gradient-primary" href="index.php?com=product&act=edit&id_list=<?= $productDetail['id_list'] ?>&id_cat=<?= $productDetail['id_cat'] ?>&id_item=<?= $productDetail['id_item'] ?>&id_sub=<?= $productDetail['id_sub'] ?>&id_region=<?= $productDetail['id_region'] ?>&id_city=<?= $productDetail['id_city'] ?>&id_district=<?= $productDetail['id_district'] ?>&id_wards=<?= $productDetail['id_wards'] ?>&id=<?= $productDetail['id'] ?>" target="_blank" title="Kiểm tra tin đăng">Kiểm tra tin đăng</a>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chặn tin đăng</h3>
            </div>
            <div class="card-body">
                <div class="btn btn-info mb-3 mr-1"><span class="d-inline-block pr-2">Số lượt báo xấu:</span>
                    <h6 class="d-inline-block text-warning mb-0"><strong><?= (!empty($reportInfo)) ? count($reportInfo) : 0 ?></strong></h6>
                </div>
                <div class="btn btn-warning mb-3 mr-1"><span class="d-inline-block pr-2">Số lần bị chặn:</span>
                    <h6 class="d-inline-block text-danger mb-0"><strong><?= @$item['count_locked'] ?></strong></h6>
                </div>
                <div class="btn btn-danger mb-3 mr-1"><span class="d-inline-block pr-2">Số lần bị khóa:</span>
                    <h6 class="d-inline-block text-warning mb-0"><strong><?= @$item['count_banned'] ?></strong></h6>
                </div>
                <div class="btn btn-success mb-3"><span class="d-inline-block pr-2">Số lần mở tin:</span>
                    <h6 class="d-inline-block text-warning mb-0"><strong><?= @$item['count_unlock'] ?></strong></h6>
                </div>
                <div class="form-group">
                    <label for="note">Mô tả thông tin <span class="text-danger">Chặn/Khóa</span> tin đăng:</label>
                    <textarea class="form-control text-sm" name="data[note]" id="note" rows="5" placeholder="Nhập mô tả lý do đăng sai cho tin đăng (Thành viên sẽ nhận được và chỉnh sửa dựa trên các mô tả này)"><?= @$item['note'] ?></textarea>
                </div>
                <div class="form-group report-action mb-0">
                    <?php if ($item['status'] > 0 && $item['status'] != 2) { ?>
                        <button type="submit" class="btn btn-sm bg-gradient-success submit-unlock mr-1" name="submit-report" value="unlock"><i class="fas fa-lock-open mr-2"></i>Mở tin</button>
                    <?php } ?>
                    <?php if ($item['status'] != 3) { ?>
                        <button type="submit" class="btn btn-sm bg-gradient-warning submit-lock mr-1" name="submit-report" value="lock"><i class="fas fa-lock mr-2"></i><?= ($item['status'] == 0 || $item['status'] == 2) ? 'Chặn tin' : (($item['status'] == 1) ? 'Gửi lại thông báo' : '') ?></button>
                    <?php } ?>
                    <button type="submit" class="btn btn-sm bg-gradient-danger submit-banned" name="submit-report" value="banned"><i class="fas fa-ban mr-2"></i>Khóa tin đăng</button>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Danh sách báo xấu</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($reportInfo)) { ?>
                    <div class="accordion" id="accordion-report">
                        <?php foreach ($reportInfo as $k_reportInfo => $v_reportInfo) { ?>
                            <div class="card">
                                <div class="card-header bg-light px-3 py-2" id="heading-report-<?= $v_reportInfo['id'] ?>">
                                    <button class="btn btn-block text-left p-0" type="button" data-toggle="collapse" data-target="#collapse-report-<?= $v_reportInfo['id'] ?>" aria-expanded="true" aria-controls="collapse-report-<?= $v_reportInfo['id'] ?>">
                                        <div>Họ tên: <strong class="text-capitalize"><?= $v_reportInfo['fullname'] ?></strong></div>
                                        <div>Tình trạng: <strong class="text-danger text-uppercase"><?= $v_reportInfo['statusName'] ?></strong></div>
                                    </button>
                                </div>
                                <div id="collapse-report-<?= $v_reportInfo['id'] ?>" class="collapse <?= ($k_reportInfo == 0) ? 'show' : '' ?>" aria-labelledby="heading-report-<?= $v_reportInfo['id'] ?>" data-parent="#accordion-report">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Tình trạng:</label>
                                                <input type="text" class="form-control text-sm" placeholder="Tình trạng" value="<?= $v_reportInfo['statusName'] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Họ tên:</label>
                                                <input type="text" class="form-control text-sm" placeholder="Họ tên" value="<?= $v_reportInfo['fullname'] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Điện thoại:</label>
                                                <input type="text" class="form-control text-sm" placeholder="Điện thoại" value="<?= $v_reportInfo['phone'] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Email:</label>
                                                <input type="email" class="form-control text-sm" placeholder="Email" value="<?= $v_reportInfo['email'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nội dung:</label>
                                            <textarea class="form-control text-sm" rows="5" placeholder="Nội dung" disabled><?= $v_reportInfo['content'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($paging) { ?>
                        <div class="card-footer text-sm pb-0"><?= $paging ?></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="card-footer text-sm sticky-top">
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>