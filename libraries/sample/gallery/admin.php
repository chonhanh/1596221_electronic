<div class="fileuploader-items">
    <ul class="fileuploader-items-list">
        <?php foreach ($params['data'] as $v) { ?>
            <li class="fileuploader-item fileuploader-item-detail fileuploader-item-detail-<?= $v['id'] ?>">
                <div class="columns">
                    <div class="column-thumbnail">
                        <div class="fileuploader-item-image">
                            <img src="../upload/<?= $params['folder'] ?>/<?= $v['photo'] ?>" alt="<?= $v['namevi'] ?>">
                        </div>
                        <span class="fileuploader-action-popup"></span>
                    </div>
                    <?php /*
						<div class="column-title">
							<div title="<?=$v['namevi']?>"><?=$v['namevi']?></div>
						</div>
					*/ ?>
                    <div class="column-actions">
                        <a class="fileuploader-action fileuploader-action-remove" title="Xóa" data-id="<?= $v['id'] ?>" data-folder="<?= $params['folder'] ?>" data-table="<?= $params['table'] ?>"><i></i></a>
                    </div>
                </div>
                <div class="progress-bar2"><span></span></div>
            </li>
        <?php } ?>
    </ul>
</div>