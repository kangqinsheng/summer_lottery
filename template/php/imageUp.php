<?php
    header("Content-Type:text/html;charset=gbk");
    error_reporting( E_ERROR | E_WARNING );
    date_default_timezone_set("Asia/chongqing");
    include "Uploader.class.php";
    //�ϴ�����
    $config = array(
        "savePath" => "upload/" ,             //�洢�ļ���
        "maxSize" => 10000 ,                   //������ļ����ߴ磬��λKB
        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //������ļ���ʽ
    );
    //�ϴ��ļ�Ŀ¼
    $Path = "upload/";

    //������������ʱĿ¼��
    $config["savePath"] = $Path;
    $up = new Uploader( "upfile" , $config );
    $type = $_REQUEST['type'];
    $callback=$_GET['callback'];

    $info = $up->getFileInfo();
    /**
     * ��������
     */
    if($callback) {
        echo '<script>'.$callback.'('.json_encode($info).')</script>';
    } else {
		if(json_encode($info)){
			
		}else{
			$info['originalName']=$info['name'];
		}
		echo json_encode($info);
    }
