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
    //��ӵ�������
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //�鿴ĳ�˵�ǰ��ĳ������ͶƱ��
    public function get_count($w_id,$jing_id,$now){
        $data = DB::result_first("select count(*) from %t where `zan_wid`=%s and `jing_id`=%i and `zan_day`=%i",array($this->_table,$w_id,$jing_id,$now));
        return $data;
    }
    //��ȡĳ�������е�����
    public function get_zan_count($jing_id){
        $data = DB::result_first("select count(*) from %t where `jing_id`=%i",array($this->_table,$jing_id));
        return $data;
    }
    //�鿴ĳ�˶Ծ��㼯����
    public function get_some_zan($jing_id,$leader_id){
        $data = DB::result_first("select count(*) from %t where `jing_id`=%i and `leader_id`=%i",array($this->_table,$jing_id,$leader_id));
        return $data;
    }

}