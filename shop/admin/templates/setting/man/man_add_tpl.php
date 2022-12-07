<?php
$linkSave = "index.php?com=setting&act=save";
$linkJson = "index.php?com=setting&act=json";
$options = (isset($item['options']) && $item['options'] != '') ? json_decode($item['options'], true) : null;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Thông tin công ty</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-setting"><i class="far fa-save mr-2"></i>Lưu</button>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin chung</h3>
            </div>
            <div class="card-body">
                <?php if (count($config['website']['lang']) > 1) { ?>
                    <div class="form-group">
                        <label>Ngôn ngữ mặc định:</label>
                        <div class="form-group">
                            <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="custom-control custom-radio d-inline-block mr-3 text-md">
                                    <input class="custom-control-input" type="radio" id="lang_default-<?= $k ?>" name="data[options][lang_default]" <?= ($k == 'vi' ? "checked" : ($k == $options['lang_default'])) ? "checked" : "" ?> value="<?= $k ?>">
                                    <label for="lang_default-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if (isset($config['setting']['address']) && $config['setting']['address'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="address">Địa chỉ:</label>
                            <input type="text" class="form-control text-sm" name="data[options][address]" id="address" placeholder="Địa chỉ" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : @$options['address'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['email']) && $config['setting']['email'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control text-sm" name="data[options][email]" id="email" placeholder="Email" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : @$options['email'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['hotline']) && $config['setting']['hotline'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="hotline">Hotline:</label>
                            <input type="text" class="form-control text-sm" name="data[options][hotline]" id="hotline" placeholder="Hotline" value="<?= (!empty($flash->has('hotline'))) ? $flash->get('hotline') : @$options['hotline'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['phone']) && $config['setting']['phone'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="phone">Điện thoại:</label>
                            <input type="text" class="form-control text-sm" name="data[options][phone]" id="phone" placeholder="Điện thoại" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : @$options['phone'] ?>" required>
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['zalo']) && $config['setting']['zalo'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="zalo">Zalo:</label>
                            <input type="text" class="form-control text-sm" name="data[options][zalo]" id="zalo" placeholder="Zalo" value="<?= (!empty($flash->has('zalo'))) ? $flash->get('zalo') : @$options['zalo'] ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['oaidzalo']) && $config['setting']['oaidzalo'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="oaidzalo">OAID Zalo:</label>
                            <input type="text" class="form-control text-sm" name="data[options][oaidzalo]" id="oaidzalo" placeholder="OAID Zalo" value="<?= (!empty($flash->has('oaidzalo'))) ? $flash->get('oaidzalo') : @$options['oaidzalo'] ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['website']) && $config['setting']['website'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="website">Website:</label>
                            <input type="text" class="form-control text-sm" name="data[options][website]" id="website" placeholder="Website" value="<?= (!empty($flash->has('website'))) ? $flash->get('website') : @$options['website'] ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['fanpage']) && $config['setting']['fanpage'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="fanpage">Fanpage:</label>
                            <input type="text" class="form-control text-sm" name="data[options][fanpage]" id="fanpage" placeholder="Fanpage" value="<?= (!empty($flash->has('fanpage'))) ? $flash->get('fanpage') : @$options['fanpage'] ?>">
                        </div>
                    <?php } ?>
                    <?php if (isset($config['setting']['coords']) && $config['setting']['coords'] == true) { ?>
                        <div class="form-group col-md-4 col-sm-6">
                            <label for="coords">Tọa độ google map:</label>
                            <input type="text" class="form-control text-sm" name="data[options][coords]" id="coords" placeholder="Tọa độ google map" value="<?= (!empty($flash->has('coords'))) ? $flash->get('coords') : @$options['coords'] ?>">
                        </div>
                    <?php } ?>
                </div>
                <?php if (isset($config['setting']['coords_iframe']) && $config['setting']['coords_iframe'] == true) { ?>
                    <div class="form-group">
                        <label for="coords_iframe">
                            <span>Tọa độ google map iframe:</span>
                            <a class="text-sm font-weight-normal ml-1" href="https://www.google.com/maps" target="_blank" title="Lấy mã nhúng google map">(Lấy mã nhúng)</a>
                        </label>
                        <textarea class="form-control text-sm" name="data[options][coords_iframe]" id="coords_iframe" rows="5" placeholder="Tọa độ google map iframe"><?= $func->decodeHtmlChars($flash->get('coords_iframe')) ?: $func->decodeHtmlChars(@$options['coords_iframe']) ?></textarea>
                    </div>
                <?php } ?>
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                            <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?= $k ?>" role="tab" aria-controls="tabs-lang-<?= $k ?>" aria-selected="true"><?= $v ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="card-body card-article">
                        <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                            <?php foreach ($config['website']['lang'] as $k => $v) { ?>
                                <div class="tab-pane fade show <?= ($k == 'vi') ? 'active' : '' ?>" id="tabs-lang-<?= $k ?>" role="tabpanel" aria-labelledby="tabs-lang">
                                    <div class="form-group">
                                        <label for="name<?= $k ?>">Tiêu đề (<?= $k ?>):</label>
                                        <input type="text" class="form-control for-seo text-sm" name="data[name<?= $k ?>]" id="name<?= $k ?>" placeholder="Tiêu đề (<?= $k ?>)" value="<?= (!empty($flash->has('name' . $k))) ? $flash->get('name' . $k) : @$item['name' . $k] ?>" required>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Nội dung SEO</h3>
                <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
            </div>
            <div class="card-body">
                <?php
                $seoDB = $seo->getOnDB("*", 'setting_seo', @$item['id']);
                include TEMPLATE . LAYOUT . "seo.php";
                ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-setting"><i class="far fa-save mr-2"></i>Lưu</button>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>

<!-- Setting js -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".mailertype").click(function() {
            var value = parseInt($(this).val());

            if (value == 1) {
                $(".host-email").removeClass("d-none");
                $(".host-email").addClass("d-block");
                $(".gmail-email").removeClass("d-block");
                $(".gmail-email").addClass("d-none");
            }
            if (value == 2) {
                $(".gmail-email").removeClass("d-none");
                $(".gmail-email").addClass("d-block");
                $(".host-email").removeClass("d-block");
                $(".host-email").addClass("d-none");
            }
        })
    })
</script>