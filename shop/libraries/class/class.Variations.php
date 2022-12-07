<?php
class Variations
{
    private $d;
    private $cache;
    private $data = array();

    function __construct($d, $cache)
    {
        $this->d = $d;
        $this->cache = $cache;
    }

    public function get($tableProductVariation, $id, $type, $lang = 'vi')
    {
        if (empty($this->data[$type])) {
            $rows = $this->cache->get("select id_parent, id_variation from #_$tableProductVariation where type = ?", array($type), 'result', 7200);

            if (!empty($rows)) {
                foreach ($rows as $v) {
                    $variation = $this->cache->get("select name$lang from #_variation where id = ? and find_in_set('hienthi',status)", array($v['id_variation']), 'fetch', 7200);

                    if (!empty($variation)) {
                        $this->data[$type][$v['id_parent']] = $variation['name' . $lang];
                    }
                }
            }
        }

        return (!empty($this->data[$type][$id])) ? $this->data[$type][$id] : '';
    }
}
