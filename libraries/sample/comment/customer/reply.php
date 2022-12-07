<form class="mt-3" id="form-reply" action="" method="post" enctype="multipart/form-data">
    <div class="response-reply"></div>
    <div class="form-group">
        <textarea class="form-control text-sm" placeholder="Viết câu trả lời của bạn" name="dataReview[content]" id="reply-content" data-name="@<?= $params['lists']['memberName'] ?>:" rows="5"></textarea>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-sm btn-warning py-2 px-3">Gửi trả lời</button>
        <button type="button" class="btn btn-sm btn-secondary btn-cancel-reply py-2 px-3">Hủy bỏ</button>
    </div>
    <input type="hidden" name="dataReview[fullname_parent]" value="@<?= $params['lists']['memberName'] ?>:">
    <input type="hidden" name="dataReview[poster]" value="<?= (!empty($params['is_check']) || !empty($params['is_owner'])) ? 'member' : '' ?>">
    <input type="hidden" name="dataReview[id_parent]" value="<?= $params['lists']['id'] ?>">
    <input type="hidden" name="dataReview[id_shop]" value="<?= $params['lists']['id_shop'] ?>">
    <input type="hidden" name="dataReview[id_product]" value="<?= $params['id_product'] ?>">
    <input type="hidden" name="dataReview[is_check]" value="<?= (!empty($params['is_check'])) ? 1 : 0 ?>">
    <input type="hidden" name="dataReview[variant]" value="<?= $params['variant'] ?>">
</form>