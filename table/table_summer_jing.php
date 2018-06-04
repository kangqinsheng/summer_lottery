<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/31
 * Time: 20:57
 */

class table_summer_jing extends discuz_table
{
    public function __construct()
    {
        $this->_pk="id";
        $this->_table="summer_jing";
        parent::__construct();
    }
    //���һ������
    public function add_one($data){
        $res = DB::insert($this->_table,$data,true);
        return $res;
    }
    //��ȡ���������б����������ݣ�
    public function get_list(){
        $data = DB::fetch_all("select `id`,`jing_name`,`jing_img`,`jing_status`,`jing_ext_zan` from %t",array($this->_table));
        return $data;
    }
    //ͨ��id��ȡ��ϸ��Ϣ
    public function get_by_id($id){
        $data = DB::fetch_first("select * from %t where `id`=%i",array($this->_table,$id));
        return $data;
    }
    //��������
    public function update_one($jing_id,$data){
        $res = DB::update($this->_table,$data,"id={$jing_id}");
        return $res;
    }
}