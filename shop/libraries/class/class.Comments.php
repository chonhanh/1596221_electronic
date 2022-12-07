<?php
class Comments
{
    public $total;
    public $total_star;
    public $count_star;
    public $star;
    public $limitParentShow = 5;
    public $limitParentGet = 2;
    public $limitChildShow = 3;
    public $limitChildGet = 1;
    public $lists = [], $params = [];
    private $d;
    private $func;
    private $sector_prefix;
    private $table_shop;
    private $table_main;
    private $table_photo;
    private $table_video;
    private $id_product;
    private $errors = [], $response = [];

    public function __construct($d, $func, $table = [], $sector_prefix = '', $id = 0)
    {
        $this->d = $d;
        $this->func = $func;
        $this->sector_prefix = $sector_prefix;
        $this->table_shop = $table['shop'];
        $this->table_main = $table['main'];
        $this->table_photo = $table['photo'];
        $this->table_video = $table['video'];

        if (!empty($id)) {
            $this->id_product = $id;
            $this->total = $this->total();
            $this->count_star = $this->countStar();
            $this->star = (!empty($this->count_star)) ? json_decode($this->count_star, true) : null;
            $this->total_star = $this->totalStar();
            $this->lists = $this->lists();
        }
    }

    private function response()
    {
        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        } else {
            $response['success'] = true;
        }

