<tr>
    <h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:{emailColor}">ĐƠN HÀNG THUỘC - {orderOwnerType}: <span style="color:#000000">{orderOwnerTitle}</span></h2>

    <?php if (!empty($params['cartInfoType']) && $params['cartInfoType'] == 'shop') { ?>
        <div style="text-align:left;font-size:13px;margin-bottom:10px"><a style="color:green;text-decoration:none" href="{orderShopURL}" style="font-weight:bold;" target="_blank">Xem shop</a></div>
    <?php } ?>

    <table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
        <thead>
            <tr>
                <th align="left" bgcolor="{emailColor}" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Sản phẩm</th>
                <th align="left" bgcolor="{emailColor}" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Đơn giá</th>
                <th align="center" bgcolor="{emailColor}" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px;min-width:55px;">Số lượng</th>
                <th align="right" bgcolor="{emailColor}" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
            </tr>
        </thead>
        <tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
            {orderContentLists}
            <tr bgcolor="#eee">
                <td align="right" colspan="3" style="padding:7px 9px"><strong><big>Tổng cộng</big> </strong></td>
                <td align="right" style="padding:7px 9px"><strong><big><span>{orderGroupTotalPrice}</span> </big> </strong></td>
            </tr>
        </tfoot>
    </table>
</tr>