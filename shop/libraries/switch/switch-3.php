<?php
switch ($com) {
    case 'lien-he':
        $source = "contact";
        $template = "contact/contact";
        $seo->set('type', 'object');
        $title_crumb = lienhe;
        break;

    case 'gioi-thieu':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Giới thiệu';
        break;

    case 'tin-tuc':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Tin tức';
        break;

    case 'san-pham':
        $source = "product";
        $template = "product/product";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Sản phẩm';
        break;

    case 'tim-kiem':
        $source = "search";
        $template = "product/product";
        $seo->set('type', 'object');
        break;

    case '':
    case 'index':
        $source = "index";
        $template = "index-" . INTERFACE_SHOP . "/index";
        $seo->set('type', 'website');
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}
