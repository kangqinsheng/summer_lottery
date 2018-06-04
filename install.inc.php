<?php
/**
 * ��Ȩ�û���
 *
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `xiaojizhe_summer_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `open_id` VARCHAR(300),
  `user_nickname` VARCHAR(200) NOT NULL,
  `user_img` VARCHAR(200)
) ENGINE=MyISAM;
EOF;
DB::query($sql);

/**
 * ��������
 *
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `xiaojizhe_summer_jing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `jing_name` VARCHAR(100) NOT NULL,
  `jing_img` VARCHAR(50),
  `jing_content` VARCHAR(10000),
  `jing_ext_zan` int(10) DEFAULT 0,
  `jing_status` int(1) DEFAULT 0
) ENGINE=MyISAM;
EOF;
DB::query($sql);
/**
 * ���޲�����
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `xiaojizhe_summer_leader` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `leader_wid` VARCHAR(100) NOT NULL,
  `leader_img` varchar(200),
  `leader_nickname` VARCHAR(200),
  `jing_id` int(10),
  `first_time` int(20)
) ENGINE=MyISAM;
EOF;
DB::query($sql);
/**
 * ���޼�¼
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `xiaojizhe_summer_zan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `zan_wid` VARCHAR(100) NOT NULL,
  `jing_id` int(10),
  `zan_time` int(20),
  `zan_day` VARCHAR(20),
  `leader_id` int(10)
) ENGINE=MyISAM;
EOF;
DB::query($sql);
/**
 * ����
 */
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `xiaojizhe_summer_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `comment_wid` VARCHAR(100) NOT NULL,
  `comment_img` varchar(200),
  `comment_nickname` VARCHAR(200),
  `comment_cont` varchar(1000),
  `comment_time` int(20),
  `jing_id` int(10)
) ENGINE=MyISAM;
EOF;
DB::query($sql);
echo "��װ�ɹ�";