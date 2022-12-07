<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "man":
        viewMans();
        $template = "comment/man/mans";
        break;

    default:
        $template = "404";
}

function viewMans()
{
    global $d, $func, $cache, $comment, $id_list, $item, $configSector;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

        if (!empty($id)) {
            /* Get data */
            $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
            $tableComment = (!empty($configSector['tables']['comment'])) ? $configSector['tables']['comment'] : '';
            $tableCommentPhoto = (!empty($configSector['tables']['comment-photo'])) ? $configSector['tables']['comment-photo'] : '';
            $tableCommentVideo = (!empty($configSector['tables']['comment-video'])) ? $configSector['tables']['comment-video'] : '';

            /* Where logic when owner or shop unactive */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $configSector, false);
            $where = $whereLogicOwner['where'];

            /* Get data detail */
            $item = $d->rawQueryOne("select A.* from #_" . $configSector['tables']['main'] . " as A where A.id = ? $where limit 0,1", array($id));

            /* Check data detail */
            if (!empty($item)) {
                /* Comment */
                $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableComment, 'photo' => $tableCommentPhoto, 'video' => $tableCommentVideo], $configSector['prefix'], $item['id'], true);
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man&id_list=" . $id_list, false);
            }
        } else {
            $func->transfer("Trang không tồn tại", "index.php", false);
        }
    }
}
