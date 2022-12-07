<?php if (!empty($params['replies'])) {
    foreach ($params['replies'] as $v_reply) {
        $infoReply = array();
        $infoReply['user'] = $this->parseInfo($v_reply, 'avatar');
        $infoReply['shop'] = $this->parseInfo($v_reply, 'logo');
        $infoReply['name'] = $this->parseInfo($v_reply, 'name')['name']; ?>
        <div class="comment-replies-item">
            <?php if (!empty($infoReply['user']) && $infoReply['user']['type'] == 'user') { ?>
                <div class="comment-replies-avatar <?= $v_reply['poster'] ?>"><?= $this->func->getImage(['class' => 'lazy w-100', 'sizes' => '45x45x1', 'upload' => UPLOAD_USER_L, 'image' => $infoReply['user']['avatar'], 'alt' => $infoReply['name']]) ?></div>
            <?php } else if (!empty($infoReply['shop']) && $infoReply['shop']['type'] == 'shop') { ?>
                <div class="comment-replies-avatar <?= $v_reply['poster'] ?>"><?= $this->func->getImage(['class' => 'lazy w-100', 'sizes' => '45x45x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $infoReply['shop']['logo'], 'alt' => $infoReply['name']]) ?></div>
            <?php } else { ?>
                <div class="comment-replies-letter <?= $v_reply['poster'] ?>"><?= $this->subName($infoReply['name']) ?></div>
            <?php } ?>
            <div class="comment-replies-info">
                <div class="comment-replies-name mb-1"><?= $infoReply['name'] ?><span class="font-weight-normal small text-muted pl-2"><?= $this->timeAgo($v_reply['date_posted']) ?></span><?= ($v_reply['poster'] == 'admin') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi Ban Quản Trị)</span>' : (($v_reply['poster'] == 'member') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi người bán)</span>' : (($v_reply['poster'] == 'shop') ? '<span class="font-weight-normal text-info ml-2">(Phản hồi bởi gian hàng)</span>' : '')) ?><?= (!empty($params['is_check']) && strstr($v_reply['status'], 'new-member')) ? '<strong class="comment-new bg-danger rounded text-white small ml-2 px-2 py-1">Mới</strong>' : '' ?></div>
                <div class="comment-replies-content"><?= nl2br($this->func->decodeHtmlChars($v_reply['content'])) ?></div>
            </div>
        </div>
<?php }
} ?>