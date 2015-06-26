<?php

// require_once("lib.php");
require_once("mysql-ini.php");
// データベースに接続
$db_conn = new mysqli($host, $user, $pass, $dbname)
or die("データベースとの接続に失敗しました");
$db_conn->set_charset('utf8');

//カウント取得
function f_get_img_url($db_conn,$id)
{
  $aryname = array();
  $strSQL = "SELECT `id`, `url` FROM `tbl_imagesite` WHERE `id` = '$id'";
  $tbl_tmp = mysqli_query($db_conn,$strSQL);
  if($tbl_tmp)
  {
    while($rec_tmp = mysqli_fetch_row($tbl_tmp))
    {
      $aryname[$rec_tmp[0]] = $rec_tmp[1];
    }
  }
  foreach ($aryname as $key => $value)
  {
    $disporder = $value;
  }
     return $disporder;
}


$id = $_GET['id'];
$get_img_url = f_get_img_url($db_conn,$id);

$save_path = "/home/midasmn/photomotto.xyz/public_html/img/tab/".$id.".png";
$image_path = "http://faceapglezon.info/ogimage/topcolecter.php?url=".$get_img_url;
echo "<br>".$id;
echo "<br>".$get_img_url;
echo "<br>".$save_path;
echo "<br>".$image_path;



// 画像ファイルを指定場所に保存
// file_put_contents($save_path, $image_path);
// リサイズ
//　画像生成
 // $out = ImageCreateTrueColor(250 , 250);


