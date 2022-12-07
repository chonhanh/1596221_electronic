<div class="box-Pos">
    <?php if (!empty($stores)) { ?>
        <div class="block-stores p-3">
            <div class="block-label d-flex align-items-center justify-content-between mb-2 py-2">
                <div class="block-label-text">Danh sách cửa hàng <?= $func->get('sector-label') ?></div>
            </div>
            <div class="position-relative mb-3">
                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:3|margin:30" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-store">
                    <?php foreach ($stores as $v_store) { ?>
                        <div class="store">
                            <a class="store-image rounded-main scale-img" href="cua-hang/<?= $v_store['slug' . $lang] ?>/<?= $v_store['id'] ?>?sector=<?= $sector['id'] ?>" title="<?= $v_store['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '300x240x1', 'upload' => UPLOAD_STORE_L, 'image' => $v_store['photo'], 'alt' => $v_store['name' . $lang]]) ?>
                            </a>
                            <h3 class="store-name w-100 mb-0 text-center">
                                <a class="text-decoration-none text-primary-hover <?= (!empty($storeDetail) && $storeDetail['id'] == $v_store['id']) ? 'active' : '' ?> text-uppercase transition" href="cua-hang/<?= $v_store['slug' . $lang] ?>/<?= $v_store['id'] ?>?sector=<?= $sector['id'] ?>" title="<?= $v_store['name' . $lang] ?>"><?= $v_store['name' . $lang] ?></a>
                            </h3>
                        </div>
                    <?php } ?>
                </div>
                <div class="control-store control-owl transition <?= (count($stores) <= 4) ? 'd-none' : '' ?>"></div>
            </div>
            <div class="block-label d-flex align-items-center justify-content-between py-2">
                <div class="store-search search-box border shadow-primary-hover transition m-auto">
                    <input type="text" id="<?= $func->get('search-id') ?>" placeholder="Tìm kiếm gian hàng" onkeypress="doEnter(event, '<?= $func->get('search-obj') ?>');" value="<?= (!empty($_GET[$func->get('search-val')])) ? $_GET[$func->get('search-val')] : '' ?>" autocomplete="off" />
                    <span onclick="onSearchShop('<?= $func->get('search-obj') ?>');"></span>
                </div>
            </div>

        </div>
    <?php } ?>


    <!-- Filters actived -->
    <?php if (!empty($FiltersActived) && $com != 'tim-kiem-cua-hang') {  ?>
        <div class="block-filters-actived mb-1">
            <div class="d-flex flex-wrap align-items-center justify-content-start p-2">
                <?php foreach ($FiltersActived as $v_filter) { ?>
                    <div class="<?= $v_filter['clsFilter'] ?> mr-1 mb-1">
                        <div class="btn btn-sm btn-primary filter-remove <?= $v_filter['clsMain'] ?>" data-remove="true">
                            <span class="text-white"><?= $v_filter['name'] ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x align-top pt-1 pl-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffc107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </div>
                    </div>
                <?php } ?>
                <?php if (count($FiltersActived) >= 2) { ?>
                    <div class="filter-remove-all-store-criteria mb-1">
                        <div class="btn btn-sm btn-danger filter-remove">
                            <span class="text-white">Xóa tất cả</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x align-top pt-1 pl-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffc107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!-- Shop -->
    <div class="block-shops p-2">
        <?php if (!empty($shops)) { ?>
            <div class="form-row">
                <?php foreach ($shops as $v_shop) {
                    $v_shop['href'] = $configBaseShop . $v_shop['slug_url'] . '/';
                    $v_shop['sample'] = !empty($sampleData) ? $sampleData : array();
                    $v_shop['memberSubscribe'] = !empty($memberSubscribe) ? $memberSubscribe : array(); ?>
                    <div class="col-6 mb-3"><?= $func->getShop($v_shop) ?></div>
                <?php } ?>
            </div>
            <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
        <?php } else { ?>
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Lists store ID -->
<div class="lists-store-id d-none">
    <input type="hidden" id="id-city" value="<?= (!empty($IDCity)) ? $IDCity : '' ?>">
    <input type="hidden" id="id-district" value="<?= (!empty($IDDistrict)) ? $IDDistrict : '' ?>">
</div>