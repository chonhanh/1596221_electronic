<?php
$linkMan = $linkFilter = "index.php?com=product&act=man";
$linkAdd = "index.php?com=product&act=add";
$linkEdit = "index.php?com=product&act=edit";
$linkDelete = "index.php?com=product&act=delete";
$linkComment = "index.php?com=comment&act=man&id_list=" . $id_list;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $config['product']['title_main'] ?></li>
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
            <label class="d-block">Lĩnh vực kinh doanh</label>
            <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Lĩnh vực" value="<?= $nameSectorList ?>" readonly>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Danh mục cấp 1</label>
            <input type="text" class="form-control form-control-plaintext text-uppercase text-sm px-3" placeholder="Danh mục cấp 2" value="<?= $nameSectorCat ?>" readonly>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Danh mục cấp 2</label>
            <?= $func->getLinkCategory('product', 'item') ?>
        </div>
        <div class="form-group col-xl-2 col-lg-3 col-md-4 col-sm-4 mb-2">
            <label class="d-block">Danh mục cấp 3</label>
            <?= $func->getLinkCategory('product', 'sub') ?>
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
            <h3 class="card-title"><?= $config['product']['title_main'] ?></h3>
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
                        <th class="align-middle text-center" width="5%">STT</th>
                        <th class="align-middle">Hình</th>
                        <th class="align-middle" style="width:35%">Tiêu đề</th>
                        <th class="align-middle" style="width:10%">Ngày tạo</th>
                        <th class="align-middle" style="width:10%">Ngày sửa</th>
                        <?php if (!empty($config['product']['check'])) {
                            foreach ($config['product']['check'] as $key => $value) { ?>
                                <?php
                                if ($key == 'dichvu' && !$func->hasService($configSector)) {
                                    $showCheckAttr = false;
                                } else if ($key == 'phutung' && !$func->hasAccessary($configSector)) {
                                    $showCheckAttr = false;
                                } else {
                                    $showCheckAttr = true;
                                }
                                ?>
                                <?php if ($showCheckAttr) { ?>
                                    <th class="align-middle text-center"><?= $value ?></th>
                        <?php }
                            }
                        } ?>
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
                            if ($items[$i]['id_list']) $linkID .= "&id_list=" . $idSectorList;
                            if ($items[$i]['id_cat']) $linkID .= "&id_cat=" . $idSectorCat;
                            if ($items[$i]['id_item']) $linkID .= "&id_item=" . $items[$i]['id_item'];
                            if ($items[$i]['id_sub']) $linkID .= "&id_sub=" . $items[$i]['id_sub'];
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
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="<?= $configSector['tables']['main'] ?>">
                                </td>
                                <td class="align-middle">
                                    <a href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/<?= $config['product']['thumb'] ?>/<?= UPLOAD_PRODUCT_THUMB . $items[$i]['photo'] ?>" alt="<?= $items[$i]['namevi'] ?>"></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                    <div class="tool-action mt-2 w-clear">
                                        <?php if (!empty($items[$i]['status']) && $items[$i]['status'] == 'xetduyet') { ?>
                                            <?php
                                            $items[$i]['totalComment'] = $comment->totalByID($items[$i]['id']);
                                            $items[$i]['newComment'] = $comment->newPost($items[$i]['id'], 'new-shop');
                                            ?>
                                            <a class="text-primary mr-3" href="<?= $linkComment ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><i class="fas fa-comments mr-1"></i>(<?= $items[$i]['totalComment'] ?>) Comment <?= (!empty($items[$i]['newComment'])) ? '<span class="badge badge-danger align-top">' . $items[$i]['newComment'] . '</span>' : '' ?></a>
                                            <a class="text-info mr-3" href="<?= $linkEdit ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><i class="far fa-edit mr-1"></i>Edit</a>
                                            <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?><?= $linkID ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><i class="far fa-trash-alt mr-1"></i>Delete</a>
                                        <?php } else if (!empty($items[$i]['status']) && $items[$i]['status'] == 'taman') { ?>
                                            <a class="btn btn-sm btn-secondary text-white" title="Đang tạm ẩn">Đang tạm ẩn</a>
                                        <?php } else if (!empty($items[$i]['status']) && $items[$i]['status'] == 'dangsai') { ?>
                                            <a class="btn btn-sm btn-warning" title="Tin đăng sai">Tin đăng sai</a>
                                        <?php } else if (!empty($items[$i]['status']) && $items[$i]['status'] == 'vipham') { ?>
                                            <a class="btn btn-sm btn-danger text-white" title="Tin vi phạm">Tin vi phạm</a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-info text-white" title="Đang chờ duyệt">Đang chờ duyệt</a>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td class="align-middle"><?= (!empty($items[$i]['date_created'])) ? date('d/m/Y h:i:s A', $items[$i]['date_created']) : '' ?></td>
                                <td class="align-middle"><?= (!empty($items[$i]['date_updated'])) ? date('d/m/Y h:i:s A', $items[$i]['date_updated']) : 'Chưa cập nhật' ?></td>
                                <?php
                                $status_attr_array = (!empty($items[$i]['status_attr'])) ? explode(',', $items[$i]['status_attr']) : array();
                                if (!empty($config['product']['check'])) {
                                    foreach ($config['product']['check'] as $key => $value) { ?>
                                        <?php
                                        if ($key == 'dichvu' && !$func->hasService($configSector)) {
                                            $showCheckAttr = false;
                                        } else if ($key == 'phutung' && !$func->hasAccessary($configSector)) {
                                            $showCheckAttr = false;
                                        } else {
                                            $showCheckAttr = true;
                                        }
                                        ?>
                                        <?php if ($showCheckAttr) { ?>
                                            <td class="align-middle text-center">
                                                <?php if (!empty($items[$i]['id']) && in_array($key, array('dichvu', 'phutung'))) { ?>
                                                    <i class="<?= (in_array($key, $status_attr_array)) ? 'fas fa-check-square' : 'fas fa-ban' ?> text-primary text-lg align-top p-1" data-plugin="tooltip" data-html="true" data-placement="top" title="Trạng thái chỉ được chọn duy nhất 1 lần"></i>
                                                <?php } else { ?>
                                                    <div class="custom-control custom-checkbox my-checkbox">
                                                        <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="<?= $configSector['tables']['main'] ?>" data-col="status_attr" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_attr_array)) ? 'checked' : '' ?>>
                                                        <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                <?php }
                                    }
                                } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
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
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?= $linkDelete ?><?= $strUrl ?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
</section>