<?php
$linkMan = "index.php?com=user&act=man_admin_virtual";
$linkAdd = "index.php?com=user&act=add_admin_virtual";
$linkEdit = "index.php?com=user&act=edit_admin_virtual";
$linkDelete = "index.php?com=user&act=delete_admin_virtual";
$linkPerms = "index.php?com=user&act=add_admin_perms";
?>

<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý tài khoản admin ảo</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <?php if (!$func->checkRole()) { ?>
            <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <?php } ?>
        <div class="form-inline form-search d-inline-block align-middle <?= (!$func->checkRole()) ? 'ml-3' : '' ?>">
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
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách tài khoản admin ảo</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle">Tài khoản</th>
                        <th class="align-middle">Họ tên</th>
                        <th class="align-middle">Email</th>
                        <?php if ($func->getGroup('loggedByLeader')) { ?>
                            <th class="align-middle text-align">Phân quyền</th>
                        <?php } ?>
                        <?php if (isset($config['user']['check_admin_virtual'])) {
                            foreach ($config['user']['check_admin_virtual'] as $key => $value) { ?>
                                <th class="align-middle text-center"><?= $value ?></th>
                        <?php }
                        } ?>
                        <?php if (!$func->checkRole()) { ?>
                            <th class="align-middle text-center">Thao tác</th>
                        <?php } ?>
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
                            $hrefEdit = !$func->checkRole() ? $linkEdit . '&id=' . $items[$i]['id'] : 'javascript:void(0)';
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="user">
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $hrefEdit ?>" title="<?= $items[$i]['username'] ?>"><?= $items[$i]['username'] ?></a>
                                    <strong class="text-info d-block"><?= $items[$i]['GroupName'] ?></strong>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $hrefEdit ?>" title="<?= $items[$i]['fullname'] ?>"><?= $items[$i]['fullname'] ?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $hrefEdit ?>" title="<?= $items[$i]['email'] ?>"><?= $items[$i]['email'] ?></a>
                                </td>
                                <?php if ($func->getGroup('loggedByLeader')) { ?>
                                    <th class="align-middle text-align">
                                        <a class="btn bg-gradient-warning" href="<?= $linkPerms ?>&id=<?= $items[$i]['id'] ?>" href="Phân quyền"><i class="fas fa-user-lock"></i></a>
                                    </th>
                                <?php } ?>
                                <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                <?php if (isset($config['user']['check_admin_virtual'])) {
                                    foreach ($config['user']['check_admin_virtual'] as $key => $value) { ?>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="user" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                                <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                <?php }
                                } ?>
                                <?php if (!$func->checkRole()) { ?>
                                    <td class="align-middle text-center text-md text-nowrap">
                                        <a class="text-primary mr-2" href="<?= $hrefEdit ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                        <a class="text-danger" id="delete-item" data-message="Bạn muốn xóa tài khoản này này ?" data-url="<?= $linkDelete ?>&id=<?= $items[$i]['id'] ?>"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if ($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?= $paging ?>
        </div>
    <?php } ?>
    <?php if (!$func->checkRole()) { ?>
        <div class="card-footer text-sm">
            <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        </div>
    <?php } ?>
</section>