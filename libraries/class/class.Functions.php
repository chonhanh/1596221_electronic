<?php
require LIBRARIES . 'WebpConvert/vendor/autoload.php';

use WebPConvert\WebPConvert;

class Functions
{
    private $d;
    private $cache;
    private $data;

    function __construct($d, $cache)
    {
        $this->d = $d;
        $this->cache = $cache;
    }

    /* Set */
    public function set($key = '', $value = '')
    {
        if (!empty($key) && !empty($value)) {
            $this->data[$key] = $value;
        }
    }

    /* Get */
    public function get($key)
    {
        return (!empty($this->data[$key])) ? $this->data[$key] : '';
    }

    /* Has */
    public function has($key = '')
    {
        if (!empty($this->data[$key])) {
            return true;
        } else {
            return false;
        }
    }

    /* Markdown */
    public function markdown($path = '', $params = array())
    {
        $content = '';

        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }

        return $content;
    }

    /* Check URL */
    public function checkURL($index = false)
    {
        global $configBase;

        $url = '';
        $urls = array('index', 'index.html', 'trang-chu', 'trang-chu.html');

        if (array_key_exists('REDIRECT_URL', $_SERVER)) {
            $url = explode("/", $_SERVER['REDIRECT_URL']);
        } else {
            $url = explode("/", $_SERVER['REQUEST_URI']);
        }

        if (is_array($url)) {
            $url = $url[count($url) - 1];
            if (strpos($url, "?")) {
                $url = explode("?", $url);
                $url = $url[0];
            }
        }

        if ($index) array_push($urls, "index.php");
        else if (array_search('index.php', $urls)) $urls = array_diff($urls, ["index.php"]);
        if (in_array($url, $urls)) $this->redirect($configBase, 301);
    }
    /* Curl file */
    public function curlFile($file)
    {
        $result = null;

        if ($this->hasFile($file)) {
            $result = new CURLFile($_FILES[$file]['tmp_name'], $_FILES[$file]['type'], $_FILES[$file]['name']);
        }

        return $result;
    }
    /* Check HTTP */
    public function checkHTTP($http, $arrayDomain, &$configBase, $configUrl)
    {
        if (count($arrayDomain) == 0 && $http == 'https://') {
            $configBase = 'http://' . $configUrl;
        }
    }

    /* Create sitemap */
    public function createSitemap($url = '', $date_created = 0, $changefreq = '', $priority = '')
    {
        if (!empty($url)) {
            echo '<url>';
            echo '<loc>' . $url . '</loc>';
            echo '<lastmod>' . date('c', $date_created) . '</lastmod>';
            echo '<changefreq>' . $changefreq . '</changefreq>';
            echo '<priority>' . $priority . '</priority>';
            echo '</url>';
        }
    }

    /* Check Is Ajax Request */
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'));
    }

    /* Logout admin */
    public function logoutAdmin()
    {
        global $loginAdmin;

        /* Hủy bỏ quyền */
        $data_update_permission['secret_key'] = '';
        $this->d->where('id', $_SESSION[$loginAdmin]['owner']['id']);
        $this->d->update('user', $data_update_permission);

        /* Hủy bỏ login */
        if (!empty($_SESSION[TOKEN])) unset($_SESSION[TOKEN]);
        unset($_SESSION[$loginAdmin]);
        $this->redirect("index.php?com=user&act=login");
    }

    /* Kiểm tra dữ liệu nhập vào */
    public function cleanInput($input = '', $type = '')
    {
        $output = '';

        if ($input != '') {
            /*
					// Loại bỏ HTML tags
					'@<[\/\!]*?[^<>]*?>@si',
				*/

            $search = array(
                'script' => '@<script[^>]*?>.*?</script>@si',
                'style' => '@<style[^>]*?>.*?</style>@siU',
                'blank' => '@<![\s\S]*?--[ \t\n\r]*>@',
                'iframe' => '/<iframe(.*?)<\/iframe>/is',
                'title' => '/<title(.*?)<\/title>/is',
                'pre' => '/<pre(.*?)<\/pre>/is',
                'frame' => '/<frame(.*?)<\/frame>/is',
                'frameset' => '/<frameset(.*?)<\/frameset>/is',
                'object' => '/<object(.*?)<\/object>/is',
                'embed' => '/<embed(.*?)<\/embed>/is',
                'applet' => '/<applet(.*?)<\/applet>/is',
                'meta' => '/<meta(.*?)<\/meta>/is',
                'doctype' => '/<!doctype(.*?)>/is',
                'link' => '/<link(.*?)>/is',
                'body' => '/<body(.*?)<\/body>/is',
                'html' => '/<html(.*?)<\/html>/is',
                'head' => '/<head(.*?)<\/head>/is',
                'onclick' => '/onclick="(.*?)"/is',
                'ondbclick' => '/ondbclick="(.*?)"/is',
                'onchange' => '/onchange="(.*?)"/is',
                'onmouseover' => '/onmouseover="(.*?)"/is',
                'onmouseout' => '/onmouseout="(.*?)"/is',
                'onmouseenter' => '/onmouseenter="(.*?)"/is',
                'onmouseleave' => '/onmouseleave="(.*?)"/is',
                'onmousemove' => '/onmousemove="(.*?)"/is',
                'onkeydown' => '/onkeydown="(.*?)"/is',
                'onload' => '/onload="(.*?)"/is',
                'onunload' => '/onunload="(.*?)"/is',
                'onkeyup' => '/onkeyup="(.*?)"/is',
                'onkeypress' => '/onkeypress="(.*?)"/is',
                'onblur' => '/onblur="(.*?)"/is',
                'oncopy' => '/oncopy="(.*?)"/is',
                'oncut' => '/oncut="(.*?)"/is',
                'onpaste' => '/onpaste="(.*?)"/is',
                'php-tag' => '/<(\?|\%)\=?(php)?/',
                'php-short-tag' => '/(\%|\?)>/'
            );

            if (!empty($type)) {
                unset($search[$type]);
            }

            $output = preg_replace($search, '', $input);
        }

        return $output;
    }

    /* Kiểm tra dữ liệu nhập vào */
    public function sanitize($input = '', $type = '')
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->sanitize($val, $type);
            }
        } else {
            $output  = $this->cleanInput($input, $type);
        }

        return $output;
    }

    /* Decode html characters */
    public function decodeHtmlChars($htmlChars)
    {
        return htmlspecialchars_decode($htmlChars ?: '');
    }

    /* Encrypt string */
    public function encryptString($string = '')
    {
        return base64_encode(json_encode($string));
    }

    /* Decrypt string */
    public function decryptString($string = '')
    {
        return json_decode(base64_decode($string));
    }

    /* Kiểm tra đăng nhập */
    public function checkLoginAdmin()
    {
        global $loginAdmin;

        $token = (!empty($_SESSION[$loginAdmin]['owner']['token'])) ? $_SESSION[$loginAdmin]['owner']['token'] : '';
        $row = $this->d->rawQuery("select secret_key from #_user where secret_key = ? and find_in_set('hienthi',status)", array($token));

        if (count($row) == 1 && $row[0]['secret_key'] != '') {
            return true;
        } else {
            if (!empty($_SESSION[TOKEN])) unset($_SESSION[TOKEN]);
            unset($_SESSION[$loginAdmin]);
            return false;
        }
    }

    /* Mã hóa mật khẩu admin */
    public function encryptPassword($secret = '', $str = '', $salt = '')
    {
        return md5($secret . $str . $salt);
    }

    /* Kiểm tra phân quyền */
    public function checkRole()
    {
        global $config, $loginAdmin;

        if (((!empty($_SESSION[$loginAdmin]['owner']['role'])) && $_SESSION[$loginAdmin]['owner']['role'] == 3) || !empty($config['website']['debug-developer'])) return false;
        else return true;
    }

    /* Lấy thông tin Group */
    public function getGroup($col = '')
    {
        global $loginAdmin;

        if (!empty($col)) {
            if ($col == '*') {
                return $_SESSION[$loginAdmin]['group'];
            } else if (!empty($_SESSION[$loginAdmin]['group'][$col])) {
                return $_SESSION[$loginAdmin]['group'][$col];
            } else {
                return '';
            }
        } else {
            return false;
        }
    }

    /* Kiểm tra quyền truy cập của Group */
    public function checkAccessGroup($perms = '')
    {
        $flag = false;
        $permsLists = '';
        $permsGroup = $this->getGroup('permsGroup');
        $permsSelf = $this->getGroup('permsSelf');

        if (!empty($permsSelf)) {
            $permsLists = $permsSelf;
        } else if (!empty($permsGroup)) {
            $permsLists = $permsGroup;
        }

        if (!empty($perms) && !empty($permsLists)) {
            $permsLists = explode(",", $permsLists);
            if (in_array($perms, $permsLists)) {
                $flag = true;
            }
        }

        return $flag;
    }

    /* Kiểm tra quyền truy cập của Block */
    public function checkAccessBlock($com = '', $act = '', $types = '')
    {
        $flag = false;

        if (!empty($com) && !empty($types)) {
            $types = explode(",", $types);

            foreach ($types as $v) {
                if ($this->checkAccess($com, $act, trim($v))) {
                    $flag = true;
                    break;
                }
            }
        }

        return $flag;
    }

    /* Kiểm tra quyền truy cập */
    public function checkAccess($com = '', $act = '', $type = '')
    {
        $flag = false;
        $permLists = $this->getGroup('permissions');

        if (!empty($com) && !empty($act) && !empty($permLists)) {
            $perm = (!empty($type)) ? $com . '_' . $act . '_' . $type : $com . '_' . $act;

            if (in_array($perm, $permLists)) {
                $flag = true;
            }
        }

        return $flag;
    }

    /* Postdate */
    public function postDate($date)
    {
        $result = '';
        $langs = array('giây', 'phút', 'giờ', 'ngày', 'tuần', 'tháng', 'năm');
        $chunks = array(
            array(60 * 60 * 24 * 365,  $langs[6], $langs[6]),
            array(60 * 60 * 24 * 30, $langs[5], $langs[5]),
            array(60 * 60 * 24 * 7, $langs[4], $langs[4]),
            array(60 * 60 * 24, $langs[3], $langs[3]),
            array(60 * 60, $langs[2], $langs[2]),
            array(60, $langs[1], $langs[1]),
            array(1,  $langs[0], $langs[0])
        );

        $newer_date = time();
        $since = $newer_date - $date;

        if (0 > $since) {
            $result = 'Vài giây trước';
        } else {
            for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];

                if (($count = floor($since / $seconds)) != 0) {
                    break;
                }
            }

            $result = (1 == $count) ? '1 ' . $chunks[$i][1] : $count . ' ' . $chunks[$i][2];

            if (!(int)trim($result)) {
                $result = '0 ' .  $langs[0];
            }

            $result .= ' trước';
        }

        return $result;
    }

    /* Format money */
    public function formatMoney($price = 0, $unit = 'đ', $html = false)
    {
        $str = !empty($price) ? number_format($price, 0, ',', '.') : 0;

        if ($unit != '') {
            if ($html) {
                $str .= '<span>' . $unit . '</span>';
            } else {
                $str .= $unit;
            }
        }

        return $str;
    }

    function precisionNumber($number, $precision = 1, $separator = ',')
    {
        $numberParts = explode($separator, $number);
        $response = $numberParts[0];

        if (count($numberParts) > 1 && $precision > 0) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }

        return $response;
    }

    function shortNumber($number = 0, $lang = 'vi', $len = 'l')
    {
        $result = array();
        $result['format'] = '';
        $result['suffix'] = 'NaN';

        /* Number preg */
        $number = (!empty($number)) ? preg_replace("/[^0-9]/", "", $number) : 0;

        if ($number > 0) {
            /* Suffix */
            $suffix = array(
                'vi' => array(
                    'l' => array('nghìn', 'triệu', 'tỷ'),
                    's' => array('N', 'Tr', 'T')
                ),
                'en' => array(
                    'l' => array('thousand', 'million', 'billion'),
                    's' => array('K', 'M', 'B')
                )
            );

            if ($number <= 999) {
                $result['suffix'] = '';
            } else if ($number <= 999999) {
                $number = $number / 1000;
                $result['suffix'] = $suffix[$lang][$len][0];
            } else if ($number <= 999999999) {
                $number = $number / 1000000;
                $result['suffix'] = $suffix[$lang][$len][1];
            } else if ($number <= 999999999999) {
                $number = $number / 1000000000;
                $result['suffix'] = $suffix[$lang][$len][2];
            }

            $number = str_replace(".", ",", $number);
            $result['format'] = $this->precisionNumber($number);
        } else {
            $result['format'] = 0;
            $result['suffix'] = '';
        }

        return trim($result['format'] . ' ' . $result['suffix']);
    }

    /* Check recaptcha */
    public function checkRecaptcha($response = '')
    {
        global $config;

        $result = null;
        $active = $config['googleAPI']['recaptcha']['active'];

        if ($active == true && $response != '') {
            $recaptcha = file_get_contents($config['googleAPI']['recaptcha']['urlapi'] . '?secret=' . $config['googleAPI']['recaptcha']['secretkey'] . '&response=' . $response);
            $recaptcha = json_decode($recaptcha);
            $result['score'] = $recaptcha->score;
            $result['action'] = $recaptcha->action;
        } else if (!$active) {
            $result['test'] = true;
        }

        return $result;
    }

    /* Login */
    public function checkLoginMember()
{
    global $configBase, $loginMember, $restApi, $apiRoutes;

    if (!empty($_SESSION[$loginMember]) || !empty($_COOKIE['cookieLoginMemberId'])) {
        $flag = true;
        $iduser = (!empty($_COOKIE['cookieLoginMemberId'])) ? $_COOKIE['cookieLoginMemberId'] : $_SESSION[$loginMember]['id'];

        if ($iduser) {
            $urlApi = str_replace('{id}', $iduser, $apiRoutes['storefront']['member']['detail']);
            $apiResp = $restApi->get($urlApi);
            $apiResp = $restApi->decode($apiResp, true);

            if (!empty($apiResp) && $apiResp['status'] == 200) {
                $login_session = (!empty($_COOKIE['cookieLoginMemberSession'])) ? $_COOKIE['cookieLoginMemberSession'] : $_SESSION[$loginMember]['login_session'];

                if ($login_session == $apiResp['data']['login_session']) {
                    $_SESSION[$loginMember]['active'] = true;
                    $_SESSION[$loginMember]['id'] = $apiResp['data']['id'];
                    $_SESSION[$loginMember]['avatar'] = $apiResp['data']['avatar'];
                    $_SESSION[$loginMember]['username'] = $apiResp['data']['username'];
                    $_SESSION[$loginMember]['address'] = $apiResp['data']['address'];
                    $_SESSION[$loginMember]['email'] = $apiResp['data']['email'];
                    $_SESSION[$loginMember]['phone'] = $apiResp['data']['phone'];
                    $_SESSION[$loginMember]['first_name'] = $apiResp['data']['first_name'];
                    $_SESSION[$loginMember]['last_name'] = $apiResp['data']['last_name'];
                    $_SESSION[$loginMember]['fullname'] = $apiResp['data']['fullname'];
                } else $flag = false;
            } else $flag = false;

            if (!$flag) {
                unset($_SESSION[$loginMember]);
                setcookie('cookieLoginMemberId', '', 0, '', '', false, true);
                setcookie('cookieLoginMemberSession', '', 0, '', '', false, true);

                $this->transfer("Tài khoản của bạn đã hết hạn đăng nhập hoặc đã đăng nhập trên thiết bị khác", $configBase, false);
            }
        }
    }
}

    /* Get info session member */
    public function getMember($col = '')
    {
        global $loginMember;

        if (!empty($col) && !empty($_SESSION[$loginMember][$col])) return $_SESSION[$loginMember][$col];
        else return false;
    }

    /* Join place */
    public function joinPlace($array = array())
    {
        $result = '';

        if (!empty($array['nameWard'])) {
            $result .= $array['nameWard'] . ', ';
        }

        if (!empty($array['nameDistrict'])) {
            $result .= $array['nameDistrict'] . ', ';
        }

        if (!empty($array['nameCity'])) {
            $result .= $array['nameCity'];
        }

        if (!empty($array['name_ward'])) {
            $result .= $array['name_ward'] . ', ';
        }

        if (!empty($array['name_district'])) {
            $result .= $array['name_district'] . ', ';
        }

        if (!empty($array['name_city'])) {
            $result .= $array['name_city'];
        }

        return $result;
    }

    /* Join column */
    public function joinCols($array = null, $column = null)
    {
        $str = '';
        $arrayTemp = array();

        if ($array && $column) {
            foreach ($array as $k => $v) {
                if (!empty($v[$column])) {
                    $arrayTemp[] = $v[$column];
                }
            }

            if (!empty($arrayTemp)) {
                $arrayTemp = array_unique($arrayTemp);
                $str = implode(",", $arrayTemp);
            }
        }

        return $str;
    }

    /* Get all owner (admin + virtual + member) not active */
    public function getAllOwnerUnActive()
    {
        $result = array();

        /* Member unactive */
        $members = $this->cache->get("select id from #_member where !find_in_set('hienthi',status)", null, 'result', 7200);
        $members = (!empty($members)) ? $this->joinCols($members, 'id') : '';
        $result['member'] = (!empty($members)) ? $members : '';

        /* Admin unactive */
        $admins = $this->cache->get("select id from #_user where !find_in_set('hienthi',status) and !find_in_set('virtual',status)", null, 'result', 7200);
        $admins = (!empty($admins)) ? $this->joinCols($admins, 'id') : '';
        $result['admin'] = (!empty($admins)) ? $admins : '';

        /* Admin virtual unactive */
        $adminsVirtual = $this->cache->get("select id from #_user where !find_in_set('hienthi',status) and find_in_set('virtual',status)", null, 'result', 7200);
        $adminsVirtual = (!empty($adminsVirtual)) ? $this->joinCols($adminsVirtual, 'id') : '';
        $result['admin-virtual'] = (!empty($adminsVirtual)) ? $adminsVirtual : '';

        return $result;
    }

    /* Get all shop EXCEPT */
    public function getAllShopExcept($tableShop = '', $idOwner = array())
    {
        $result = '';

        if (!empty($tableShop)) {
            $rows = array();

            if (!empty($idOwner['member'])) {
                $rows['member'] = $this->cache->get("select id from #_$tableShop where id_member in(" . $idOwner['member'] . ")", null, 'result', 7200);
                $rows['member'] = (!empty($rows['member'])) ? $this->joinCols($rows['member'], 'id') : '';
            }

            if (!empty($idOwner['admin'])) {
                $rows['admin'] = $this->cache->get("select id from #_$tableShop where id_admin in(" . $idOwner['admin'] . ")", null, 'result', 7200);
                $rows['admin'] = (!empty($rows['admin'])) ? $this->joinCols($rows['admin'], 'id') : '';
            }

            if (!empty($idOwner['admin-virtual'])) {
                $rows['admin-virtual'] = $this->cache->get("select id from #_$tableShop where id_admin_virtual in(" . $idOwner['admin-virtual'] . ")", null, 'result', 7200);
                $rows['admin-virtual'] = (!empty($rows['admin-virtual'])) ? $this->joinCols($rows['admin-virtual'], 'id') : '';
            }

            $result .= (!empty($rows['member'])) ? $rows['member'] . ',' : '';
            $result .= (!empty($rows['admin'])) ? $rows['admin'] . ',' : '';
            $result .= (!empty($rows['admin-virtual'])) ? $rows['admin-virtual'] . ',' : '';
            $result  = (!empty($result)) ? rtrim($result, ',') : '';
        }

        return $result;
    }

    /* Get all shop not active */
    public function getAllShopUnActive($tableShop = '')
    {
        $result = '';

        if (!empty($tableShop)) {
            $rows = $this->cache->get("select id from #_$tableShop where status != 'xetduyet' or status_user != 'hienthi'", null, 'result', 7200);
            $result = (!empty($rows)) ? $this->joinCols($rows, 'id') : '';
        }

        return $result;
    }

    /* Get all shop virtual owner unactive */
    public function getAllShopOwnerUnActive($tableShop = '', $ownerVirtualUnActive = '')
    {
        $result = '';

        if (!empty($tableShop) && !empty($ownerVirtualUnActive)) {
            $rows = $this->cache->get("select id from #_$tableShop where id_admin_virtual in($ownerVirtualUnActive)", null, 'result', 7200);
            $result = (!empty($rows)) ? $this->joinCols($rows, 'id') : '';
        }

        return $result;
    }

    /* Get where logic when owner or shop unactive */
    public function getLogicOwner($tableShop = '', $sector = array(), $isCheck = true)
    {
        $result = array();
        $result['where'] = '';

        /* Get all owner (admin + member) not active */
        $ownerUnActive = $this->getAllOwnerUnActive();
        $result['memberUnActive'] = (!empty($ownerUnActive['member'])) ? $ownerUnActive['member'] : '';
        $result['adminUnActive'] = (!empty($ownerUnActive['admin'])) ? $ownerUnActive['admin'] : '';
        $result['adminVirtualUnActive'] = (!empty($ownerUnActive['admin-virtual'])) ? $ownerUnActive['admin-virtual'] : '';

        /* Where owner when owner unactive */
        if (!empty($ownerUnActive['member']) || !empty($ownerUnActive['admin']) || !empty($ownerUnActive['admin-virtual'])) {
            /* Where for shop */
            if (!empty($tableShop) && in_array($sector['type'], array('dien-tu', 'thoi-trang'))) {
                /* Get all shop EXCEPT */
                $shopExcept = $this->getAllShopExcept($tableShop, $ownerUnActive);

                /* Where shop EXCEPT */
                if (!empty($shopExcept)) {
                    $result['where'] .= " and A.id_shop not in($shopExcept)";
                }

                /* Get all shop virtual owner unactive */
                $shopVirtualOwnerUnActive = $this->getAllShopOwnerUnActive($tableShop, $result['adminVirtualUnActive']);

                /* Where shop virtual owner UNACTIVE */
                if (!empty($shopVirtualOwnerUnActive)) {
                    $result['where'] .= " and A.id_shop not in($shopVirtualOwnerUnActive)";
                }
            }

            /* Where owner member */
            if (!empty($ownerUnActive['member'])) {
                $result['where'] .= " and A.id_member not in(" . $ownerUnActive['member'] . ")";
            }

            /* Where owner admin */
            if (!empty($ownerUnActive['admin'])) {
                $result['where'] .= " and A.id_admin not in(" . $ownerUnActive['admin'] . ")";
            }
        }

        /* Where shop unactive */
        if ($isCheck) {
            /* Get all shop not active */
            $shopUnActive = $this->getAllShopUnActive($tableShop);

            /* Where shop UNACTIVE */
            if (!empty($shopUnActive)) {
                $result['where'] .= " and A.id_shop not in($shopUnActive)";
            }

            /* Where by sector */
            if (in_array($sector['type'], array('dien-tu', 'thoi-trang'))) {
                $result['where'] .= " and (A.status_user = 'hienthi' or find_in_set('hienthi',A.status_attr))";
            } else {
                $result['where'] .= " and A.status_user = 'hienthi'";
            }
        }

        return $result;
    }

    /* Get where login when shop unactive */
    public function getLogicShop($tableShop = '', $whereLogicOwner = array())
    {
        $result = '';

        if (empty($whereLogicOwner['memberUnActive']) && empty($whereLogicOwner['adminUnActive']) && empty($whereLogicOwner['adminVirtualUnActive'])) {
            /* Get all shop not active */
            $shopUnActive = $this->getAllShopUnActive($tableShop);

            /* Get all shop virtual owner unactive */
            $shopVirtualOwnerUnActive = $this->getAllShopOwnerUnActive($tableShop, $whereLogicOwner['adminVirtualUnActive']);

            /* Where shop */
            $result .= " and (A.status_user = 'hienthi' or (A.id_shop > 0 and A.status = 'xetduyet' and find_in_set('hienthi',A.status_attr))";
            $result .= (!empty($shopUnActive)) ? " and A.id_shop not in($shopUnActive)" : "";
            $result .= (!empty($shopVirtualOwnerUnActive)) ? " and A.id_shop not in($shopVirtualOwnerUnActive)" : "";
            $result .= ")";
        }

        return $result;
    }

    /* Is phone */
    public function isPhone($number)
    {
        $number = trim($number);
        if (preg_match('/(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/', $number) && strlen($number) == 10) {
            return true;
        } else {
            return false;
        }
    }

    /* Exist file */
    public function existFile($file)
    {
        if (file_exists($file)) {
            return true;
        } else {
            return false;
        }
    }

    /* Has file */
    public function hasFile($file)
    {
        if (isset($_FILES[$file])) {
            if ($_FILES[$file]['error'] == 4) {
                return false;
            } else if ($_FILES[$file]['error'] == 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    /* Size file */
    public function sizeFile($file)
    {
        if ($this->hasFile($file)) {
            if ($_FILES[$file]['error'] == 0) {
                return $_FILES[$file]['size'];
            }
        } else {
            return 0;
        }
    }

    /* Check file */
    public function checkFile($file)
    {
        global $config;

        $result = true;

        if ($this->hasFile($file)) {
            if ($this->sizeFile($file) > $config['website']['video']['max-size']) {
                $result = false;
            }
        }

        return $result;
    }

    /* Check extension file */
    public function checkExtFile($file)
    {
        global $config;

        $result = true;

        if ($this->hasFile($file)) {
            $ext = $this->infoPath($_FILES[$file]["name"], 'extension');

            if (!in_array($ext, $config['website']['video']['extension'])) {
                $result = false;
            }
        }

        return $result;
    }

    /* Info path */
    public function infoPath($filename = '', $type = '')
    {
        $result = '';

        if (!empty($filename) && !empty($type)) {
            if ($type == 'extension') {
                $result = pathinfo($filename, PATHINFO_EXTENSION);
            } else if ($type == 'filename') {
                $result = pathinfo($filename, PATHINFO_FILENAME);
            }
        }

        return $result;
    }

    /* Format bytes */
    public function formatBytes($size, $precision = 2)
    {
        $result = array();
        $base = log($size, 1024);
        $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');
        $result['numb'] = round(pow(1024, $base - floor($base)), $precision);
        if($suffixes[floor($base)] == 'Bytes'){
            $result['numb'] = $result['numb'] / 1024 / 1024;
        }else if($suffixes[floor($base)] == 'KB'){
            $result['numb'] = $result['numb'] / 1024;
        }else if($suffixes[floor($base)] == 'MB'){
            $result['numb'] = $result['numb'];
        }else if($suffixes[floor($base)] == 'GB'){
            $result['numb'] = $result['numb'] * 1024;
        }else if($suffixes[floor($base)] == 'TB'){
            $result['numb'] = $result['numb'] * 1024 * 1024;
        }

        $result['ext'] = $suffixes[floor($base)];

        return $result;
    }

    /* Format phone */
    public function formatPhone($number, $dash = ' ')
    {
        if (preg_match('/^(\d{4})(\d{3})(\d{3})$/', $number, $matches)) {
            return $matches[1] . $dash . $matches[2] . $dash . $matches[3];
        }
    }

    /* Parse phone */
    public function parsePhone($number)
    {
        return (!empty($number)) ? preg_replace('/[^0-9]/', '', $number) : '';
    }

    /* Check letters and nums */
    public function isAlphaNum($str)
    {
        if (preg_match('/^[a-z0-9]+$/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is email */
    public function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is match */
    public function isMatch($value1, $value2)
    {
        if ($value1 == $value2) {
            return true;
        } else {
            return false;
        }
    }

    /* Is password */
    public function isPassword($password)
    {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#&$*]).{8,}$/', $password)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is decimal */
    public function isDecimal($number)
    {
        if (preg_match('/^\d{1,10}(\.\d{1,4})?$/', $number)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is zero */
    public function isZero($number)
    {
        if (preg_match('/^((?!(0))[0-9].*)$/', $number)) {
            return false;
        } else {
            return true;
        }
    }

    /* Is coordinates */
    public function isCoords($str)
    {
        if (preg_match('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is url */
    public function isUrl($str)
    {
        if (preg_match('/^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is url youtube */
    public function isYoutube($str)
    {
        if (preg_match('/https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is fanpage */
    public function isFanpage($str)
    {
        if (preg_match('/^(https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is date */
    public function isDate($str)
    {
        if (preg_match('/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /* Is number */
    public function isNumber($numbs)
    {
        if (preg_match('/^[0-9]+$/', $numbs)) {
            return true;
        } else {
            return false;
        }
    }

    /* Get image */
    public function getImage($data = array())
    {
        global $config;

        /* Defaults */
        $defaults = [
            'class' => 'lazy',
            'id' => '',
            'isLazy' => true,
            'thumbs' => THUMBS,
            'size-error' => '',
            'size-src' => '',
            'sizes' => '',
            'url' => '',
            'upload' => '',
            'image' => '',
            'upload-error' => 'assets/images/',
            'image-error' => 'noimage.png',
            'alt' => '',
        ];

        /* Data */
        $info = array_merge($defaults, $data);

        /* Upload - Image */
        if (empty($info['upload']) || empty($info['image'])) {
            $info['upload'] = $info['upload-error'];
            $info['image'] = $info['image-error'];
        }

        /* Size */
        if (!empty($info['sizes'])) {
            $info['size-error'] = $info['size-src'] = $info['sizes'];
        }

        /* Path origin */
        $info['pathOrigin'] = $info['upload'] . $info['image'];

        /* Path src */
        $info['pathSrc'] = (!empty($info['url'])) ? $info['url'] : ((!empty($info['size-src'])) ? ASSET . $info['thumbs'] . "/" . $info['size-src'] . "/" . $info['upload'] . $info['image'] : ASSET . $info['pathOrigin']);

        /* Path error */
        $info['pathError'] = ASSET . $info['thumbs'] . "/" . $info['size-error'] . "/" . $info['upload-error'] . $info['image-error'];

        /* Class */
        $info['class'] = (empty($info['isLazy'])) ? str_replace('lazy', '', $info['class']) : $info['class'];
        $info['class'] = (!empty($info['class'])) ? "class='" . $info['class'] . "'" : "";

        /* Id */
        $info['id'] = (!empty($info['id'])) ? "id='" . $info['id'] . "'" : "";

        /* Check to convert Webp */
        $info['hasURL'] = false;

        if (filter_var(str_replace(ASSET, "", $info['pathSrc']), FILTER_VALIDATE_URL)) {
            $info['hasURL'] = true;
        }

        if ($config['website']['image']['hasWebp']) {
            if (!$info['sizes']) {
                if (!$info['hasURL']) {
                    $this->converWebp($info['pathSrc']);
                }
            }

            if (!$info['hasURL']) {
                $info['pathSrc'] .= '.webp';
            }
        }

        /* Src */
        $info['src'] = (!empty($info['isLazy']) && strstr($info['class'], 'lazy')) ? "data-src='" . $info['pathSrc'] . "'" : "src='" . $info['pathSrc'] . "'";

        /* Image */
        $result = "<img " . $info['class'] . " " . $info['id'] . " onerror=\"this.src='" . $info['pathError'] . "';\" " . $info['src'] . " alt='" . $info['alt'] . "'/>";

        return $result;
    }

    /* Get members that favourited products in shop */
    public function getMembersFavouritedProducts($sectorType = '', $tableProductMain = '', $IDShop = 0)
    {
        $result = array();

        if (!empty($sectorType) && !empty($tableProductMain) && !empty($IDShop)) {
            /* Get all favourties of sector */
            $favouritesOfSector = $this->cache->get("select id_variant from #_member_favourite where type = ? and variant = ?", array($sectorType, 'product'), "result", 7200);

            if (!empty($favouritesOfSector)) {
                $favouritedProducts = $this->joinCols($favouritesOfSector, 'id_variant');
                $productsInShop = $this->cache->get("select id from #_$tableProductMain where id in ($favouritedProducts) and id_shop = ?", array($IDShop), "result", 7200);
                $result = (!empty($productsInShop)) ? $this->cache->get("select id_member from #_member_favourite where id_variant in (" . $this->joinCols($productsInShop, 'id') . ") and type = ? and variant = ?", array($sectorType, 'product'), "result", 7200) : array();
                $result = (!empty($result)) ? explode(",", $this->joinCols($result, 'id_member')) : array();
                $result = (!empty($result)) ? array_unique($result) : array();
            }
        }

        return $result;
    }

    /* Get group cat */
    public function getGroupCat($cat = array())
    {
        $str = '';

        if (!empty($cat)) {
            /* Get markdown */
            $str = $this->markdown('sector/group-cat', $cat);
        }

        return $str;
    }

    /* Delete related sale */
    public function deleteSale($id = 0, $attr = '')
    {
        global $defineSectors;

        if (!empty($defineSectors)) {
            foreach ($defineSectors['types'] as $v_define) {
                if (!empty($v_define['tables']['sale'])) {
                    $this->d->rawQuery("delete from #_" . $v_define['tables']['sale'] . " where id_$attr = ?", array($id));
                }
            }
        }
    }

    /* Delete product */
    public function deleteProduct($detail = array(), $sector = array(), $path = '')
    {
        if (empty($detail) || empty($sector) || empty($path)) {
            return false;
        }

        /* Delete main */
        $this->deleteFile($path . $detail['photo']);
        $this->d->rawQuery("delete from #_" . $sector['tables']['main'] . " where id = ?", array($detail['id']));

        /* Get data report */
        $rowReport = $this->d->rawQueryOne("select id from #_" . $sector['tables']['report-product'] . " where id_product = ? limit 0,1", array($detail['id']));

        /* Delete seo */
        $this->d->rawQuery("delete from #_" . $sector['tables']['seo'] . " where id_parent = ?", array($detail['id']));

        /* Delete info */
        if (!empty($sector['tables']['info'])) {
            $this->d->rawQuery("delete from #_" . $sector['tables']['info'] . " where id_parent = ?", array($detail['id']));
        }

        /* Delete content */
        $this->d->rawQuery("delete from #_" . $sector['tables']['content'] . " where id_parent = ?", array($detail['id']));

        /* Delete contact */
        $this->d->rawQuery("delete from #_" . $sector['tables']['contact'] . " where id_parent = ?", array($detail['id']));

        /* Delete tag */
        $this->d->rawQuery("delete from #_" . $sector['tables']['tag'] . " where id_parent = ?", array($detail['id']));

        /* Delete comment */
        $rowComment = $this->d->rawQuery("select id, id_parent from #_" . $sector['tables']['comment'] . " where id_product = ?", array($detail['id']));

        if (!empty($rowComment)) {
            foreach ($rowComment as $v) {
                if ($v['id_parent'] == 0) {
                    /* Delete comment photo */
                    $rowCommentPhoto = $this->d->rawQuery("select photo from #_" . $sector['tables']['comment-photo'] . " where id_parent = ?", array($v['id']));

                    if (!empty($rowCommentPhoto)) {
                        /* Delete image */
                        foreach ($rowCommentPhoto as $v_photo) {
                            $this->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                        }

                        /* Delete photo */
                        $this->d->rawQuery("delete from #_" . $sector['tables']['comment-photo'] . " where id_parent = ?", array($v['id']));
                    }

                    /* Delete comment video */
                    $rowCommentVideo = $this->d->rawQueryOne("select photo, video from #_" . $sector['tables']['comment-video'] . " where id_parent = ? limit 0,1", array($v['id']));

                    if (!empty($rowCommentVideo)) {
                        $this->deleteFile(UPLOAD_PHOTO . $rowCommentVideo['photo']);
                        $this->deleteFile(UPLOAD_VIDEO . $rowCommentVideo['video']);
                        $this->d->rawQuery("delete from #_" . $sector['tables']['comment-video'] . " where id_parent = ?", array($v['id']));
                    }

                    /* Delete child */
                    $this->d->rawQuery("delete from #_" . $sector['tables']['comment'] . " where id_parent = ?", array($v['id']));
                }

                /* Delete comment main */
                $this->d->rawQuery("delete from #_" . $sector['tables']['comment'] . " where id = ?", array($v['id']));
            }
        }

        /* Delete video */
        $rowVideo = $this->d->rawQueryOne("select photo, video, type from #_" . $sector['tables']['video'] . " where id_parent = ? limit 0,1", array($detail['id']));

        if (!empty($rowVideo)) {
            $this->deleteFile(UPLOAD_PHOTO . $rowVideo['photo']);
            $this->deleteFile(UPLOAD_VIDEO . $rowVideo['video']);
            $this->d->rawQuery("delete from #_" . $sector['tables']['video'] . " where id_parent = ?", array($detail['id']));
        }

        /* Delete variation */
        if (!empty($sector['tables']['variation'])) {
            $this->d->rawQuery("delete from #_" . $sector['tables']['variation'] . " where id_parent = ?", array($detail['id']));
        }

        /* Delete sale */
        if (!empty($sector['tables']['sale'])) {
            $this->d->rawQuery("delete from #_" . $sector['tables']['sale'] . " where id_parent = ?", array($detail['id']));
        }

        /* Delete report */
        if (!empty($rowReport)) {
            $this->d->rawQuery("delete from #_" . $sector['tables']['report-product'] . " where id = ?", array($rowReport['id']));
            $this->d->rawQuery("delete from #_" . $sector['tables']['report-product-info'] . " where id_parent = ?", array($rowReport['id']));
        }

        /* Delete order detail */
        $this->d->rawQuery("delete from #_order_detail where id_product = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete member favourite */
        $this->d->rawQuery("delete from #_member_favourite where id_variant = ? and type = ? and variant = ?", array($detail['id'], $sector['type'], 'product'));

        /* Get photo */
        if (!empty($sector['tables']['photo'])) {
            $row = $this->d->rawQuery("select id, photo from #_" . $sector['tables']['photo'] . " where id_parent = ?", array($detail['id']));

            /* Check photo */
            if (count($row)) {
                /* Delete image */
                foreach ($row as $v) {
                    $this->deleteFile($path . $v['photo']);
                }

                /* Delete photo */
                $this->d->rawQuery("delete from #_" . $sector['tables']['photo'] . " where id_parent = ?", array($detail['id']));
            }
        }
    }

    /* Get product */
    public function getProduct($product = array())
    {
        $str = '';

        if (!empty($product)) {
            /* Data */
            $product['imgDisabled'] = '';
            $product['target'] = '';// 'target="_blank"';
            $product['clsMain'] = (!empty($product['clsMain'])) ? trim($product['clsMain']) : '';
            $product['clsSmall'] = (!empty($product['clsSmall'])) ? trim($product['clsSmall']) : '';
            $product['clsNewPost'] = (!empty($product['clsNewPost'])) ? trim($product['clsNewPost']) : '';
            $product['variant'] = (!empty($product['id_shop'])) ? 'is-shop' : 'is-personal';
            $product['isOwned'] = ((!empty($product['idMember']) && $product['idMember'] == $product['id_member']) || !empty($product['ownedShop']) && in_array($product['id_shop'], $product['ownedShop'])) ? 'is-owned' : '';
            $product['memberTitle'] = ($product['memberFullname']!="")? $this->changeTitle($product['memberFullname']):'';
            if (!empty($product['isAccount'])) {
                $statusUser = array();
                $product['statusCls'] = 'success';
                $product['statusText'] = 'Hoạt động';
                $statusUser['active'] = 'disabled';
                $statusUser['text'] = 'Vô hiệu';

                if ($product['status'] == '') {
                    $product['imgDisabled'] = 'img-disabled';
                    $product['statusCls'] = 'secondary';
                    $product['statusText'] = 'Chờ duyệt';
                    $product['target'] = '';
                    $product['href'] = 'javascript:void(0)';
                } else if (in_array($product['status'], array('dangsai', 'vipham'))) {
                    $product['imgDisabled'] = 'img-disabled';
                    $product['statusCls'] = 'danger';
                    $product['statusText'] = ($product['status'] == 'dangsai') ? 'Đăng sai' : (($product['status'] == 'vipham') ? 'Vi phạm' : '');

                    if ($product['status'] == 'vipham') {
                        $product['target'] = '';
                        $product['href'] = 'javascript:void(0)';
                    }
                } else if (!empty($product['status_user'])) {
                    if ($product['status_user'] == 'hienthi') {
                        $statusUser['active'] = 'checked';
                        $statusUser['text'] = 'Hiển thị';
                    } else if ($product['status_user'] == 'taman') {
                        $statusUser['active'] = '';
                        $statusUser['text'] = 'Tạm ẩn';
                    }
                }
            }

            /* Params for markdown */
            $params = array();
            $params['product'] = $product;
            $params['statusUser'] = (!empty($statusUser)) ? $statusUser : array();
      
            /* Get markdown */
            $str = $this->markdown('product/main', $params);
        }

        return $str;
    }

    /* Get product comment */
    public function getProductComment($product = array())
    {
        $str = '';

        if (!empty($product)) {
            /* Get markdown */
            $str = $this->markdown('product/comment', $product);
        }

        return $str;
    }

    /* Get product content */
    public function getProductContent($id, $lang, $table)
    {
        return (!empty($id) && !empty($table)) ? $this->cache->get("select content$lang from #_$table where id_parent = ?", array($id), 'fetch', 7200) : array();
    }

    /* Get product photo */
    public function getProductPhoto($id, $lang, $table)
    {
        return (!empty($id) && !empty($table)) ? $this->cache->get("select id, photo, name$lang from #_$table where id_parent = ?", array($id), 'result', 7200) : array();
    }

    /* Get product video */
    public function getProductVideo($id, $lang, $table)
    {
        return (!empty($id) && !empty($table)) ? $this->cache->get("select photo, video, name$lang, type from #_$table where id_parent = ? and name$lang != '' and video != ''", array($id), 'fetch', 7200) : array();
    }

    /* Check owned product */
    public function isOwnedProduct($product = array(), $tableShop = '', $idMember = 0)
    {
        $result = array();
        $result['isOwned'] = false;
        $result['ownedShop'] = array();

        if (!empty($product) && !empty($idMember)) {
            if (!empty($tableShop)) {
                $result['ownedShop'] = $this->cache->get("select id from #_$tableShop where id = ? and id_member = ? limit 0,1", array($product['id_shop'], $idMember), 'fetch', 7200);
            }

            if (($product['id_member'] == $idMember) || (!empty($result['ownedShop']) && !empty($product['id_shop']) && $product['id_shop'] == $result['ownedShop']['id'])) {
                $result['isOwned'] = true;
            }
        }

        return $result;
    }

    /* Condition favourite product */
    public function favouriteProduct($isOwned = false, $favourites = array(), $product = array(), $lang = 'vi')
    {
        $result = array();
        $result['favourite-active'] = '';
        $result['favourite-title'] = 'Quan tâm (' . $product['name' . $lang] . ')';

        if (!empty($product) && !empty($lang)) {
            if (!empty($isOwned)) {
                $result['favourite-active'] = 'text-secondary';
                $result['favourite-title'] = 'Tin đăng thuộc quyền sở hữu của bạn';
            } else if (!empty($favourites) && in_array($product['id'], $favourites)) {
                $result['favourite-active'] = 'active';
                $result['favourite-title'] = 'Bỏ quan tâm (' . $product['name' . $lang] . ')';
            }
        }

        return $result;
    }

    /* Comment count product */
    public function commentCountProduct($id = 0, $tableProductComment = '')
    {
        $row = (!empty($id) && !empty($tableProductComment)) ? $this->cache->get("select count(id) as num from #_$tableProductComment where find_in_set('hienthi',status) and id_parent = 0 and id_product = ?", array($id), 'fetch', 7200) : array();
        return (!empty($row)) ? $row['num'] : 0;
    }

    /* Job info product */
    public function jobInfoProduct($id = 0, $sectorType = '', $tableProductInfo = '')
    {
        $result = array();

        if (!empty($id) && !empty($sectorType) && !empty($tableProductInfo)) {
            if (in_array($sectorType, array('nha-tuyen-dung'))) {
                $result = $this->cache->get("select fullname, application_deadline, age_requirement, trial_period, employee_quantity, gender, address, phone, email, 	introduce from #_$tableProductInfo where id_parent = ? limit 0,1", array($id), 'fetch', 7200);
            } else if (in_array($sectorType, array('ung-vien'))) {
                $result = $this->cache->get("select first_name, last_name, birthday, gender, address, phone, email from #_$tableProductInfo where id_parent = ? limit 0,1", array($id), 'fetch', 7200);
            }
        }

        return $result;
    }

    /* Shop detail product */
    public function shopDetailProduct($idShop = 0, $idMember = 0, $tableShop = '', $tableShopSubscribe = '', $sectorPrefix = '')
    {
        global $configBaseShop;

        $result = array();

        if (!empty($idShop) && !empty($tableShop) && !empty($tableShopSubscribe) && !empty($sectorPrefix)) {
            $result = $this->cache->get("select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.id_interface as id_interface, A.name as name, A.slug_url as slug_url, A.phone as phone, A.email as email, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where A.id = ? and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id limit 0,1", array($sectorPrefix, $idShop), 'fetch', 7200);

            /* Get info of Shop */
            $sampleData = $this->cache->get("select logo from #_sample where id_interface = ?", array($result['id_interface']), 'fetch', 7200);

            /* Logo shop or sample data */
            if (empty($result['logo'])) {
                $result['logo'] = $sampleData['logo'];
            }

            /* Member subscribe */
            if (!empty($idMember)) {
                $subscribeMember = $this->d->rawQueryOne("select id from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ? limit 0,1", array($idMember, $result['id'], $sectorPrefix));
                $result['subscribeActive'] = (!empty($subscribeMember)) ? 'active' : '';
            }

            /* Href shop */
            $result['href'] = $configBaseShop . $result['slug_url'] . '/';
        }

        return $result;
    }

    /* Poster detail product */
    public function posterDetailProduct($product = array())
    {
        if (!empty($product['id_member'])) {
            $tablePoster = 'member';
            $colIDPoster = 'id_member';
        } else if (!empty($product['id_admin'])) {
            $tablePoster = 'user';
            $colIDPoster = 'id_admin';
        }

        $result = $this->cache->get("select fullname, address, phone, email, avatar from #_$tablePoster where id = ? limit 0,1", array($product[$colIDPoster]), 'fetch', 7200);

        return $result;
    }

    /* Get video */
    public function getVideo($video = array())
    {
        $str = '';

        if (!empty($video)) {
            /* Data */
            $video['clsMain'] = (!empty($video['clsMain'])) ? $video['clsMain'] : '';
            $video['target'] = 'target="_blank"';
            $video['variant'] = (!empty($video['id_shop'])) ? 'is-shop' : 'is-personal';
            $video['isOwned'] = ((!empty($video['idMember']) && $video['idMember'] == $video['id_member']) || !empty($video['ownedShop']) && in_array($video['id_shop'], $video['ownedShop'])) ? 'is-owned' : '';

            /* Get markdown */
            $str = $this->markdown('video/main', $video);
        }

        return $str;
    }

    /* Delete shop */
    public function deleteShop($detail = array(), $sector = array(), $paths = array())
    {
        if (empty($detail) || empty($sector) || empty($paths)) {
            return false;
        }

        /* Delete main */
        $this->deleteFile($paths['shop'] . $detail['photo']);
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop'] . " where id = ?", array($detail['id']));

        /* Delete ckfinder folder */
        $this->removeDir($paths['filemanager'] . $detail['folder']);

        /* Delete login logs */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-log'] . " where id_shop = ?", array($detail['id']));

        /* Delete login limit */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-limit'] . " where id_shop = ?", array($detail['id']));

        /* Delete counter */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-counter'] . " where id_shop = ?", array($detail['id']));

        /* Delete user online */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-user-online'] . " where id_shop = ?", array($detail['id']));

        /* Delete rating */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-rating'] . " where id_shop = ?", array($detail['id']));

        /* Delete subscribe */
        $this->d->rawQuery("delete from #_" . $sector['tables']['shop-subscribe'] . " where id_shop = ?", array($detail['id']));

        /* Get data chat */
        $rowChat = $this->d->rawQuery("select id, id_parent from #_" . $sector['tables']['shop-chat'] . " where id_shop = ?", array($detail['id']));

        if (!empty($rowChat)) {
            foreach ($rowChat as $v) {
                $this->d->rawQuery("delete from #_" . $sector['tables']['shop-chat'] . " where id = ?", array($v['id']));

                /* Photo */
                if ($v['id_parent'] == 0) {
                    $photo = $this->d->rawQuery("select photo from #_" . $sector['tables']['shop-chat-photo'] . " where id_parent = ?", array($v['id']));

                    if (!empty($photo)) {
                        foreach ($photo as $v_photo) {
                            $this->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                        }
                    }

                    $this->d->rawQuery("delete from #_" . $sector['tables']['shop-chat-photo'] . " where id_parent = ?", array($v['id']));
                }
            }
        }

        /* Delete member subscribe */
        $this->d->rawQuery("delete from #_member_subscribe where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Get data report */
        $rowReport = $this->d->rawQueryOne("select id from #_" . $sector['tables']['report-shop'] . " where id_shop = ? limit 0,1", array($detail['id']));

        /* Delete report */
        if (!empty($rowReport)) {
            $this->d->rawQuery("delete from #_" . $sector['tables']['report-shop'] . " where id = ?", array($rowReport['id']));
            $this->d->rawQuery("delete from #_" . $sector['tables']['report-shop-info'] . " where id_parent = ?", array($rowReport['id']));
        }

        /* Get order group */
        $rowOrderGroup = $this->d->rawQuery("select id from #_order_group where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete order group */
        $this->d->rawQuery("delete from #_order_group where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete order detail */
        if (!empty($rowOrderGroup)) {
            foreach ($rowOrderGroup as $v_orderGroup) {
                $this->d->rawQuery("delete from #_order_detail where id_group = ?", array($v_orderGroup['id']));
            }
        }

        /* Delete product item status */
        $this->d->rawQuery("delete from #_product_item_status where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete product sub status */
        $this->d->rawQuery("delete from #_product_sub_status where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Get data product */
        $rowProduct = $this->d->rawQuery("select id, photo from #_" . $sector['tables']['main'] . " where id_shop = ?", array($detail['id']));

        if (!empty($rowProduct)) {
            /* Delete related data */
            foreach ($rowProduct as $v_product) {
                $this->deleteProduct($v_product, $sector, $paths['product']);
            }
        }

        /* Get data photo */
        $rowPhoto = $this->d->rawQuery("select id, photo from #_photo where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete photo */
        if (!empty($rowPhoto)) {
            foreach ($rowPhoto as $v_photo) {
                $this->deleteFile($paths['photo'] . $v_photo['photo']);
                $this->d->rawQuery("delete from #_photo where id = ?", array($v_photo['id']));
            }
        }

        /* Get data news */
        $rowNews = $this->d->rawQuery("select id, photo from #_news where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete news */
        if (!empty($rowNews)) {
            foreach ($rowNews as $v_news) {
                $this->deleteFile($paths['news'] . $v_news['photo']);
                $this->d->rawQuery("delete from #_news where id = ?", array($v_news['id']));
                $this->d->rawQuery("delete from #_news_content where id_parent = ?", array($v_news['id']));
                $this->d->rawQuery("delete from #_news_seo where id_parent = ?", array($v_news['id']));
            }
        }

        /* Get data contact */
        $rowContact = $this->d->rawQuery("select id, file_attach from #_contact where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete contact */
        if (!empty($rowContact)) {
            foreach ($rowContact as $v_contact) {
                $this->deleteFile($paths['contact-file'] . $v_contact['file_attach']);
                $this->d->rawQuery("delete from #_contact where id = ?", array($v_contact['id']));
            }
        }

        /* Get data seopage */
        $rowSEOPage = $this->d->rawQuery("select id, photo from #_seopage where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete seopage */
        if (!empty($rowSEOPage)) {
            foreach ($rowSEOPage as $v_seopage) {
                $this->deleteFile($paths['seopage'] . $v_seopage['photo']);
                $this->d->rawQuery("delete from #_seopage where id = ?", array($v_seopage['id']));
            }
        }

        /* Get data static */
        $rowStatic = $this->d->rawQuery("select id, photo from #_static where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete static */
        if (!empty($rowStatic)) {
            foreach ($rowStatic as $v_static) {
                $this->deleteFile($paths['static'] . $v_static['photo']);
                $this->d->rawQuery("delete from #_static where id = ?", array($v_static['id']));
                $this->d->rawQuery("delete from #_static_content where id_parent = ?", array($v_static['id']));
                $this->d->rawQuery("delete from #_static_seo where id_parent = ?", array($v_static['id']));
            }
        }

        /* Get data newsletter */
        $rowNewsletter = $this->d->rawQuery("select id from #_newsletter where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete newsletter */
        if (!empty($rowNewsletter)) {
            foreach ($rowNewsletter as $v_newsletter) {
                $this->d->rawQuery("delete from #_newsletter where id = ?", array($v_newsletter['id']));
            }
        }

        /* Get data lang */
        $rowLang = $this->d->rawQuery("select id from #_lang where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete lang */
        if (!empty($rowLang)) {
            foreach ($rowLang as $v_lang) {
                $this->d->rawQuery("delete from #_lang where id = ?", array($v_lang['id']));
            }
        }

        /* Get data setting */
        $rowSetting = $this->d->rawQuery("select id from #_setting where id_shop = ? and sector_prefix = ?", array($detail['id'], $sector['prefix']));

        /* Delete setting */
        if (!empty($rowSetting)) {
            foreach ($rowSetting as $v_setting) {
                $this->d->rawQuery("delete from #_setting where id = ?", array($v_setting['id']));
                $this->d->rawQuery("delete from #_setting_seo where id_parent = ?", array($v_setting['id']));
            }
        }
    }

    /* Get shop */
    public function getShop($shop = array())
    {
        $str = '';

        if (!empty($shop)) {
            /* Data */
            $shop['imgDisabled'] = '';
            $shop['target'] = '';// target="_blank"
            $shop['clsMain'] = (!empty($shop['clsMain'])) ? trim($shop['clsMain']) : '';
            $shop['clsSmall'] = (!empty($shop['clsSmall'])) ? trim($shop['clsSmall']) : '';
            $shop['score'] = (!empty($shop['score'])) ? $shop['score'] : 0;
            $shop['hit'] = (!empty($shop['hit'])) ? $shop['hit'] : 0;
            $shop['rating'] = $this->mathRating($shop['score'], $shop['hit']);
            $shop['logo'] = (!empty($shop['sample']) && empty($shop['logo'])) ? $shop['sample']['interface'][$shop['interface']]['logo'] : $shop['logo'];

            if (!empty($shop['isAccount'])) {
                $statusUser = array();
                $shop['statusCls'] = 'success';
                $shop['statusText'] = 'Hoạt động';
                $statusUser['active'] = 'disabled';
                $statusUser['text'] = 'Vô hiệu';

                if ($shop['status'] == '') {
                    $shop['imgDisabled'] = 'img-disabled';
                    $shop['statusCls'] = 'secondary';
                    $shop['statusText'] = 'Chờ duyệt';
                    $shop['target'] = '';
                    $shop['href'] = 'javascript:void(0)';
                } else if (in_array($shop['status'], array('dangsai', 'vipham'))) {
                    $shop['imgDisabled'] = 'img-disabled';
                    $shop['statusCls'] = 'danger';
                    $shop['statusText'] = ($shop['status'] == 'dangsai') ? 'Đăng sai' : (($shop['status'] == 'vipham') ? 'Vi phạm' : '');

                    if ($shop['status'] == 'vipham') {
                        $shop['target'] = '';
                        $shop['href'] = 'javascript:void(0)';
                    }
                } else if (!empty($shop['status_user'])) {
                    if ($shop['status_user'] == 'hienthi') {
                        $statusUser['active'] = 'checked';
                        $statusUser['text'] = 'Hiển thị';
                    } else if ($shop['status_user'] == 'taman') {
                        $statusUser['active'] = '';
                        $statusUser['text'] = 'Tạm ẩn';
                    }
                }
            }

            /* Params for markdown */
            $params = array();
            $params['shop'] = $shop;
            $params['statusUser'] = (!empty($statusUser)) ? $statusUser : array();

            /* Get markdown */
            $str = $this->markdown('shop/main', $params);
        }

        return $str;
    }

    /* Get shop mini */
    public function getShopMini($shop = array())
    {
        $str = '';

        if (!empty($shop)) {
            /* Data */
            $shop['logo'] = (!empty($shop['sample']) && empty($shop['logo'])) ? $shop['sample']['interface'][$shop['interface']]['logo'] : $shop['logo'];

            /* Get markdown */
            $str = $this->markdown('shop/mini', $shop);
        }

        return $str;
    }

    /* Get shop chat */
    public function getShopChat($shop = array())
    {
        $str = '';

        if (!empty($shop)) {
            /* Data */
            $shop['logo'] = (!empty($shop['sample']) && empty($shop['logo'])) ? $shop['sample']['interface'][$shop['interface']]['logo'] : $shop['logo'];

            /* Get markdown */
            $str = $this->markdown('shop/chat', $shop);
        }

        return $str;
    }

    /* Math rating */
    private function mathRating($score = 0, $hit = 0)
    {
        $result = 2;

        if (!empty($score) && !empty($hit)) {
            $result = $score / $hit;

            if ($result == 0 || $result <= 1) {
                $result = 2;
            }
        }

        return round($result, 1);
    }

    /* Init new post */
    private function initNewPost()
    {
        global $config;

        /* Create folder */
        if (!file_exists(NEWPOST)) {
            mkdir(NEWPOST, 0777, true);
        }

        /* Remove all files when file expire */
        $time = 3600 * 24 * $config['website']['dayNewPost'];
        $this->RemoveFilesFromDirInXSeconds(NEWPOST, $time);
    }

    /* Add ID viewed into file */
    public function addViewedNewPost($IDSector = 0, $IDPosting = 0)
    {
        /* Init new post */
        $this->initNewPost();

        /* Data */
        $isLogin = $this->getMember('active');
        $idMember = $this->getMember('id');
        $isExist = false;

        /* Add data */
        if (!empty($isLogin) && !empty($IDSector) && !empty($IDPosting)) {
            $filePath = NEWPOST . $idMember . '-' . $IDSector . ".txt";
            $file = fopen($filePath, "a+");
            $fileSize = filesize($filePath);

            if (!empty($fileSize)) {
                /* Read data from file */
                $fileData = fread($file, $fileSize);

                /* Check data */
                if (!empty($fileData)) {
                    $fileData = explode(",", $fileData);

                    foreach ($fileData as $v) {
                        if ($v == $IDPosting) {
                            $isExist = true;
                            break;
                        }
                    }
                }
            }

            if ($isExist == false) {
                fwrite($file, $IDPosting . ',');
            }

            fclose($file);
        }

        return true;
    }

    /* Get ID viewed into file */
    public function getViewedNewPost($IDSector = 0)
    {
        /* Init new post */
        $this->initNewPost();

        /* Data */
        $result = '';
        $isLogin = $this->getMember('active');
        $idMember = $this->getMember('id');

        /* Get data */
        if (!empty($isLogin) && !empty($IDSector)) {
            $filePath = NEWPOST . $idMember . '-' . $IDSector . ".txt";

            if (file_exists($filePath) && is_readable($filePath)) {
                /* File open */
                $file = fopen($filePath, "a+");
                $fileSize = filesize($filePath);

                /* Get data */
                if (!empty($fileSize)) {
                    $fileData = fread($file, $fileSize);

                    if (!empty($fileData)) {
                        $fileData = explode(",", $fileData);

                        foreach ($fileData as $v) {
                            $result .= $v . ',';
                        }

                        $result = (!empty($result)) ? rtrim($result, ',') : '';
                    }
                }

                /* File close */
                fclose($file);
            }
        }

        return $result;
    }

    /* Exist product seen */
    private function existSeen($IDSector = 0, $IDSeen = 0, $type = '')
    {
        $result = false;

        if (!empty($_SESSION['seen'][$type]) && !empty($_SESSION['seen'][$type][$IDSector]) && !empty($IDSector) && !empty($IDSeen)) {
            for ($i = 0; $i < count($_SESSION['seen'][$type][$IDSector]); $i++) {
                if ($IDSeen == $_SESSION['seen'][$type][$IDSector][$i]['IDSeen']) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /* Set product seen */
    public function setSeen($IDSector = 0, $IDSeen = 0, $type = '')
    {
        if (!empty($IDSector) && !empty($IDSeen) && !empty($type)) {
            if (!empty($_SESSION['seen'][$type][$IDSector])) {
                if (!$this->existSeen($IDSector, $IDSeen, $type)) {
                    $_SESSION['seen'][$type][$IDSector][count($_SESSION['seen'][$type][$IDSector])]['IDSeen'] = $IDSeen;
                }
            } else {
                $_SESSION['seen'][$type][$IDSector] = array();
                $_SESSION['seen'][$type][$IDSector][0]['IDSeen'] = $IDSeen;
            }
        }
    }

    /* Get product seen */
    public function getSeen($IDSector, $IDSeen, $type)
    {
        $result = '';

        if (!empty($IDSector) && !empty($IDSeen) && !empty($type) && !empty($_SESSION['seen'][$type][$IDSector])) {
            $result = $this->joinCols($_SESSION['seen'][$type][$IDSector], 'IDSeen');
        }

        return $result;
    }

    /* Check exist */
    public function checkExistData($data = '', $tbl = '', $id = 0)
    {
        $result = false;
        $row = array();

        if (!empty($data) && !empty($tbl)) {
            $where = (!empty($id)) ? ' and id != ' . $id : '';
            $row = $this->d->rawQueryOne("select id from #_$tbl where (slugvi = ? or slugen = ?) $where limit 0,1", array($data, $data));

            if (!empty($row)) {
                $result = true;
            }
        }

        return $result;
    }

    /* Check account */
    public function checkAccount($data = '', $type = '', $tbl = '', $id = 0)
    {
        $result = false;
        $row = array();

        if (!empty($data) && !empty($type) && !empty($tbl)) {
            $where = (!empty($id)) ? ' and id != ' . $id : '';
            $row = $this->d->rawQueryOne("select id from #_$tbl where $type = ? $where limit 0,1", array($data));

            if (!empty($row)) {
                $result = true;
            }
        }

        return $result;
    }

    /* Check shop */
    public function checkShop($data = array(), $type = '', $id = 0)
    {
        global $defineSectors;

        $result = false;
        $row = array();
        $where = (!empty($id)) ? ' and id != ' . $id . ' ' : '';

        if ($type == 'name' && !empty($data['slug']) && !empty($data['slug_url'])) {
            foreach ($defineSectors['types'] as $k => $v) {
                if (!empty($v['tables']['shop']) && !$result) {
                    $tableShop = $v['tables']['shop'];
                    $row = $this->d->rawQueryOne("select id from #_$tableShop where (slug = ? or slug_url = ?) $where limit 0,1", array($data['slug'], $data['slug_url']));

                    if (!empty($row['id'])) {
                        $result = true;
                        break;
                    }
                }
            }
        } else if ($type == 'restricted' && !empty($data['slug']) && !empty($data['slug_url'])) {
            $restricted = $defineSectors['restrictedShop'];

            if (in_array($data['slug'], $restricted) || in_array($data['slug_url'], $restricted)) {
                $result = true;
            }

            if (empty($result)) {
                foreach ($restricted as $k => $v) {
                    if (strstr($data['slug'], $v) || strstr($data['slug_url'], $v)) {
                        $result = true;
                    }
                }
            }
        } else if ($type == 'email' && !empty($data['email'])) {
            foreach ($defineSectors['types'] as $k => $v) {
                if (!empty($v['tables']['shop']) && !$result) {
                    $tableShop = $v['tables']['shop'];
                    $row = $this->d->rawQueryOne("select id from #_$tableShop where email = ? $where limit 0,1", array($data['email']));

                    if (!empty($row['id'])) {
                        $result = true;
                        break;
                    }
                }
            }
        } else if ($type == 'username' && !empty($data['username'])) {
            foreach ($defineSectors['types'] as $k => $v) {
                if (!empty($v['tables']['shop']) && !$result) {
                    $tableShop = $v['tables']['shop'];
                    $row = $this->d->rawQueryOne("select id from #_$tableShop where username = ? $where limit 0,1", array($data['username']));

                    if (!empty($row['id'])) {
                        $result = true;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /* Check has shop */
    public function hasShop($sector = array())
    {
        global $defineSectors;

        $result = false;

        if (in_array($sector['id'], $defineSectors['hasShop']['id']) && in_array($sector['type'], $defineSectors['hasShop']['types'])) {
            $result = true;
        }

        return $result;
    }

    /* Check has Coords */
    public function hasCoords($sector = array())
    {
        global $defineSectors;

        $result = false;

        if (in_array($sector['id'], $defineSectors['hasCoords']['id']) && in_array($sector['type'], $defineSectors['hasCoords']['types'])) {
            $result = true;
        }

        return $result;
    }

    /* Check has Service */
    public function hasService($sector = array())
    {
        global $defineSectors;

        $result = false;

        if (in_array($sector['id'], $defineSectors['hasService']['id']) && in_array($sector['type'], $defineSectors['hasService']['types'])) {
            $result = true;
        }

        return $result;
    }

    /* Check has Accessary */
    public function hasAccessary($sector = array())
    {
        global $defineSectors;

        $result = false;

        if (in_array($sector['id'], $defineSectors['hasAccessary']['id']) && in_array($sector['type'], $defineSectors['hasAccessary']['types'])) {
            $result = true;
        }

        return $result;
    }

    /* Check has Cart */
    public function hasCart($sector = array())
    {
        global $defineSectors;

        $result = false;

        if (in_array($sector['id'], $defineSectors['hasCart']['id']) && in_array($sector['type'], $defineSectors['hasCart']['types'])) {
            $result = true;
        }

        return $result;
    }

    /* Write json */
    public function writeJson($data = array())
    {
        global $defineSectors;

        if ($data['type'] == 'list') {
            $sectors = $this->d->rawQuery("select id, namevi, nameen, slugvi, slugen, photo from #_product_list order by numb,id desc", null, "result", 7200);

            if (!empty($sectors)) {
                /* Create data by cate */
                $result = array();
                $result['next'] = 'cat';
                $result['back'] = '';
                $result['data'] = $sectors;

                /* Put data */
                $this->putJson('sector-lists.json', $sectors);
            }
        } else if ($data['type'] == 'cat') {
            $sectors = $this->d->rawQuery("select id, namevi, nameen, slugvi, slugen, photo from #_product_list order by numb,id desc", null, "result", 7200);

            if (!empty($sectors)) {
                foreach ($sectors as $k => $v) {
                    $sectorCats = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, photo from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id']), "result", 7200);

                    if (!empty($sectorCats)) {
                        $sectors[$k]['cat'] = $sectorCats;

                        /* Create data by cate */
                        $result = array();
                        $result['next'] = 'item';
                        $result['back'] = array(
                            'prev' => 'list',
                            'id' => $v['id'],
                            'namevi' => $v['namevi'],
                            'nameen' => $v['nameen']
                        );
                        $result['data'] = $sectorCats;

                        /* Put data */
                        $this->putJson('sector-cats-' . $v['id'] . '.json', $sectorCats);
                    }
                }

                /* Put data */
                $this->putJson('sector-cats.json', $sectors);
            }
        } else if ($data['type'] == 'item') {
            $sectors = $this->d->rawQuery("select id, namevi, nameen, slugvi, slugen, photo from #_product_list order by numb,id desc", null, "result", 7200);

            if (!empty($sectors)) {
                foreach ($sectors as $k => $v) {
                    $sectorCats = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, photo from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id']), "result", 7200);

                    if (!empty($sectorCats)) {
                        $sectors[$k]['cat'] = $sectorCats;

                        foreach ($sectorCats as $k_cat => $v_cat) {
                            $sectorItems = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, id_cat, photo from #_product_item where id_list = ? and id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id'], $v_cat['id']), "result", 7200);

                            if (!empty($sectorItems)) {
                                /* Create data by cate */
                                $result = array();
                                $result['next'] = in_array($v['id'], $defineSectors['hasFourLevel']['id']) ? 'sub' : '';
                                $result['back'] = array(
                                    'prev' => 'cat',
                                    'id' => $v['id'],
                                    'namevi' => $v_cat['namevi'],
                                    'nameen' => $v_cat['nameen']
                                );
                                $result['data'] = $sectorItems;

                                /* Put data */
                                $this->putJson('sector-items-' . $v_cat['id'] . '.json', $sectorItems);
                            }
                        }
                    }
                }
            }
        } else if ($data['type'] == 'sub') {
            $sectors = $this->d->rawQuery("select id, namevi, nameen, slugvi, slugen, photo from #_product_list order by numb,id desc", null, "result", 7200);

            if (!empty($sectors)) {
                foreach ($sectors as $k => $v) {
                    $sectorCats = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, photo from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id']), "result", 7200);

                    if (!empty($sectorCats)) {
                        foreach ($sectorCats as $k_cat => $v_cat) {
                            $sectorItems = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, id_cat, photo from #_product_item where id_list = ? and id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id'], $v_cat['id']), "result", 7200);

                            if (!empty($sectorItems)) {
                                foreach ($sectorItems as $k_item => $v_item) {
                                    $sectorSubs = $this->d->rawQuery("select namevi, nameen, slugvi, slugen, id, id_list, id_cat, photo from #_product_sub where id_list = ? and id_cat = ? and id_item = ? and find_in_set('hienthi',status) order by numb,id desc", array($v['id'], $v_cat['id'], $v_item['id']), "result", 7200);

                                    if (!empty($sectorSubs)) {
                                        /* Create data by cate */
                                        $result = array();
                                        $result['next'] = '';
                                        $result['back'] = array(
                                            'prev' => 'item',
                                            'id' => $v_cat['id'],
                                            'namevi' => $v_item['namevi'],
                                            'nameen' => $v_item['nameen']
                                        );
                                        $result['data'] = $sectorSubs;

                                        /* Put data */
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else if ($data['type'] == 'region') {
            $data = $this->d->rawQuery("select id, name from #_region where find_in_set('hienthi',status) order by numb,id desc");

            /* Put data */
            $this->putJson('region.json', $data);

            /* Reload data citys */
            $this->writeJson(array('type' => 'city'));
        } else if ($data['type'] == 'city') {
            /* Get all city */
            $citys = $this->d->rawQuery("select id, id_region, name, photo, status from #_city where find_in_set('hienthi',status) order by numb,id desc");

            /* City group */
            $data = array();
            $regions = $this->d->rawQuery("select id, name from #_region where find_in_set('hienthi',status) order by numb,id desc");

            if (!empty($citys)) {
                foreach ($citys as $k_city => $v_city) {
                    if (!empty($v_city['status']) && strstr($v_city['status'], 'trunguong')) {
                        $data['citysCentral'][] = $v_city;
                        unset($citys[$k_city]);
                    }
                }
            }

            if (!empty($regions) && !empty($citys)) {
                foreach ($regions as $k_region => $v_region) {
                    $cityTemp = array();
                    $data['citysRegion'][$k_region] = array(
                        'id' => $v_region['id'],
                        'name' => $v_region['name']
                    );

                    foreach ($citys as $k_city => $v_city) {
                        if ($v_region['id'] == $v_city['id_region']) {
                            $cityTemp[] = $v_city;
                        }
                    }

                    if (!empty($cityTemp)) {
                        $data['citysRegion'][$k_region]['citys'] = $cityTemp;
                    }
                }
            }

            /* Put data */
            $this->putJson('city-group.json', $data);
        } else if ($data['type'] == 'district') {
            /* Update */
            if (!empty($data['idCity'])) {
                $district = $this->d->rawQuery("select id, id_region, id_city, name from #_district where id_city = ? and find_in_set('hienthi',status) order by numb,id desc", array($data['idCity']));

                /* Put data */
                $this->putJson('district-' . $data['idCity'] . '.json', $district);
            } else /* Create */ {
                $citys = $this->d->rawQuery("select id from #_city where find_in_set('hienthi',status)");

                if (!empty($citys)) {
                    $result = array();

                    foreach ($citys as $v_city) {
                        $district = $this->d->rawQuery("select id, id_region, id_city, name from #_district where id_city = ? and find_in_set('hienthi',status) order by numb,id desc", array($v_city['id']));

                        /* Put data */
                        if (!empty($district)) {
                            $this->putJson('district-' . $v_city['id'] . '.json', $district);
                        }
                    }
                }
            }
        } else if ($data['type'] == 'wards') {
            /* Update */
            if (!empty($data['idCity']) && !empty($data['idDistrict'])) {
                $ward = $this->d->rawQuery("select id, id_region, id_city, id_district, name from #_wards where id_city = ? and id_district = ? and find_in_set('hienthi',status) order by numb,id desc", array($data['idCity'], $data['idDistrict']));

                /* Put data */
                $this->putJson('wards-' . $data['idCity'] . '-' . $data['idDistrict'] . '.json', $ward);
            } else /* Create */ {
                $districts = $this->d->rawQuery("select distinct id_city, id from #_district where find_in_set('hienthi',status)");

                if (!empty($districts)) {
                    $result = array();

                    foreach ($districts as $v_district) {
                        $ward = $this->d->rawQuery("select id, id_region, id_city, id_district, name from #_wards where id_city = ? and id_district = ? and find_in_set('hienthi',status) order by numb,id desc", array($v_district['id_city'], $v_district['id']));

                        /* Put data */
                        if (!empty($ward)) {
                            $this->putJson('wards-' . $v_district['id_city'] . '-' . $v_district['id'] . '.json', $ward);
                        }
                    }
                }
            }
        }

        return true;
    }

    /* Put json */
    public function putJson($filename = '', $data = array())
    {
        if (!empty($data)) {
            $data = json_encode($data);
            $file = fopen(JSONS . $filename, "w+");

            if (!empty($file)) {
                fwrite($file, $data);
                fclose($file);
            }
        } else if (file_exists(JSONS . $filename)) {
            $this->deleteFile(JSONS . $filename);
        }

        return true;
    }

    /* Get gender */
    public function getGender($gender = 0)
    {
        $str = '';

        if ($gender == 1) {
            $str = 'Nam';
        } else if ($gender == 2) {
            $str = 'Nữ';
        } else if ($gender == 3) {
            $str = 'Không yêu cầu';
        }

        return $str;
    }

    /* Xử lý back url */
    public function backUrl()
    {
        $result = array();

        $queryString = (!empty($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : '';
        $transfer = (!empty($queryString)) ? str_replace("back=", "", $queryString) : '';
        $redirect = (!empty($transfer)) ? '?back=' . $transfer : '';
        $result['original'] = $queryString;
        $result['transfer'] = $transfer;
        $result['redirect'] = $redirect;

        return $result;
    }

    /* Lấy youtube */
    public function getYoutube($url = '')
    {
        if ($url != '') {
            $parts = parse_url($url);
            if (isset($parts['query'])) {
                parse_str($parts['query'], $qs);
                if (isset($qs['v'])) return $qs['v'];
                else if ($qs['vi']) return $qs['vi'];
            }

            if (isset($parts['path'])) {
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path) - 1];
            }
        }

        return false;
    }

    /* Get list gallery */
    public function listsGallery($file = '')
    {
        $result = array();

        if (!empty($file) && !empty($_POST['fileuploader-list-' . $file])) {
            $fileLists = '';
            $fileLists = str_replace('"', '', $_POST['fileuploader-list-' . $file]);
            $fileLists = str_replace('[', '', $fileLists);
            $fileLists = str_replace(']', '', $fileLists);
            $fileLists = str_replace('{', '', $fileLists);
            $fileLists = str_replace('}', '', $fileLists);
            $fileLists = str_replace('0:/', '', $fileLists);
            $fileLists = str_replace('file:', '', $fileLists);
            $result = explode(',', $fileLists);
        }

        return $result;
    }

    /* Upload gallery */
    public function uploadGallery($file = null, $table = '', $exts = '', $folder = '', $id_parent = 0)
    {
        if (!empty($_FILES[$file]) && !empty($table) && !empty($exts) && !empty($folder) && !empty($id_parent)) {
            $listsGallery = $this->listsGallery($file);
            $myFile = $_FILES[$file];
            $fileCount = count($myFile["name"]);

            if (!empty($fileCount)) {
                for ($i = 0; $i < $fileCount; $i++) {
                    if (in_array($myFile["name"][$i], $listsGallery, true)) {
                        /* Files */
                        $_FILES['file-uploader-temp'] = array(
                            'name' => $myFile['name'][$i],
                            'type' => $myFile['type'][$i],
                            'tmp_name' => $myFile['tmp_name'][$i],
                            'error' => $myFile['error'][$i],
                            'size' => $myFile['size'][$i]
                        );

                        $file_name = $this->uploadName($myFile["name"][$i]);

                        /* Data */
                        $data = array();
                        $data['id_parent'] = $id_parent;
                        $data['namevi'] = $file_name;
                        $data['numb'] = ($i + 1);
                        $data['status'] = 'hienthi';
                        $data['date_created'] = time();

                        if ($this->d->insert($table, $data)) {
                            $id_insert = $this->d->getLastInsertId();

                            if ($this->hasFile("file-uploader-temp")) {
                                $photoUpdate = array();

                                if ($photo = $this->uploadImage("file-uploader-temp", $exts, $folder, $file_name)) {
                                    $photoUpdate['photo'] = $photo;
                                    $this->d->where('id', $id_insert);
                                    $this->d->update($table, $photoUpdate);
                                    unset($photoUpdate);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /* Get gallery */
    public function getGallery($data = array(), $folder = '', $table = '')
    {
        $str = '';

        if (!empty($data) && !empty($folder) && !empty($table)) {
            /* Params for markdown */
            $params = array();
            $params['data'] = $data;
            $params['folder'] = $folder;
            $params['table'] = $table;

            /* Get markdown */
            $str = $this->markdown('gallery/admin', $params);
        }

        return $str;
    }

    /* Alert */
    public function alert($notify = '')
    {
        echo '<script language="javascript">alert("' . $notify . '")</script>';
    }

    /* Delete file */
    public function deleteFile($file = '')
    {
        return @unlink($file);
    }

    /* Transfer */
    public function transfer($msg = '', $page = '', $numb = true)
    {
        global $configBase;

        $basehref = $configBase;
        $showtext = $msg;
        $page_transfer = $page;
        $numb = $numb;

        include("./templates/layout/transfer.php");
        exit();
    }

    /* Redirect */
    public function redirect($url = '', $response = null)
    {
        header("location:$url", true, $response);
        exit();
    }

    /* Dump */
    public function dump($value = '', $exit = false)
    {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
        if ($exit) exit();
    }

    /* Pagination */
    public function pagination($totalq = 0, $perPage = 10, $page = 1, $url = '?', $var = 'p')
    {
        $urlpos = strpos($url, "?");
        $url = ($urlpos) ? $url . "&" : $url . "?";
        $total = $totalq;
        $adjacents = "2";
        $firstlabel = "First";
        $prevlabel = "Prev";
        $nextlabel = "Next";
        $lastlabel = "Last";
        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $perPage;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $perPage);
        $lpm1 = $lastpage - 1;
        $pagination = "";

        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination flex-wrap justify-content-center mb-0'>";
            $pagination .= "<li class='page-item'><a class='page-link'>Page {$page} / {$lastpage}</a></li>";

            if ($page > 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$prev}'>{$prevlabel}</a></li>";
            }

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                    else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$counter}'>{$counter}</a></li>";
                    }

                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>...</a></li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$counter}'>{$counter}</a></li>";
                    }

                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>...</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$lastpage}'>{$lastpage}</a></li>";
                } else {
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>1</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=2'>2</a></li>";
                    $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=1'>...</a></li>";

                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) $pagination .= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
                        else $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$counter}'>{$counter}</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}={$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li class='page-item'><a class='page-link' href='{$url}{$var}=$lastpage'>{$lastlabel}</a></li>";
            }

            $pagination .= "</ul>";
        }

        return $pagination;
    }

    /* UTF8 convert */
    public function utf8Convert($str = '')
    {
        if ($str != '') {
            $utf8 = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'd' => 'đ|Đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
                '' => '`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
            );

            foreach ($utf8 as $ascii => $uni) {
                $str = preg_replace("/($uni)/i", $ascii, $str);
            }
        }

        return $str;
    }

    /* Change title */
    public function changeTitle($text = '')
    {
        if ($text != '') {
            $text = strtolower($this->utf8Convert($text));
            $text = preg_replace("/[^a-z0-9-\s]/", "", $text);
            $text = preg_replace('/([\s]+)/', '-', $text);
            $text = str_replace(array('%20', ' '), '-', $text);
            $text = preg_replace("/\-\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-\-/", "-", $text);
            $text = preg_replace("/\-\-/", "-", $text);
            $text = '@' . $text . '@';
            $text = preg_replace('/\@\-|\-\@|\@/', '', $text);
        }

        return $text;
    }

    /* Text convert */
    public function textConvert($text = '', $type = '')
    {
        if (!empty($text)) {
            if ($type == 'capitalize') {
                $text = mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
            } else if ($type == 'upper') {
                $text = mb_convert_case($text, MB_CASE_UPPER, "UTF-8");
            } else if ($type == 'lower') {
                $text = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
            }
        }

        return $text;
    }

    /* Lấy IP */
    public function getRealIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /* Lấy getPageURL */
    public function getPageURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $pageURL;
    }

    /* Lấy getCurrentPageURL */
    public function getCurrentPageURLWithParams()
    {
        $queryString = (!empty($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : '';
        $pageURL = (!empty($queryString)) ? 'index.php?' . $queryString : '';
        return $pageURL;
    }

    /* Lấy getCurrentPageURL */
    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $urlpos = strpos($pageURL, "?p");
        $pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
        return $pageURL[0];
    }

    /* Lấy getCurrentOriginURL */
    public function getCurrentOriginURL()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        if (!empty($_SERVER["REDIRECT_URL"])) {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REDIRECT_URL"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];
        }
        return $pageURL;
    }

    /* Lấy getCurrentPageURL Cano */
    public function getCurrentPageURL_CANO()
    {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $pageURL = str_replace("amp/", "", $pageURL);
        $urlpos = strpos($pageURL, "?p");
        $pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
        $pageURL = explode("?", $pageURL[0]);
        $pageURL = explode("#", $pageURL[0]);
        $pageURL = explode("index", $pageURL[0]);
        return $pageURL[0];
    }

    /* Get Img size */
    public function getImgSize($photo = '', $patch = '')
    {
        $array = array();
        if ($photo != '') {
            $x = (file_exists($patch)) ? getimagesize($patch) : null;
            $array = (!empty($x)) ? array("p" => $photo, "w" => $x[0], "h" => $x[1], "m" => $x['mime']) : null;
        }
        return $array;
    }

    /* Upload name */
    public function uploadName($name = '')
    {
        $result = '';

        if ($name != '') {
            $rand = rand(1, 99999);
            $ten_anh = pathinfo($name, PATHINFO_FILENAME);
            $result = $this->changeTitle($ten_anh) . "-" . $rand;
        }

        return $result;
    }

    /* Resize images */
    public function smartResizeImage($file = '', $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100, $grayscale = false)
    {
        if ($height <= 0 && $width <= 0) return false;
        if ($file === null && $string === null) return false;
        $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image = '';
        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        if ($proportional) {
            if ($width == 0) $factor = $height / $height_old;
            elseif ($height == 0) $factor = $width / $width_old;
            else $factor = min($width / $width_old, $height / $height_old);
            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        } else {
            $final_width = ($width <= 0) ? $width_old : $width;
            $final_height = ($height <= 0) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;
            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_GIF:
                $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_PNG:
                $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
                break;
            default:
                return false;
        }
        if ($grayscale) {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        }
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
        if ($delete_original) {
            if ($use_linux_commands) exec('rm ' . $file);
            else @unlink($file);
        }
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }
        switch ($info[2]) {
            case IMAGETYPE_GIF:
                imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image_resized, $output, $quality);
                break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9 * $quality) / 10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default:
                return false;
        }
        return true;
    }

    /* Correct images orientation */
    public function correctImageOrientation($filename)
    {
        ini_set('memory_limit', '1024M');
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;

                    switch ($orientation) {
                        case 3:
                            $image = imagerotate($img, 180, 0);
                            break;

                        case 6:
                            $image = imagerotate($img, -90, 0);
                            break;

                        case 8:
                            $image = imagerotate($img, 90, 0);
                            break;
                    }

                    imagejpeg($image, $filename, 90);
                }
            }
        }
    }

    /* Upload images */
    public function uploadImage($file = '', $extension = '', $folder = '', $newname = '')
    {
        global $config;

        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $postMaxSize = ini_get('post_max_size');
            $MaxSize = explode('M', $postMaxSize);
            $MaxSize = $MaxSize[0];
            if ($_FILES[$file]['size'] > $MaxSize * 1048576) {
                $this->alert('Dung lượng file không được vượt quá ' . $postMaxSize);
                return false;
            }

            $ext = explode('.', $_FILES[$file]['name']);
            $ext = strtolower($ext[count($ext) - 1]);
            $name = basename($_FILES[$file]['name'], '.' . $ext);

            if (strpos($extension, $ext) === false) {
                $this->alert('Chỉ hỗ trợ upload file dạng ' . $extension);
                return false;
            }

            if ($newname == '' && file_exists($folder . $_FILES[$file]['name']))
                for ($i = 0; $i < 100; $i++) {
                    if (!file_exists($folder . $name . $i . '.' . $ext)) {
                        $_FILES[$file]['name'] = $name . $i . '.' . $ext;
                        break;
                    }
                }
            else {
                $_FILES[$file]['name'] = $newname . '.' . $ext;
            }

            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }

            /* Fix correct Image Orientation */
            $this->correctImageOrientation($folder . $_FILES[$file]['name']);

            /* Resize image if width origin > config max width */
            $array = getimagesize($folder . $_FILES[$file]['name']);
            list($image_w, $image_h) = $array;
            $maxWidth = $config['website']['upload']['max-width'];
            $maxHeight = $config['website']['upload']['max-height'];
            if ($image_w > $maxWidth) $this->smartResizeImage($folder . $_FILES[$file]['name'], null, $maxWidth, $maxHeight, true);

            return $_FILES[$file]['name'];
        }
        return false;
    }

    /* Delete folder */
    public function removeDir($dirname = '')
    {
        if (is_dir($dirname)) $dir_handle = opendir($dirname);
        if (!isset($dir_handle) || $dir_handle == false) return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file)) unlink($dirname . "/" . $file);
                else $this->removeDir($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    /* Remove Sub folder */
    public function RemoveEmptySubFolders($path = '')
    {
        $empty = true;

        foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
            if (is_dir($file)) {
                if (!$this->RemoveEmptySubFolders($file)) $empty = false;
            } else {
                $empty = false;
            }
        }

        if ($empty) {
            if (is_dir($path)) {
                rmdir($path);
            }
        }

        return $empty;
    }

    /* Remove files from dir in x seconds */
    public function RemoveFilesFromDirInXSeconds($dir = '', $seconds = 3600)
    {
        $files = glob(rtrim($dir, '/') . "/*");
        $now = time();

        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($now - filemtime($file) >= $seconds) {
                        unlink($file);
                    }
                } else {
                    $this->RemoveFilesFromDirInXSeconds($file, $seconds);
                }
            }
        }
    }

    /* Remove zero bytes */
    public function removeZeroByte($dir)
    {
        $files = glob(rtrim($dir, '/') . "/*");
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if (!filesize($file)) {
                        unlink($file);
                    }
                } else {
                    $this->removeZeroByte($file);
                }
            }
        }
    }

    /* Filter opacity */
    public function filterOpacity($img = '', $opacity = 80)
    {
        return true;
        /*
			if(!isset($opacity) || $img == '') return false;

			$opacity /= 100;
			$w = imagesx($img);
			$h = imagesy($img);
			imagealphablending($img, false);
			$minalpha = 127;

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
					if($alpha < $minalpha) $minalpha = $alpha;
				}
			}

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$colorxy = imagecolorat($img, $x, $y);
					$alpha = ($colorxy >> 24) & 0xFF;
					if($minalpha !== 127) $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
					else $alpha += 127 * $opacity;
					$alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
					if(!imagesetpixel($img, $x, $y, $alphacolorxy)) return false;
				}
			}

			return true;
			*/
    }

    /* Convert Webp */
    public function converWebp($in)
    {
        global $config;

        $in = $_SERVER['DOCUMENT_ROOT'] . $config['database']['url'] . str_replace(ASSET, "", $in);

        if (!extension_loaded('imagick')) {
            ob_start();

            WebPConvert::serveConverted($in, $in . ".webp", [
                'fail' => 'original',
                //'show-report' => true,
                'serve-image' => [
                    'headers' => [
                        'cache-control' => true,
                        'vary-accept' => true,
                    ],
                    'cache-control-header' => 'max-age=2',
                ],
                'convert' => [
                    "quality" => 100
                ]
            ]);

            file_put_contents($in . ".webp", ob_get_contents());
            ob_end_clean();
        } else {
            WebPConvert::convert($in, $in . ".webp", [
                'fail' => 'original',
                'convert' => [
                    'quality' => 100,
                    'max-quality' => 100,
                ]
            ]);
        }
    }

    /* Create thumb */
    public function createThumb($width_thumb = 0, $height_thumb = 0, $zoom_crop = '1', $src = '', $watermark = null, $path = THUMBS, $preview = false, $args = array(), $quality = 100)
    {
        global $config;

        $webp = false;
        $t = 3600 * 24 * 30;

        if (strpos($src, ".webp") !== false) {
            $webp = true;
            $src = str_replace(".webp", "", $src);
        }

        $this->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP_L, 1);

        if ($watermark != null) {
            $this->RemoveFilesFromDirInXSeconds(WATERMARK . '/' . $path . "/", $t);
            $this->RemoveEmptySubFolders(WATERMARK . '/' . $path . "/");
        } else {
            $this->RemoveFilesFromDirInXSeconds($path . "/", $t);
            $this->RemoveEmptySubFolders($path . "/");
        }

        $src = str_replace("%20", " ", $src);
        if (!file_exists($src)) die("NO IMAGE $src");

        $image_url = $src;
        $origin_x = 0;
        $origin_y = 0;
        $new_width = $width_thumb;
        $new_height = $height_thumb;

        if ($new_width < 10 && $new_height < 10) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            die("Width and height larger than 10px");
        }
        if ($new_width > 2000 || $new_height > 2000) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            die("Width and height less than 2000px");
        }

        $array = getimagesize($image_url);
        if ($array) list($image_w, $image_h) = $array;
        else die("NO IMAGE $image_url");

        $width = $image_w;
        $height = $image_h;

        if ($new_height && !$new_width) $new_width = $width * ($new_height / $height);
        else if ($new_width && !$new_height) $new_height = $height * ($new_width / $width);

        $image_ext = explode('.', $image_url);
        $image_ext = trim(strtolower(end($image_ext)));
        $image_name = explode('/', $image_url);
        $image_name = trim(basename($image_url), "/");

        switch ($array['mime']) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($image_url);
                $func = 'imagejpeg';
                $mime_type = 'jpeg';
                break;

            case 'image/x-ms-bmp':
            case 'image/png':
                $image = @imagecreatefrompng($image_url);
                $func = 'imagepng';
                $mime_type = 'png';
                break;

            case 'image/gif':
                $image = imagecreatefromgif($image_url);
                $func = 'imagegif';
                $mime_type = 'png';
                break;

            default:
                die("UNKNOWN IMAGE TYPE: $image_url");
        }

        $_new_width = $new_width;
        $_new_height = $new_height;

        if ($zoom_crop == 3) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) $new_width = $width * ($new_height / $height);
            else $new_height = $final_height;
        }

        $canvas = imagecreatetruecolor(intval($new_width), intval($new_height));
        imagealphablending($canvas, false);
        $color = imagecolorallocatealpha($canvas, 255, 255, 255, 0);
        imagefill($canvas, 0, 0, $color);

        if ($zoom_crop == 2) {
            $final_height = $height * ($new_width / $width);
            if ($final_height > $new_height) {
                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {
                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }

        imagesavealpha($canvas, true);

        if ($zoom_crop > 0) {
            $align = '';
            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;

            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;

            if ($cmp_x > $cmp_y) {
                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else if ($cmp_y > $cmp_x) {
                $src_h = round($height / $cmp_y * $cmp_x);
                $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
            }

            if ($align) {
                if (strpos($align, 't') !== false) {
                    $src_y = 0;
                }
                if (strpos($align, 'b') !== false) {
                    $src_y = $height - $src_h;
                }
                if (strpos($align, 'l') !== false) {
                    $src_x = 0;
                }
                if (strpos($align, 'r') !== false) {
                    $src_x = $width - $src_w;
                }
            }

            imagecopyresampled($canvas, $image, intval($origin_x), intval($origin_y), intval($src_x), intval($src_y), intval($new_width), intval($new_height), intval($src_w), intval($src_h));
        } else {
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, intval($new_width), intval($new_height), intval($width), intval($height));
        }

        if ($preview) {
            $watermark = array();
            $watermark['status'] = 'hienthi';
            $options = $args;
            $overlay_url = $args['watermark'];
        }

        $upload_dir = '';
        $folder_old = dirname($image_url) . '/';

        if (!empty($watermark['status']) && strpos('hienthi', $watermark['status']) !== false) {
            $upload_dir = WATERMARK . '/' . $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
        } else {
            if ($watermark != null) $upload_dir = WATERMARK . '/' . $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
            else $upload_dir = $path . '/' . $width_thumb . 'x' . $height_thumb . 'x' . $zoom_crop . '/' . $folder_old;
        }

        if (!file_exists($upload_dir)) if (!mkdir($upload_dir, 0777, true)) die('Failed to create folders...');

        if (!empty($watermark['status']) && strpos('hienthi', $watermark['status']) !== false) {
            $options = (isset($options)) ? $options : json_decode($watermark['options'], true)['watermark'];
            $per_scale = $options['per'];
            $per_small_scale = $options['small_per'];
            $max_width_w = $options['max'];
            $min_width_w = $options['min'];
            $opacity = @$options['opacity'];
            $overlay_url = (isset($overlay_url)) ? $overlay_url : UPLOAD_PHOTO_L . $watermark['photo'];
            $overlay_ext = explode('.', $overlay_url);
            $overlay_ext = trim(strtolower(end($overlay_ext)));

            switch (strtoupper($overlay_ext)) {
                case 'JPG':
                case 'JPEG':
                    $overlay_image = imagecreatefromjpeg($overlay_url);
                    break;

                case 'PNG':
                    $overlay_image = imagecreatefrompng($overlay_url);
                    break;

                case 'GIF':
                    $overlay_image = imagecreatefromgif($overlay_url);
                    break;

                default:
                    die("UNKNOWN IMAGE TYPE: $overlay_url");
            }

            $this->filterOpacity($overlay_image, $opacity);
            $overlay_width = imagesx($overlay_image);
            $overlay_height = imagesy($overlay_image);
            $overlay_padding = 5;
            imagealphablending($canvas, true);

            if (min($_new_width, $_new_height) <= 300) $per_scale = $per_small_scale;

            $oz = max($overlay_width, $overlay_height);

            if ($overlay_width > $overlay_height) {
                $scale = $_new_width / $oz;
            } else {
                $scale = $_new_height / $oz;
            }

            if ($_new_height > $_new_width) {
                $scale = $_new_height / $oz;
            }
            $new_overlay_width = (floor($overlay_width * $scale) - $overlay_padding * 2) / $per_scale;
            $new_overlay_height = (floor($overlay_height * $scale) - $overlay_padding * 2) / $per_scale;
            $scale_w = $new_overlay_height > 0 ? $new_overlay_width / $new_overlay_height : 0;
            $scale_h = $new_overlay_width > 0 ? $new_overlay_height / $new_overlay_width : 0;
            $new_overlay_height = $scale_w > 0 ? $new_overlay_width / $scale_w : 0;

            if ($new_overlay_height > $_new_height) {
                $new_overlay_height = $_new_height / $per_scale;
                $new_overlay_width = $new_overlay_height * $scale_w;
            }
            if ($new_overlay_width > $_new_width) {
                $new_overlay_width = $_new_width / $per_scale;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($new_overlay_width > 0 && ($_new_width / $new_overlay_width) < $per_scale) {
                $new_overlay_width = $_new_width / $per_scale;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($_new_height < $_new_width && ($new_overlay_height > 0 && ($_new_height / $new_overlay_height) < $per_scale)) {
                $new_overlay_height = $_new_height / $per_scale;
                $new_overlay_width = $new_overlay_height / $scale_h;
            }
            if ($new_overlay_width > $max_width_w && $new_overlay_width) {
                $new_overlay_width = $max_width_w;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            if ($new_overlay_width < $min_width_w && $_new_width <= $min_width_w * 3) {
                $new_overlay_width = $min_width_w;
                $new_overlay_height = $new_overlay_width * $scale_h;
            }
            $new_overlay_width = round($new_overlay_width);
            $new_overlay_height = round($new_overlay_height);

            switch ($options['position']) {
                case 1:
                    $khoancachx = $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;

                case 2:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = $overlay_padding;
                    break;

                case 3:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;

                case 4:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;

                case 5:
                    $khoancachx = abs($_new_width - $new_overlay_width) - $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;

                case 6:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;

                case 7:
                    $khoancachx = $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) - $overlay_padding;
                    break;

                case 8:
                    $khoancachx = $overlay_padding;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;

                case 9:
                    $khoancachx = abs($_new_width - $new_overlay_width) / 2;
                    $khoancachy = abs($_new_height - $new_overlay_height) / 2;
                    break;

                default:
                    $khoancachx = $overlay_padding;
                    $khoancachy = $overlay_padding;
                    break;
            }

            $new_overlay_width = $new_overlay_width > 0 ? $new_overlay_width : 1;
            $new_overlay_height = $new_overlay_height > 0 ? $new_overlay_height : 1;
            $overlay_new_image = imagecreatetruecolor($new_overlay_width, $new_overlay_height);
            imagealphablending($overlay_new_image, false);
            imagesavealpha($overlay_new_image, true);
            imagecopyresampled($overlay_new_image, $overlay_image, 0, 0, 0, 0, $new_overlay_width, $new_overlay_height, $overlay_width, $overlay_height);
            imagecopy($canvas, $overlay_new_image, $khoancachx, $khoancachy, 0, 0, $new_overlay_width, $new_overlay_height);
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
        }

        if ($preview) {
            $upload_dir = '';
            $this->RemoveEmptySubFolders(WATERMARK . '/' . $path . "/");
        }

        if ($upload_dir) {
            if (!isset($_GET['preview'])) {
                if ($func == 'imagejpeg') $func($canvas, $upload_dir . $image_name, 100);
                else $func($canvas, $upload_dir . $image_name, floor($quality * 0.09));
            }

            $this->removeZeroByte($path);
        }

        header('Content-Type: image/' . $mime_type);
        if ($func == 'imagejpeg') $func($canvas, NULL, 100);
        else $func($canvas, NULL, floor($quality * 0.09));
        imagedestroy($canvas);

        if ($config['website']['image']['hasWebp'] && ($webp || !$preview)) {
            $this->converWebp($upload_dir . $image_name);
        }

        exit;
    }

    /* String sub */
    public function stringSub($text = '', $maxchar = 0, $end = '...')
    {
        $result = '';

        if (strlen($text) > $maxchar || $text == '') {
            $words = preg_split('/\s/', $text);
            $i = 0;

            while (1) {
                $length = strlen($result) + strlen($words[$i]);

                if ($length > $maxchar) {
                    break;
                } else {
                    $result .= " " . $words[$i];
                    ++$i;
                }
            }

            $result .= $end;
        } else {
            $result = $text;
        }

        $result = (!empty($result)) ? trim($result) : '';

        return $result;
    }

    /* String original */
    public function stringOrigin($str = '')
    {
        $result = '';

        if (!empty($str)) {
            $utf8 = array(
                '' => '`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
            );

            foreach ($utf8 as $ascii => $uni) {
                $str = preg_replace("/($uni)/i", $ascii, $str);
            }

            $result = str_replace(array("\n", "\r"), '', $str);
        }

        return $result;
    }

    /* String random */
    public function stringRandom($sokytu = 10)
    {
        $str = '';

        if ($sokytu > 0) {
            $chuoi = 'ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789';
            for ($i = 0; $i < $sokytu; $i++) {
                $vitri = mt_rand(0, strlen($chuoi));
                $str = $str . substr($chuoi, $vitri, 1);
            }
        }

        return $str;
    }

    /* Digital random */
    public function digitalRandom($min = 1, $max = 10, $num = 10)
    {
        $result = '';

        if ($num > 0) {
            for ($i = 0; $i < $num; $i++) {
                $result .= rand($min, $max);
            }
        }

        return $result;
    }

    /* Lấy tình trạng báo xấu */
    public function getStatusReport($status = 0)
    {
        $result = array();

        if ($status == 1) {
            $result['message'] = "Đã chặn";
            $result['text-cls'] = "text-warning";
        } else if ($status == 2) {
            $result['message'] = "Đã mở";
            $result['text-cls'] = "text-success";
        } else if ($status == 3) {
            $result['message'] = "Đã khóa";
            $result['text-cls'] = "text-danger";
        } else {
            $result['message'] = "Đang chờ duyệt";
            $result['text-cls'] = "text-info";
        }

        return $result;
    }

    /* Lấy tình trạng nhận tin */
    public function getStatusNewsletter($confirm_status = 0, $type = '')
    {
        global $config;

        $loai = '';

        if (!empty($config['newsletter'][$type]['confirm_status'])) {
            foreach ($config['newsletter'][$type]['confirm_status'] as $key => $value) {
                if ($key == $confirm_status) {
                    $loai = $value;
                    break;
                }
            }
        }

        if ($loai == '') $loai = "Đang chờ duyệt...";

        return $loai;
    }

    /* Lấy thông tin chi tiết */
    public function getInfo($cols='', $table='', $id=0)
    {
        $row = array();

        if(!empty($cols) && !empty($table) && !empty($id))
        {
            $row = $this->cache->get("select $cols from #_$table where id = ? limit 0,1", array($id), "fetch", 7200);
        }   
        if ($row) {
            # code...
        if ($cols!='') {
            $row = $row[$cols];
        }

        return $row;
        }else{
            return false;
        }
      
        
    }

    /* Lấy thông tin chi tiết */
    public function getInfoDetail($cols = '', $table = '', $id = 0)
    {
        $row = array();

        if (!empty($cols) && !empty($table) && !empty($id)) {
            $row = $this->cache->get("select $cols from #_$table where id = ? limit 0,1", array($id), "fetch", 7200);
        }

        return $row;
    }

    /* Check order status for order main */
    public function updateOrderMainStatus($idGroup = 0)
    {
        if (!empty($idGroup)) {
            $row = $this->d->rawQueryOne("select id_order from #_order_group where id = ? limit 0,1", array($idGroup));

            if (!empty($row)) {
                /* Get status order by Group */
                $rows = array();
                $rows['all'] = $this->d->rawQueryOne("select count(id) as num from #_order_group where id_order = ?", array($row['id_order']));
                $rows['trading'] = $this->d->rawQueryOne("select count(id) as num from #_order_group where id_order = ? and (order_status = 1 or order_status = 2 or order_status = 3)", array($row['id_order']));
                $rows['deliveried'] = $this->d->rawQueryOne("select count(id) as num from #_order_group where id_order = ? and order_status = 4", array($row['id_order']));
                $rows['canceled'] = $this->d->rawQueryOne("select count(id) as num from #_order_group where id_order = ? and order_status = 5", array($row['id_order']));

                /* Update status order main */
                if (!empty($rows)) {
                    $data = array();

                    if ($rows['all']['num'] == $rows['deliveried']['num'] || $rows['trading'] == 0) {
                        $data['order_status'] = 4;
                        $data['date_updated'] = time();
                    } else if ($rows['all']['num'] == $rows['canceled']['num']) {
                        $data['order_status'] = 5;
                        $data['date_updated'] = time();
                    } else {
                        $data['order_status'] = 6;
                    }

                    $this->d->where('id', $row['id_order']);
                    $this->d->update('order', $data);
                }
            }
        }
    }

    /* Get status order */
    public function orderStatus($type = '', $status = 0)
    {
        $where = ($type == 'main') ? 'is_main = 1' : (($type == 'other') ? 'is_other = 1' : '');
        $row = $this->cache->get("select * from #_order_status where $where order by id", null, "result", 7200);

        $str = '<select id="order_status" name="data[order_status]" class="form-control custom-select text-sm"><option value="0">Chọn tình trạng</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_status']) && ($v["id"] == (int)$_REQUEST['order_status']) || ($v["id"] == $status)) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }

    /* Get payments order */
    public function orderPayments()
    {
        $row = $this->cache->get("select * from #_news where id_shop = 0 and type='hinh-thuc-thanh-toan' order by numb,id desc", null, "result", 7200);

        $str = '<select id="order_payment" name="order_payment" class="form-control custom-select text-sm"><option value="0">Chọn hình thức thanh toán</option>';
        foreach ($row as $v) {
            if (isset($_REQUEST['order_payment']) && ($v["id"] == (int)$_REQUEST['order_payment'])) $selected = "selected";
            else $selected = "";
            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }

    /* Get admin by multi */
    public function getMultiAdmin($strIdAdmins = '', $idGroup = 0)
    {
        $where = '';

        if (!empty($strIdAdmins) && !empty($idGroup)) {
            $temp = explode(",", $strIdAdmins);

            /* Điều kiện lọc lấy những admin thuộc nhóm hiện tại và những admin chưa được chọn */
            $where .= ' and id not in(select id_admin from #_user_group_admin where id_user_group != ' . $idGroup . ')';
        } else {
            /* Điều kiện lọc lấy những admin chưa được chọn */
            $where .= ' and id not in(select id_admin from #_user_group_admin)';
        }

        /* Điều kiện lọc admin chính - ảo */
        $where .= (!empty($_GET['id_type']) && $_GET['id_type'] == 2) ? " and find_in_set('virtual',status)" : " and !find_in_set('virtual',status)";

        $rows = $this->d->rawQuery("select fullname, id from #_user where role != 3 $where order by numb,id desc");

        $str = '<select id="admin_group" name="admin_group[]" class="select multiselect multiselect-admins" multiple="multiple">';
        if (!empty($rows)) {
            for ($i = 0; $i < count($rows); $i++) {
                if (!empty($temp)) {
                    if (in_array($rows[$i]['id'], $temp)) $selected = 'selected="selected"';
                    else $selected = '';
                } else {
                    $selected = '';
                }
                $str .= '<option value="' . $rows[$i]["id"] . '" ' . $selected . ' />' . $rows[$i]["fullname"] . '</option>';
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get permission lists */
    public function getPermissionGroup($mainPermissions = array(), $configSector = array())
    {
        global $defineSectors;

        $permission_lists = (!empty($_GET['id_type']) && $_GET['id_type'] == 1) ? $defineSectors['permissions']['lists'] : $defineSectors['permissions']['lists-virtual'];

        if (!empty($mainPermissions)) {
            $temp = $mainPermissions;
        }

        $str = '<select id="permission_group" name="permission_group[]" class="select multiselect multiselect-permission" multiple="multiple">';
        if (!empty($permission_lists)) {
            foreach ($permission_lists as $k => $v) {
                $v_temp = $v;

                if (!empty($configSector) && !$this->hasShop($configSector)) {
                    if ($k == 'shop') {
                        unset($v_temp);
                    }
                }

                if (!empty($configSector) && !$this->hasCart($configSector)) {
                    if ($k == 'order') {
                        unset($v_temp);
                    }
                }

                if (!empty($v_temp)) {
                    if (!empty($temp)) {
                        if (in_array($k, $temp)) $selected = 'selected="selected"';
                        else $selected = '';
                    } else {
                        $selected = '';
                    }

                    $str .= '<option value="' . $k . '" ' . $selected . ' />' . $v . '</option>';
                }
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get Sale */
    public function getSale($attr = '', $name = '', $id = '', $id_list = '')
    {
        $where = ($attr == 'size') ? ' and id_list = ' . $id_list : '';
        $temps = (!empty($id)) ? explode(",", $id) : array();
        $rowSale = $this->d->rawQuery("select namevi, id from #_product_$attr where find_in_set('hienthi',status) $where order by numb,id desc");

        $str = '<select id="' . $name . '" name="' . $name . '[]" class="select multiselect multiselect-sale multiselect-' . $attr . ' text-sm" multiple="multiple" >';
        for ($i = 0; $i < count($rowSale); $i++) {
            if (!empty($temps)) {
                if (in_array($rowSale[$i]['id'], $temps)) $selected = 'selected="selected"';
                else $selected = '';
            } else {
                $selected = '';
            }
            $str .= '<option value="' . $rowSale[$i]["id"] . '" ' . $selected . ' /> ' . $rowSale[$i]["namevi"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }


    /* Get product tags */
    public function getVariation($id_list='', $element='', $type='')
    {
        $temp = (!empty($id_list)) ? explode(",", $id_list) : array();
        $row_variation = $this->cache->get("select namevi, id from #_variation where type = ? order by numb,id desc", array($type), "result", 7200);   

        $str = '<select id="'.$element.'" name="'.$element.'[]" class="select multiselect" multiple="multiple" >';
        for($i=0;$i<count($row_variation);$i++)
        {
            if(!empty($id_list))
            {
                if(in_array($row_variation[$i]['id'],$temp)) $selected = 'selected="selected"';
                else $selected = '';
            }
            else
            {
                $selected = '';
            }
            $str .= '<option value="'.$row_variation[$i]["id"].'" '.$selected.' /> '.$row_variation[$i]["namevi"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

    /* Get product tags */
    public function getProductTags($id = 0, $id_list = 0, $tableTag = '')
    {
        $row_tags = array();

        if ($id) {
            $temps = $this->cache->get("select id_tag from #_" . $tableTag . " where id_parent = ?", array($id), "result", 7200);

            if (!empty($temps)) {
                $temp = $this->joinCols($temps, 'id_tag');
                $temp = (!empty($temp)) ? explode(",", $temp) : array();
            }
        }

        if (!empty($id_list)) {
            $row_tags = $this->cache->get("select namevi, id from #_product_tags where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($id_list), "result", 7200);
        }

        $str = '<select id="dataTags" name="dataTags[]" class="select multiselect" multiple="multiple">';
        if (!empty($row_tags)) {
            for ($i = 0; $i < count($row_tags); $i++) {
                if (!empty($temp)) {
                    if (in_array($row_tags[$i]['id'], $temp)) $selected = 'selected="selected"';
                    else $selected = '';
                } else {
                    $selected = '';
                }
                $str .= '<option value="' . $row_tags[$i]["id"] . '" ' . $selected . ' />' . $row_tags[$i]["namevi"] . '</option>';
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get interface by category */
    public function getInterfaceByCategory($data = array(), $id = 0)
    {
        global $defineSectors;

        $result = '';

        if (!empty($data) && !empty($data[$id])) {
            foreach ($data[$id] as $v) {
                $typeList = $defineSectors['IDs'][$v];
                $result .= $defineSectors['types'][$typeList]['name'] . ' - ';
            }
        }

        return (!empty($result)) ? rtrim($result, ' - ') : '';
    }

    /* Get multi category by interface */
    public function getMultiCategoryByInterface($id = 0)
    {
        global $defineSectors;

        if ($id) {
            $temps = $this->cache->get("select id_list from #_interface_category where id_interface = ?", array($id), "result", 7200);

            if (!empty($temps)) {
                $temp = $this->joinCols($temps, 'id_list');
                $temp = (!empty($temp)) ? explode(",", $temp) : array();
            }
        }

        $hasShopID = implode(",", $defineSectors['hasShop']['id']);
        $row_category = $this->cache->get("select namevi, id from #_product_list where id in ($hasShopID) order by numb,id desc", null, "result", 7200);

        $str = '<select id="dataCategory" name="dataCategory[]" class="select multiselect" multiple="multiple">';
        if (!empty($row_category)) {
            for ($i = 0; $i < count($row_category); $i++) {
                if (!empty($temp)) {
                    if (in_array($row_category[$i]['id'], $temp)) $selected = 'selected="selected"';
                    else $selected = '';
                } else {
                    $selected = '';
                }
                $str .= '<option value="' . $row_category[$i]["id"] . '" ' . $selected . ' />' . $row_category[$i]["namevi"] . '</option>';
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get multi cat by group */
    public function getMultiCategoryCatByGroup()
    {
        $str = '';
        $params = array();
        $idGroup = (isset($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : 0;
        $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;

        /* Where by list */
        $where = ' and id_list = ?';
        array_push($params, $idlist);

        /* Lấy cấp 2 theo group */
        $catByCategoryGroup = $this->cache->get("select id_cat from #_user_group_category_cat where id_user_group = ? and id_list = ?", array($idGroup, $idlist), "result", 7200);
        $iDCatByCategoryGroup = !empty($catByCategoryGroup) ? explode(',', $this->joinCols($catByCategoryGroup, 'id_cat')) : [];

        $rows = $this->cache->get("select namevi, id from #_product_cat where id > 0 " . $where . " order by numb,id desc", $params, "result", 7200);

        $str .= '<select id="dataMultiCategoryCat" name="dataMultiCategoryCat[]" class="select multiselect" multiple="multiple">';

        foreach ($rows as $v) {
            if (in_array($v["id"], $iDCatByCategoryGroup)) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }

        $str .= '</select>';

        return $str;
    }

    /* Get category by ajax */
    public function getAjaxCategory($table = '', $level = '', $isExclude = false, $isCart = false, $type = '', $title_select = 'Chọn danh mục', $class_select = 'select-category')
    {
        global $defineSectors;

        $str = '';
        $where = '';
        $params = array();
        $id_parent = 'id_' . $level;
        $data_level = '';
        $data_type = 'data-type="' . $type . '"';
        $data_table = '';
        $data_child = '';
        $isGroup = $this->getGroup('active');
        $iDListByGroup = $this->getGroup('list');
        $iDCatByGroup = $this->getGroup('cat');

        if (!empty($isExclude)) {
            $hasShopID = implode(",", $defineSectors['hasShop']['id']);
            $where .= ' and id in (' . $hasShopID . ')';
        }

        if (!empty($isCart)) {
            $hasCartID = implode(",", $defineSectors['hasCart']['id']);
            $where .= ' and id in (' . $hasCartID . ')';
        }

        if ($type != '') {
            $where .= ' and type = ?';
            array_push($params, $type);
        }

        if ($level == 'list') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="#_' . $table . '_cat"';
            $data_child = 'data-child="id_cat"';

            if ($isGroup) {
                $where .= ' and id = ?';
                array_push($params, $iDListByGroup);
            }
        } else if ($level == 'cat') {
            $data_level = 'data-level="1"';
            $data_table = 'data-table="#_' . $table . '_item"';
            $data_child = 'data-child="id_item"';

            if ($isGroup) {
                /* Lọc cấp 1 theo Group */
                $idlist = $iDListByGroup;

                /* Lọc cấp 2 theo Group */
                $iDCatByGroup = (!empty($iDCatByGroup)) ? implode(',', $iDCatByGroup) : '';
                $where .= ' and id in (' . $iDCatByGroup . ')';
            } else {
                $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            }

            $where .= ' and id_list = ?';
            array_push($params, $idlist);
        } else if ($level == 'item') {
            $data_level = 'data-level="2"';
            $data_table = 'data-table="#_' . $table . '_sub"';
            $data_child = 'data-child="id_sub"';

            if ($isGroup) {
                /* Lọc cấp 1 theo Group */
                $idlist = $iDListByGroup;
            } else {
                $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            }

            $where .= ' and id_list = ?';
            array_push($params, $idlist);

            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
        } else if ($level == 'sub') {
            $data_level = '';
            $data_type = '';
            $class_select = ($class_select == 'select-category')?'':$class_select;

            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);

            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);

            $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
            $where .= ' and id_item = ?';
            array_push($params, $iditem);
        }

        $rows = $this->cache->get("select namevi, id from #_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", $params, "result", 7200);

        $str .= '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_type . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 text-sm ' . $class_select . '">';
        if (!$isGroup || $level != 'list') $str .= '<option value="">' . $title_select . '</option>';

        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }

        $str .= '</select>';

        return $str;
    }

    /* Get category by link */
    public function getLinkCategory($table = '', $level = '', $isExclude = false, $isCart = false, $type = '', $title_select = 'Chọn danh mục')
    {
        global $defineSectors;

        $str = '';
        $where = '';
        $params = array();
        $id_parent = 'id_' . $level;
        $isGroup = $this->getGroup('active');
        $iDListByGroup = $this->getGroup('list');
        $iDCatByGroup = $this->getGroup('cat');

        if (!empty($isExclude)) {
            $hasShopID = implode(",", $defineSectors['hasShop']['id']);
            $where .= ' and id in (' . $hasShopID . ')';
        }

        if (!empty($isCart)) {
            $hasCartID = implode(",", $defineSectors['hasCart']['id']);
            $where .= ' and id in (' . $hasCartID . ')';
        }

        if ($type != '') {
            $where .= ' and type = ?';
            array_push($params, $type);
        }

        if ($level == 'list' && $isGroup) {
            $where .= ' and id = ?';
            array_push($params, $iDListByGroup);
        } else if ($level == 'cat') {
            if ($isGroup) {
                /* Lọc cấp 1 theo Group */
                $idlist = $iDListByGroup;

                /* Lọc cấp 2 theo Group */
                $iDCatByGroup = (!empty($iDCatByGroup)) ? implode(',', $iDCatByGroup) : '';
                $where .= ' and id in (' . $iDCatByGroup . ')';
            }else {
                $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            }

            $where .= ' and id_list = ?';
            array_push($params, $idlist);
        } else if ($level == 'item') {
            if ($isGroup) {
                /* Lọc cấp 1 theo Group */
                $idlist = $iDListByGroup;
            } else {
                $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            }

            $where .= ' and id_list = ?';
            array_push($params, $idlist);

            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);
        } else if ($level == 'sub') {
            $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
            $where .= ' and id_list = ?';
            array_push($params, $idlist);

            $idcat = (isset($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            $where .= ' and id_cat = ?';
            array_push($params, $idcat);

            $iditem = (isset($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
            $where .= ' and id_item = ?';
            array_push($params, $iditem);
        }

        $rows = $this->cache->get("select namevi, id from #_" . $table . "_" . $level . " where id > 0 " . $where . " order by numb,id desc", $params, "result", 7200);

        $str .= '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" onchange="onchangeCategory($(this))" class="form-control filter-category select2 text-sm">';
        if (!$isGroup || $level != 'list') $str .= '<option value="">' . $title_select . '</option>';

        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["namevi"] . '</option>';
        }

        $str .= '</select>';

        return $str;
    }

    /* Get place by group */
    public function getGroupPlace()
    {
        $region = $this->cache->get("select name, id from #_region order by numb,id desc", null, "result", 7200);

        $str = '<select id="id_place" onchange="onchangeCategory($(this))" class="form-control filter-category select2 text-sm"><option value="">Chọn danh mục</option>';
        if (!empty($region)) {
            foreach ($region as $v_region) {
                $city = $this->cache->get("select name, id from #_city where id_region = ? order by numb,id desc", array($v_region['id']), "result", 7200);

                if (!empty($city)) {
                    $str .= '<optgroup label="' . $this->textConvert($v_region["name"], 'upper') . '">';
                    foreach ($city as $v_city) {
                        $id_city = (!empty($_REQUEST['id_place'])) ? explode(",", $_REQUEST['id_place']) : 0;
                        if (!empty($id_city) && ($v_city["id"] == $id_city[1])) $selected = "selected";
                        else $selected = "";

                        $str .= '<option value="' . $v_region["id"] . ',' . $v_city["id"] . '" ' . $selected . ' />' . $v_city["name"] . '</option>';
                    }
                    $str .= '</optgroup>';
                }
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get place by multi */
    public function getMultiPlace($strIdPlaces = '')
    {
        if (!empty($strIdPlaces)) {
            $temp = explode(",", $strIdPlaces);
        }

        $region = $this->cache->get("select name, id from #_region order by numb,id desc", null, "result", 7200);

        $str = '<select id="place_group" name="place_group[]" class="select multiselect text-sm" multiple="multiple">';
        if (!empty($region)) {
            foreach ($region as $v_region) {
                $city = $this->cache->get("select name, id from #_city where id_region = ? order by numb,id desc", array($v_region['id']), "result", 7200);

                if (!empty($city)) {
                    $str .= '<optgroup label="' . $this->textConvert($v_region["name"], 'upper') . '">';
                    foreach ($city as $v_city) {
                        if (!empty($temp)) {
                            if (in_array($v_city['id'], $temp)) $selected = 'selected="selected"';
                            else $selected = '';
                        } else {
                            $selected = '';
                        }

                        $str .= '<option value="' . $v_region["id"] . ',' . $v_city["id"] . '" ' . $selected . ' />' . $v_city["name"] . '</option>';
                    }
                    $str .= '</optgroup>';
                }
            }
        }
        $str .= '</select>';

        return $str;
    }

    /* Get place by ajax */
    public function getAjaxPlace($table = '', $get_region = true, $title_select = 'Chọn danh mục')
    {
        $where = '';
        $params = array('0');
        $id_parent = 'id_' . $table;
        $data_level = '';
        $data_table = '';
        $data_child = '';
        $isGroup = $this->getGroup('active');
        $idregionByGroup = $this->getGroup('regions');
        $idcityByGroup = $this->getGroup('citys');

        if ($table == 'region') {
            $data_level = 'data-level="0"';
            $data_table = 'data-table="#_city"';
            $data_child = 'data-child="id_city"';

            /* Lọc region theo Group */
            if ($isGroup) {
                $where .= ' and id in (' . $idregionByGroup . ')';
            }
        } else if ($table == 'city') {
            $data_level = 'data-level="1"';
            $data_table = 'data-table="#_district"';
            $data_child = 'data-child="id_district"';

            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            /* Lọc city theo Group */
            if ($isGroup) {
                $where .= ' and id in (' . $idcityByGroup . ')';
            }
        } else if ($table == 'district') {
            $data_level = 'data-level="2"';
            $data_table = 'data-table="#_wards"';
            $data_child = 'data-child="id_wards"';

            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
        } else if ($table == 'wards') {
            $data_level = '';
            $data_table = '';
            $data_child = '';

            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);

            $iddistrict = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
            $where .= ' and id_district = ?';
            array_push($params, $iddistrict);
        }

        $rows = $this->cache->get("select name, id from #_" . $table . " where id <> ? " . $where . " order by id asc", $params, "result", 7200);

        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" ' . $data_level . ' ' . $data_table . ' ' . $data_child . ' class="form-control select2 text-sm select-place"><option value="">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }

    /* Get place by link */
    public function getLinkPlace($table = '', $get_region = true, $title_select = 'Chọn danh mục')
    {
        $where = '';
        $params = array('0');
        $id_parent = 'id_' . $table;
        $isGroup = $this->getGroup('active');
        $idregionByGroup = $this->getGroup('regions');
        $idcityByGroup = $this->getGroup('citys');

        if ($table == 'region' && $isGroup) {
            /* Lọc region theo Group */
            $where .= ' and id in (' . $idregionByGroup . ')';
        } else if ($table == 'city') {
            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            /* Lọc city theo Group */
            if ($isGroup) {
                $where .= ' and id in (' . $idcityByGroup . ')';
            }
        } else if ($table == 'district') {
            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);
        } else if ($table == 'wards') {
            if ($get_region == true) {
                $idregion = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $where .= ' and id_region = ?';
                array_push($params, $idregion);
            }

            $idcity = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            $where .= ' and id_city = ?';
            array_push($params, $idcity);

            $iddistrict = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
            $where .= ' and id_district = ?';
            array_push($params, $iddistrict);
        }

        $rows = $this->cache->get("select name, id from #_" . $table . " where id <> ? " . $where . " order by id asc", $params, "result", 7200);

        $str = '<select id="' . $id_parent . '" name="data[' . $id_parent . ']" onchange="onchangeCategory($(this))" class="form-control filter-category select2 text-sm"><option value="">' . $title_select . '</option>';
        foreach ($rows as $v) {
            if (isset($_REQUEST[$id_parent]) && ($v["id"] == (int)$_REQUEST[$id_parent])) $selected = "selected";
            else $selected = "";

            $str .= '<option value=' . $v["id"] . ' ' . $selected . '>' . $v["name"] . '</option>';
        }
        $str .= '</select>';

        return $str;
    }
}
