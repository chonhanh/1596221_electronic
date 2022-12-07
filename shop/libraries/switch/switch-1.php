<?php
switch ($com) {
    case 'lien-he':
        $source = "contact";
        $template = "contact/contact";
        $seo->set('type', 'object');
        $title_crumb = lienhe;
        break;

    case 'gioi-thieu':
        $source = "static";
        $template = "static/static";
        $type = $com;
        $seo->set('type', 'article');
        break;

    case 'khuyen-mai':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Khuyến mãi';
        break;

    case 'chinh-sach':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Chính sách';
        break;

    case 'thong-tin':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Thông tin';
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
        $type = "";
        $source = "index";
        $template = "product/product";
        $seo->set('type', 'website');

        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}
