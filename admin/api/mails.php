<?php
include "config.php";

$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

if (!empty($id)) {
    $d->rawQuery("delete from #_member_mails where id = ?", array($id));
    $cache->delete();
}
