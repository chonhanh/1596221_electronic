<div class="comment-item">
    <div class="comment-item-poster">
        <?php if (!empty($params['lists']['memberAvatar'])) { ?>
            <div class="comment-item-avatar"><img class="w-100" onerror="src='assets/images/noimage.png'" src="<?= THUMBS_COMMENT ?>/65x65x1/<?= UPLOAD_USER_L . $params['lists']['memberAvatar'] ?>" alt="<?= $params['lists']['memberName'] ?>"></div>
        <?php } else { ?>
            <div class="comment-item-letter"><?= $this->subName($params['lists']['memberName']) ?></div>
        <?php } ?>

        <div class="comment-item-name"><?= $params['lists']['memberName'] ?></div>
        <div class="comment-item-posttime"><?= $this->timeAgo($params['lists']['date_posted']) ?></div>
    </div>
    <div class="comment-item-information">
        <div class="comment-item-rating mb-2 w-clear">
            <div class="comment-item-star comment-star mb-0">
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <span style="width: <?= $this->scoreStar($params['lists']['star']) ?>%;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </span>
            </div>
            <div class="comment-item-title"><?= $this->decodeHtmlChars($params['lists']['title']) ?><?= (strstr($params['lists']['status'], 'new-shop')) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
        </div>

        <div class="comment-item-content mb-2"><?= nl2br($this->decodeHtmlChars($params['lists']['content'])) ?></div>

        <a class="btn-reply-comment d-inline-block align-top text-decoration-none text-primary mb-2" href="javascript:void(0)" data-name="<?= $params['lists']['memberName'] ?>">Trả lời</a>

        <?php
        if (!empty($params['lists']['photo']) || !empty($params['lists']['video'])) {
            include LIBRARIES . "sample/comment/media.php";
        }
        ?>

        <?php if (!empty($params['lists']['replies'])) {
            $params['replies'] = $params['lists']['replies']; ?>
            <!-- Replies -->
            <div class="comment-replies mt-3">
                <div class="comment-replies-load">
                    <?php include LIBRARIES . "sample/comment/replies.php"; ?>
                </div>
                <?php if ($this->totalReplies($params['lists']['id'], $params['id_product']) > $this->limitChildShow) { ?>
                    <div class="comment-load-more-control border-top text-left mt-4 pt-3">
                        <input type="hidden" class="limit-from" value="<?= $this->limitChildShow ?>">
                        <input type="hidden" class="limit-get" value="<?= $this->limitChildGet ?>">
                        <input type="hidden" class="id-parent" value="<?= $params['lists']['id'] ?>">
                        <input type="hidden" class="id-product" value="<?= $params['id_product'] ?>">
                        <button class="btn-load-more-comment-child text-primary text-decoration-none" href="javascript:void(0)" title="Xem thêm bình luận">Xem thêm bình luận</button>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php include LIBRARIES . "sample/comment/reply.php"; ?>
    </div>
</div>