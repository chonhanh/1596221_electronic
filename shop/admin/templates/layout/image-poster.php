<div class="photoUpload-zone mb-3">
    <div class="photoUpload-detail" id="photoUpload-preview-poster"><img class="rounded" src="<?= @$photoVideoPoster ?>" onerror="src='assets/images/noimage.png'" alt="Alt Photo" /></div>
    <label class="photoUpload-file" id="photo-zone-poster" for="file-zone-poster">
        <input type="file" name="file-poster" id="file-zone-poster">
        <i class="fas fa-cloud-upload-alt"></i>
        <p class="photoUpload-drop">Kéo và thả hình vào đây</p>
        <p class="photoUpload-or">hoặc</p>
        <p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
    </label>
    <div class="photoUpload-dimension"><?= @$dimensionVideoPoster ?></div>
</div>