<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/31
 * Time: 21:01
 */

class table_summer_zan extends discuz_table
{
    public function __construct()
    {
        $this->_pk="id";
        $this->_table="summer_zan";
        parent::__construct();
    }
    //添加点赞数据
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //查看某人当前对某个景点投票数
    public function get_count($w_id,$jing_id,$now){
        $data = DB::result_first("select count(*) from %t where `zan_wid`=%s and `jing_id`=%i and `zan_day`=%i",array($this->_table,$w_id,$jing_id,$now));
        return $data;
    }
    //获取某景区所有点赞数
    public function get_zan_count($jing_id){
        $data = DB::result_first("select count(*) from %t where `jing_id`=%i",array($this->_table,$jing_id));
        return $data;
    }
    //查看某人对景点集赞数
    public function get_some_zan($jing_id,$leader_id){
        $data = DB::result_first("select count(*) from %t where `jing_id`=%i and `leader_id`=%i",array($this->_table,$jing_id,$leader_id));
        return $data;
    }

}