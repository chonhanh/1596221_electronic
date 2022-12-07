<?php
include "config.php";

$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$isLogin = $func->getMember('active');

if (!empty($isLogin) && !empty($type) && !empty($id) && !empty($defineSectors['types'][$type])) {
    /* Sector */
    $sector = $defineSectors['types'][$type];

    /* Add ID viewed into file */
    $func->addViewedNewPost($sector['id'], $id);
}
