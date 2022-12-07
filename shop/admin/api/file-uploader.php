<?php
include "config.php";

$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$folder = (!empty($_POST['folder'])) ? htmlspecialchars($_POST['folder']) : '';
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';

if (!empty($id) && !empty($folder) && !empty($table)) {
    $row = $d->rawQueryOne("select photo from #_$table where id = ? limit 0,1", array($id));
    $path = "../../../upload/" . $folder . "/" . $row['photo'];
    $func->deleteFile($path);
    $d->rawQuery("delete from #_$table where id = ?", array($id));
    $cache->delete();
}
