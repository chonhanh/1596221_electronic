<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <div class="comment-page">
        <div class="card mb-4">
            <div class="card-header"><strong>Đánh Giá Trung Bình</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="comment-avg-point mb-4">
                            <div class="text-center">
                                <div class="comment-point"><strong><?= $comment->avgPoint() ?>/5</strong></div>
                                <div class="comment-star">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span style="width: <?= $comment->avgStar() ?>%">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                </div>
                                <div class="comment-count"><a>(<?= $comment->total ?> nhận xét)</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="comment-progress-percent">
                            <div class="comment-progress rate-5">
                                <span class="progress-num">5</span>
                                <div class="progress">
                                    <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(5) ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <span class="progress-total"><?= $comment->perScore(5) ?>%</span>
                            </div>
                            <div class="comment-progress rate-4">
                                <span class="progress-num">4</span>
                                <div class="progress">
                                    <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(4) ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <span class="progress-total"><?= $comment->perScore(4) ?>%</span>
                            </div>
                            <div class="comment-progress rate-3">
                                <span class="progress-num">3</span>
                                <div class="progress">
                                    <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(3) ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <span class="progress-total"><?= $comment->perScore(3) ?>%</span>
                            </div>
                            <div class="comment-progress rate-2">
                                <span class="progress-num">2</span>
                                <div class="progress">
                                    <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(2) ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <span class="progress-total"><?= $comment->perScore(2) ?>%</span>
                            </div>
                            <div class="comment-progress rate-1">
                                <span class="progress-num">1</span>
                                <div class="progress">
                                    <div class="progress-bar" id="has-rate" style="width: <?= $comment->perScore(1) ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <span class="progress-total"><?= $comment->perScore(1) ?>%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="border rounded shadow px-3 py-3 mb-3">
                            <div class="media">
                                <a class="scale-img mr-3" target="_blank" href="<?= $sector['type'] . '/' . $productDetail[$sluglang] . '/' . $productDetail['id'] ?>" title="Chi tiết">
                                    <?= $func->getImage(['class' => 'rounded', 'sizes' => '90x90x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $productDetail['photo'], 'alt' => $productDetail['name' . $lang]]) ?>
                                </a>
                                <div class="media-body">
                                    <h6 class="text-capitalize mb-1"><a class="text-decoration-none text-primary-hover transition" target="_blank" href="<?= $sector['type'] . '/' . $productDetail[$sluglang] . '/' . $productDetail['id'] ?>" title="Chi tiết"><?= $productDetail['name' . $lang] ?></a></h6>
                                    <div class="text-muted mb-2">Ngày đăng: <?= date('d/m/Y', $productDetail['date_created']) ?></div>
                                    <a class="btn btn-sm btn-primary text-capitalize py-1 px-2" target="_blank" href="<?= $sector['type'] . '/' . $productDetail[$sluglang] . '/' . $productDetail['id'] ?>" title="Chi tiết">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Danh sách bình luận</strong></div>
            <div class="card-body">
                <?php if (!empty($comment->lists)) { ?>
                    <div class="comment-lists">
                        <div class="comment-load">
                            <?php
                            foreach ($comment->lists as $v_lists) {
                                /* Params data */
                                $comment->params = array();
                                $comment->params['id_product'] = $productDetail['id'];
                                $comment->params['is_check'] = true;
                                $comment->params['variant'] = 'personal';
                                $comment->params['lists'] = $v_lists;
                                $comment->params['lists']['photo'] = $comment->photo($v_lists['id']);
                                $comment->params['lists']['video'] = $comment->video($v_lists['id']);
                                $comment->params['lists']['replies'] = $comment->replies($v_lists['id'], $productDetail['id']);

                                /* Get template */
                                echo $comment->markdown('customer/lists', $comment->params);
                            }
                            ?>
                        </div>
                        <?php if ($comment->total > $comment->limitParentShow) { ?>
                            <div class="comment-load-more-control text-center mt-4">
                                <input type="hidden" class="limit-from" value="<?= $comment->limitParentShow ?>">
                                <input type="hidden" class="limit-get" value="<?= $comment->limitParentGet ?>">
                                <input type="hidden" class="id-product" value="<?= $productDetail['id'] ?>">
                                <input type="hidden" class="is-check" value="1">
                                <input type="hidden" class="variant" value="<?= (!empty($productDetail['id_shop'])) ? 'shop' : 'personal' ?>">
                                <button class="btn btn-sm btn-primary btn-load-more-comment-parent rounded-0 w-100 font-weight-bold py-2 px-3" href="javascript:void(0)" title="Tải thêm bình luận">Tải thêm bình luận</button>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>