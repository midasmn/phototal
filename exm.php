<?php
require_once("lib/mysql-ini.php");
require_once("lib/lib.php");
// データベースに接続
$db_conn = new mysqli($host, $user, $pass, $dbname)
or die("データベースとの接続に失敗しました");
$db_conn->set_charset('utf8');

$id=$_GET['id'];
$url=$_GET['url'];

$disporder = f_get_disporder($db_conn,$id);
f_update_disporder($db_conn,$id,$disporder+1);
header("Location: ".$url);
// exit;
?>