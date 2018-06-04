<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/31
 * Time: 21:02
 */

class table_summer_comment extends discuz_table
{
    public function __construct()
    {
        $this->_pk = "id";
        $this->_table = "summer_comment";
        parent::__construct();
    }
    //插入数据
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //获取景点所有留言
    public function get_list($jing_id){
        $data = DB::fetch_all("select * from %t WHERE `jing_id`=%i order by `comment_time` DESC ",array($this->_table,$jing_id));
        return $data;
    }
    //删除一条数据
    public function del_by_id($comment_id){
        $res = DB::delete($this->_table,array('id'=>$comment_id));
        return $res;
    }
}