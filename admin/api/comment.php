<?php
include "config.php";

$routes = array('limitLists' => ['limitLists', 'GET'], 'limitReplies' => ['limitReplies', 'GET'], 'addAdmin' => ['addAdmin', 'POST'], 'status' => ['status', 'POST'], 'delete' => ['delete', 'POST']);
$route = (!empty($_GET['get']) && !empty($routes[$_GET['get']])) ? $_GET['get'] : false;
$data = (!empty($_GET['data'])) ? $_GET['data'] : '';

if (!empty($route) && !empty($data)) {
    $data = explode("|", base64_decode($data));
    $comment = new Comments($d, $func, ['shop' => $data[1], 'main' => $data[2], 'photo' => $data[3], 'video' => $data[4]], $data[0]);
    $method = $routes[$route][0];
    $requestType = $routes[$route][1];

    if (method_exists($comment, $method) && $_SERVER['REQUEST_METHOD'] == $requestType) {
        print $comment->$method();
    }
}
