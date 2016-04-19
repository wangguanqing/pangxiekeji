<?php
defined('IN_PHPCMS') or exit('No permission resources.');
header('Content-Type: application/json');
pc_base::load_app_func('global','content');


$mofangapi = new wangshihao;
$true_action = trim($_GET['action']);

if(!method_exists($mofangapi,$true_action)){
    $return = array();
    $return['code'] = -1;
    $return['message'] = '接口方法不存在，请检查!';
    $return['data'] = array();
}else{
    $return = $mofangapi->$true_action($_GET);
}

// $callback = isset($_GET['jsonpcallback']) ? trim($_GET['jsonpcallback']) : ( isset($_GET['callback']) ? trim($_GET['callback']) : "" );
$callback = $_GET['callback'];
if($callback){
    echo $callback."(".json_encode($return).")";
}else{
    echo json_encode($return);
}
exit;


/**
 * 本文件功能注释
 * @author 作者
 * 时间
 */
class wangshihao {
    function __construct() {
        $this->db_content = pc_base::load_model('content_model');
    }

    //根据typeid,catid,modelid获取文章列表
    public function load_type_more($data){
        $catid = intval($_GET['catid']);
        $modelid = intval($_GET['modelid']);
        $typeid = intval($_GET['typeid']);
        $pagesize = intval($_GET['pagesize']);
        $page = intval($_GET['page']);
        $type = $_GET['type']? $_GET['type'] : 'new';

        if(!$catid && !$typeid && !$modelid){
            showmessage('请通过正常渠道访问！谢谢.... ',HTTP_REFERER);
            exit();
        }

        //检查筛选条件是否存在于数组中
        $type_arr = array("new","hot");
        if(!in_array($type, $type_arr)){
            showmessage('请选择正确的筛选条件，谢谢.... ',HTTP_REFERER);
            exit;
        }


        // //检查typeid是否存在
        // $type_db = pc_base::load_model('type_model');
        // $sql = array("typeid"=>$typeid);
        // $type_array = $type_db->select($sql);
        // if(empty($type_array)){
        //     showmessage('请通过正常渠道访问！谢谢.... ',HTTP_REFERER);
        // }
        //根据typeid,catid获取文章列表
        $CATEGORYS = getcache('category_content_1','commons');
        $CAT = $CATEGORYS[$catid];

        $MODEL = getcache('model','commons');
        if($catid){
            //如果catid存在，根据catid，寻找modelid
            $modelid = $CAT['modelid'];
        }

        // 判断model是否真的存在
        if(empty($MODEL[$modelid])){
            showmessage('请通过正常渠道访问！谢谢.... ',HTTP_REFERER);
        }
        $this->db = pc_base::load_model('content_model');

        $tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];

        if($type=='hot'){
            //按最热进行查询
            //加载hits表，查出modelid,catid下排行
            $hits_db = pc_base::load_model('hits_model');
            if($catid){
                $sql_array = array("catid"=>$catid,"modelid"=>$modelid);
            }else{
                $sql_array = array("modelid"=>$modelid);
            }
            $hit_array = $hits_db->listinfo($sql_array,$order = 'monthviews desc ',  $page, $pagesize);//按本月浏览量排行，非全部浏览量
            if(!empty($hit_array)){
                $return = array();
                foreach ($hit_array as $key => $value) {
                    # code...
                    $id = '';
                    $pos = strpos($value['hitsid'],'-',2) + 1;
                    $id = substr($value['hitsid'],$pos);
                    $return[] = $this->db->get_one(array("id"=>$id));
                }
            }
        }else{
            
            if($typeid){
                //检查typeid是否存在
                $type_db = pc_base::load_model('type_model');
                $sql = array("typeid"=>$typeid);
                $type_array = $type_db->select($sql);
                if(empty($type_array)){
                    showmessage('请通过正常渠道访问！谢谢.... ',HTTP_REFERER);
                }
                //按最新进行查询
                if($catid){//按栏目，查出typeid所有的文章列表
                    $art_sql = array("typeid"=>$typeid,"catid"=>$catid);
                }else{
                    $art_sql = array("typeid"=>$typeid);
                }
            }else{
                $art_sql = array("status"=>99);
            }
            $return = $this->db->listinfo($art_sql,$order = 'inputtime desc ',  $page, $pagesize);
        }
        
