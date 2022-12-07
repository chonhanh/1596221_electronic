<?php
$linkMan = $linkFilter = "index.php?com=shop&act=man&id_list=" . $id_list;
$linkBack = $func->encryptString($configBase . 'admin/index.php?' . $_SERVER['QUERY_STRING']);
$linkAdd = "index.php?com=shop&act=add&id_list=" . $id_list . "&backPage=" . $linkBack;
$linkEdit = "index.php?com=shop&act=edit&id_list=" . $id_list . "&backPage=" . $linkBack;
$linkDelete = "index.php?com=shop&act=delete&id_list=" . $id_list . "&backPage=" . $linkBack;
?>

<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $config['shop']['title_main'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>

<div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" onkeypress="doEnter(event,'keyword','<?= $linkMan ?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?= $linkMan ?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer form-group-category text-sm bg-light row">
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Loại gian hàng</label>
            <select class="form-control filter-category select2" onchange="onchangeCategory($(this))" id="shop_type">
                <?php if (!$func->getGroup('virtual')) { ?>
                    <option value="">Chọn loại gian hàng</option>
                    <option <?= (!empty($_GET['shop_type']) && $_GET['shop_type'] == 1) ? 'selected' : '' ?> value="1">Chính thức</option>
                    <option <?= (!empty($_GET['shop_type']) && $_GET['shop_type'] == 2) ? 'selected' : '' ?> value="2">Tạm thời (Ảo)</option>
                <?php } else { ?>
                    <option selected value="2">Tạm thời (Ảo)</option>
                <?php } ?>
                <option <?= (!empty($_GET['shop_type']) && $_GET['shop_type'] == 3) ? 'selected' : '' ?> value="3">Thiếu thông tin</option>
            </select>
        </div>
        <?php if (!$func->getGroup('virtual')) { ?>
            <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
                <label class="d-block">Người đăng tin</label>
                <select class="form-control filter-category select2" onchange="onchangeCategory($(this))" id="shop_user" <?= (!empty($_GET['shop_type']) && $_GET['shop_type'] == 2) ? 'disabled' : '' ?>>
                    <option value="">Chọn người đăng tin</option>
                    <option <?= (!empty($_GET['shop_user']) && $_GET['shop_user'] == 1) ? 'selected' : '' ?> value="1">Thành viên</option>
                    <option <?= (!empty($_GET['shop_user']) && $_GET['shop_user'] == 2) ? 'selected' : '' ?> value="2">Ban quản trị</option>
                </select>
            </div>
        <?php } ?>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Người đăng:</label>
            <input type="text" class="form-control filter-category text-sm" onchange="onchangeCategory($(this))" id="shop_poster" placeholder="Lọc theo tên người đăng" value="<?= (isset($_GET['shop_poster'])) ? $_GET['shop_poster'] : '' ?>" <?= ((!empty($_GET['shop_type']) && !empty($_GET['shop_user']) && $_GET['shop_type'] == 1) || (!empty($_GET['shop_type']) && $_GET['shop_type'] == 2) || $func->getGroup('virtual')) ? '' : 'disabled' ?>>
        </div>
        <div class="form-group col-xl-4 col-lg-6 col-md-8 col-sm-8 mb-2">
            <label class="d-block">Thời gian đăng tin:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control filter-category float-right text-sm" onchange="onchangeCategory($(this))" id="shop_date" placeholder="Lọc theo thời gian đăng tin" value="<?= (isset($_GET['shop_date'])) ? $_GET['shop_date'] : '' ?>" readonly>
            </div>
        </div>

        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Danh mục cấp 1</label>
            <?= $func->getLinkCategory('product', 'cat') ?>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Danh sách cửa hàng</label>
            <select class="form-control filter-category select2" onchange="onchangeCategory($(this))" id="id_store">
                <option value="">Chọn danh mục</option>
                <?php if (!empty($store)) {
                    foreach ($store as $v) { ?>
                        <option <?= (!empty($_REQUEST['id_store']) && $_REQUEST['id_store'] == $v['id']) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Vùng/miền</label>
            <?= $func->getLinkPlace('region') ?>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Tỉnh/thành phố</label>
            <?= $func->getLinkPlace('city') ?>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Quận/huyện</label>
            <?= $func->getLinkPlace('district') ?>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Phường/xã</label>
            <?= $func->getLinkPlace('wards') ?>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><?= $config['shop']['title_main'] ?></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle">Hình</th>
                        <th class="align-middle" style="width:25%">Tiêu đề</th>
                        <th class="align-middle" style="width:20%">Địa điểm</th>
                        <th class="align-middle" style="width:10%">Ngày tạo</th>
                        <th class="align-middle" style="width:10%">Ngày sửa</th>
                        <th class="align-middle text-center" style="width:10%">Tình trạng</th>
                        <th class="align-middle text-center">Gửi thông tin</th>
                        <th class="align-middle text-center">Thao tác</th>
                    </tr>
                </thead>
                <?php if (empty($items)) { ?>
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center">Không có dữ liệu</td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for ($i = 0; $i < count($items); $i++) {
                            $linkID = "";
                            if ($items[$i]['id_cat']) $linkID .= "&id_cat=" . $items[$i]['id_cat'];
                            if ($items[$i]['id_region']) $linkID .= "&id_region=" . $items[$i]['id_region'];
                            if ($items[$i]['id_city']) $linkID .= "&id_city=" . $items[$i]['id_city'];
                            if ($items[$i]['id_district']) $linkID .= "&id_district=" . $items[$i]['id_district'];
                            if ($items[$i]['id_wards']) $linkID .= "&id_wards=" . $items[$i]['id_wards']; ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                        <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="<?= $configSector['tables']['shop'] ?>">
                                </td>
                                <td class="align-middle">
                                    <a href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/<?= $config['shop']['thumb'] ?>/<?= UPLOAD_SHOP_L . $items[$i]['photo'] ?>" alt="<?= $items[$i]['name'] ?>"></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><?= $items[$i]['name'] ?><?= (strstr($items[$i]['status_attr'], 'virtual')) ? '<strong class="text-danger pl-2">(Gian hàng Ảo)</strong>' : '' ?></a>
                                    <div class="bg-light border rounded p-2 mt-2">
                                        <p class="font-weight-bold mb-0">Danh mục: <?= !empty($items[$i]['productCatName']) ? '<span class="text-info">' . $items[$i]['productCatName'] . '</span>' : '<span class="text-danger">Cần cập nhật</span>' ?></p>
                                        <p class="font-weight-bold mb-1">Cửa hàng: <?= !empty($items[$i]['storeName']) ? '<span class="text-info">' . $items[$i]['storeName'] . '</span>' : '<span class="text-danger">Cần cập nhật</span>' ?></p>
                                        <?php if (!empty($items[$i]['adminFullname'])) { ?>
                                            <p class="text-secondary mb-0">Người tạo: <?= $items[$i]['adminFullname'] ?><?= (strstr($items[$i]['status_attr'], 'virtual')) ? '<span class="text-danger pl-1">(Admin Ảo)</span>' : '' ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="tool-action mt-2 w-clear">
                                        <a class="text-info mr-3" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['name'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                        <?php if ($items[$i]['status'] == 'deleted') { ?>
                                            <a class="text-success mr-3" id="restore-shop" href="javascript:void(0)" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $items[$i]['id'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<span class='text-light'>Kích hoạt lại gian hàng</span>"><i class="fas fa-sync mr-1"></i>Khôi phục</a>
                                            <a class="text-danger" id="delete-prompt" data-message="<strong class='d-block text-danger mb-1'>Các dữ liệu liên quan đến gian hàng này sẽ không còn khả dụng trên Chợ Nhanh.</strong> Bạn muốn xóa gian hàng này ?" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" href="javascript:void(0)" data-plugin="tooltip" data-html="true" data-placement="right" title="<span class='text-warning'>Khi xóa. Các dữ liệu liên quan sẽ không còn khả dụng</span>"><i class="fas fa-trash-alt mr-1"></i>Xóa vĩnh viễn</a>
                                        <?php } else { ?>
                                            <a class="text-success mr-3" target="_blank" href="<?= $configBaseShop . $items[$i]['slug_url'] ?>/" title="<?= $items[$i]['name'] ?>"><i class="fas fa-store mr-1"></i>View shop</a>
                                            <?php if (strstr($items[$i]['status_attr'], 'virtual')) { ?>
                                                <a class="text-info" id="transfer-shop" href="javascript:void(0)" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $items[$i]['id'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<span class='text-light'>Chuyển thông tin gian hàng và thông tin thành viên trở thành thông tin chính thức</span>"><i class="fas fa-sync mr-1"></i>Chuyển thông tin</a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <p class="font-weight-bold mb-1">TT: <?= !empty($items[$i]['cityName']) ? '<span class="text-info">' . $items[$i]['cityName'] . '</span>' : '<span class="text-danger">Trống</span>' ?></p>
                                    <p class="font-weight-bold mb-1">QH: <?= !empty($items[$i]['districtName']) ? '<span class="text-info">' . $items[$i]['districtName'] . '</span>' : '<span class="text-danger">Trống</span>' ?></p>
                                    <p class="font-weight-bold mb-0">PX: <?= !empty($items[$i]['wardName']) ? '<span class="text-info">' . $items[$i]['wardName'] . '</span>' : '<span class="text-danger">Trống</span>' ?></p>
                                    <p class="font-weight-bold mb-0">Store: <?= !empty($items[$i]['storeName']) ? '<span class="text-info">' . $items[$i]['storeName'] . '</span>' : '<span class="text-danger">Trống</span>' ?></p>
                                </td>
                                <td class="align-middle"><?= (!empty($items[$i]['date_created'])) ? date('d/m/Y h:i:s A', $items[$i]['date_created']) : '' ?></td>
                                <td class="align-middle"><?= (!empty($items[$i]['date_updated'])) ? date('d/m/Y h:i:s A', $items[$i]['date_updated']) : 'Chưa cập nhật' ?></td>
                                <td class="align-middle text-center">
                                    <?php if (in_array($items[$i]['status'], array('dangsai', 'vipham'))) { ?>
                                        <?php
                                        if ($items[$i]['status'] == 'dangsai') {
                                            $status = array(
                                                "cls" => "warning",
                                                "title" => "Đăng sai"
                                            );
                                        } else if ($items[$i]['status'] == 'vipham') {
                                            $status = array(
                                                "cls" => "danger",
                                                "title" => "Vi phạm"
                                            );
                                        }
                                        ?>
                                        <strong class="d-block text-<?= $status['cls'] ?> text-capitalize mb-1"><?= $status['title'] ?></strong>
                                        <a class="btn btn-sm bg-gradient-info text-nowrap" target="_blank" href="index.php?com=report&act=edit_report_shop&id_list=<?= $configSector['id'] ?>&id_shop=<?= $items[$i]['id'] ?>" title="Xem báo cáo">Xem báo cáo</a>
                                    <?php } else if ($items[$i]['status'] == 'deleted') { ?>
                                        <strong class="text-danger">Đã được xóa bởi thành viên</strong>
                                    <?php } else {
                                        $status['cls'] = (!empty($items[$i]['status'])) ? $config['shop']['check'][$items[$i]['status']]['cls'] : "primary";
                                        $status['title'] = (!empty($items[$i]['status'])) ? $config['shop']['check'][$items[$i]['status']]['title'] : "Đang chờ"; ?>
                                        <div class="dropdown dropdown-status dropdown-shop">
                                            <button class="btn btn-sm bg-gradient-<?= $status['cls'] ?> dropdown-toggle" type="button" id="dropdownMenuButton" data-cls="<?= $status['cls'] ?>" data-toggle="dropdown"><span class="pr-1"><?= $status['title'] ?></span></button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php foreach ($config['shop']['check'] as $key => $value) { ?>
                                                    <a class="dropdown-item text-nowrap" href="javascript:void(0)" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $items[$i]['id'] ?>" data-virtual="<?= (strstr($items[$i]['status_attr'], 'virtual')) ? true : false ?>" data-attr="<?= $key ?>" data-cls="<?= $value['cls'] ?>" data-text="<?= $value['title'] ?>"><?= $value['title'] ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($items[$i]['status'] == 'deleted') { ?>
                                        <a class="btn btn-sm btn-secondary text-white" title="Vô hiệu"><i class="fas fa-ban"></i></a>
                                    <?php } else { ?>
                                        <?php
                                        $status_send = array(
                                            'cls' => 'bg-gradient-info',
                                            'status' => ''
                                        );
                                        if (empty($items[$i]['status']) || $items[$i]['status'] != 'xetduyet' || strstr($items[$i]['status_attr'], 'virtual')) {
                                            $status_send = array(
                                                'cls' => 'bg-gradient-secondary',
                                                'status' => 'disabled'
                                            );
                                        }
                                        ?>
                                        <button class="btn btn-sm <?= $status_send['cls'] ?> text-white text-nowrap send-info" id="send-shop" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $items[$i]['id'] ?>" <?= $status_send['status'] ?> data-plugin="tooltip" data-html="true" data-placement="top" title="Gửi thông tin quản lý gian hàng cho chủ sở hữu">Gửi email</button>
                                    <?php } ?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <?php if (in_array($items[$i]['status_attr'], array('virtual')) || in_array($items[$i]['status'], array('', 'deleted', 'dangsai', 'vipham')) || !empty($items[$i]['id_admin'])) { ?>
                                        <a class="text-danger" id="delete-prompt" data-message="<strong class='d-block text-danger mb-1'>Các dữ liệu liên quan đến gian hàng này sẽ không còn khả dụng trên Chợ Nhanh.</strong> Bạn muốn xóa gian hàng này ?" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" href="javascript:void(0)" data-plugin="tooltip" data-html="true" data-placement="left" title="<span class='text-warning'>Khi xóa. Các dữ liệu liên quan sẽ không còn khả dụng</span>"><i class="fas fa-trash-alt"></i></a>
                                    <?php } else { ?>
                                        <a class="text-secondary" href="javascript:void(0)" data-plugin="tooltip" data-html="true" data-placement="left" title="Chỉ được xóa khi shop ở trạng thái <span class='text-primary'>Đang chờ duyệt</span>, <span class='text-warning'>Sở hữu bởi ADMIN</span>, <span class='text-info'>Đã xóa bởi thành viên</span>, <span class='text-warning'>Đăng sai</span>, <span class='text-danger'>Vi phạm</span>, <span class='text-info'>Gian hàng ảo</span>"><i class="fas fa-trash-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0"><?= $paging ?></div>
    <?php } ?>
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
    </div>
</section>