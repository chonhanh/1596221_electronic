<div class="menu">
    <ul class="block-content d-flex align-items-center justify-content-between">
        <li><a class="transition <?php if ($com == '' || $com == 'index') echo 'active'; ?>" href="" title="<?= trangchu ?>"><?= trangchu ?></a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'gioi-thieu') echo 'active'; ?>" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
        <li class="line"></li>
        <li>
            <a class="transition <?php if ($com == 'san-pham') echo 'active'; ?>" href="san-pham" title="<?= sanpham ?>"><?= sanpham ?></a>
            <?php if (!empty($sectorItemsPage['active'])) { ?>
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
            <?php } ?>
        </li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'dich-vu') echo 'active'; ?>" href="dich-vu" title="Dịch vụ">Dịch vụ</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'khuyen-mai') echo 'active'; ?>" href="khuyen-mai" title="Khuyến mãi">Khuyến mãi</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'chinh-sach') echo 'active'; ?>" href="chinh-sach" title="Chính sách">Chính sách</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'thong-tin') echo 'active'; ?>" href="thong-tin" title="Thông tin">Thông tin</a></li>
        <li class="line"></li>
        <li><a class="transition <?php if ($com == 'lien-he') echo 'active'; ?>" href="lien-he" title="<?= lienhe ?>"><?= lienhe ?></a></li>
        <li class="ml-auto">
            <div class="search shadow-primary-hover transition">
                <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" value="<?= (!empty($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" autocomplete="off" />
                <span onclick="onSearch('keyword');"></span>
            </div>
        </li>
    </ul>
</div>