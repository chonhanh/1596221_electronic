<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?= $flash->getMessages('frontend') ?>

    <?php if (!empty($messages)) { ?>
        <div class="direct-chat direct-chat-primary">
            <div class="direct-chat-messages">
                <div class="direct-chat-messages-scroll">
                    <div class="direct-chat-messages-result">
                        <?php
                        foreach ($messages as $v_message) {
                            $params = array();
                            $params['config_base_shop'] = $configBaseShop;
                            $params['detail'] = $chatDetail;
                            $params['message'] = $v_message;
                            echo $func->markdown('chat/lists', $params);
                        }
                        ?>
                    </div>
                </div>
                <div class="direct-chat-messages-loading d-none">
                    <div class="direct-chat-messages-loading-dot">
                        <div class="dot-falling"></div>
                    </div>
                </div>
                <input type="hidden" class="limit-from" value="<?= $limitLoad['show'] ?>">
                <input type="hidden" class="limit-get" value="<?= $limitLoad['get'] ?>">
                <input type="hidden" class="limit-total" value="<?= $total ?>">
            </div>
            <div class="bg-light border rounded-bottom p-3">
                <form class="form-chat-account" method="post" action="account/gui-tin-nhan" enctype="multipart/form-data">
                    <div class="d-flex align-items-start justify-content-start">
                        <textarea class="form-control text-sm mr-3" name="data[message]" id="message" placeholder="Soạn tin nhắn ..." rows="5" required></textarea>
                        <button type="submit" class="btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-4" name="action-chat-user" value="send-message">Gửi</button>
                    </div>
                    <input type="hidden" name="id_sector" value="<?= $sector['id'] ?>">
                    <input type="hidden" name="id_shop" value="<?= $IDShop ?>">
                    <input type="hidden" name="id_chat" value="<?= $IDChat ?>">
                </form>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
</div>