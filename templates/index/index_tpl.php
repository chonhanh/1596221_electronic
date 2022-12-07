

<?php if (!empty($sectors)) { ?>
    <div class="block-sectors mb-5">

            <?php
            if (!empty($groupCat['data'])) {
                foreach ($groupCat['data'] as $kGroup => $vGroup) {
                    foreach ($vGroup as $k => $v) {
                         // Params 
                        $params = array();
                        $params['sector'] = $defineSectors['types'][$k];
                        $params['data'] = $v;
                        $params['lang'] = $lang;
                        $params['sluglang'] = $sluglang;
                        $params['show'] = $groupCat['show'];
                        $params['get'] = $groupCat['get'];

                         // Get template 
                        echo $func->markdown('sector/home-cat', $params);
                    }
                }
            }
            ?>
<?php /*
            <div class="sectors-job">
                <div class="sectors-title text-center mb-3">
                    <a class="sectors-text text-decoration-none text-primary-hover transition mb-2" href="javascript:void(0)" title="Việc làm">Việc làm</a>
                </div>
                <div class="flex-job d-flex align-items-start justify-content-between">
                    <a class="block-job d-block rounded-circle scale-img" href="ung-vien" title="Ứng viên"><?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '240x240x1', 'upload' => 'assets/images/', 'image' => 'candidate.png', 'alt' => 'Ứng viên']) ?></a>
                    <a class="block-job d-block rounded-circle scale-img" href="nha-tuyen-dung" title="Nhà tuyển dụng"><?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '240x240x1', 'upload' => 'assets/images/', 'image' => 'employer.png', 'alt' => 'Nhà tuyển dụng']) ?></a>
                </div>
            </div>
            */ ?>

    </div>
<?php } ?>

<?php /*if (!empty($about)) { ?>
    <div class="block-about text-center">
        <div class="block-content">
            <h3 class="about-title position-relative pb-2 mb-3">
                <a class="text-decoration-none text-uppercase text-primary-hover transition" href="gioi-thieu" title="<?= $about['name' . $lang] ?>"><?= $about['name' . $lang] ?></a>
            </h3>
            <div class="about-desc mx-auto mb-3"><?= nl2br($about['desc' . $lang]) ?></div>
            <a class="btn btn-warning text-sm" href="gioi-thieu" title="Xem thêm">Xem thêm</a>
        </div>
    </div>
<?php }*/ ?>