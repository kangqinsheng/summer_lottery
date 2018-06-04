<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31
 * Time: 13:00
 */
$action = $_GET['action']?$_GET['action']:'index';
//���򷽷�
function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    return $arrays;
}
if($action=="index"){
    //��ȡ���������б�����
    $list = C::t("#summer_lottery#summer_jing")->get_list();
    foreach($list as $key=>$val){
        //��ȡ��ǰ����
        $con_zan = C::t("#summer_lottery#summer_zan")->get_zan_count($val['id']);
        $list[$key]['con_zan'] = $con_zan+$val['jing_ext_zan'];
    }
    $list = my_sort($list,'con_zan',SORT_DESC );
    include template("summer_admin","","source/plugin/summer_lottery/template");
}elseif($action=="update"){
    $jing_id = $_GET['jing_id'];
    //��ȡ������������
    $jing = C::t("#summer_lottery#summer_jing")->get_by_id($jing_id);
    include template("summer_update","","source/plugin/summer_lottery/template");
}elseif($action=="add_jing"){
    $jing_img = $_POST['jing_img'][0]?$_POST['jing_img'][0]:"";
    $jing_name = $_POST['jing_name']?$_POST['jing_name']:"";
    $jing_content = $_POST['jing_content']?$_POST['jing_content']:"";
    if($jing_img!=""&&$jing_name!=""&&$jing_content!=""){
        $data = array("jing_name"=>$jing_name,"jing_img"=>$jing_img,"jing_content"=>$jing_content);
        $res = C::t("#summer_lottery#summer_jing")->add_one($data);
        if($res){
            //��ӳɹ�
            header("location:plugin.php?id=summer_lottery:summer_admin");
        }else{
            die("��������ʧ��!!!!!!");
        }
    }else{
        die("���ݴ���!!!!!!");
    }
}elseif($action=="update_jing"){
    $jing_id = intval($_POST['jing_id']);
    $jing_img = $_POST['jing_img'][0];
    $jing_name = $_POST['jing_name']?$_POST['jing_name']:"";
    $jing_content = $_POST['jing_content']?$_POST['jing_content']:"";
    $jing_ext_zan = intval($_POST['jing_ext_zan']);
    //ת���
    $encode = mb_detect_encoding($jing_name,array("ASCII","UTF-8","GB2312","GBK","BIG5"));
    $jing_name = iconv($encode,"GBK",$jing_name);
    $jing_content = iconv($encode,"GBK",$jing_content);
    if($jing_name!=""&&$jing_content!=""){
        if(isset($jing_img)){
            $data = array("jing_name"=>$jing_name,"jing_img"=>$jing_img,"jing_content"=>$jing_content,"jing_ext_zan"=>$jing_ext_zan);
        }else{
            $data = array("jing_name"=>$jing_name,"jing_content"=>$jing_content,"jing_ext_zan"=>$jing_ext_zan);
        }
        $res = C::t("#summer_lottery#summer_jing")->update_one($jing_id,$data);
        if($res){
            //�޸ĳɹ�
            header("location:plugin.php?id=summer_lottery:summer_admin");
        }else{
            die("û�������޸�!!!!!!");
        }
    }else{
        die("���ݴ���!!!!!!");
    }
}