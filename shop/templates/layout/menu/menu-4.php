<div class="menu">
    <ul class="block-content d-flex align-items-center justify-content-between">
        <li><a class="transition <?php if ($com == '' || $com == 'index') echo 'active'; ?>" href="" title="<?= trangchu ?>"><?= trangchu ?></a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'gioi-thieu') echo 'active'; ?>" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
        <li class="line"></li>
        <li>
            <a class="transition <?php if ($com == 'nha-dat') echo 'active'; ?>" href="nha-dat" title="Nhà đất">Nhà đất</a>
            <?php if (!empty($sectorItemsPage['active'])) { ?>
                <ul>
                    <?php foreach ($sectorItemsPage['active'] as $kitem => $vitem) { ?>
                        <li>
                            <a class="transition" title="<?= $vitem['name' . $lang] ?>" href="nha-dat?item=<?= $vitem['id'] ?>"><?= $vitem['name' . $lang] ?></a>
                            <?php if (!empty($sectorSubsPage['active'])) { ?>
                                <ul>
                                    <?php foreach ($sectorSubsPage['active'] as $ksub => $vsub) {
                                        if ($vsub['id_item'] == $vitem['id']) { ?>
                                            <li>
                                                <a class="transition" title="<?= $vsub['name' . $lang] ?>" href="nha-dat?item=<?= $vitem['id'] ?>&sub=<?= $vsub['id'] ?>"><?= $vsub['name' . $lang] ?></a>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'tin-tuc') echo 'active'; ?>" href="tin-tuc" title="Tin tức">Tin tức</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'thong-bao') echo 'active'; ?>" href="thong-bao" title="Thông báo">Thông báo</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'lien-he') echo 'active'; ?>" href="lien-he" title="<?= lienhe ?>"><?= lienhe ?></a></li>
        <li class="ml-auto mr-0">
            <div class="search shadow-primary-hover transition">
                <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" value="<?= (!empty($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" autocomplete="off" />
                <span onclick="onSearch('keyword');"></span>
            </div>
        </li>
    </ul>
</div>