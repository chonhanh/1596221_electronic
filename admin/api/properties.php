<?php
include "config.php";

if (!empty($_POST["id_sub"])) {
    $id_sub = (!empty($_POST["id_sub"])) ? htmlspecialchars($_POST["id_sub"]) : 0;

    $str ="";
    if ($id_sub >0) { 

        $list_opt = $func -> getInfo('properties', 'product_sub', $id_sub);
        if ($list_opt) {
            $arr_list_opt=explode(",",$list_opt);
            $arr_opt = (isset( $itemContent['propertiesvi']) &&  $itemContent['propertiesvi'] != '') ? json_decode( @$itemContent['propertiesvi'],true) : null;

            if ($arr_list_opt) {
                foreach ($arr_list_opt as $key => $value) { ?>
                <div class="form-group">
                    <label for="propertiesvi<?=$value?>"><?=$func -> getInfo('namevi', 'variation', $value)?> (vi):</label>
                    <textarea class="form-control for-seo text-sm" name="dataContent[propertiesvi][<?=$value?>]" id="propertiesvi<?=$value?>" rows="2" placeholder="Thuộc tính(vi)"><?=$func->decodeHtmlChars(@$arr_opt[$value])?></textarea>
                </div>

                <?php }
            }
        }
    }
    echo $str;
}
