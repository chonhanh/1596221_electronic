<?php
class Statistic
{
    private $d;

    function __construct($d, $cache)
    {
        $this->d = $d;
        $this->cache = $cache;
    }

    public function getCounter()
    {
        global $idShop, $tableShopCounter;

        $locktime = 15 * 60;
        $initialvalue = 1;
        $records = 100000;
        $day = date('d');
        $month = date('n');
        $year = date('Y');

        /* Day start */
        $daystart = mktime(0, 0, 0, $month, $day, $year);

        /* Month start */
        $monthstart = mktime(0, 0, 0, $month, 1, $year);

        /* Week start */
        $weekday = date('w');
        $weekday--;
        if ($weekday < 0) $weekday = 7;
        $weekday = $weekday * 24 * 60 * 60;
        $weekstart = $daystart - $weekday;

        /* Yesterday start */
        $yesterdaystart = $daystart - (24 * 60 * 60);
        $now = time();
        $ip = $_SERVER['REMOTE_ADDR'];

        $t = $this->cache->get("select max(id) as total from #_$tableShopCounter where id_shop = $idShop", null, 'fetch', 1800);
        $all_visitors = $t['total'];

        if ($all_visitors !== NULL) $all_visitors += $initialvalue;
        else $all_visitors = $initialvalue;

        /* Delete old records */
        $temp = $all_visitors - $records;

        if ($temp > 0) $this->d->rawQuery("delete from #_$tableShopCounter where id_shop = $idShop and id < '$temp'");

        $vip = $this->d->rawQueryOne("select count(*) as visitip from #_$tableShopCounter where id_shop = $idShop and ip='$ip' and (tm+'$locktime')>'$now' limit 0,1");
        $items = $vip['visitip'];

        if (empty($items)) $this->d->rawQuery("insert into #_$tableShopCounter (id_shop, tm, ip) values ($idShop, '$now', '$ip')");

        $n = $all_visitors;
        $div = 100000;
        while ($n > $div) $div *= 10;

        $todayrec = $this->cache->get("select count(*) as todayrecord from #_$tableShopCounter where id_shop = $idShop and tm > '$daystart'", null, 'fetch', 1800);
        $yesrec = $this->cache->get("select count(*) as yesterdayrec from #_$tableShopCounter where id_shop = $idShop and tm > '$yesterdaystart' and tm < '$daystart'", null, 'fetch', 1800);
        $weekrec = $this->cache->get("select count(*) as weekrec from #_$tableShopCounter where id_shop = $idShop and tm >= '$weekstart'", null, 'fetch', 1800);
        $monthrec = $this->cache->get("select count(*) as monthrec from #_$tableShopCounter where id_shop = $idShop and tm >= '$monthstart'", null, 'fetch', 1800);
        $totalrec = $this->cache->get("select max(id) as totalrec from #_$tableShopCounter where id_shop = $idShop", null, 'fetch', 1800);

        $result['today'] = $todayrec['todayrecord'];
        $result['yesterday'] = $yesrec['yesterdayrec'];
        $result['week'] = $weekrec['weekrec'];
        $result['month'] = $monthrec['monthrec'];
        $result['total'] = $totalrec['totalrec'];

        return $result;
    }

    public function getOnline()
    {
        global $idShop, $tableShopUserOnline;

        $session = session_id();
        $time = time();
        $time_check = $time - 600;
        $ip = $_SERVER['REMOTE_ADDR'];

        $result = $this->d->rawQuery("select * from #_$tableShopUserOnline where id_shop = $idShop and session = ?", array($session));

        if (count($result) == 0) {
            $this->d->rawQuery("insert into #_$tableShopUserOnline(id_shop,session,time,ip) values($idShop,?,?,?)", array($session, $time, $ip));
        } else {
            $this->d->rawQuery("update #_$tableShopUserOnline set time = ? where id_shop = $idShop and session = ?", array($time, $session));
        }

        $this->d->rawQuery("delete from #_$tableShopUserOnline where id_shop = $idShop and time < $time_check");

        $user_online = $this->d->rawQuery("select * from #_$tableShopUserOnline where id_shop = $idShop");
        $user_online = count($user_online);

        return $user_online;
    }
}
