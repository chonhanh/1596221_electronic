<?php
include "config.php";

$routes = array('limitLists' => ['limitLists', 'GET'], 'limitReplies' => ['limitReplies', 'GET'], 'add' => ['add', 'POST']);
$route = (!empty($_GET['get']) && !empty($routes[$_GET['get']])) ? $_GET['get'] : false;
$tables = (!empty($_GET['tables'])) ? $_GET['tables'] : '';

if (!empty($route) && !empty($tables)) {
    $tables = explode("|", base64_decode($tables));
    $comment = new Comments($d, $func, ['shop' => $tables[0], 'main' => $tables[1], 'photo' => $tables[2], 'video' => $tables[3]], $prefixSector);
    $method = $routes[$route][0];
    $requestType = $routes[$route][1];

    if (method_exists($comment, $method) && $_SERVER['REQUEST_METHOD'] == $requestType) {
        print $comment->$method();
    }
}
