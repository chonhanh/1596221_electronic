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
                                                <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Cảm ơn quý khách đã đặt hàng tại {emailCompanyWebsite}</h1>
                                                <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Chúng tôi rất vui thông báo đơn hàng #{emailOrderCode} của quý khách đã được tiếp nhận và đang trong quá trình xử lý. {emailCompanyWebsite} sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao.</p>
                                                <h3 style="font-size:13px;font-weight:bold;color:{emailColor};text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin đơn hàng #{emailOrderCode} <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">({emailDateSend}).')</span></h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" style="padding:6px 9px 0px 0px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin thanh toán</th>
                                                            <th align="left" style="padding:6px 0px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Địa chỉ giao hàng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">{emailOrderInfoFullname}</span><br>
                                                                <a href="mailto:emailOrderInfoEmail" target="_blank">emailOrderInfoEmail</a><br>
                                                                {emailOrderInfoPhone}
                                                            </td>
                                                            <td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:capitalize">{emailOrderInfoFullname}</span><br>
                                                                <a href="mailto:emailOrderInfoEmail" target="_blank">emailOrderInfoEmail</a><br>
                                                                {emailOrderInfoAddress}<br>
                                                                Tel: {emailOrderInfoPhone}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding:7px 0px 0px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">
                                                                <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><strong>Hình thức thanh toán: </strong> {emailOrderPayment}</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        {orderContentBookingUser}
                                        <tr>
                                            <div style="border-bottom:1px solid #ddd;margin:10px 0px;"></div>
                                        </tr>
                                        <table border="0" cellpadding="0" cellspacing="0" style="background:#EBEDF0" width="100%">
                                            <tr bgcolor="#eee">
                                                <td align="right" style="padding:7px 9px;">
                                                    <strong><strong><big>Tổng giá trị đơn hàng: <span style="color:#ff0000;">{emailOrderTotalPrice}</span> </big></strong>
                                                </td>
                                            </tr>
                                        </table>
                                        <tr>
                                            <td>
                                                <div style="margin:auto;text-align:center">
                                                    <a href="{emailHome}" style="display:inline-block;text-decoration:none;background-color:{emailColor}!important;text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;font-weight:bold;margin-top:5px" target="_blank">Chi tiết đơn hàng tại {emailCompanyWebsite}</a>
                                                </div>
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