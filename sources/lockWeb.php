<?php if (!defined('SOURCES')) die("Error");

function make_date111($time, $dot = '.', $lang = 'vi', $f = false)
{

    $str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y", $time) : date("m{$dot}d{$dot}Y", $time);
    if ($f)
    {
        $thu['vi'] = array(
            'Chủ nhật',
            'Thứ hai',
            'Thứ ba',
            'Thứ tư',
            'Thứ năm',
            'Thứ sáu',
            'Thứ bảy'
        );
        $thu['en'] = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        );
        $str = $thu[$lang][date('w', $time) ] . ', ' . $str;
    }
    return $str;
}

$todayPage = strtotime(make_date111(time() , '-'));
$intTimeLock = strtotime('10-03-2022');

if ($intTimeLock < $todayPage)
{
    $stringUrl = $func->getCurrentPageURL();

    $arrayUrl = explode('.vn/', $stringUrl);

    if ($stringUrl == "http://chonhanh.vn/")
    {

        if ($arrayUrl[1] == '')
        {
            $func->redirect('http://chonhanh.vn/lock.php');
        }
    }
}