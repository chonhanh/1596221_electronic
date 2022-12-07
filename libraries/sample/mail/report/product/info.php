<?php if (!empty($params['reportData']['shopData'])) { ?>
    <div style="margin-bottom:0.75rem;">
        <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Gian hàng:</span>
        <strong style="text-transform:uppercase;font-size:14px;">{emailShopName}</strong>
    </div>
    <div style="margin-bottom:0.75rem;">
        <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Tiêu đề:</span>
        <strong style="text-transform:uppercase;font-size:14px;">{emailProductName}</strong>
    </div>
<?php } else { ?>
    <div style="margin-bottom:0.75rem;">
        <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Lĩnh vực:</span>
        <strong style="text-transform:uppercase;font-size:14px;">{emailSectorListName}</strong>
    </div>
    <div style="margin-bottom:0.75rem;">
        <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Tiêu đề:</span>
        <strong style="text-transform:uppercase;font-size:14px;">{emailProductName}</strong>
    </div>
<?php } ?>

<?php if (!empty($params['reportData']['lock'])) { ?>
    <a style="color:red;font-size:12px;" href="{emailLinkFixLock}" target="_blank" title="Chỉnh sửa tin đăng">Chỉnh sửa tin đăng</a>
<?php } else if (!empty($params['reportData']['unlock'])) { ?>
    <a style="color:red;font-size:12px;" href="{emailProductURL}" target="_blank" title="Xem tin đăng">Xem tin đăng</a>
<?php } ?>