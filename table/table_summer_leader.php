<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/31
 * Time: 21:00
 */

class table_summer_leader extends discuz_table
{
    public function __construct()
    {
        $this->_pk="id";
        $this->_table="summer_leader";
        parent::__construct();
    }
    //���һ������
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //�鿴�����ڴξ����Ƿ��Ѿ�������Ʊ
    public function is_add($w_id,$jing_id){
        $data = DB::fetch_first("select * from %t where `leader_wid`=%s and `jing_id`=%i",array($this->_table,$w_id,$jing_id));
        return $data;
    }
    //��Ӧ���������
    public function leader_all($jing_id){
        $data = DB::fetch_all("select * from %t where `jing_id`=%i",array($this->_table,$jing_id));
        return $data;
    }
    //��ȡ���˼������о���
    public function leader_jing($leader_wid){
        $data = DB::fetch_all("select DISTINCT `jing_id`,`leader_img`,`leader_nickname`,`id` from %t where `leader_wid`=%s",array($this->_table,$leader_wid));
        return $data;
    }
}