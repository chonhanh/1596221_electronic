<?php
include "config.php";

$text = (!empty($_POST['text'])) ? htmlspecialchars($_POST['text']) : '';
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$tbl = (!empty($_POST['tbl'])) ? htmlspecialchars($_POST['tbl']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

if (!empty($text) && !empty($type) && !empty($tbl)) {
    echo $func->checkAccount(trim($text), $type, $tbl, $id);
}
