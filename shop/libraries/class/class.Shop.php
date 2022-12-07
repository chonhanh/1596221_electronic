<?php
class Shop
{
    private $d;
    private $data;

    public function __construct($d)
    {
        $this->d = $d;
    }

    public function init($shopName)
    {
        global $defineSectors;

        /* Check restricted */
        $restricted = $defineSectors['restrictedShop'];
        $fail = false;

        if (empty($shopName)) {
            $fail = true;
        }

        if (empty($fail)) {
            if (in_array($shopName, $restricted)) {
                $fail = true;
            }
        }

        if (empty($fail)) {
            foreach ($restricted as $k => $v) {
                if (strstr($shopName, $v)) {
                    $fail = true;
                }
            }
        }

        /* Get data */
        if (empty($fail)) {
            foreach ($defineSectors['hasShop']['types'] as $v) {
                $tableShop = $defineSectors['types'][$v]['tables']['shop'];
                $shopDetail = $this->d->rawQueryOne("select * from #_$tableShop where slug_url = ? and (status = ? or status = ?) and status_user = ? and id_member not in (select id from #_member where !find_in_set('hienthi',status)) and id_admin not in (select id from #_user where !find_in_set('hienthi',status) and !find_in_set('virtual',status)) and id_admin_virtual not in (select id from #_user where !find_in_set('hienthi',status) and find_in_set('virtual',status)) limit 0,1", array($shopName, 'xetduyet', 'dangsai', 'hienthi'));

                if (!empty($shopDetail)) {
                    break;
                }
            }

            /* Message */
            $messageText = 'Gian hàng của bạn chưa được ban quản trị website xét duyệt hoặc không tồn tại. Vui lòng liên hệ với chúng tôi.';
        } else {
            $shopDetail = array();

            /* Message */
            $messageText = 'Gian hàng của bạn không hợp lệ. Vui lòng liên hệ với chúng tôi.';
        }

        /* Init info for Shop */
        if (!empty($shopDetail)) {
            /* Sector */
            $detailSector = array();
            $detailSector = $this->d->rawQueryOne("select type from #_product_list where id = ? limit 0,1", array($shopDetail['id_list']));
            $detailSectorCat = $this->d->rawQueryOne("select namevi from #_product_cat where id = ? limit 0,1", array($shopDetail['id_cat']));
            $sampleData = $this->d->rawQueryOne("select header, banner, logo, favicon, social, slideshow from #_sample where id_interface = ? limit 0,1", array($shopDetail['id_interface']));
            $shopDetail['theme-color'] = ($shopDetail['id_interface'] == 1) ? '#145652' : (($shopDetail['id_interface'] == 2) ? '#EF9701' : (($shopDetail['id_interface'] == 3) ? '#B77A4E' : (($shopDetail['id_interface'] == 4) ? '#FFC800' : '')));
            $shopDetail['sector-type'] = $detailSector['type'];
            $shopDetail['sector-prefix'] = $defineSectors['types'][$detailSector['type']]['prefix'];
            $shopDetail['sector-list-name'] = $defineSectors['types'][$detailSector['type']]['name'];
            $shopDetail['sector-cat-name'] = (!empty($detailSectorCat['namevi'])) ? $detailSectorCat['namevi'] : '';
            $shopDetail['sample-data'] = array(
                'header' => array(
                    'photo' => $sampleData['header']
                ),
                'banner' => array(
                    'photo' => $sampleData['banner']
                ),
                'logo' => array(
                    'photo' => $sampleData['logo']
                ),
                'favicon' => array(
                    'photo' => $sampleData['favicon']
                ),
                'social' => array(
                    0 => array(
                        'photo' => $sampleData['social'],
                        'namevi' => $shopDetail['name'],
                        'link' => URL_SHOP
                    )
                ),
                'slideshow' => array(
                    0 => array(
                        'photo' => $sampleData['slideshow'],
                        'namevi' => $shopDetail['name'],
                        'link' => URL_SHOP
                    ),
                    1 => array(
                        'photo' => $sampleData['slideshow'],
                        'namevi' => $shopDetail['name'],
                        'link' => URL_SHOP
                    ),
                    3 => array(
                        'photo' => $sampleData['slideshow'],
                        'namevi' => $shopDetail['name'],
                        'link' => URL_SHOP
                    )
                )
            );
            $shopDetail['table-main'] = $defineSectors['types'][$detailSector['type']]['tables']['main'];
            $shopDetail['table-photo'] = $defineSectors['types'][$detailSector['type']]['tables']['photo'];
            $shopDetail['table-tag'] = $defineSectors['types'][$detailSector['type']]['tables']['tag'];
            $shopDetail['table-content'] = $defineSectors['types'][$detailSector['type']]['tables']['content'];
            $shopDetail['table-seo'] = $defineSectors['types'][$detailSector['type']]['tables']['seo'];
            $shopDetail['table-variation'] = $defineSectors['types'][$detailSector['type']]['tables']['variation'];
            $shopDetail['table-comment'] = $defineSectors['types'][$detailSector['type']]['tables']['comment'];
            $shopDetail['table-shop'] = $defineSectors['types'][$detailSector['type']]['tables']['shop'];
            $shopDetail['table-shop-counter'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-counter'];
            $shopDetail['table-shop-user-online'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-user-online'];
            $shopDetail['table-shop-rating'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-rating'];
            $shopDetail['table-shop-subscribe'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-subscribe'];
            $shopDetail['table-shop-chat'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-chat'];
            $shopDetail['table-shop-chat-photo'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-chat-photo'];
            $shopDetail['table-shop-limit'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-limit'];
            $shopDetail['table-shop-log'] = $defineSectors['types'][$detailSector['type']]['tables']['shop-log'];
            $shopDetail['table-shop-report'] = $defineSectors['types'][$detailSector['type']]['tables']['report-shop'];
            $shopDetail['table-shop-report-info'] = $defineSectors['types'][$detailSector['type']]['tables']['report-shop-info'];

            /* Set */
            $this->set('shop', $shopDetail);

            return true;
        } else {
            if ($this->isAjax()) {
                return false;
            } else {
                $message = '';
                $message .= '<div class="messages">';
                $message .= '<div class="alert alert-danger text-center">';
                $message .= '<small style="display:block;line-height:1.5;">' . $messageText . '</small>';
                $message .= '</div>';
                $message .= "</div>";

                die($this->exception('Thông báo', $message, BASE_MAIN . 'lien-he'));
            }
        }
    }

    public function checkLogin()
    {
        global $loginShop, $defineSectors;

        if (!empty($loginShop)) {
            /* Shop info */
            $shopInfo = $this->get('shop');
            $tableShop = $shopInfo['table-shop'];

            /* Check login */
            $token = (!empty($_SESSION[$loginShop]['shop']['token'])) ? $_SESSION[$loginShop]['shop']['token'] : '';
            $row = $this->d->rawQuery("select secret_key from #_$tableShop where secret_key = ? and (status = ? or status = ?) and status_user = ?", array($token, 'xetduyet', 'dangsai', 'hienthi'));

            if (count($row) == 1 && $row[0]['secret_key'] != '') {
                return true;
            } else {
                if (!empty($_SESSION[TOKEN_SHOP])) unset($_SESSION[TOKEN_SHOP]);
                unset($_SESSION[$loginShop]);
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkInfo()
    {
        /* Shop info */
        $shopInfo = $this->get('shop');
        $idShop = $shopInfo['id'];

        /* Create folder for Shop */
        if (!empty($shopInfo['folder'])) {
            $folderFileManager = UPLOAD_FILEMANAGER_SOURCE . $shopInfo['folder'];

            if (!file_exists($folderFileManager)) {
                mkdir($folderFileManager, 0777, true);
                chmod($folderFileManager, 0777);
            }
        }

        /* Check necessary info before acccess shop */
        $response = array();
        $footer = $this->d->rawQueryOne("select id from #_static where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($shopInfo['sector-prefix'], 'footer'));
        $contact = $this->d->rawQueryOne("select id from #_static where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($shopInfo['sector-prefix'], 'lien-he'));
        $setting = $this->d->rawQueryOne("select options, id from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1", array($shopInfo['sector-prefix']));
        $optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : array();

        /* Get owner */
        if (!empty($shopInfo['id_member'])) {
            $owner = $this->d->rawQueryOne("select email, phone, address from #_member where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopInfo['id_member']));
        } else if (!empty($shopInfo['id_admin'])) {
            $owner = $this->d->rawQueryOne("select email, phone, address from #_user where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopInfo['id_admin']));
        }

        /* Add data sample Footer */
        if (empty($footer)) {
            /* Add data */
            $data = array();
            $data['id_shop'] = $shopInfo['id'];
            $data['sector_prefix'] = $shopInfo['sector-prefix'];
            $data['namevi'] = $shopInfo['name'];
            $data['type'] = 'footer';
            $data['status'] = 'hienthi';
            $data['date_created'] = time();

            /* Add data */
            if ($this->d->insert('static', $data)) {
                $id_insert = $this->d->getLastInsertId();

                /* Data content */
                $dataContent = array();
                $dataContent['id_parent'] = $id_insert;
                $dataContent['contentvi'] = '';
                $dataContent['contentvi'] .= '<p>Email: ' . $owner['email'] . '</strong></p>';
                $dataContent['contentvi'] .= '<p>Hotline: ' . $owner['phone'] . '</strong></p>';
                $dataContent['contentvi'] .= '<p>Địa chỉ: ' . $owner['address'] . '</strong></p>';
                $this->d->insert('static_content', $dataContent);

                /* Data seo */
                $dataSeo = array();
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['titlevi'] = $shopInfo['name'];
                $dataSeo['keywordsvi'] = $shopInfo['name'];
                $dataSeo['descriptionvi'] = $shopInfo['name'];
                $this->d->insert('static_seo', $dataSeo);
            }
        }

        /* Add data sample Contact */
        if (empty($contact)) {
            /* Add data */
            $data = array();
            $data['id_shop'] = $shopInfo['id'];
            $data['sector_prefix'] = $shopInfo['sector-prefix'];
            $data['namevi'] = $shopInfo['name'];
            $data['type'] = 'lien-he';
            $data['status'] = 'hienthi';
            $data['date_created'] = time();

            /* Add data */
            if ($this->d->insert('static', $data)) {
                $id_insert = $this->d->getLastInsertId();

                /* Data content */
                $dataContent = array();
                $dataContent['id_parent'] = $id_insert;
                $dataContent['contentvi'] = '';
                $dataContent['contentvi'] .= '<p><span style="text-transform:uppercase;font-size:16px;"><strong>' . $shopInfo['name'] . '</strong></span></p>';
                $dataContent['contentvi'] .= '<p>Email: ' . $owner['email'] . '</strong></p>';
                $dataContent['contentvi'] .= '<p>Hotline: ' . $owner['phone'] . '</strong></p>';
                $dataContent['contentvi'] .= '<p>Địa chỉ: ' . $owner['address'] . '</strong></p>';
                $this->d->insert('static_content', $dataContent);

                /* Data seo */
                $dataSeo = array();
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['titlevi'] = $shopInfo['name'];
                $dataSeo['keywordsvi'] = $shopInfo['name'];
                $dataSeo['descriptionvi'] = $shopInfo['name'];
                $this->d->insert('static_seo', $dataSeo);
            }
        }

        /* Add data sample Setting */
        if (empty($setting)) {
            /* Add data */
            $data = array();
            $data['id_shop'] = $shopInfo['id'];
            $data['sector_prefix'] = $shopInfo['sector-prefix'];
            $data['namevi'] = $shopInfo['name'];

            /* Options */
            $option = array();
            $option['email'] = $owner['email'];
            $option['phone'] = $owner['phone'];
            $option['hotline'] = $owner['phone'];
            $option['zalo'] = $owner['phone'];
            $option['address'] = $owner['address'];
            $option['coords_iframe'] = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501725.3382559615!2d106.41504042150287!3d10.75534107191606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2zSOG7kyBDaMOtIE1pbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1634270470706!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';

            /* Options */
            $data['options'] = json_encode($option);

            /* Add data */
            if ($this->d->insert('setting', $data)) {
                $id_insert = $this->d->getLastInsertId();

                /* Data seo */
                $dataSeo = array();
                $dataSeo['id_parent'] = $id_insert;
                $dataSeo['titlevi'] = $shopInfo['name'];
                $dataSeo['keywordsvi'] = $shopInfo['name'];
                $dataSeo['descriptionvi'] = $shopInfo['name'];
                $this->d->insert('setting_seo', $dataSeo);
            }
        } else if (!empty($setting) && empty($optsetting)) {
            /* Options */
            $option = $data = array();
            $option['email'] = $owner['email'];
            $option['phone'] = $owner['phone'];
            $option['hotline'] = $owner['phone'];
            $option['zalo'] = $owner['phone'];
            $option['address'] = $owner['address'];
            $option['coords_iframe'] = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501725.3382559615!2d106.41504042150287!3d10.75534107191606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2zSOG7kyBDaMOtIE1pbmgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1634270470706!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';

            /* Options */
            $data['options'] = json_encode($option);

            /* Update data */
            $this->d->where('id', $setting['id']);
            $this->d->update('setting', $data);
        }
    }

    private function exception($name, $erroMessage, $urlBack)
    {
        $exceptions = array();
        $exceptions['vars'] = array(
            '{name}',
            '{errormessage}',
            '{urlback}'
        );
        $exceptions['vals'] = array(
            $name,
            $erroMessage,
            $urlBack
        );

        ob_start();
        include dirname(__DIR__) . "/sample/shop/exception.php";
        $template = ob_get_contents();
        ob_clean();

        return str_replace($exceptions['vars'], $exceptions['vals'], $template);
    }

    public function set($key, $data)
    {
        $this->data[$key] = $data;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function getCol($key)
    {
        return $this->data['shop'][$key];
    }

    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'));
    }
}
