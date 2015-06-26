<?php
require_once("lib/lib.php");
require_once("lib/mysql-ini.php");
// データベースに接続
$db_conn = new mysqli($host, $user, $pass, $dbname)
or die("データベースとの接続に失敗しました");
$db_conn->set_charset('utf8');

////////////////////////////////////
//$lang_dir = "fr";//フランス 1
// $lang_dir = "us";//アメリカ 2
//$lang_dir = "en";//UK 3
//$lang_dir = "de";//ドイツ 4
//$lang_dir = "es";//スペイン 5
//$lang_dir = "it";//イタリア 6
//$lang_dir = "pt";//ポルトガル 7
//$lang_dir = "br";//ブラジル 8
//$lang_dir = "jp";//日本 9
//$lang_dir = "pl";//ポーランド 11
//$lang_dir = "ru";//ロシア 12
//$lang_dir = "cn";//中国 13 
//$lang_dir = "tr";//トルコ 14
//$lang_dir = "kr";//韓国 15
////////////////////////////////////
if ( isset($_REQUEST['language_id']) ) {
  $language_id = (int)$_REQUEST['language_id'];
} else {
  $language_id= 9; // 日本
}
// $language_id= 2; // 日本

$lang = f_get_tran($db_conn,$language_id,'lang');
$title = f_get_tran($db_conn,$language_id,'title-free');
$keywords = f_get_tran($db_conn,$language_id,'keywords-free');
$description = f_get_tran($db_conn,$language_id,'description-free');
$h1_index = f_get_tran($db_conn,$language_id,'h1_free');
$h2_index = f_get_tran($db_conn,$language_id,'h2_free');
$menu_tab1_st = f_get_tran($db_conn,$language_id,'menu_tab1_st');
$menu_tab2_st = f_get_tran($db_conn,$language_id,'menu_tab2_st');
$menu_tab3_st = f_get_tran($db_conn,$language_id,'menu_tab3_st');
$tgcnt = $t0+$t1+$t2;
$description .= '('.date(Y).'-'.date(m).'-'.date(d).':'.$tgcnt.')';
$site_name = f_get_tran($db_conn,$language_id,'site_name');
$site_name .= ' ( '.$tgcnt.' SITE )';
$seek = f_get_tran($db_conn,$language_id,'seek');
//
$og_title = $title;
$og_image = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_site_name = $title;
$og_description = $description;
$h1_st = $title;
$h1_st_s = "  ";
$culhtml = "http://photomotto.xyz/";
$crlhtmltitle = $title;
$footer_sitename = $title;
$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://photomotto.xyz/";
// //
$fb_app_id = 819245511499601;
$article_publisher = "https://www.facebook.com/photomottoxyz";
// //
$twitter_site = "@photomottoZ";
$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
// 
$title = "サイト追加|フォトもっと";
$keywords = "写真素材 ロイヤリティフリー クリエイティブコモンズ ";
$description = "写真素材ポータル";
//
$og_title = $title;
$og_image = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_url = "http://photomotto.xyz/index.php";
$og_site_name = $title;
$og_description = $description;
$h1_st = $title;
$h1_st_s = "  ";
$culhtml = "http://photomotto.xyz/";
$crlhtmltitle = "フォトもっと";
$site_name = "フォトもっと";
$footer_sitename = "フォトもっと";
$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://photomotto.xyz/";
// //
$fb_app_id = 819245511499601;
$article_publisher = "https://www.facebook.com/photomottoxyz";
// //
$twitter_site = "@photomottoZ";
$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);

?>
<?php require('header.php');?>
<body>
<div id="wrap">
<?php require('menu.php');?>
<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
  <div class="container"  style="margin-top: 50px;">
    <div class="row">
      
      <iframe src="https://docs.google.com/forms/d/1glUt0t7kWlLHPAxoI4MkV1leNOitS2RpJM-wIxYCx7g/viewform?embedded=true" width="760" height="500" frameborder="0" marginheight="0" marginwidth="0">読み込み中...</iframe>


    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- .wrap -->
<?php require('footer.php');?>
</body>
</html>
