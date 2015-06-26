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
$title = f_get_tran($db_conn,$language_id,'title');
$keywords = f_get_tran($db_conn,$language_id,'keywords');
$description = f_get_tran($db_conn,$language_id,'description');
$h1_index = f_get_tran($db_conn,$language_id,'h1_index');
$h2_index = f_get_tran($db_conn,$language_id,'h2_index');
$t0 = f_get_item_cnt($db_conn,0);
$t1 = f_get_item_cnt($db_conn,1);
$t2 = f_get_item_cnt($db_conn,2);
$menu_tab1_st = f_get_tran($db_conn,$language_id,'menu_tab1_st');
$menu_tab2_st = f_get_tran($db_conn,$language_id,'menu_tab2_st');
$menu_tab3_st = f_get_tran($db_conn,$language_id,'menu_tab3_st');

$tgcnt = $t0+$t1+$t2;
$description .= '('.date(Y).'-'.date(m).'-'.date(d).':'.$tgcnt.')';
$site_name = f_get_tran($db_conn,$language_id,'site_name');
$site_name .= ' ( '.$tgcnt.' SITE )';
$seek = f_get_tran($db_conn,$language_id,'seek');

// 
// $title = "フォトもっと";
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
//アクティブメニュー
$q=$_GET['q'];
$exm_carno=$_GET['exm_carno'];
$exm_itemno=$_GET['exm_itemno'];

$V=$_GET['V'];
if($V=="V")
{
  if($exm_carno>0){}else{$exm_carno = 0;}
  if($exm_itemno>0){}else{$exm_itemno = 99;}
}
if($q)
{
  $key_st = '<div id="rtn_div" class="col-md-12" style="margin-top: 10px;">';
  // カルーセル取得
  $key_st .= f_get_cul($db_conn,$exm_carno,$exm_itemno,$q,$language_id);
    
  //検索結果処理
  $key_st .= f_get_keyword_search($db_conn,$exm_itemno,$q,$language_id);
  $key_st .= '</div>';
}
// 登録数
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

        <div class="col-md-12" style="margin-top: 15px;text-align: center;">
          <h1 class="h3 text-danger">
            <?php echo $h1_index; ?>
          </h1>
          <h2 class="h5 text-default">
            <?php echo $h2_index; ?>
          </h2>
        </div>

        <!-- 広告 -->
        <div class="col-md-12" style="margin-top: 20px;height: 80px;text-align: center;">
          <!-- ＜スポンサーリンク＞ -->
          <?php if (is_mobile()) :?>
          <!-- スマートフォン向けコンテンツ -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- フォトもっとレスポンシブ -->
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-6625574146245875"
               data-ad-slot="8947356006"
               data-ad-format="auto"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
          <?php else: ?>
          <!-- PC向けコンテンツ -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- フォトもっとビックバナーPC -->
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

        <div class="hidden-xs col-xs-12 col-sm-4 col-md-4" style="margin-top:20px;">
          <a href="index.php" class="btn btn-danger btn-block btn-lg text-center md h2 ">
          <?php echo $menu_tab1_st;?> (<?php echo $tab_keyword_cnt;?> site )
          </a>
        </div>
        <div class="hidden-xs col-xs-12 col-sm-4 col-md-4" style="margin-top:20px;">
          <a href="free.php" class="btn btn-default btn-block btn-lg text-center md h2 ">
          <?php echo $menu_tab2_st;?><small> (<?php echo $tab_free_cnt;?> site )</small>
          </a>
        </div>
        <div class="hidden-xs col-xs-12 col-sm-4 col-md-4" style="margin-top:20px;">
          <a href="pay.php" class="btn btn-default btn-block btn-lg text-center md h2 ">
          <?php echo $menu_tab3_st;?><small> (<?php echo $tab_pay_cnt;?> site )</small>
          </a>
        </div>

    </div><!-- .row -->

    <div class="row">
      <!-- .タブ -->
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
                      <i class="fa fa-circle-thin">有料サイト</i> | 
                    </ul>
                  </div>
              </div>
            </div>
          </div>
          <!-- .アイコン -->

        <!-- キーワードタブ -->
          <!-- 検索窓 -->
          <!-- <form  id="exm-form" method="get" name="form"  onSubmit="return exm(this);"> -->
         
          <div class="bootsnipp-search animate open" style="margin-top: 30px;">
            <div class="container">
              <form  id="exm-form" method="get" name="form" acticon="index.php">
                <div class="input-group">
                  <input type="hidden" name="exm_carno" value="<?php echo $exm_carno; ?>">
                  <input type="hidden" name="exm_itemno" value="<?php echo $exm_itemno; ?>">
                  <input type="hidden" name="V" value="V">
                  <input type="text" class="form-control" id="q" name="q" value="<?php echo $q; ?>" placeholder="<?php echo $seek;?>">
                    <span class="input-group-btn">
                      <button class="btn btn-danger" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                </div>
              </form>  
            </div>
          </div>
          <!-- .検索窓 -->

          <!-- キーワード結果枠 -->
          <div id="rtn_div" class="col-md-12" style="margin-top: 10px;text-align: center;">
          <!-- .キーワード結果枠 -->
          <?php echo $key_st;?>
          </div>


          <?php
          if($key_st)
          {

          }else
          {
          ?>
          <!-- 使いかた -->
          <div id="howto" class="hidden-xs col-md-12" style="margin-top: 10px;text-align: center;">
            <h2 class="h3">フォトもっとの使いかた</h2>
            <div class="row" style="margin-top: 20px;">
              <div class="col-xs-12 col-sm-4" >
                <ul>
                  <li class="image"><img class="img-responsive img-thumbnail img-responsive-overwrite" alt="キーワード検索" src="/img/howto1.png" /></li>
                  <li class="title">キーワード検索</li>
                  <li class="text">人気順に10件表示します。</li>
                </ul>
              </div>
              <div class="col-xs-12 col-sm-4">
                <ul>
                  <li class="image"><img class="img-responsive img-thumbnail img-responsive-overwrite" alt="サイト選択後再検索" src="/img/howto2.png" /></li>
                  <li class="title">カルーセルからサイトを選択します。</li>
                  <li class="text">キーワードはそのまま検索します。</li>
                </ul>
              </div>
              <div class="col-xs-12 col-sm-4">
                <ul>
                  <li class="image"><img class="img-responsive img-thumbnail img-responsive-overwrite" alt="サイトパネル抽出" src="/img/howto3.png" /></li>
                  <li class="title">写真素材サイトパネルから選択</li>
                  <li class="text">写真素材サイトのページが開きます。</li>
                </ul>
              </div>
            </div>
            
          </div>
          <?php
          }
          ?>
          <!-- ページトップへ -->
          <a href="#top" class="btn btn-default pull-right" id="page-top">
            <i class="fa fa-angle-up fa-fw"></i>
          </a>
        </div>
        <!-- .キーワードタブ -->

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
          <!-- フォトもっとビックバナーPC -->
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
