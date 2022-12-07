<div class="menu">
    <div class="block-content d-flex align-items-center justify-content-between w-100">
        <a class="menu-logo" href="" title="<?= $setting['name' . $lang] ?>">
            <?= $func->getImage(['sizes' => '125x60x2', 'upload' => UPLOAD_PHOTO_THUMB, 'image' => $logo['photo'], 'alt' => $setting['name' . $lang]]) ?>
        </a>
        <div class="menu-nav">
            <ul class="d-flex align-items-center justify-content-start">
                <?php if (!empty($sectorItemsPage['menu'])) {
                    foreach ($sectorItemsPage['menu'] as $kitem => $vitem) {
                        if (($kitem + 1) <= 5) { ?>
                            <li class="menu-nav-li mr-2">
                                <a class="menu-nav-item transition" title="<?= $vitem['name' . $lang] ?>" href="san-pham?item=<?= $vitem['id'] ?>"><?= $vitem['name' . $lang] ?></a>
                                <?php if (!empty($sectorSubsPage['active'])) { ?>
                                    <div class="menu-nav-block">
                                        <ul class="d-flex align-items-center justify-content-start">
                                            <?php foreach ($sectorSubsPage['active'] as $ksub => $vsub) {
                                                if ($vsub['id_item'] == $vitem['id']) { ?>
                                                    <li class="menu-nav-li">
                                                        <a class="menu-nav-item transition" title="<?= $vsub['name' . $lang] ?>" href="javascript:void(0)" data-item="<?= $vitem['id'] ?>" data-sub="<?= $vsub['id'] ?>"><?= $vsub['name' . $lang] ?></a>
                                                    </li>
                                            <?php }
                                            } ?>
                                        </ul>
                                        <div class="menu-nav-item-<?= $vitem['id'] ?>"></div>
                                    </div>
                                <?php } ?>
                            </li>
                <?php }
                    }
                } ?>
                <li class="mr-0">
                    <div class="search shadow-primary-hover transition">
                        <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" value="<?= (!empty($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" autocomplete="off" />
                        <span onclick="onSearch('keyword');"></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>