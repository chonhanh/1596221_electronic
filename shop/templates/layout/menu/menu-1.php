<div class="menu px-2">
    <ul class="d-flex align-items-center ">
        <li>
            <a class="transition <?php if ($com == 'san-pham' || $com == '') echo 'active'; ?>" href="san-pham" title="<?= sanpham ?>"><?= sanpham ?></a>
            <?php /*if (!empty($sectorItemsPage['active'])) { ?>
                <ul>
                    <?php foreach ($sectorItemsPage['active'] as $kitem => $vitem) { ?>
                        <li>
                            <a class="transition" title="<?= $vitem['name' . $lang] ?>" href="san-pham?item=<?= $vitem['id'] ?>"><?= $vitem['name' . $lang] ?></a>
                            <?php if (!empty($sectorSubsPage['active'])) { ?>
                                <ul>
                                    <?php foreach ($sectorSubsPage['active'] as $ksub => $vsub) {
                                        if ($vsub['id_item'] == $vitem['id']) { ?>
                                            <li>
                                                <a class="transition" title="<?= $vsub['name' . $lang] ?>" href="san-pham?item=<?= $vitem['id'] ?>&sub=<?= $vsub['id'] ?>"><?= $vsub['name' . $lang] ?></a>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php }*/ ?>
        </li>

        <li><a class="transition <?php if ($com == 'gioi-thieu') echo 'active'; ?>" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
        
        <li><a class="transition <?php if ($com == 'lien-he') echo 'active'; ?>" href="lien-he" title="<?= lienhe ?>"><?= lienhe ?></a></li>
        
    </ul>
    <?php if ($com == 'san-pham' || $com == 'index' || $com == '') { ?>
        <div class="tab-cont">

            <?php if (!empty($sectorItemsPage['active'])) { ?>
                <div class="sector-scroll-items sector-scroll custom-mcsrcoll-x filter-item d-flex align-items-start justify-content-start border p-2">
                    <?php foreach ($sectorItemsPage['active'] as $v_item) { ?>
                        <div class="sectors sectors-item <?= $sector['prefix'] ?> float-left mr-2 <?= (!empty($IDItem) && @$IDItem == $v_item['id']) ? 'active' : '' ?>" data-id="<?= $v_item['id'] ?>" >
                            <a class="sectors-image scale-img" href="san-pham?item=<?=$v_item['id'] ?>" title="<?= $v_item['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '315x230x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_item['photo'], 'alt' => $v_item['name' . $lang]]) ?>
                            </a>
                            <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                                <a class="text-decoration-none text-primary-hover <?= (!empty($IDItem) && @$IDItem == $v_item['id']) ? 'active' : '' ?> text-uppercase transition" href="san-pham?item=<?= $v_item['id'] ?>" title="<?= $v_item['name' . $lang] ?>"><?= $v_item['name' . $lang] ?></a>
                            </h3>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if (!empty($sectorSubsPage['active'])) { ?>
                <div class="sector-scroll-subs sector-scroll custom-mcsrcoll-x filter-item d-flex align-items-start justify-content-start border p-2">
                    <?php foreach ($sectorSubsPage['active'] as $vsub) { ?>
                        <div class="sectors sectors-sub <?= $sector['prefix'] ?> float-left mr-2 "" >
                            <a class="sectors-image scale-img" href="san-pham?item=<?= $vsub['id_item'] ?>&sub=<?= $vsub['id'] ?>" title="<?= $vsub['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '315x230x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $vsub['photo'], 'alt' => $vsub['name' . $lang]]) ?>
                            </a>
                            <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                                <a class="text-decoration-none text-primary-hover <?= (!empty($IDSub) && @$IDSub == $vsub['id']) ? 'active' : '' ?> text-uppercase transition" href="san-pham?item=<?= $vsub['id_item'] ?>&sub=<?= $vsub['id'] ?>" title="<?= $vsub['name' . $lang] ?>"><?= $vsub['name' . $lang] ?></a>
                            </h3>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>  

    <?php } ?>
    <div class="py-3">
        <div class="search shadow-primary-hover transition m-auto">
            <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" value="<?= (!empty($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" autocomplete="off" />
            <span onclick="onSearch('keyword');"></span>
        </div>
    </div>
</div>