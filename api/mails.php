<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

if (!empty($cmd)) {
    if ($cmd == 'read' && !empty($id)) {
        $mails = $d->rawQueryOne("select id, is_readed from #_member_mails where id = ? and is_readed = 0 limit 0,1", array($id));

        if (!empty($mails['id'])) {
            $data = array();
            $data['is_readed'] = 1;

            if (!empty($data)) {
                $d->where('id', $id);

                if ($d->update("member_mails", $data)) {
                    /* Delete cache */
                    $cache->delete();
                }
            }
        }
    } else if ($cmd == 'delete' && !empty($id)) {
        $d->rawQuery("delete from #_member_mails where id = ?", array($id));
        $cache->delete();
    }
}
