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
            <div class="comment-item-title"><?= $this->func->decodeHtmlChars($params['lists']['title']) ?><?= (strstr($params['lists']['status'], 'new-admin')) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
        </div>

        <div class="comment-item-content mb-2"><?= nl2br($this->func->decodeHtmlChars($params['lists']['content'])) ?></div>

        <div class="comment-action mb-2">
            <a class="btn btn-sm btn-info btn-reply-comment mr-1" href="javascript:void(0)" data-name="<?= $params['lists']['memberName'] ?>">Trả lời</a>
            <a class="btn btn-sm <?= (strstr($params['lists']['status'], 'hienthi')) ? 'btn-warning' : 'btn-primary' ?> btn-status-comment mr-1" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-new-sibling="comment-item-rating" data-status="hienthi"><?= (strstr($params['lists']['status'], 'hienthi')) ? 'Bỏ duyệt' : 'Duyệt' ?></a>
            <a class="btn btn-sm btn-danger btn-delete-comment" href="javascript:void(0)" data-id="<?= $params['lists']['id'] ?>" data-class="comment-item" data-parents="comment-lists">Xóa</a>
        </div>

        <?php
        if (!empty($params['lists']['photo']) || !empty($params['lists']['video'])) {
            include LIBRARIES . "sample/comment/admin/media.php";
        }
        ?>

        <?php if (!empty($params['lists']['replies'])) {
            $params['replies'] = $params['lists']['replies']; ?>
            <!-- Replies -->
            <div class="comment-replies mt-3">
                <div class="comment-replies-load">
                    <?php include LIBRARIES . "sample/comment/admin/replies.php"; ?>
                </div>
                <?php if ($this->totalReplies($params['lists']['id'], $params['id_product'], $params['is_admin']) > $this->limitChildShow) { ?>
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

        <?php include LIBRARIES . "sample/comment/admin/reply.php"; ?>
    </div>
</div>