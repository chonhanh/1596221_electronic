<div class="sectors-<?= $params['sector']['prefix'] ?> mb-4">
    <div class="sectors-<?= $params['sector']['prefix'] ?>">
        <div class="sectors-title d-flex align-items-center justify-content-between mb-4">
            <a class="sectors-text text-nowrap text-decoration-none text-primary-hover transition mr-4" href="javascript:void(0)" title="<?= $params['sector']['name'] ?>"><?= $params['sector']['name'] ?></a>
            <div class="sectors-search search-block rounded d-flex align-items-center justify-content-start">
                <input class="search-text rounded-left" type="text" id="keyword-shop-<?= $params['sector']['id'] ?>" placeholder="Tìm tên Công ty và tên Cửa hàng ngành <?= $params['sector']['name'] ?>" onkeypress="doEnter(event, 'keyword-shop|<?= $params['sector']['id'] ?>');" autocomplete="off" />
                <div class="search-button rounded-right" onclick="onSearchShop('keyword-shop|<?= $params['sector']['id'] ?>');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a0a0a0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
            <a class="sectors-video nav-icon text-decoration-none ml-4" href="video?sector=<?= $params['sector']['id'] ?>" data-plugin="tooltip" data-placement="top" title="Tổng hợp các video của ngành <?= $params['sector']['name'] ?>">
                <?= $this->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'video.png', 'alt' => 'Video']) ?>
                <span class="text-dark">Xem video ngành <?= $params['sector']['name'] ?></span>
            </a>
        </div>
        <div class="sectors-content">
            <div class="sector-group-cat-loader mb-3" id="<?= $params['sector']['prefix'] ?>">
                <div class="row">
                    <?php foreach ($params['data'] as $k => $v) {
                        if ($k < $params['show']) {
                            $v['name-main'] = $v['name' . $params['lang']];
                            $v['href-main'] = $params['sector']['type'] . '?cat=' . $v['id'];
                            $v['name-store'] = $v['name_store' . $params['lang']];
                            $v['href-store'] = "nhom-cua-hang/" . $v[$params['sluglang']] . "/" . $v['id'] . "?sector=" . $params['sector']['id'];

                            if ($params['sector']['prefix'] == 'realestate') {
                                echo '<div class="col-4 p-0">' . $this->getGroupCat($v) . '</div>';
                            } else {
                                echo '<div class="col-3 p-0">' . $this->getGroupCat($v) . '</div>';
                            }
                        }
                    } ?>
                </div>
            </div>
            <?php if (count($params['data']) > $params['show']) { ?>
                <div class="load-more-control text-center" id="sector">
                    <input type="hidden" class="limit-from" value="<?= $params['show'] ?>">
                    <input type="hidden" class="limit-get" value="<?= $params['get'] ?>">
                    <input type="hidden" class="id-list" value="<?= $params['sector']['id'] ?>">
                    <a class="load-more-button d-inline-block align-top text-primary-hover text-decoration-none text-uppercase transition" id="sector">
                        <span class="d-inline-block align-top transition">Xem thêm danh mục <?= $params['sector']['name'] ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>