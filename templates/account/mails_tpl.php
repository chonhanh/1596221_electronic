<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if (!empty($mails)) { ?>
        <div class="accordion" id="accordion-mails">
            <?php foreach ($mails as $k_mails => $v_mails) { ?>
                <div class="card card-mails card-info card-outline border-bottom rounded-0 mb-3">
                    <div class="card-header px-3 py-2" id="heading-mails-<?= $v_mails['id'] ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="title-mails read-mails <?= (!empty($v_mails['is_readed'])) ? 'readed' : '' ?> text-decoration-none pr-5" href="javascript:void(0)" data-toggle="collapse" data-target="#collapse-mails-<?= $v_mails['id'] ?>" aria-expanded="true" aria-controls="collapse-mails-<?= $v_mails['id'] ?>" data-id="<?= $v_mails['id'] ?>" title="<?= $v_mails['title'] ?>"><?= $v_mails['title'] ?></a>
                            <a class="read-mails <?= (!empty($v_mails['is_readed'])) ? 'readed' : '' ?> btn btn-sm ml-auto mr-1 text-secondary" data-toggle="collapse" data-target="#collapse-mails-<?= $v_mails['id'] ?>" aria-expanded="true" aria-controls="collapse-mails-<?= $v_mails['id'] ?>" data-id="<?= $v_mails['id'] ?>" title="Xem thư"><i class="fas fa-chevron-down pt-1 align-top"></i></a>
                            <a class="btn btn-sm delete-mails text-danger" data-id="<?= $v_mails['id'] ?>" title="Xóa thư này"><i class="far fa-trash-alt"></i></a>
                        </div>
                    </div>
                    <div id="collapse-mails-<?= $v_mails['id'] ?>" class="collapse" aria-labelledby="heading-mails-<?= $v_mails['id'] ?>" data-parent="#accordion-mails">
                        <div class="card-body"><?= $func->decodeHtmlChars($v_mails['content']) ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
</div>