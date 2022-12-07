<?php if ($params['message']['poster'] == 'member') { ?>
    <div class="direct-chat-msg">
        <div class="direct-chat-infos clearfix">
            <span class="direct-chat-name float-left text-capitalize"><?= $params['detail']['fullname'] ?></span>
            <span class="direct-chat-timestamp float-right"><?= date("F j, Y, g:i a", $params['message']['date_posted']) ?></span>
        </div>
        <img class="direct-chat-img border" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/40x40x1/<?= UPLOAD_USER_THUMB . $params['detail']['avatar'] ?>" alt="<?= $params['detail']['fullname'] ?>">
        <div class="direct-chat-text"><?= nl2br($this->decodeHtmlChars($params['message']['message'])) ?></div>
    </div>
<?php } else if ($params['message']['poster'] == 'shop') { ?>
    <div class="direct-chat-msg right">
        <div class="direct-chat-infos clearfix">
            <span class="direct-chat-name float-right text-capitalize"><?= $params['detail']['shopName'] ?></span>
            <span class="direct-chat-timestamp float-left"><?= date("F j, Y, g:i a", $params['message']['date_posted']) ?></span>
        </div>
        <img class="direct-chat-img border" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/40x40x1/<?= UPLOAD_PHOTO_THUMB . $params['detail']['logo'] ?>" alt="<?= $params['detail']['shopName'] ?>">
        <div class="direct-chat-text"><?= nl2br($this->decodeHtmlChars($params['message']['message'])) ?></div>
    </div>
<?php } ?>