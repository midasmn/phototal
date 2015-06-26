<?php
require_once("lib/lib.php");
require_once("lib/mysql-ini.php");
// データベースに接続
$db_conn = new mysqli($host, $user, $pass, $dbname)
or die("データベースとの接続に失敗しました");
$db_conn->set_charset('utf8');
// 
$title = "Phototalもっと";
$keywords = "写真素材 ロイヤリティフリー クリエイティブコモンズ	";
$description = "写真素材ポータル";
//
$og_title = $title;
$og_image = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$og_url = "http://phototal.link/index.php";
$og_site_name = $title;
$og_description = $description;
$h1_st = $title;
$h1_st_s = "  ";
$culhtml = "http://phototal.link/";
$crlhtmltitle = "Phototalもっと";
$site_name = "Phototalもっと";
$footer_sitename = "Phototalもっと";
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
$q=$_GET['q'];
$exm_carno=$_GET['exm_carno'];
$exm_itemno=$_GET['exm_itemno'];

$V = $_POST['V'];
if($V=="V")
{
  $exm_carno="";
  $exm_itemno="";
}

if($q&&$exm_carno&&$exm_itemno)
{
  $key_st = '<div id="rtn_div" class="col-md-12" style="margin-top: 10px;">';
  $key_st .= f_get_cul($db_conn,$exm_carno,$exm_itemno,$q);
  $key_st .= '</div>';
}
$rtn_tab1 = f_get_tab_img($db_conn,1,1,"img-responsive img-thumbnail img-responsive-overwrite");
$rtn_tab2 = f_get_tab_img($db_conn,1,1,"img-responsive img-circle img-responsive-overwrite");
?>
<?php require('header.php');?>
<body>
<div id="wrap">
<?php require('menu.php');?>
<!-- ページのコンテンツすべてをwrapする（フッター以外） -->
<script>
function exm(form)
{
  $form = $('#exm-form');
  fd = new FormData($form[0]);
  $('#submit-btn').hide(); //hide submit button
  $('#loading-img').show(); //hide submit button
  $("#rtn_div").html("");
  $.ajax(
    'http://phototal.link/exm.php',
    {
      type: 'post',
      processData: false,
      contentType: false,
      data: fd,
      dataType: "html",
      success: function(data, textStatus){
          //
          $('#submit-btn').show(); //hide submit button
          $('#loading-img').hide(); //hide submit button
          $('#note').hide(); //hide submit button
          $('#rtn_div').html(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert( "ERROR" );
          alert( textStatus );
          alert( errorThrown );
          $('#submit-btn').show(); //hide submit button
          $('#loading-img').hide(); //hide submit button
      }
    });
  return false;
}
</script>

  <div class="container"  style="margin-top: 50px;">
    <div class="row" >
      <!-- nav-tabs -->
      <ul class="nav nav-tabs nav-justified lg col-md-12">
        <li class="active">
        <!-- <li class=""> -->
          <a href="#keyword" data-toggle="tab" class="text-center lg h2 text-success">キーワード検索</a>
        </li>
        <li class="">
          <a href="#free" data-toggle="tab" class="text-center lg h2 text-info">検索なし無料サイト</a>
        </li>
        <li class="">
          <a href="#pay" data-toggle="tab" class="text-center lg h2 text-danger">検索なし有料サイト</a>
        </li>
      </ul>
      <!-- .nav-tabs -->
    </div><!-- .row -->

    <div class="row">
      <!-- .タブ -->
      <div class="tab-content  text-center ">
        <!-- キーワードタブ -->
        <div class="tab-pane active  text-center" id="keyword">
          <!-- 検索窓 -->
          <form  id="exm-form" method="post" name="form"  onSubmit="return exm(this);">
          <div class="bootsnipp-search animate open" style="margin-top: 30px;">
            <div class="container">
                <div class="input-group">
                  <input type="hidden" name="V" value="V">
                  <input type="text" class="form-control" id="q" name="q" value="<?php echo $q; ?>" placeholder="検索キーワードを入力してください">
                    <span class="input-group-btn">
                      <button class="btn btn-danger" type="reset">
                        <span class="glyphicon glyphicon-search"></span>
                      </button>
                    </span>
                </div>
            </div>
          </div>
          </form>
          <!-- .検索窓 -->
          <!-- キーワード結果枠 -->
          <div id="rtn_div" class="col-md-12" style="margin-top: 10px;"></div>
          <!-- .キーワード結果枠 -->
          <?php echo $key_st;?>
          <!-- ページトップへ -->
          <a href="#top" class="btn btn-default pull-right" id="page-top">
            <i class="fa fa-angle-up fa-fw"></i>
          </a>
        </div>
        <!-- .キーワードタブ -->

        <!-- 無料タブ -->
        <div class="tab-pane text-center" id="free" >
          <div class="row col-md-12" style="margin-top: 50px;">
            <?php echo $rtn_tab1; ?>
          </div>
          <!-- ページトップへ -->
          <a href="#top" class="btn btn-default pull-right" id="page-top">
            <i class="fa fa-angle-up fa-fw"></i>
          </a>
        </div>
        <!-- .無料タブ -->

        <!-- 有料タブ -->
        <div class="tab-pane  text-center" id="pay">
          <div class="row col-md-12 " style="margin-top: 50px;">
            <?php echo $rtn_tab2; ?>
          </div>
          <!-- ページトップへ -->
          <a href="#top" class="btn btn-default pull-right" id="page-top">
            <i class="fa fa-angle-up fa-fw"></i>
          </a>
        </div>
        <!-- .有料タブ -->

      </div><!-- .tab -->

    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- .wrap -->
<?php require('footer.php');?>
</body>
</html>