        return $return;
    }

    //插入文章
    public function add_article($data){
        $add_article_db = pc_base::load_model('add_article_model');
        $array = array();
        $array['tagid'] = $data['tagid'];

        $array['contentid'] = $data['contentid'];//文章的ID
        $array['title'] = $data['title'];
        $array['url'] = $data['url'];
        $array['thumb'] = $data['thumb'];
        $array['listorder'] = $data['listorder'];
        $array['tagid'] = $data['tagid'];
        $array['inputtime'] = SYS_TIME;
        $array['starttime'] = strtotime($data['starttime']);
        $array['endtime'] = strtotime($data['endtime']);
        //如果开始时间小于当前时间，则status=1; 前台不可能显示中
        if($array['starttime'] > $array['inputtime']){
            $array['status'] = 1;
        }
        $id = $add_article_db->insert($array,1);
        if($id){
            return $id;
        }else{
            return false;
        }
    }

    //根据catid获取文章列表
    public function lists($data) {
        $ids = intval($data['catid']);
        $modelid = intval($data['modelid']);
        $page = max(intval($data['page']),1);//分页
        $pagesize = $data['pagesize'] ? intval($data['modelid']): 10 ;//每页条数
        $ordertype = $data['ordertype'] ? intval($data['ordertype']) :  0;//排序

        if(!$ids || !$modelid){
            $return = array();
            $return['code'] = -1;
            $return['message'] = '栏目ID不对，请检查!';
            $return['data'] = array();
            return $return;exit;
        }

        //读memcached缓存
        $article_search = 'article_list_'.$ids;
        $game_search_key = sha1($article_search);
        $game_search_key .= '_'.$page."_".$pagesize;
        if($_GET['test']!='' || !$new_array = getcache($game_search_key, '', 'memcache', 'html')) { //没有缓存
            $ordertype_array = array("inputtime desc","listorder asc");
            //定义文章数组
            $new_array = array(); 
            $this->db_content->set_model($modelid);   
            //频道对应的栏目ID集合
            $where = " `catid` = $ids AND status=99";
            $new_array = $this->db_content->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);
            setcache($game_search_key, $new_array, '', 'memcache', 'html', 1200);
        }else{//缓存有数据
            $new_array = getcache($game_search_key, '', 'memcache', 'html');
        }
        $return = array();
        $return['code'] = 0;
        $return['message'] = 'Success!';
        $return['data'] = $new_array;
        return $return;
    }


    //根据catid获取文章列表，加载更多
    public function load_more($data) {
        $ids = intval($data['catid']);
        $modelid = intval($data['modelid']);
        $page = max(intval($data['page']),1);//分页
        $pagesize = $data['pagesize'] ? intval($data['pagesize']): 10 ;//每页条数
        $ordertype = $data['ordertype'] ? intval($data['ordertype']) :  0;//排序

        if(!$ids || !$modelid){
            $return = array();
            $return['code'] = -1;
            $return['message'] = '栏目ID不对，请检查!';
            $return['data'] = array();
            return $return;exit;
        }

        //读memcached缓存
        $article_search = 'article_list_'.$ids;
        $game_search_key = sha1($article_search);
        $game_search_key .= '_'.$page."_".$pagesize;
        if($_GET['test']!='' || !$new_array = getcache($game_search_key, '', 'memcache', 'html')) { //没有缓存
            $ordertype_array = array("id desc","listorder asc");
            //定义文章数组
            $new_array = array(); 
            $this->db_content->set_model($modelid);   
            //频道对应的栏目ID集合
            $where = " `catid` = $ids AND status=99";
            $new_array = $this->db_content->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);
            setcache($game_search_key, $new_array, '', 'memcache', 'html', 1200);
        }else{//缓存有数据
            $new_array = getcache($game_search_key, '', 'memcache', 'html');
        }
        
        return $new_array;
    }

    //根据catid获取文章列表，加载更多
    public function load_more_index($data) {
        $array = get_h5index_list($data['page'],$data['pagesize']);
        return $array;exit; 
    }

    

    //根据tagid获取 关联的ID
    public function load_add_article($data) {
        $tagid = safe_replace($data['tagid']);
        $order = 'listorder asc';
        if(!$tagid){
            $return = array();
            $return['code'] = -1;
            $return['message'] = '请选择正确的位置!';
            $return['data'] = array();
            return $return;exit;
        }

        //定义文章数组
        $new_array = array(); 
        $add_article_db = pc_base::load_model('add_article_model');
        $sql = array("tagid"=>$tagid);//属于tagid 并且没有过期的文章数据
        $add_article_array = $add_article_db->listinfo($sql, $order, 1, 10);
        return $add_article_array; 
    }

    //根据关键字搜索
    public function search($data) {
        $q = safe_replace(trim($data['q']));

        $modelid = intval($data['modelid']);
        $page = max(intval($data['page']),1);//分页
        $pagesize = $data['pagesize'] ? intval($data['pagesize']): 5 ;//每页条数
        $ordertype = $data['ordertype'] ? intval($data['ordertype']) :  0;//排序

        if(!$modelid){
            $return = array();
            $return['code'] = -1;
            $return['message'] = '请选择要搜索的模型!';
            $return['data'] = array();
            return $return;exit;
        }

        $ordertype_array = array("id desc","listorder asc");
        //定义文章数组
        $new_array = array(); 
        $this->db_content->set_model($modelid);   
        //频道对应的栏目ID集合
        // $where = array("status"=>99);
        $where = " `status`=99 AND `title` like '%".$q."%'";
        $new_array = $this->db_content->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);
        return $new_array;


        //读memcached缓存
        // $article_search = 'article_list_'.$ids;
        // $game_search_key = sha1($article_search);
        // $game_search_key .= '_'.$page."_".$pagesize;
        // if($_GET['test']!='' || !$new_array = getcache($game_search_key, '', 'memcache', 'html')) { //没有缓存
        //     $ordertype_array = array("id desc","listorder asc");
        //     //定义文章数组
        //     $new_array = array(); 
        //     $this->db_content->set_model($modelid);   
        //     //频道对应的栏目ID集合
        //     $where = " `catid` = $ids AND status=99";
        //     $new_array = $this->db_content->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);
        //     setcache($game_search_key, $new_array, '', 'memcache', 'html', 1200);
        // }else{//缓存有数据
        //     $new_array = getcache($game_search_key, '', 'memcache', 'html');
        // }
        
        // return $new_array;
    }





 
}


?>
