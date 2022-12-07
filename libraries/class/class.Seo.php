<?php
class Seo
{
    private $d;
    private $data;

    function __construct($d)
    {
        $this->d = $d;
    }

    public function set($key = '', $value = '')
    {
        if (!empty($key) && !empty($value)) {
            $this->data[$key] = $value;
        }
    }

    public function get($key)
    {
        return (!empty($this->data[$key])) ? $this->data[$key] : '';
    }

    public function getOnDB($cols = '', $table = '', $id = 0)
    {
        $row = array();
        if (!empty($cols) && !empty($table) && !empty($id)) {
            $row = $this->d->rawQueryOne("select $cols from #_$table where id_parent = ? limit 0,1", array($id));
        }
        return $row;
    }

    public function updateSeoDB($json = '', $table = '', $id = 0)
    {
        if ($table && $id) $this->d->rawQuery("update #_$table set options = ? where id = ?", array($json, $id));
    }
}
