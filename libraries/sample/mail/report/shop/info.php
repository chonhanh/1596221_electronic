<div style="margin-bottom:0.75rem;">
    <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Lĩnh vực:</span>
    <strong style="text-transform:uppercase;font-size:14px;">{emailSectorListName}</strong>
</div>
<div style="margin-bottom:0.75rem;">
    <span style="font-size:13px;display:block;margin-bottom:0.5rem;">Gian hàng:</span>
    <strong style="text-transform:uppercase;font-size:14px;">{emailShopName}</strong>
</div>

<?php if (!empty($params['reportData']['lock'])) { ?>
    <div style="margin-bottom:0.5rem;">
        <a style="color:red;font-size:12px;" href="{emailLinkFixLockOwner}" target="_blank" title="Chỉnh sửa thông tin gian hàng">Chỉnh sửa thông tin gian hàng</a>
    </div>
    <div>
        <a style="color:red;font-size:12px;" href="{emailLinkFixLockPage}" target="_blank" title="Chỉnh sửa nội dung gian hàng">Chỉnh sửa nội dung gian hàng</a>
    </div>
<?php } else if (!empty($params['reportData']['unlock'])) { ?>
    <a style="color:red;font-size:12px;" href="{emailShopURL}" target="_blank" title="Xem gian hàng">Xem gian hàng</a>
<?php } ?>