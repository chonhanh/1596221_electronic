<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
$text = (!empty($_POST['text'])) ? htmlspecialchars($_POST['text']) : '';
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';

if (!empty($cmd)) {
    if ($cmd == 'valid-data' && !empty($text) && !empty($type)) {
        if ($type == 'name') {
            $data = array();
            $data['slug'] = $func->changeTitle($text);
            $data['slug_url'] = str_replace("-", "", $data['slug']);
            echo $func->checkShop($data, 'name', $id);
        } else if ($type == 'restricted') {
            $data = array();
            $data['slug'] = $func->changeTitle($text);
            $data['slug_url'] = str_replace("-", "", $data['slug']);
            echo $func->checkShop($data, 'restricted', $id);
        } else if ($type == 'email') {
            $data = array();
            $data['email'] = trim($text);
            echo $func->checkShop($data, 'email', $id);
        } else if ($type == 'username') {
            $data = array();
            $data['username'] = trim($text);
            echo $func->checkShop($data, 'username', $id);
        }
    } else if ($cmd == 'restore' && !empty($id) && !empty($table)) {
        /* Data */
        $data = array();
        $result = 0;

        /* Get data detail */
        $row = $d->rawQueryOne("select id, status from #_$table where id = ? and status = 'deleted' limit 0,1", array($id));

        /* Check data detail */
        if (!empty($row['id'])) {
            $data['status'] = 'xetduyet';

            $d->where('id', $id);

            if ($d->update($table, $data)) {
                /* Delete cache */
                $cache->delete();

                /* Success */
                $result = 1;
            }
        }

        echo $result;
    } else if ($cmd == 'transfer' && !empty($id) && !empty($table)) {
        /* Data */
        $data = array();
        $result = 0;

        /* Get data detail */
        $row = $d->rawQueryOne("select id, id_member, status_attr from #_$table where id = ? and find_in_set('virtual',status_attr) limit 0,1", array($id));

        /* Check data detail */
        if (!empty($row['id']) && !empty($row['id_member'])) {
            $status_array = (!empty($row['status_attr'])) ? explode(',', $row['status_attr']) : array();

            if (array_search('virtual', $status_array) !== false) {
                $key = array_search('virtual', $status_array);
                unset($status_array[$key]);
            }

            $data['status_attr'] = (!empty($status_array)) ? implode(',', $status_array) : "";

            $d->where('id', $id);

            if ($d->update($table, $data)) {
                /* Update member account is Official */
                $rowMember = $d->rawQueryOne("select id, status from #_member where id = ? and find_in_set('virtual',status) limit 0,1", array($row['id_member']));

                if (!empty($rowMember['id'])) {
                    $status_array = (!empty($rowMember['status'])) ? explode(',', $rowMember['status']) : array();

                    if (array_search('virtual', $status_array) !== false) {
                        $key = array_search('virtual', $status_array);
                        unset($status_array[$key]);
                    }

                    $data = array();
                    $data['status'] = (!empty($status_array)) ? implode(',', $status_array) : "";
                    $data['password_virtual'] = '';

                    $d->where('id', $rowMember['id']);
                    $d->update('member', $data);
                }

                /* Delete cache */
                $cache->delete();

                /* Success */
                $result = 1;
            }
        }

        echo $result;
    } else if ($cmd == 'send-info') {
        /* Get shop info */
        $result = false;
        $shopDetail = $cache->get("select id_member, id_admin, slug_url, name, email, password, phone, status_attr from #_$table where id = ? and status = ? limit 0,1", array($id, 'xetduyet'), 'fetch', 7200);

        if (!empty($shopDetail) && !strstr($shopDetail['status_attr'], 'virtual')) {
            /* Get user info */
            if (!empty($shopDetail['id_member'])) {
                $userDetail = $cache->get("select fullname, email from #_member where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopDetail['id_member']), 'fetch', 7200);
            } else {
                $userDetail = $cache->get("select fullname, email from #_user where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopDetail['id_admin']), 'fetch', 7200);
            }

            /* Send email customer */
            if (!empty($userDetail)) {
                /* Defaults attributes email */
                $emailDefaultAttrs = $emailer->defaultAttrs();

                /* Variables email */
                $emailVars = array(
                    '{emailShopURL}',
                    '{emailShopAdminURL}',
                    '{emailShopEmail}',
                    '{emailShopPassword}'
                );
                $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

                /* Values email */
                $emailVals = array(
                    $configBaseShop . $shopDetail['slug_url'] . '/',
                    $configBaseShop . $shopDetail['slug_url'] . '/admin/',
                    $shopDetail['email'],
                    $shopDetail['password']
                );
                $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

                /* Info to send */
                $arrayEmail = array(
                    "dataEmail" => array(
                        "name" => $userDetail['fullname'],
                        "email" => $userDetail['email']
                    )
                );
                $subject = "Thư thông báo từ " . $setting['name' . $lang];
                $message = str_replace($emailVars, $emailVals, $emailer->markdown('shop/active-shop'));
                $file = null;

                if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
                    $result = true;
                }
            }
        }

        echo $result;
    }
}
