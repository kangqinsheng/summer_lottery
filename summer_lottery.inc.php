<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31
 * Time: 10:21
 */

/**********΢��openid***************/
require_once "class/poster.php";
//����appid secret url
$appid="wxc9e02b188ab1ea58";
$secret="94022c5a73399e7c285878f5c6a2acd3";
$url="http://xjz.cqdsrb.com.cn";

$code = $_GET['code'];//��ȡcode
$share_id = $_GET['share_id']?$_GET['share_id']:0;//���������Դ
session_start();
if($code || $_SESSION['openid']){
    $weixin=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code");//ͨ��code��ȡ��ҳ��Ȩaccess_token
    $jsondecode = json_decode($weixin); //��JSON��ʽ���ַ������б���
    $array = get_object_vars($jsondecode);//ת��������
    $openid = $array['openid'];//���openid
    $access_token = $array['access_token'];

    //$poster = new Poster();
    //$user = $poster->getInfo($access_token,$openid);

    if($openid){
        $_SESSION['access_token']=$access_token;
        $_SESSION['openid']=$openid;
    }
    if($_SESSION['openid']){
        $access_token=$_SESSION['access_token'];
        $openid=$_SESSION['openid'];
    }
}else{
    $redit="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=http://xjz.cqdsrb.com.cn/plugin.php?id=summer_lottery&share_id={$share_id}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
    header("Location:".$redit);
    exit;
}
$page_to = $_GET['page_to']?$_GET['page_to']:'home';
$jing_id = $_GET['jing_id']?$_GET['jing_id']:0;
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

if($page_to=='home'){
    //��ȡ��ҳ�б�����
    $list = C::t("#summer_lottery#summer_jing")->get_list();
    foreach($list as $key=>$val){
        //��ȡ��ǰ����
        $con_zan = C::t("#summer_lottery#summer_zan")->get_zan_count($val['id']);
        $list[$key]['con_zan'] = $con_zan+$val['jing_ext_zan'];
    }
    $list = my_sort($list,'con_zan',SORT_DESC );
    include template("summer_home","","source/plugin/summer_lottery/template");
}elseif ($page_to=="info"){
    //��ȡ��������
    $info = C::t("#summer_lottery#summer_jing")->get_by_id($jing_id);
    //������
    $con_zan = C::t("#summer_lottery#summer_zan")->get_zan_count($jing_id);
    //��ȡ�����б�
    $commert_list = C::t("#summer_lottery#summer_comment")->get_list($jing_id);
    //��ȡ��������Ϣ
    $leader_all = C::t("#summer_lottery#summer_leader")->leader_all($jing_id);
    //�����˼�����
    foreach($leader_all as $key=>$val){
        //��ȡ��ǰ����
        $con_zan = C::t("#summer_lottery#summer_zan")->get_some_zan($jing_id,$val['id']);
        $leader_all[$key]['con_zan'] = $con_zan;
    }
    $leader_all = my_sort($leader_all,'con_zan',SORT_DESC );
    include template("summery_info","","source/plugin/summer_lottery/template");
}elseif ($page_to=="my_info"){
    //��ȡ���˼������
    $mydata =  C::t("#summer_lottery#summer_leader")->leader_jing($openid);
    //�����˼�����
    foreach($mydata as $key=>$val){
        //��ȡ��ǰ����
        $con_zan = C::t("#summer_lottery#summer_zan")->get_some_zan($val['jing_id'],$openid);
        $mydata[$key]['con_zan'] = $con_zan;
    }
    $mydata = my_sort($mydata,'con_zan',SORT_DESC );
    include template("summery_my_info","","source/plugin/summer_lottery/template");
}


