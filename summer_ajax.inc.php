<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 11:19
 */

require_once "class/poster.php";
$action = $_POST['action']?$_POST['action']:0;
$w_id = $_POST['open_id']?$_POST['open_id']:0;
$leader_id = $_POST['leader_id']?$_POST['leader_id']:0;
$jing_id = intval($_POST['jing_id'])?intval($_POST['jing_id']):0;
session_start();
//发起集赞
if($action=="as_leader"){
    if($w_id==0||$jing_id==0){
        die(json_encode(array("status"=>400,"msg"=>"no params")));
    }
    if($_SESSION['openid']!=$w_id){//验证集赞来源
        die(json_encode(array("status"=>400,"msg"=>"no from openid")));
    }
    //查看是否已发起（已发起直接获取集赞号leader_id）
    $data = C::t("#summer_lottery#summer_leader")->is_add($w_id,$jing_id);
    if($data['id']>0){
        echo json_encode(array("status"=>200,"msg"=>"success","leader_id"=>$data['id']));
    }else{//第一次发起，插入数据
        $poster = new Poster();
        $user = $poster->getInfo($_SESSION['access_token'],$_SESSION['openid']);
        //转码存数据
        $encode = mb_detect_encoding($user['nickname'],array("ASCII","UTF-8","GB2312","GBK","BIG5"));
        $leader_nickname = iconv($encode,"GBK",$user['nickname']);
        $add_data = array('leader_wid'=>$_SESSION['openid'],'leader_img'=>$user['headimgurl'],'leader_nickname'=>$leader_nickname,'jing_id'=>$jing_id,'first_time'=>time());
        $res = C::t("#summer_lottery#summer_leader")->add_one($add_data);
        if($res>0){
            echo json_encode(array("status"=>200,"msg"=>"success","leader_id"=>$res));
        }else{
            echo json_encode(array("status"=>500,"msg"=>"fail as leader"));
        }
    }
}
//点赞
if($action == "zan"){
    if($w_id==0||$jing_id==0||$now==0||$leader_id==0){
        die(json_encode(array("status"=>400,"msg"=>"no params")));
    }
    if($_SESSION['openid']!=$w_id){//验证投票来源
        die(json_encode(array("status"=>400,"msg"=>"no from openid")));
    }
    //查看当天对该景点点赞情况
    $now = intval(date("Ymd",time()));
    $con = C::t("#summer_lottery#summer_zan")->get_count($w_id,$jing_id,$now);
    //判断是否已经超出限制
    if($con<5){//可点赞
        $data = array("zan_wid"=>$w_id,"jing_id"=>$jing_id,"zan_time"=>time(),"zan_day"=>$now,"leader_id"=>$leader_id);
        $res = C::t("#summer_lottery#summer_zan")->add_one($data);
        if($res>0){
            echo json_encode(array("status"=>200,"msg"=>$res));
        }else{
            echo json_encode(array("status"=>500,"msg"=>"fail zan"));
        }
    }else{//不可点赞
        die(json_encode(array("status"=>300,"msg"=>"ext zan shu")));
    }
}
//评论
if($action=="comment"){
    if($w_id==0||$jing_id==0){
        die(json_encode(array("status"=>400,"msg"=>"no params")));
    }
    if($_SESSION['openid']!=$w_id){//验证评论来源
        die(json_encode(array("status"=>400,"msg"=>"no from openid")));
    }
    //转码存数据
    $encode = mb_detect_encoding($_POST['comment'],array("ASCII","UTF-8","GB2312","GBK","BIG5"));
    $comment = iconv($encode,"GBK",$_POST['comment']);
    $data = array("comment_wid"=>$w_id,'comment_cont'=>$comment,'comment_time'=>time(),'jing_id'=>$jing_id);
    $res = C::t("#summer_lottery#summer_comment")->add_one($data);
    if($res>0){
        echo json_encode(array("status"=>200,"msg"=>$res));
    }else{
        echo json_encode(array("status"=>500,"msg"=>"fail comment"));
    }
}
//删除评论
if($action=="delete_comment"){
    $comment_id = intval($_POST['comment_id']);
    $res = C::t("#summer_lottery#summer_comment")->del_by_id($comment_id);
    if($res){
        echo json_encode(array("status"=>200,"msg"=>$res));
    }else{
        echo json_encode(array("status"=>500,"msg"=>"fail delete comment"));
    }
}
//上线景点
if($action == "online_jing"){
    $data = array("jing_status"=>0);
    $res = C::t("#summer_lottery#summer_jing")->update_one($jing_id,$data);
    if($res){
        echo json_encode(array("status"=>200,"msg"=>$res));
    }else{
        echo json_encode(array("status"=>500,"msg"=>"fail online"));
    }
}
//下线景点
if($action == "under_jing"){
    $data = array("jing_status"=>1);
    $res = C::t("#summer_lottery#summer_jing")->update_one($jing_id,$data);
    if($res){
        echo json_encode(array("status"=>200,"msg"=>$res));
    }else{
        echo json_encode(array("status"=>500,"msg"=>"fail under line"));
    }
}