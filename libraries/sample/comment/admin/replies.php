<?php if (!empty($params['replies'])) {
    foreach ($params['replies'] as $v_reply) {
        $infoReply = array();
        $infoReply['user'] = $this->parseInfo($v_reply, 'avatar');
        $infoReply['shop'] = $this->parseInfo($v_reply, 'logo');
        $infoReply['name'] = $this->parseInfo($v_reply, 'name')['name']; ?>
        <div class="comment-replies-item">
            <?php if (!empty($infoReply['user']) && $infoReply['user']['type'] == 'user') { ?>
                <div class="comment-replies-avatar <?= $v_reply['poster'] ?>"><img class="w-100" onerror="src='assets/images/noimage.png'" src="<?= THUMBS_COMMENT ?>/45x45x1/<?= UPLOAD_USER_L . $infoReply['user']['avatar'] ?>" alt="<?= $infoReply['name'] ?>"></div>
            <?php } else if (!empty($infoReply['shop']) && $infoReply['shop']['type'] == 'shop') { ?>
                <div class="comment-replies-avatar <?= $v_reply['poster'] ?>"><img class="w-100" onerror="src='assets/images/noimage.png'" src="<?= THUMBS_COMMENT ?>/45x45x1/<?= UPLOAD_PHOTO_L . $infoReply['shop']['logo'] ?>" alt="<?= $infoReply['name'] ?>"></div>
            <?php } else { ?>
                <div class="comment-replies-letter <?= $v_reply['poster'] ?>"><?= $this->subName($infoReply['name']) ?></div>
            <?php } ?>
            <div class="comment-replies-info">
                <div class="comment-replies-name mb-1"><?= $infoReply['name'] ?><span class="font-weight-normal small text-muted pl-2"><?= $this->timeAgo($v_reply['date_posted']) ?></span><?= ($v_reply['poster'] == 'admin') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi Ban Quản Trị)</span>' : (($v_reply['poster'] == 'member') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi người bán)</span>' : (($v_reply['poster'] == 'shop') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi gian hàng)</span>' : '')) ?><?= (strstr($v_reply['status'], 'new-admin')) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
                <div class="comment-action mb-2">
                    <a class="btn btn-sm <?= (strstr($v_reply['status'], 'hienthi')) ? 'btn-warning' : 'btn-primary' ?> btn-status-comment mr-1" href="javascript:void(0)" data-id="<?= $v_reply['id'] ?>" data-new-sibling="comment-replies-name" data-status="hienthi"><?= (strstr($v_reply['status'], 'hienthi')) ? 'Bỏ duyệt' : 'Duyệt' ?></a>
                    <a class="btn btn-sm btn-danger btn-delete-comment" href="javascript:void(0)" data-id="<?= $v_reply['id'] ?>" data-class="comment-replies-item" data-parents="comment-replies">Xóa</a>
                </div>
                <div class="comment-replies-content"><?= nl2br($this->func->decodeHtmlChars($v_reply['content'])) ?></div>
            </div>
        </div>
<?php }
} ?>