<tbody bgcolor="#f7f7f7" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
    <tr>
        <td align="left" style="padding:3px 9px" valign="top">
            <span style="display:block;font-weight:bold">{productName}</span>
            <?php if (!empty($params['productAttr'])) { ?>
                <span style="display:block;font-size:12px">{productAttr}</span>
            <?php } ?>
        </td>
        <td align="left" style="padding:3px 9px" valign="top"><span style="color:#ff0000;">{productRealPrice}</span></td>
        <td align="center" style="padding:3px 9px" valign="top">{productQuantity}</td>
        <td align="right" style="padding:3px 9px" valign="top"><span style="color:#ff0000;">{productRealTotalPrice}</span></td>
    </tr>
</tbody>