<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once LIBRARIES . "PHPMailer/PHPMailer.php";
include_once LIBRARIES . "PHPMailer/SMTP.php";
include_once LIBRARIES . "PHPMailer/Exception.php";

class Email
{
    private $d;
    private $data = array();
    private $company = array();
    private $optcompany = '';

    function __construct($d)
    {
        $this->d = $d;
        $this->info();
    }

    private function info()
    {
        global $configBase, $idShop, $sampleData, $prefixSector;

        $logo = array();
        $social = array();
        $socialString = '';

        /* Setting main */
        $this->settingMain = $this->d->rawQueryOne("select options from #_setting where id_shop = 0 limit 0,1");
        $this->settingMail = json_decode($this->settingMain['options'], true);

        /* Setting shop */
        $this->company = $this->d->rawQueryOne("select options, namevi from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1", array($prefixSector));
        $this->optcompany = (!empty($this->company['options'])) ? json_decode($this->company['options'], true) : array();

        /* Setting mail */
        $this->optcompany['ip_host'] = $this->settingMail['ip_host'];
        $this->optcompany['port_host'] = $this->settingMail['port_host'];
        $this->optcompany['secure_host'] = $this->settingMail['secure_host'];
        $this->optcompany['email_host'] = $this->settingMail['email_host'];
        $this->optcompany['password_host'] = $this->settingMail['password_host'];
        $this->optcompany['mailertype'] = $this->settingMail['mailertype'];
        $this->optcompany['host_gmail'] = $this->settingMail['host_gmail'];
        $this->optcompany['port_gmail'] = $this->settingMail['port_gmail'];
        $this->optcompany['secure_gmail'] = $this->settingMail['secure_gmail'];
        $this->optcompany['email_gmail'] = $this->settingMail['email_gmail'];
        $this->optcompany['password_gmail'] = $this->settingMail['password_gmail'];

        /* Photo */
        $logo = $this->d->rawQueryOne("select photo from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act = ? limit 0,1", array($prefixSector, 'logo', 'photo_static'));
        $logo = (!empty($logo)) ? $logo : ((!empty($sampleData['logo'])) ? $sampleData['logo'] : array());
        $social = $this->d->rawQuery("select photo, link from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($prefixSector, 'social'));
        $social = (!empty($social)) ? $social : ((!empty($sampleData['social'])) ? $sampleData['social'] : array());

        if ($social && count($social) > 0) {
            foreach ($social as $value) {
                $socialString .= '<a href="' . $value['link'] . '" target="_blank"><img src="' . $configBase . UPLOAD_PHOTO_THUMB . $value['photo'] . '" style="max-height:30px;margin:0 0 0 5px" /></a>';
            }
        }

        $this->data['email'] = ($this->optcompany['mailertype'] == 1) ? $this->optcompany['email_host'] : $this->optcompany['email_gmail'];
        $this->data['color'] = '#6981ed';
        $this->data['home'] = $configBase;
        $this->data['logo'] = (!empty($logo['photo'])) ? '<img src="' . $configBase . UPLOAD_PHOTO_THUMB . $logo['photo'] . '" style="max-height:70px;" >' : '';
        $this->data['social'] = $socialString;
        $this->data['datesend'] = time();
        $this->data['company'] = $this->company['namevi'];
        $this->data['company:address'] = (!empty($this->optcompany['address'])) ? $this->optcompany['address'] : '';
        $this->data['company:email'] = (!empty($this->optcompany['email'])) ? $this->optcompany['email'] : '';
        $this->data['company:hotline'] = (!empty($this->optcompany['hotline'])) ? $this->optcompany['hotline'] : '';
        $this->data['company:website'] = (!empty($this->optcompany['website'])) ? $this->optcompany['website'] : '';
        $this->data['company:worktime'] = '(8-21h cả T7,CN)';
    }

    public function set($key, $value)
    {
        if (!empty($key) && !empty($value)) {
            $this->data[$key] = $value;
        }
    }

    public function get($key)
    {
        return (!empty($this->data[$key])) ? $this->data[$key] : '';
    }

    public function markdown($path = '', $params = array())
    {
        $content = '';

        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/mail/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }

        return $content;
    }

    public function defaultAttrs()
    {
        $default = array();
        $default['vars'] = array(
            '{emailColor}',
            '{emailHome}',
            '{emailLogo}',
            '{emailSocial}',
            '{emailMail}',
            '{emailDateSend}',
            '{emailCompanyName}',
            '{emailCompanyWebsite}',
            '{emailCompanyAddress}',
            '{emailCompanyMail}',
            '{emailCompanyHotline}',
            '{emailCompanyWorktime}'
        );
        $default['vals'] = array(
            $this->get('color'),
            $this->get('home'),
            $this->get('logo'),
            $this->get('social'),
            $this->get('email'),
            'Ngày ' . date('d', time()) . ' tháng ' . date('m', time()) . ' năm ' . date('Y H:i:s', time()),
            $this->get('company'),
            $this->get('company:website'),
            $this->get('company:address'),
            $this->get('company:email'),
            $this->get('company:hotline'),
            $this->get('company:worktime')
        );

        return $default;
    }

    public function addAttrs($array1 = array(), $array2 = array())
    {
        if (!empty($array1) && !empty($array2)) {
            foreach ($array2 as $k2 => $v2) {
                array_push($array1, $v2);
            }
        }

        return $array1;
    }

    public function send($owner = '', $arrayEmail = array(), $subject = "", $message = "", $file = '')
    {
        global $configBase;

        $mail = new PHPMailer(true);
        $config_host = '';
        $config_port = 0;
        $config_secure = '';
        $config_email = '';
        $config_password = '';

        if ($this->optcompany['mailertype'] == 1) {
            $config_host = $this->optcompany['ip_host'];
            $config_port = $this->optcompany['port_host'];
            $config_secure = $this->optcompany['secure_host'];
            $config_email = $this->optcompany['email_host'];
            $config_password = $this->optcompany['password_host'];

            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = false;
            $mail->SMTPSecure = $config_secure;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        } else if ($this->optcompany['mailertype'] == 2) {
            $config_host = $this->optcompany['host_gmail'];
            $config_port = $this->optcompany['port_gmail'];
            $config_secure = $this->optcompany['secure_gmail'];
            $config_email = $this->optcompany['email_gmail'];
            $config_password = $this->optcompany['password_gmail'];
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = false;
            $mail->SMTPSecure = $config_secure;
        }

        $mail->Host = $config_host;
        if ($config_port) {
            $mail->Port = $config_port;
        }
        $mail->Username = $config_email;
        $mail->Password = $config_password;
        $mail->SetFrom($config_email, $this->company['namevi']);

        if ($owner == 'admin') {
            $mail->AddAddress($this->optcompany['email'], $this->company['namevi']);
        } else if ($owner == 'customer') {
            if ($arrayEmail && count($arrayEmail) > 0) {
                foreach ($arrayEmail as $vEmail) {
                    $mail->AddAddress($vEmail['email'], $vEmail['name']);
                }
            }
        }
        $mail->AddReplyTo($this->optcompany['email'], $this->company['namevi']);
        $mail->CharSet = "utf-8";
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        if ($file != '' && isset($_FILES[$file]) && !$_FILES[$file]['error']) {
            $mail->AddAttachment($_FILES[$file]["tmp_name"], $_FILES[$file]["name"]);
        }

        if ($mail->Send()) return true;
        else return false;
    }
}
