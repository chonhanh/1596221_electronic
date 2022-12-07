<?php
$linkMan = "index.php?com=chat&act=man";
$linkFilter = "index.php?com=chat&act=message&id=" . $id;
$linkSave = "index.php?com=chat&act=save&p=" . $curPage;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết trò chuyện</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle mb-3" onerror="src='assets/images/noimage.png'" src="<?= THUMBS ?>/90x90x1/<?= UPLOAD_USER_THUMB . $item['avatar'] ?>" alt="<?= $item['fullname'] ?>">
                            <h3 class="profile-username text-capitalize"><?= $item['fullname'] ?></h3>
                            <p class="text-muted text-center mb-1"><?= $item['address'] ?></p>
                            <p class="text-muted text-center mb-1">Phone: <?= $func->formatPhone($item['phone']) ?></p>
                            <p class="text-muted text-center mb-0">Email: <?= $item['email'] ?></p>

                        </div>
                    </div>
                </div>
                <?php if (!empty($chatPhoto)) { ?>
                    <div class="card card-primary card-outline card-chat-photo text-sm">
                        <div class="card-header">
                            <h3 class="card-title float-none mb-1">Hình ảnh</h3>
                        </div>
                        <div class="card-body text-center">
                            <?php foreach ($chatPhoto as $k => $v) { ?>
                                <img class="border rounded img-upload <?= ($k < count($chatPhoto) - 1) ? 'mr-1' : '' ?> mb-2" src="<?= THUMBS ?>/170x170x2/<?= UPLOAD_PHOTO_THUMB . $v['photo'] ?>" data-photo="<?= $v['photo'] ?>" alt="<?= $item['fullname'] ?>">
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="card card-primary direct-chat direct-chat-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title float-none mb-1">Nội dung trò chuyện</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($messages)) { ?>
                            <div class="direct-chat-messages h-auto">
                                <div class="direct-chat-messages-scroll">
                                    <div class="direct-chat-messages-result">
                                        <?php
                                        foreach ($messages as $v_message) {
                                            $params = array();
                                            $params['detail'] = $item;
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
                        <?php } ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-start justify-content-start">
                            <textarea class="form-control text-sm mr-3" name="data[message]" id="message" placeholder="Soạn tin nhắn ..." rows="5" required></textarea>
                            <button type="submit" class="btn btn-sm btn-primary submit-check text-capitalize py-2 px-4">Gửi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-sm">
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
            <input type="hidden" name="id_member" value="<?= $item['id_member'] ?>">
        </div>
    </form>
</section>