<?php
if ($act == "add") $labelAct = "Thêm mới";
else if ($act == "edit") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=shop&act=man&id_list=" . $id_list;
if ($act == 'add') $linkFilter = "index.php?com=shop&act=add&id_list=" . $id_list;
else if ($act == 'edit') $linkFilter = "index.php?com=shop&act=edit&id_list=" . $id_list . "&id=" . $id;
$linkSave = "index.php?com=shop&act=save&id_list=" . $id_list . "&backPage=" . $backPage;

$flashSlugURL = (!empty($flash->has('slug_url'))) ? $flash->get('slug_url') . '/' : @$item['slug_url'] . '/';
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-shop"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <?php if (!empty($item['status'])) { ?>
            <?php if ($item['status'] == 'deleted') { ?>
                <div class="alert my-alert alert-danger mb-2">Đã được xóa bởi chử sở hữu</div>
            <?php } ?>

            <?php if (in_array($item['status'], array('dangsai', 'vipham'))) { ?>
                <?php if ($item['status'] == 'dangsai') { ?>
                    <div class="alert my-alert alert-warning mb-2">Gian hàng đang bị tạm dừng hoạt động do người dùng báo đăng sai.</div>
                <?php } else if ($item['status'] == 'vipham') { ?>
                    <div class="alert my-alert alert-danger mb-2">Gian hàng đã bị khóa do vi phạm hoặc bị chặn nhiều lần.</div>
                <?php } ?>
                <a class="btn btn-sm bg-gradient-info mb-2" target="_blank" href="index.php?com=report&act=edit_report_shop&id_list=<?= $configSector['id'] ?>&id_shop=<?= $item['id'] ?>" title="Xem báo cáo">Xem báo cáo</a>
            <?php } ?>
        <?php } ?>

        <?php if (!empty($item['status_attr']) && strstr($item['status_attr'], 'virtual')) { ?>
            <div class="alert my-alert alert-info mb-2">Gian hàng Ảo. Được tạo bới Ban Quản Trị. Sẽ trở thành gian hàng chính thức khi được chuyển thông tin</div>
        <?php } ?>

        <div class="row">
            <div class="col-xl-8">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin gian hàng</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-group">
                                <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                                <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                            </div>
                            <?php if (!empty($item['status']) && $item['status'] == 'deleted') { ?>
                                <a class="btn btn-sm bg-gradient-info" id="restore-shop" href="javascript:void(0)" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $item['id'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<span class='text-light'>Kích hoạt lại gian hàng</span>"><i class="fas fa-sync mr-1"></i>Khôi phục</a>
                            <?php } else if (!empty($item['slug_url'])) { ?>
                                <a class="btn btn-sm bg-gradient-success" target="_blank" href="<?= $configBaseShop . $item['slug_url'] ?>/" title="<?= $item['name'] ?>"><i class="fas fa-store mr-2"></i>View shop</a>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="d-block" for="name">Tên gian hàng:</label>
                                <?php if ($act == 'edit') { ?>
                                    <input type="text" class="form-control text-sm" placeholder="Tên gian hàng" value="<?= @$item['name'] ?>" readonly>
                                <?php } else { ?>
                                    <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tên gian hàng" value="<?= (!empty($flash->has('name'))) ? $flash->get('name') : @$item['name'] ?>" required>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block" for="email">Email:</label>
                                <?php if ($act == 'edit') { ?>
                                    <input type="text" class="form-control text-sm" placeholder="Email" value="<?= @$item['email'] ?>" readonly>
                                <?php } else { ?>
                                    <input type="text" class="form-control text-sm" name="data[email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$item['email'] ?>" required>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block" for="username">Tên đăng nhập:</label>
                                <input type="text" class="form-control text-sm" name="data[username]" id="username" placeholder="Tên đăng nhập" value="<?= (!empty($flash->has('username'))) ? $flash->get('username') : @$item['username'] ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block" for="password">Mật khẩu:</label>
                                <input type="text" class="form-control text-sm" name="data[password]" id="password" placeholder="Mật khẩu" value="<?= (!empty($flash->has('password'))) ? $flash->get('password') : @$item['password'] ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="d-block" for="phone">Điện thoại:</label>
                                <input type="text" class="form-control text-sm" name="data[phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$item['phone'] ?>" required>
                            </div>
                            <div class="form-group col-12">
                                <label class="d-block" for="url-shop">Link gian hàng:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-sm" id="url-shop"><?= $configBaseShop ?></span>
                                    </div>
                                    <input type="text" class="form-control text-sm" id="url-shop" placeholder="Link gian hàng" value="<?= $flashSlugURL ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label class="d-block" for="url-shop-admin">Link quản trị gian hàng:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-sm" id="url-shop-admin"><?= $configBaseShop ?></span>
                                    </div>
                                    <input type="text" class="form-control text-sm" id="url-shop-admin" placeholder="Link quản trị gian hàng" value="<?= $flashSlugURL ?>" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-sm" id="url-shop-admin">admin/</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($act == "edit" && (!empty($item['id_member']) || !empty($item['id_admin']))) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chủ sở hữu</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!strstr($item['status_attr'], 'virtual')) { ?>
                                <div class="mb-3"><strong class="pr-1">Người đăng:</strong><strong class="text-uppercase text-danger pr-1"><?= (!empty($item['id_member'])) ? 'Thành viên' : ((!empty($item['id_admin'])) ? 'Ban quản trị' : '') ?></strong></div>
                            <?php } else { ?>
                                <a class="btn btn-sm bg-gradient-info mb-3" id="transfer-shop" href="javascript:void(0)" data-table="<?= $configSector['tables']['shop'] ?>" data-id="<?= $item['id'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<span class='text-light'>Chuyển thông tin gian hàng và thông tin thành viên trở thành thông tin chính thức</span>"><i class="fas fa-sync mr-1"></i>Chuyển thông tin</a>
                                <div class="alert my-alert alert-info mb-3">Thông tin thành viên dưới đây sẽ trở thành thông tin chính thức khi được Chuyển Thông Tin</div>
                            <?php } ?>
                            <div class="row">
                                <?php if (strstr($item['status_attr'], 'virtual')) { ?>
                                    <div class="form-group col-md-4">
                                        <label for="username">Tài khoản:</label>
                                        <input type="text" class="form-control text-sm" id="username_owner" placeholder="Tài khoản" value="<?= @$itemOwner['username'] ?>" disabled readonly>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-4">
                                    <label for="fullname">Họ tên:</label>
                                    <input type="text" class="form-control text-sm" id="fullname_owner" placeholder="Họ tên" value="<?= @$itemOwner['fullname'] ?>" disabled readonly>
                                </div>
                                <?php if (strstr($item['status_attr'], 'virtual')) { ?>
                                    <div class="form-group col-md-4">
                                        <label for="password_virtual">Mật khẩu:</label>
                                        <input type="text" class="form-control text-sm" id="password_virtual_owner" placeholder="Mật khẩu" value="<?= @$itemOwner['password_virtual'] ?>" disabled readonly>
                                    </div>
                                <?php } ?>
                                <div class="form-group col-md-4">
                                    <label for="phone">Số điện thoại:</label>
                                    <input type="text" class="form-control text-sm" id="phone_owner" placeholder="Số điện thoại" value="<?= @$itemOwner['phone'] ?>" disabled readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control text-sm" id="email_owner" placeholder="Email" value="<?= @$itemOwner['email'] ?>" disabled readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control text-sm" id="address_owner" placeholder="Địa chỉ" value="<?= @$itemOwner['address'] ?>" disabled readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($act == "add" && $func->getGroup('virtual')) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin thành viên ảo</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Tài khoản:</label>
                                    <input type="text" class="form-control text-sm" name="dataOwnerVirtual[username]" id="username_owner_virtual" placeholder="Tài khoản" value="<?= (!empty($flash->has('username_owner_virtual'))) ? $flash->get('username_owner_virtual') : @$itemOwner['username'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Họ tên:</label>
                                    <div class="input-group">
                                        <input type="text" class="col-8 form-control text-sm" name="dataOwnerVirtual[first_name]" id="first_name_owner_virtual" placeholder="Họ" value="<?= (!empty($flash->has('first_name_owner_virtual'))) ? $flash->get('first_name_owner_virtual') : @$itemOwner['first_name'] ?>" required>
                                        <input type="text" class="col-4 form-control text-sm" name="dataOwnerVirtual[last_name]" id="last_name_owner_virtual" placeholder="Tên" value="<?= (!empty($flash->has('last_name_owner_virtual'))) ? $flash->get('last_name_owner_virtual') : @$itemOwner['last_name'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Mật khẩu:</label>
                                    <input type="text" class="form-control text-sm" name="dataOwnerVirtual[password_virtual]" id="password_virtual_owner_virtual" placeholder="Mật khẩu" value="<?= (!empty($flash->has('password_virtual_owner_virtual'))) ? $flash->get('password_virtual_owner_virtual') : @$itemOwner['password_virtual'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Email:</label>
                                    <input type="text" class="form-control text-sm" name="dataOwnerVirtual[email]" id="email_owner_virtual" placeholder="Email" value="<?= (!empty($flash->has('email_owner_virtual'))) ? $flash->get('email_owner_virtual') : @$itemOwner['email'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Điện thoại:</label>
                                    <input type="text" class="form-control text-sm" name="dataOwnerVirtual[phone]" id="phone_owner_virtual" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone_owner_virtual'))) ? $flash->get('phone_owner_virtual') : @$itemOwner['phone'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Giới tính:</label>
                                    <?php $flashGender = $flash->get('gender_owner_virtual'); ?>
                                    <select class="custom-select text-sm" name="dataOwnerVirtual[gender]" id="gender_owner_virtual" required>
                                        <option value="">Chọn giới tính</option>
                                        <option <?= (!empty($flashGender) && $flashGender == 1) ? 'selected' : ((@$itemOwner['gender'] == 1) ? 'selected' : '') ?> value="1">Nam</option>
                                        <option <?= (!empty($flashGender) && $flashGender == 2) ? 'selected' : ((@$itemOwner['gender'] == 2) ? 'selected' : '') ?> value="2">Nữ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-xl-4">
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group-category row">
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_cat">Danh mục cấp 1:</label>
                                <?= $func->getAjaxCategory('product', 'cat') ?>
                            </div>
                        
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_store">Danh sách cửa hàng:</label>
                                <select class="form-control select2" name="data[id_store]" id="id_store">
                                    <option value="">Chọn danh mục</option>
                                    <?php if (!empty($store)) {
                                        foreach ($store as $v) { ?>
                                            <option <?= ((!empty($_GET['id_store']) && $_GET['id_store'] == $v['id']) || (@$item['id_store'] == $v['id'])) ? 'selected' : '' ?> value="<?= $v['id'] ?>"><?= $v['namevi'] ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_region">Vùng/miền:</label>
                                <?= $func->getAjaxPlace("region") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_city">Tỉnh/thành phố:</label>
                                <?= $func->getAjaxPlace("city") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_district">Quận/huyện:</label>
                                <?= $func->getAjaxPlace("district") ?>
                            </div>
                            <div class="form-group col-xl-6 col-sm-4">
                                <label class="d-block" for="id_wards">Phường/xã:</label>
                                <?= $func->getAjaxPlace("wards") ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Hình ảnh</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $photoDetail = (!empty($item['photo'])) ? UPLOAD_SHOP . $item['photo'] : '';
                        $dimension = "Width: " . $config['shop']['width'] . " px - Height: " . $config['shop']['height'] . " px (" . $config['shop']['img_type'] . ")";
                        include TEMPLATE . LAYOUT . "image.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-shop"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>