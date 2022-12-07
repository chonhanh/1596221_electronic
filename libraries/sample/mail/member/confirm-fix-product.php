<table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
    <tbody>
        <?php include LIBRARIES . "sample/mail/layout/header.php"; ?>
        <tr>
            <td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                        <tr style="background:#fff">
                            <td align="left" height="auto" style="padding:15px" width="600">
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Kính chào Ban Quản Trị Chợ Nhanh</h1>
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Tôi xác nhận hoàn thành chỉnh sửa các mục của tin đăng này. Mong Ban Quản Trị xem xét và duyệt để tin đăng của tôi được hoạt động lại</p>
                                                <h3 style="font-size:13px;font-weight:bold;color:{emailColor};text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin chi tiết</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">&nbsp;
                                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:normal;margin-top:0;margin-bottom:15">Lĩnh vực: <strong style="text-transform:uppercase">{emailSectorListName} </strong></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:normal;margin-top:0;margin-bottom:15">Tiêu đề: <strong style="text-transform:uppercase">{emailProductName} </strong></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:normal;margin-top:0;margin-bottom:0">
                                                                    <a style="color:red;font-size:12px;" href="{emailLinkReport}" target="_blank" title="Xem báo cáo">Xem báo cáo</a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <?php include LIBRARIES . "sample/mail/layout/footer.php"; ?>
    </tbody>
</table>