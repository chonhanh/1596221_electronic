<?php if ($params['message']['poster'] == 'member') { ?>
    <div class="direct-chat-msg right">
        <div class="direct-chat-infos clearfix">
            <span class="direct-chat-name float-right text-capitalize"><?= $params['detail']['fullname'] ?></span>
            <span class="direct-chat-timestamp float-left"><?= date("F j, Y, g:i a", $params['message']['date_posted']) ?></span>
        </div>
        <?= $this->getImage(['class' => 'direct-chat-img border lazy', 'sizes' => '40x40x1', 'upload' => UPLOAD_USER_L, 'image' => $params['detail']['avatar'], 'alt' => $params['detail']['fullname']]) ?>
        <div class="direct-chat-text"><?= nl2br($this->decodeHtmlChars($params['message']['message'])) ?></div>
    </div>
<?php } else if ($params['message']['poster'] == 'shop') { ?>
    <div class="direct-chat-msg">
        <div class="direct-chat-infos clearfix">
            <a class="direct-chat-name float-left text-dark text-capitalize text-decoration-none" target="_blank" href="<?= $params['config_base_shop'] . $params['detail']['shopUrl'] . '/' ?>" title="<?= $params['detail']['shopName'] ?>"><?= $params['detail']['shopName'] ?></a>
            <span class="direct-chat-timestamp float-right"><?= date("F j, Y, g:i a", $params['message']['date_posted']) ?></span>
        </div>
        <a class="direct-chat-img border" target="_blank" href="<?= $params['config_base_shop'] . $params['detail']['shopUrl'] . '/' ?>" title="<?= $params['detail']['shopName'] ?>">
            <?= $this->getImage(['class' => 'rounded-circle', 'sizes' => '40x40x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['detail']['logo'], 'alt' => $params['detail']['shopName']]) ?>
        </a>
        <div class="direct-chat-text"><?= nl2br($this->decodeHtmlChars($params['message']['message'])) ?></div>
    </div>
<?php } ?>