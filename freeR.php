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
$t0 = f_get_item_cnt($db_conn,0);
$t1 = f_get_item_cnt($db_conn,1);
$t2 = f_get_item_cnt($db_conn,2);
$tab_all_cnt = f_get_item_cnt($db_conn,99);
$menu_tab1_st = f_get_tran($db_conn,$language_id,'menu_tab1_st');
$menu_tab2_st = f_get_tran($db_conn,$language_id,'menu_tab2_st');
$menu_tab3_st = f_get_tran($db_conn,$language_id,'menu_tab3_st');
$menu_tab4_st = f_get_tran($db_conn,$language_id,'menu_tab4_st');
$tgcnt = $t0+$t1+$t2;
$description .= '('.date(Y).'-'.date(m).'-'.date(d).':'.$tgcnt.')';
$site_name = f_get_tran($db_conn,$language_id,'site_name');
$site_name .= ' ( '.$tgcnt.' SITE )';
$seek = f_get_tran($db_conn,$language_id,'seek');

// 
// $title = "Phototalもっと";
// $keywords = "写真素材 ロイヤリティフリー クリエイティブコモンズ ";
// $description = "写真素材ポータル";
//
$og_title = $title;
$og_image = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_site_name = $title;
$og_description = $description;
$h1_st = $title;
$h1_st_s = "  ";
$culhtml = "http://phototal.link/";
$crlhtmltitle = $title;
$footer_sitename = $title;
$itemprop_name = $title;
$itemprop_description = $description;
$itemprop_author = "http://phototal.link/";
// //
$fb_app_id = 819245511499601;
$article_publisher = "https://www.facebook.com/photomottoxyz";
// //
$twitter_site = "@photomottoZ";
$sns_url = "http://".$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["PHP_SELF"]);
//アクティブメニュー

$rtn_tab1 = f_get_tab_img($db_conn,0,1,"img-responsive img-thumbnail img-responsive-overwrite");
$tab_keyword_cnt = f_get_item_cnt($db_conn,0);
$tab_free_cnt = f_get_item_cnt($db_conn,1);
$tab_pay_cnt = f_get_item_cnt($db_conn,2);
?>
<?php require('header.php');?>
<body>
<div id="wrap">
<?php require('menu.php');?>


<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
  <div class="container"  style="margin-top: 1px;">
    <div class="row" >

        <!-- 広告 -->
        <!-- <div class="col-md-12" style="margin-top: 20px;height: 80px;text-align: center;"> -->
          <!-- ＜スポンサーリンク＞ -->
          <?php if (is_mobile()) :?>
          <!-- スマートフォン向けコンテンツ -->
          <!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
          <!-- Phototalもっとレスポンシブ -->
<!--           <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-6625574146245875"
               data-ad-slot="8947356006"
               data-ad-format="auto"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script> -->
          <?php else: ?>
          <div class="col-md-12" style="margin-top: 20px;height: 80px;text-align: center;">
          <!-- PC向けコンテンツ -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- PhototalもっとビックバナーPC -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:970px;height:90px"
               data-ad-client="ca-pub-6625574146245875"
               data-ad-slot="4098354003"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
           </div>
          <?php endif; ?>
        <!-- </div> -->
        <!-- 広告 -->

        <div class="col-md-12" style="margin-top: 15px;text-align: center;">
          <h1 class="h3 text-danger">
            <?php echo $h1_index; ?>
          </h1>
          <h2 class="h5 text-default">
            <?php echo $h2_index; ?>
          </h2>
        </div>

        <!-- <div class="hidden-xs col-xs-12 col-sm-3 col-md-3" style="margin-top:20px;"> -->
        <div class=" col-xs-12 col-sm-3 col-md-3" style="margin-top:20px;">
         <a href="index.php" class="btn btn-default btn-block btn-lg text-center md h2 ">
         <?php echo $menu_tab1_st;?> <small> (<?php echo $tab_keyword_cnt;?> site )</small>
          </a>
        </div>
        <div class=" col-xs-12 col-sm-3 col-md-3" style="margin-top:20px;">
          <a href="free.php" class="btn btn-danger btn-block btn-lg text-center md h2 ">
          <?php echo $menu_tab2_st;?> (<?php echo $tab_free_cnt;?> site )
          </a>
        </div>
        <div class=" col-xs-12 col-sm-3 col-md-3" style="margin-top:20px;">
         <a href="pay.php" class="btn btn-default btn-block btn-lg text-center md h2 ">
         <?php echo $menu_tab3_st;?><small> (<?php echo $tab_pay_cnt;?> site )</small>
         </a>
        </div>
        <div class=" col-xs-12 col-sm-3 col-md-3" style="margin-top:20px;">
         <a href="all.php" class="btn btn-default btn-block btn-lg text-center md h2 ">
         <?php echo $menu_tab4_st;?><small> (<?php echo $tab_all_cnt;?> site )</small>
         </a>
        </div>

    </div>

    <div class="row">
    
  <!-- アイコン -->
      <div class="row">
          <div class="col-md-12" style="margin-top: 10px;text-align: center;">
              <div>
                <ul class="icon-buttons-howto">
                  アイコン凡例:
                  <span class="glyphicon glyphicon-subtitles" style="color: #955251;">クリエイティブ・コモンズ</span> | 
                  <span class="glyphicon glyphicon-user" style="color: #955251;">人物</span> | 
                  <span class="glyphicon glyphicon-glass" style="color: #955251;">食物</span> | 
                  <span class="glyphicon glyphicon-picture" style="color: #955251;">風景</span> | 
                  <i class="fa fa-paw" style="color: #955251;">動物</i> | 
                  <span class="glyphicon glyphicon-tree-conifer" style="color: #955251;">植物</span> | 
                  <i class="fa fa-university" style="color: #955251;">建物</i>
                </ul>
              </div>
              <div >
                    <ul class="icon-buttons-howto">
                      サムネイル枠判例:
                      <span>□無料サイト</span> | 
                      <span style="color:#955251;">□有料サイト</span> | 
                    </ul>
                  </div>
          </div>
        </div>
      </div>
      <!-- .アイコン -->

      <!-- 無料タブ -->
      <div class="row col-md-12" style="margin-top: 50px;">
        <?php echo $rtn_tab1; ?>
      </div>
      <!-- ページトップへ -->
      <a href="#top" class="btn btn-default pull-right" id="page-top">
        <i class="fa fa-angle-up fa-fw"></i>
      </a>

    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- .wrap -->

        <!-- 広告 -->
        <div class="col-md-12" style="margin-top: 20px;height: 80px;text-align: center;">
          <!-- ＜スポンサーリンク＞ -->
          <?php if (is_mobile()) :?>
          <!-- スマートフォン向けコンテンツ -->
          <?php else: ?>
          <!-- PC向けコンテンツ -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- PhototalもっとビックバナーPC -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:970px;height:90px"
               data-ad-client="ca-pub-6625574146245875"
               data-ad-slot="4098354003"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
          <?php endif; ?>
        </div>
        <!-- 広告 -->

<?php require('footer.php');?>
</body>
</html>
