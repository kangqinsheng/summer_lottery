<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 16:17
 */

class table_summer_user extends discuz_table
{
    public function __construct()
    {
        $this->_pk="id";
        $this->_table="summer_user";
        parent::__construct();
    }
    //���һ������
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //ͨ��openid��ȡ��ϸ��Ϣ
    public function get_by_id($openid){
        $data = DB::fetch_first("select * from %t where `open_id`=%s",array($this->_table,$openid));
        return $data;
    }
    //�鿴�Ƿ���
    public function is_has($openid){
        $data = DB::result_first("select COUNT(*) from %t where `open_id`=%s",array($this->_table,$openid));
        return $data;
    }
}