        return json_encode($response);
    }

    public function countStar()
    {
        $count = array();

        for ($i = 1; $i <= 5; $i++) {
            $count[$i] = $this->getStar($i);
        }

        return json_encode($count);
    }

    private function getStar($star = 1)
    {
        $row = $this->d->rawQueryOne("select count(id) as num from #_$this->table_main where find_in_set('hienthi',status) and id_product = ? and star = ?", array($this->id_product, $star));
        return (!empty($row)) ? $row['num'] : 0;
    }

    private function totalStar()
    {
        $row = $this->d->rawQueryOne("select sum(star) as total_star from #_$this->table_main where find_in_set('hienthi',status) and id_product = ?", array($this->id_product));
        return $row['total_star'];
    }

    private function total()
    {
        $rows = $this->d->rawQuery("select * from #_$this->table_main where find_in_set('hienthi',status) and id_parent = 0 and id_product = ? order by date_posted desc", array($this->id_product));
        return (!empty($rows)) ? count($rows) : 0;
    }

    public function totalByID($id_product = 0)
    {
        $row = $this->d->rawQueryOne("select count(id) as num from #_$this->table_main where find_in_set('hienthi',status) and id_parent = 0 and id_product = ?", array($id_product));
        return (!empty($row)) ? $row['num'] : 0;
    }

    public function newPost($id_product = 0, $status = '')
    {
        $row = $this->d->rawQuery("select id_product from #_$this->table_main where find_in_set('hienthi',status) and id_product = ? and find_in_set(?,status)", array($id_product, $status));
        return (!empty($row)) ? count($row) : 0;
    }

    public function lists()
    {
        $rows = $this->d->rawQuery("select A.id as id, A.id_parent as id_parent, A.id_product as id_product, A.id_member as id_member, A.star as star, A.title as title, A.content as content, A.poster as poster, A.status as status, A.date_posted as date_posted, S.id_interface as shopInterface, S.name as shopName, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberName, M.phone as memberPhone, M.email as memberEmail from #_$this->table_main as A left join #_$this->table_shop as S on A.id_shop = S.id and S.status = 'xetduyet' and S.status_user = 'hienthi' left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' left join #_member as M on A.id_member = M.id and find_in_set('hienthi',M.status) and !find_in_set('virtual',M.status) where A.id_parent = 0 and A.id_product = ? and find_in_set('hienthi',A.status) order by A.date_posted desc limit 0,$this->limitParentShow", array($this->sector_prefix, $this->id_product));

        return $rows;
    }

    public function limitLists()
    {
        /* Request data */
        $limitFrom = (!empty($_GET['limitFrom'])) ? $this->func->sanitize($_GET['limitFrom']) : 0;
        $limitGet = (!empty($_GET['limitGet'])) ? $this->func->sanitize($_GET['limitGet']) : 0;
        $this->id_product = (!empty($_GET['idProduct'])) ? $this->func->sanitize($_GET['idProduct']) : 0;

        /* Get data */
        $rows = $this->d->rawQuery("select A.id as id, A.id_parent as id_parent, A.id_product as id_product, A.id_member as id_member, A.star as star, A.title as title, A.content as content, A.poster as poster, A.status as status, A.date_posted as date_posted, S.id_interface as shopInterface, S.name as shopName, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberName, M.phone as memberPhone, M.email as memberEmail from #_$this->table_main as A left join #_$this->table_shop as S on A.id_shop = S.id and S.status = 'xetduyet' and S.status_user = 'hienthi' left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' left join #_member as M on A.id_member = M.id and find_in_set('hienthi',M.status) and !find_in_set('virtual',M.status) where A.id_parent = 0 and A.id_product = ? and find_in_set('hienthi',A.status) order by A.date_posted desc limit $limitFrom,$limitGet", array($this->sector_prefix, $this->id_product));

        /* Export data */
        $result = array();
        $result['data'] = '';
        $result['total'] = $this->total();

        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                /* Params data */
                $this->params = array();
                $this->params['id_product'] = $this->id_product;
                $this->params['lists'] = $v;
                $this->params['lists']['photo'] = $this->photo($v['id']);
                $this->params['lists']['video'] = $this->video($v['id']);
                $this->params['lists']['replies'] = $this->replies($v['id'], $this->id_product);

                /* Get template */
                $result['data'] .= $this->markdown('lists', $this->params);
            }
        }

        echo json_encode($result);
        exit();
    }

    public function photo($id_parent = 0)
    {
        $rows = $this->d->rawQuery("select id, photo from #_$this->table_photo where id_parent = ?", array($id_parent));
        return $rows;
    }

    public function video($id_parent = 0)
    {
        $row = $this->d->rawQueryOne("select id, photo, video from #_$this->table_video where id_parent = ? limit 0,1", array($id_parent));
        return $row;
    }

    public function replies($id_parent = 0, $id_product = 0)
    {
        $rows = $this->d->rawQuery("select A.id as id, A.id_parent as id_parent, A.id_product as id_product, A.id_member as id_member, A.star as star, A.title as title, A.content as content, A.poster as poster, A.status as status, A.date_posted as date_posted, S.id_interface as shopInterface, S.name as shopName, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberName, M.phone as memberPhone, M.email as memberEmail, U.fullname as adminName, U.phone as adminPhone, U.email as adminEmail from #_$this->table_main as A left join #_$this->table_shop as S on A.id_shop = S.id and S.status = 'xetduyet' and S.status_user = 'hienthi' left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' left join #_member as M on A.id_member = M.id and find_in_set('hienthi',M.status) and !find_in_set('virtual',M.status) left join #_user as U on A.id_admin = U.id and find_in_set('hienthi',U.status) where A.id_parent = ? and A.id_product = ? and find_in_set('hienthi',A.status) order by A.date_posted desc limit 0,$this->limitChildShow", array($this->sector_prefix, $id_parent, $id_product));

        return $rows;
    }

    public function limitReplies()
    {
        /* Request data */
        $limitFrom = (!empty($_GET['limitFrom'])) ? $this->func->sanitize($_GET['limitFrom']) : 0;
        $limitGet = (!empty($_GET['limitGet'])) ? $this->func->sanitize($_GET['limitGet']) : 0;
        $id_parent = (!empty($_GET['idParent'])) ? $this->func->sanitize($_GET['idParent']) : 0;
        $id_product = (!empty($_GET['idProduct'])) ? $this->func->sanitize($_GET['idProduct']) : 0;

        /* Get data */
        $rows = $this->d->rawQuery("select A.id as id, A.id_parent as id_parent, A.id_product as id_product, A.id_member as id_member, A.star as star, A.title as title, A.content as content, A.poster as poster, A.status as status, A.date_posted as date_posted, S.id_interface as shopInterface, S.name as shopName, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberName, M.phone as memberPhone, M.email as memberEmail, U.fullname as adminName, U.phone as adminPhone, U.email as adminEmail from #_$this->table_main as A left join #_$this->table_shop as S on A.id_shop = S.id and S.status = 'xetduyet' and S.status_user = 'hienthi' left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' left join #_member as M on A.id_member = M.id and find_in_set('hienthi',M.status) and !find_in_set('virtual',M.status) left join #_user as U on A.id_admin = U.id and find_in_set('hienthi',U.status) where A.id_parent = ? and A.id_product = ? and find_in_set('hienthi',A.status) order by A.date_posted desc limit $limitFrom,$limitGet", array($this->sector_prefix, $id_parent, $id_product));

        /* Export data */
        $result = array();
        $result['data'] = '';
        $result['total'] = $this->totalReplies($id_parent, $id_product);

        if (!empty($rows)) {
            /* Params data */
            $this->params = array();
            $this->params['replies'] = $rows;

            /* Get template */
            $result['data'] .= $this->markdown('replies', $this->params);
        }

        echo json_encode($result);
        exit();
    }

    public function totalReplies($id_parent = 0, $id_product = 0)
    {
        $row = $this->d->rawQueryOne("select count(A.id) as num from #_$this->table_main as A left join #_$this->table_shop as S on A.id_shop = S.id and S.status = 'xetduyet' and S.status_user = 'hienthi' left join #_member as M on A.id_member = M.id and find_in_set('hienthi',M.status) and !find_in_set('virtual',M.status) left join #_user as U on A.id_admin = U.id and find_in_set('hienthi',U.status) where A.id_parent = ? and A.id_product = ? and find_in_set('hienthi',A.status) order by A.date_posted desc", array($id_parent, $id_product));
        return (!empty($row)) ? $row['num'] : 0;
    }

    public function perScore($num = 1)
    {
        return (!empty($this->total)) ? round(($this->star[$num] * 100) / $this->total, 1) : 0;
    }

    public function avgPoint()
    {
        return (!empty($this->total)) ? round((($this->total_star) / $this->total), 1) : 0;
    }

    public function avgStar()
    {
        return (!empty($this->total)) ? ($this->total_star * 100) / ($this->total * 5) : 0;
    }

    public function scoreStar($star = 0)
    {
        return (!empty($star)) ? ($star * 100) / 5 : 0;
    }

    public function parseInfo($data = array(), $type = '')
    {
        $result = array();

        if (!empty($data) && !empty($type)) {
            if (!empty($data['member' . ucfirst($type)])) {
                $result[$type] = $data['member' . ucfirst($type)];
                $result['type'] = 'user';
            } else if (!empty($data['admin' . ucfirst($type)])) {
                $result[$type] = $data['admin' . ucfirst($type)];
                $result['type'] = 'user';
            } else if (!empty($this->table_shop)) {
                $result[$type] = (!empty($data['shop' . ucfirst($type)])) ? $data['shop' . ucfirst($type)] : (!empty($data['shopInterface']) ? $this->sample($data['shopInterface']) : '');
                $result['type'] = 'shop';
            }
        }

        return $result;
    }

    public function sample($id = 0)
    {
        $result = $this->d->rawQueryOne("select logo from #_sample where id_interface = ?", array($id));
        return (!empty($result['logo'])) ? $result['logo'] : '';
    }

    public function subName($str = '')
    {
        $result = '';

        if (!empty($str)) {
            $arr = explode(' ', $str);

            if (count($arr) > 1) {
                $result = substr($arr[0], 0, 1) . substr(end($arr), 0, 1);
            } else {
                $result = substr($arr[0], 0, 1);
            }
        }

        return $result;
    }

    public function add()
    {
        global $idShop;

        $data = (!empty($_POST['dataReview'])) ? $_POST['dataReview'] : null;

        if (!empty($data)) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($this->func->sanitize($value));
            }

            $data['id_shop'] = $idShop;
            $data['status'] = 'hienthi';
            $data['date_posted'] = time();

            /* Valid data */
            if (empty($data['content']) || (!empty($data['fullname_parent']) && trim($data['content']) == $data['fullname_parent'])) {
                $this->errors[] = 'Chưa nhập nội dung đánh giá';
            } else {
                unset($data['fullname_parent']);
            }

            if (empty($this->errors)) {
                if ($this->d->insert($this->table_main, $data)) {
                    $this->updateStatus($data['id_parent']);
                } else {
                    $this->errors[] = 'Phản hồi thất bại. Vui lòng thử lại sau';
                }
            }
        } else {
            $this->errors[] = 'Dữ liệu không hợp lệ';
        }

        return $this->response();
    }

    public function updateStatus($id = 0)
    {
        if (!empty($id)) {
            $row = $this->d->rawQueryOne("select A.id as id from #_$this->table_main as A where A.id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $this->d->rawQuery("update #_$this->table_main set status = replace(status, ',new-shop', ''), status = replace(status, 'new-shop,', '') where id = ?", array($id));
                $this->d->rawQuery("update #_$this->table_main set status = replace(status, ',new-shop', ''), status = replace(status, 'new-shop,', '') where id_parent = ? and poster != ? and find_in_set('hienthi',status) and find_in_set('new-shop',status)", array($id, 'shop'));
            }
        }
    }

    public function markdown($path = '', $params = array())
    {
        $content = '';

        if (!empty($path)) {
            ob_start();
            include dirname(__DIR__) . "/sample/comment/" . $path . ".php";
            $content = ob_get_contents();
            ob_clean();
        }

        return $content;
    }

    public function timeAgo($time = 0)
    {
        $result = '';
        $lang = [
            'now' => 'Vài giây trước',
            'ago' => 'trước',
            'vi' => [
                'y' => 'năm',
                'm' => 'tháng',
                'd' => 'ngày',
                'h' => 'giờ',
                'm' => 'phút',
                's' => 'giây'
            ]
        ];

        $ago = time() - $time;

        if ($ago < 1) {
            $result = $lang['now'];
        } else {
            $unit = [
                365 * 24 * 60 * 60  =>  'y',
                30 * 24 * 60 * 60  =>  'm',
                24 * 60 * 60  =>  'd',
                60 * 60  =>  'h',
                60  =>  'm',
                1  =>  's'
            ];

            foreach ($unit as $secs => $key) {
                $time = $ago / $secs;

                if ($time >= 1) {
                    $time = round($time);
                    $result = $time . ' ' . ($time > 1 ? $lang['vi'][$key] : $lang['vi'][$key]) . ' ' . $lang['ago'];
                    break;
                }
            }
        }

        return $result;
    }
}
