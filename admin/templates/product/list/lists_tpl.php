<?php
$linkMan = "index.php?com=product&act=man_list";
$linkAdd = "index.php?com=product&act=add_list";
$linkEdit = "index.php?com=product&act=edit_list";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $config['product']['title_main_list'] ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <?php if (!empty($config['website']['debug-developer'])) { ?>
        <div class="card-footer text-sm sticky-top">
            <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
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
    <?php } ?>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title"><?= $config['product']['title_main_list'] ?></h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php if (!empty($config['website']['debug-developer'])) { ?>
                            <th class="align-middle" width="5%">
                                <div class="custom-control custom-checkbox my-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                    <label for="selectall-checkbox" class="custom-control-label"></label>
                                </div>
                            </th>
                            <th class="align-middle text-center" width="10%">STT</th>
                        <?php } ?>
                        <th class="align-middle">Hình</th>
                        <!-- <th class="align-middle">Hình 2</th> -->
                        <th class="align-middle">Hình 3</th>
                        <th class="align-middle" style="width:<?= (!empty($config['website']['debug-developer'])) ? '40%' : '65%' ?>">Tiêu đề</th>
                        <?php if (!empty($config['website']['debug-developer'])) { ?>
                            <?php if (isset($config['product']['check_list'])) {
                                foreach ($config['product']['check_list'] as $key => $value) { ?>
                                    <th class="align-middle text-center"><?= $value ?></th>
                            <?php }
                            } ?>
                        <?php } ?>
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
                        <?php for ($i = 0; $i < count($items); $i++) { ?>
                            <tr>
                                <?php if (!empty($config['website']['debug-developer'])) { ?>
                                    <td class="align-middle">
                                        <div class="custom-control custom-checkbox my-checkbox">
                                            <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?= $items[$i]['id'] ?>" value="<?= $items[$i]['id'] ?>">
                                            <label for="select-checkbox-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?= $items[$i]['numb'] ?>" data-id="<?= $items[$i]['id'] ?>" data-table="product_list">
                                    </td>
                                <?php } ?>
                                <td class="align-middle">
                                    <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/<?= $config['product']['thumb_list'] ?>/<?= UPLOAD_PRODUCT_L . $items[$i]['photo'] ?>" alt="<?= $items[$i]['namevi'] ?>"></a>
                                </td>
                                <?php /* ?>
                                <td class="align-middle">
                                    <a href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="<?=$items[$i]['namevi']?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?=THUMBS?>/<?=$config['product']['thumb2_list']?>/<?=UPLOAD_PRODUCT_L.$items[$i]['photo2']?>" alt="<?=$items[$i]['namevi']?>"></a>
                                </td>
                                <?php */ ?>
                                <td class="align-middle">
                                    <a href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/<?= $config['product']['thumb3_list'] ?>/<?= UPLOAD_PRODUCT_L . $items[$i]['photo3'] ?>" alt="<?= $items[$i]['namevi'] ?>"></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="<?= $items[$i]['namevi'] ?>"><?= $items[$i]['namevi'] ?></a>
                                </td>
                                <?php if (!empty($config['website']['debug-developer'])) { ?>
                                    <?php $status_array = (!empty($items[$i]['status'])) ? explode(',', $items[$i]['status']) : array(); ?>
                                    <?php if (isset($config['product']['check_list'])) {
                                        foreach ($config['product']['check_list'] as $key => $value) { ?>
                                            <td class="align-middle text-center">
                                                <div class="custom-control custom-checkbox my-checkbox">
                                                    <input type="checkbox" class="custom-control-input show-checkbox" id="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" data-table="product_list" data-id="<?= $items[$i]['id'] ?>" data-attr="<?= $key ?>" <?= (in_array($key, $status_array)) ? 'checked' : '' ?>>
                                                    <label for="show-checkbox-<?= $key ?>-<?= $items[$i]['id'] ?>" class="custom-control-label"></label>
                                                </div>
                                            </td>
                                    <?php }
                                    } ?>
                                <?php } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?= $linkEdit ?>&id=<?= $items[$i]['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                </td>
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
    <?php if (!empty($config['website']['debug-developer'])) { ?>
        <div class="card-footer text-sm">
            <a class="btn btn-sm bg-gradient-primary text-white" href="<?= $linkAdd ?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        </div>
    <?php } ?>
</section>