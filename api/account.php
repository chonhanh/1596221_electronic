<?php
include "config.php";

$text = (!empty($_POST['text'])) ? htmlspecialchars($_POST['text']) : '';
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$tbl = (!empty($_POST['tbl'])) ? htmlspecialchars($_POST['tbl']) : '';
if (!empty($text) && !empty($type)) {
	$flag=3;
	$apiResp = $restApi->get($apiRoutes['storefront']['member']['check']."?type=".$type."&keyword=".$text);
	$apiResp = $restApi->decode($apiResp, true);
	if (!empty($apiResp)) {
		if ($apiResp['status']==200) {
		   	$flag=1;
		}else{
			$flag=2;
		}
	}
	
	echo $flag;
    // echo $func->checkAccount(trim($text), $type, $tbl);
}
