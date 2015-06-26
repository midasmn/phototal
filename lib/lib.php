<?php
require 'lib/simple_html_dom.php';

// モバイル判定
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
// タブデータ読み込み
// img-responsive
// img-responsive img-circle
function f_get_tab_img($db_conn,$payflg,$tabno,$img_class)
{
  if($payflg==99&&$tabno==99)
  {
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay` ,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite`  order by `disporder` desc ,`id` asc";
  }else{
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay` ,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite` WHERE `tab`=$tabno order by `disporder` desc ,`id` asc";
  }
  // echo $sql;
  $result = @mysqli_query($db_conn,$sql);
  if($result)
  {
    $rtn_st = "";
    $index=0;
    $max=7;
    while($link = mysqli_fetch_row($result))
    {
      list($id,$url,$name,$description,$pay,$cc0,$person,$food,$landscape,$animal,$plant,$building) = $link;
      // タイトル
      $name_str = mb_strimwidth( $name, 0, 18, "...", "UTF-8" );
      $description_str = mb_strimwidth( $description, 0, 80, "...", "UTF-8" );
      // タブ用画像パス
      $img_path = "/img/tab/".$id.".png";
      if ( file_exists( "img/tab/".$id.".png" )) 
      {} else 
      {
        $img_path = "/img/tab/now.png";
      }
      // カテゴリーカラー
      $cc0_on="";
      $person_on="";
      $food_on="";
      $landscape_on="";
      $animal_on="";
      $plant_on="";
      $building_on="";
      if($cc0==1){$cc0_on='style="color: #955251;"';}
      if($person==1){$person_on='style="color: #777777;"';}
      if($food==1){$food_on='style="color: #777777;"';}
      if($landscape==1){$landscape_on='style="color: #777777;"';}
      if($animal==1){$animal_on='style="color: #777777;"';}
      if($plant==1){$plant_on='style="color: #777777;"';}
      if($building==1){$building_on='style="color: #777777;"';}

      if($pay==1)
      {
        $img_class = "img-responsive img-circle img-responsive-overwrite";
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite" ;
        $img_style = 'style ="border: 3px #955251 solid;"';
      }else{
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite";
        $img_style = '';
      }
      // 
      $url = 'exm.php?id='.$id.'&url='.$url;
      // 
      // $rtn_st .= '<div class="col-md-2 col-sm-6 col-xs-12 text-center" style="margin-top:60px;">';
      $rtn_st .='<div class="col-md-2 col-sm-6 col-xs-12" >';//col-md-2
      $rtn_st .= '<div>';
      $rtn_st .= '<a href="'.$url.'" target="_blank">';
      $rtn_st .= '<img class="'.$img_class.'" src="'.$img_path.'" alt="'.$name.'" '.$img_style.'/></a>';
      $rtn_st .= '</div>';
      $rtn_st .= '<div>';
      $rtn_st .= '<p><a href="'.$url.'" target="_blank">'.$name_str.'</a></p>';
      $rtn_st .= '</div>';

      $rtn_st .= '<div>';
      $rtn_st .= '<ul class="icon-buttons">';
      $rtn_st .= '<span class="glyphicon glyphicon-subtitles" '.$cc0_on.'></span>';//CC0
      $rtn_st .= '<span class="glyphicon glyphicon-user" '.$person_on.'></span>';//人物
      $rtn_st .= '<span class="glyphicon glyphicon-glass" '.$food_on.'></span>'; //食物
      $rtn_st .= '<span class="glyphicon glyphicon-picture" '.$landscape_on.'></span>'; //風景
      $rtn_st .= '<i class="fa fa-paw" '.$animal_on.'></i>'; //動物
      $rtn_st .= '<span class="glyphicon glyphicon-tree-conifer" '.$plant_on.'></span>'; //動物
      $rtn_st .= '<i class="fa fa-university" '.$building_on.'></i>'; //建物
      $rtn_st .= '</ul>';
      $rtn_st .= '</div>';
      $rtn_st .= '</div>';
    }
    return $rtn_st;
  }else{
    return "f_get_tab_img_NG";
  }
}
/////////////////////////////////////////////////////////////////////////////
function f_get_cul($db_conn,$exm_carno,$exm_itemno,$q,$language_id)
{
  // mysql_set_charset('utf8'); // ←変更
  $rtn_st = "";
  if (is_mobile())
  {
    $exm_cnt = 1;
  }else{
    $exm_cnt = 6;
  }
  
  $sql = "SELECT `id`, `url`, `name`, `description`,`pay`,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite` WHERE `tab`= 0 order by `disporder` desc ,`id` asc";
  $result = @mysqli_query($db_conn,$sql);
  if($result)
  {
    //  <!--カルーセﾙ本体-->
    $rtn_st .= '<div id="Carousel" class="carousel slide col-md-12">';
    $numrows = mysqli_num_rows($result); 
    $exm_numrows = ceil($numrows / $exm_cnt); // 切り上げ
    // <!-- カルーセルページャ -->
    $rtn_st .= '<ol class="hidden-xs carousel-indicators">';// <!--carousel-inner-->
    for ($i=0;$i<=$exm_numrows;$i++) 
    { 
      if($exm_carno==$i){$class_active = ' class="active"';}else{$class_active = '';}
      $rtn_st .= '<li data-target="#Carousel" data-slide-to="'.$i.'" '.$class_active.'></li>';
    }
    $rtn_st .= '</ol>';
    // <!-- .カルーセルページャ --> 
    // <!-- carousel-inner -->
    $rtn_st .= '<div class="carousel-inner">';
    $r=1;
    $ii=0;//active判定用
    while($link = mysqli_fetch_row($result))
    {
      list($id,$url,$name,$description,$pay,$cc0,$person,$food,$landscape,$animal,$plant,$building) = $link;
      // タイトル
      $name_str = mb_strimwidth( $name, 0, 18, "...", "UTF-8" );
      // タブ用画像パス
       $img_path = "/img/tab/".$id.".png";
      if ( file_exists( "img/tab/".$id.".png" )) 
      {} else 
      {
        $img_path = "/img/tab/now.png";
      }
      // 
      if($id==$exm_itemno)
      {
          $exm_name = $name;
          $exm_url = $url;
          $bk_col = '"background-color:#f5f5f5;"';
      }else{
        $bk_col = '"background-color:#f0f0f0;"';
      }
      // カテゴリーカラー
      $cc0_on="";
      $person_on="";
      $food_on="";
      $landscape_on="";
      $animal_on="";
      $plant_on="";
      $building_on="";
      if($cc0==1){$cc0_on='style="color: #955251;"';}
      if($person==1){$person_on='style="color: #777777;"';}
      if($food==1){$food_on='style="color: #777777;"';}
      if($landscape==1){$landscape_on='style="color: #777777;"';}
      if($animal==1){$animal_on='style="color: #777777;"';}
      if($plant==1){$plant_on='style="color: #777777;"';}
      if($building==1){$building_on='style="color: #777777;"';}
      // 1件目
      if($r==1)
      {
        $exm_ii = ceil($ii / $exm_cnt); // 切り上げ
        if($exm_carno==$exm_ii){$active="active";}else{$active="";}//アクティブ
        // カルーセル
        $rtn_st .='<div class=" item '.$active.'">';//item
      }
      if($pay==1)
      {
        $img_class = "img-responsive img-circle img-responsive-overwrite";
      }else{
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite";
      }
      // アイテム
      $rtn_st .='<div class="col-md-2 col-sm-6 col-xs-12" >';//col-md-2
      $rtn_st .='<a href="index.php?exm_carno='.$exm_ii.'&exm_itemno='.$id.'&q='.$q.'" class="thumbnail">';
      // $rtn_st .='<img src="'.$img_path.'" alt="'.$name.'" style="max-width:100%;'.$bk_col.'">';

      // 
      $rtn_st .='<img class="'.$img_class.'" src="'.$img_path.'" alt="'.$name.'" style="max-width:100%;'.$bk_col.'">';

      
      $rtn_st .='<div class="carousel-captionR">';//caption
      $rtn_st .='<h3 class="h5">'.$name_str.'</h3>';
      $rtn_st .='</div>';//.caption
      // カテゴリアイコン
      $rtn_st .= '<div>';
      $rtn_st .= '<ul class="icon-buttons">';
      $rtn_st .= '<span class="glyphicon glyphicon-subtitles" '.$cc0_on.'></span>';//CC0
      $rtn_st .= '<span class="glyphicon glyphicon-user" '.$person_on.'></span>';//人物
      $rtn_st .= '<span class="glyphicon glyphicon-glass" '.$food_on.'></span>'; //食物
      $rtn_st .= '<span class="glyphicon glyphicon-picture" '.$landscape_on.'></span>'; //風景
      $rtn_st .= '<i class="fa fa-paw" '.$animal_on.'></i>'; //動物
      $rtn_st .= '<span class="glyphicon glyphicon-tree-conifer" '.$plant_on.'></span>'; //動物
      $rtn_st .= '<i class="fa fa-university" '.$building_on.'></i>'; //建物
      $rtn_st .= '</ul>';
      $rtn_st .= '</div>';
      // .カテゴリアイコン
      $rtn_st .='</a>';
      $rtn_st .='</div>';//.col-md-2

      // .アイテム
      if($r==$exm_cnt)
      {
        $rtn_st .='</div>';//.item
        $r=1;
      }else{
        $r++;
      }
      $ii++;
    }
    if($r==1){}else{$rtn_st .='</div>';}//.item}
    $rtn_st .='</div>';// <!--.carousel-inner-->
    $rtn_st .='<a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>';
    $rtn_st .='<a data-slide="next" href="#Carousel" class="right carousel-control">›</a>';
    // <!--.carousel-inner-->

    // $rtn_st .='</div>';
    $rtn_st .='</div>';// <!--.カルーセﾙ本体-->
  }else{
      $rtn_st .= "ZERO";
  }

  
  $result = f_get_tran($db_conn,$language_id,'result');

  // 結果ヘッダー
  $rtn_st .= '<div class="row">';
  $rtn_st .='<div class="col-md-12">';
  $rtn_st .= '<hr>';
  $rtn_st .= '<h2 style="color:white;">[<a class="" style="color:white;" href="'.$exm_url.'" target="_blank">'.$exm_name.'</a>]<br>'.$result.'</h2>';
  $rtn_st .= '<hr>';
  $rtn_st .='</div>';//.col-md-12
  $rtn_st .='</div>';//.row

  return $rtn_st;
}
//////////////////////////////////////
// キーワード検索
//////////////////////////////////////
function f_get_keyword_search($db_conn,$exm_itemno,$q,$language_id)
{
  // キーワード記録
  f_insert_keyword($db_conn,$exm_itemno,$q);
  // 人気
  $dispordercnt = f_get_disporder($db_conn,$exm_itemno);
  f_update_disporder($db_conn,$exm_itemno,$dispordercnt+1);

  $sql = "SELECT `id`, `url`, `name`, `description`,`exm_url_q`, `img_tag`, `base_add_flg`, `exm_url_base` FROM `tbl_imagesite` WHERE `id`=$exm_itemno limit 1";
  $result = @mysqli_query($db_conn,$sql);
  if($result)
  {
    $entry_st = '<div class="row" style="margin-top:10px;">';//row
    while($link = mysqli_fetch_row($result))
    {
      list($id,$url,$name,$description,$exm_url_q,$img_tag,$base_add_flg,$exm_url_base) = $link;
      // スクレピピンパス
      if($id==136)//ペイレス
      {
        $keyword_st = mb_convert_encoding($q, "UTF-8","euc-jp");
        $exm_url_q .= $keyword_st;
      }
      if($id==58)
      {
        $keyword_st = mb_convert_encoding($q, "UTF-8","SJIS");
        $exm_url_q .= $keyword_st;
      }elseif($id==43)
      {
        $keyword_st = urlencode($q);
        $exm_url_q .= $keyword_st;
      }elseif($id==95)
      {
        $keyword_st = urlencode($q);
        $exm_url_q .= $keyword_st;
        $exm_url_q .= "/sort/relevance/desc";
      }elseif($id==104)//あまな
      {
        $keyword_st = mb_convert_encoding($q, "SJIS","auto");
        $keyword_st = urlencode($keyword_st);
        $exm_url_q .= $keyword_st;
      }else{
        $keyword_st = urlencode($q);
        $exm_url_q .= $keyword_st;
      }
      // スクレイピングメイン
      $entry_st .= f_get_img_list($db_conn,$id,$exm_url_q,$img_tag,$base_add_flg,$exm_url_base,$q,$language_id,$name);
      // .スクレイピングメイン
    }
    $entry_st .= '</div>';//.row
  }else{
    $entry_st = 'ZERO';
  }
  return $entry_st;
}
// 他サイトキーワード検索スクレイピング
function f_rtn_img($exm_url_q,$img_tag)
{
  $rtn = array();
  // 画像取得
  $html = file_get_html($exm_url_q);
  echo "<!--   ".$exm_url_q."-->";

  if(!$html)
  {
    echo "<!-- file_get_html_NG -->";
    return "NG";
  }
  //  //
  $img_cnt=0;
  //img
  foreach ($html->find($img_tag) as $element)
  {
    $rtn['img'][$img_cnt]= $element->src; 
    $img_cnt++;
  }
  $rtn_imgs = $rtn;
  //
  $html->clear();
  unset($rtn);
  return $rtn_imgs;
}

// 検索で画像パスとれないやつ
function f_rtnR_img($id,$exm_url_q,$img_tag,$base_add_flg,$exm_url_base)
{
  $encode = 'utf-8';

  $dummy_jpg = 'img/dummy.jpg';

  if($id==104) //104=あまな
  {
    $encode = 'SJIS';
    $err_st = 'エラーメッセージ';
    $err_st = mb_convert_encoding($err_st, $encode, 'auto');
  }
  // 結果取得
echo "<!--   ".$exm_url_q."-->";
  $buf = file_get_contents($exm_url_q);
  $buf = mb_convert_encoding($buf, $encode, 'auto');

  // ゼロ件判定
  $err_pos = mb_strpos($buf,$err_st , 1,$encode);
  if($err_pos>0)
  {
    return "NG";
  }


  $rtn_next_pos = 0;
  $rtn = array();
  $img_cnt=0;
  for ($img_cnt=0; $img_cnt <=9 ; $img_cnt++) 
  { 
    $rtn_itm = f_cut_html_parse($buf,$rtn_next_pos,$img_tag,$base_add_flg, $encode);
    $info = pathinfo($rtn_itm);
    $exm_info = $info['extension'];
// echo "<br>".$exm_info;
    if($exm_info=="jpg")
    {
      $rtn['img'][$img_cnt]=$exm_url_base.$rtn_itm;
      $rtn_next_pos = f_cut_html_parse_pos($buf,$rtn_next_pos+10,$img_tag,$base_add_flg,$encode);
    }else{
      if($img_cnt<1){
        return "NG";
      }
    }
  }
  // $rtn_imgs = $rtn;
  $cnt = count($rtn['img']);
  if($cnt<1)
  {
    return "NG";
  }else{
    return $rtn;
  }
}

// 他サイト画像一覧作成
function f_get_img_list($db_conn,$id,$exm_url_q,$img_tag,$base_add_flg,$exm_url_base,$q,$language_id,$exm_name)
{
  $result_notice = f_get_tran($db_conn,$language_id,'result_notice');
  // スポンサー枠
  $st_ad = f_get_ad(is_mobile());
  

  $rtn_st = "";
  if($id==104)//検索が効かないやつあまな
  {
    $res = f_rtnR_img($id,$exm_url_q,$img_tag,$base_add_flg,$exm_url_base);
    if($res=="NG")
    {
      // $rtn_st .= "お探しの条件に該当する写真素材は見つかりませんでした。";
      $rtn_st .= $result_notice;
      $rtn_st .= $st_ad;

      return $rtn_st;
    }
  }elseif($id==114)//アフロPOST
  {
    $res = f_rtn_img_POST($id,$exm_url_q,$img_tag,$q);
  }
  else{
    $res = f_rtn_img($exm_url_q,$img_tag);
  }
  
  // 
  if($res=="NG")
  {
    // $rtn_st .= "f_rtn_img_NG";
    // $rtn_st .= "お探しの条件に該当する写真素材は見つかりませんでした。";
    $rtn_st .= $result_notice;
    $rtn_st .= $st_ad;
    return $rtn_st;
  }else
  {
    $cnt = count($res['img']);
    if($cnt>0)
    {
      $i = 0;
      $listcnt = 1;
      // while ($i<=$cnt) 
      while ($i<10) //10枚
      {
        if(strlen($res['img'][$i])<10||$res['img'][$i]=='/assets/img/next_1.gif')
        {
        }else
        { 
          if($listcnt==1)
          {
            $rtn_st .= '<div class="row" style="margin-top:30px;">';//row
            $rtn_st .= '<div class="col-md-1"></div>';//col-mod-1
          }
          // 
          $rtn_st .= '<div class="col-md-2">';
          // fotoliaアフィリエイト追加
          if($id==99)
          {
            //
            $fotolia_afcode = '&utm_source=200575099&utm_medium=affiliation&utm_content=200575099&tmad=c&tmcampid=8&tmplaceref=200575099';
            $exm_url_q .= $fotolia_afcode;
          }
          $rtn_st .= '<a href="'.$exm_url_q.'" target="_blank">';
          // 
          if($base_add_flg=="ON")
          {
            if($exm_url_base=='http://photosku.com')//photosku
            {
              $rtn_st .= '<img class="img-responsive img-thumbnail" src="'.$exm_url_base.'/'.$res['img'][$i].'"/>';
            }else{
              $rtn_st .= '<img class="img-responsive img-thumbnail" src="'.$exm_url_base.$res['img'][$i].'"/>';
            }
          }else{
            $rtn_st .= '<img class="img-responsive img-thumbnail" src="'.$res['img'][$i].'"/>';
          }
          $rtn_st .= '</a>';
          $rtn_st .= '</div>';
          // 
          if($listcnt==5)
          {
            $rtn_st .= '<div class="col-md-1"></div>';//col-mod-1
            $rtn_st .= '</div>';//row
            $listcnt=1;
          }else{
            $listcnt++;
          }
        }
        $i++;
      }
      if($cnt<10)//10個以下
      {
        $rtn_st .= '<div class="col-md-1"></div>';//col-mod-1
        $rtn_st .= '</div>';//row
      }
      // もっとみる
      $rtn_st .= '<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px;">';
      $rtn_st .= '<a href="'.$exm_url_q.'" target="_blank" class="btn btn-info btn-block btn-lg">';
      // $rtn_st .= '<span class="glyphicon glyphicon-new-window"></span> ['.$exm_name.'] の画像をもっと見る ＞＞';
      if($language_id)
      {
        $more = f_get_tran($db_conn,$language_id,'more');
      }
      // $rtn_st .= '<span class="glyphicon glyphicon-new-window"></span> ['.$exm_name.'] '.$more.' ＞＞';
      $rtn_st .= '<span class="glyphicon "></span> ['.$exm_name.'] '.$more.' ＞＞';
      $rtn_st .= '</a>';
      $rtn_st .= '</div>';
    }else
    {
      // $rtn_st .= "お探しの条件に該当する写真素材は見つかりませんでした。";
      $rtn_st .= $result_notice;
      $rtn_st .= $st_ad;
    }
  }
  return $rtn_st;
}
// 登録件数
function f_get_item_cnt($db_conn,$tabno)
{
  $aryname = array();
  if($tabno==99)
  {
    $strSQL = "SELECT `id`, count('id') FROM `tbl_imagesite`";
  }else{
    $strSQL = "SELECT `id`, count('id') FROM `tbl_imagesite` WHERE `tab`=$tabno";
  }
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
    $name = $value;
  }
     return $name;
}
//////////////////////////////////////////////////////
////　HTML分割　
/////////////////////////////////////////////////////
function f_cut_html_parse($buf,$start_pos,$start_st,$end_st,$encode)
{
  $start_st_len = mb_strlen($start_st,$encode);//スタート検索文字列長
  $end_st_len = mb_strlen($end_st,$encode);//エンド検索文字列長
  $seekStartPos = mb_strpos($buf,$start_st, $start_pos,$encode);//スタート位置検索
  $end_start_pos = $seekStartPos + $start_st_len;//エンドスタート
  $seekEndPos = mb_strpos($buf,$end_st, $end_start_pos,$encode);//スタート位置検索
  $rtn_st = mb_substr($buf,$seekStartPos+$start_st_len,$seekEndPos-$seekStartPos-$start_st_len,$encode);
// echo "<br>rtn_st".$rtn_st;
  return $rtn_st;
}
//////////////////////////////////////////////////////
////　HTML分割　スタート位置
/////////////////////////////////////////////////////
function f_cut_html_parse_pos($buf,$start_pos,$start_st,$end_st,$encode)
{
  $start_st_len = mb_strlen($start_st,$encode);//スタート検索文字列長
  $end_st_len = mb_strlen($end_st,$encode);//エンド検索文字列長
  $seekStartPos = mb_strpos($buf,$start_st, $start_pos,$encode);//スタート位置検索
  $end_start_pos = $seekStartPos + $start_st_len;//エンドスタート
  $seekEndPos = mb_strpos($buf,$end_st, $end_start_pos,$encode);//スタート位置検索
  return $seekEndPos+$end_st_len;
}

// POST
function f_rtn_img_POST($id,$exm_url_q,$img_tag,$q)
{
  $rtn = array();
  switch ($id) 
  {
    case 114: //アフロ
      $keyword_st = mb_convert_encoding($q, "SJIS","auto");
      $keyword_st = urlencode($keyword_st);
      //POSTデータ
      $data = array(
      's_keywords_last' => $keyword_st,
      'ac_type' => 'cr',
      's_genru' => 'creative',
      's_page' => 0,
      'search_ext' => 0,
      's_keywords_ext' => '&quot;'.$keyword_st.'&quot;',
      's_conjunction_last' => 'AND',
      's_conjunction' => 'AND'
      );
      break;
                             
    default:
      # code...
      break;
  }

  $data = http_build_query($data, '', '&');
  //header
  $header = array(
  'Content-Type: application/x-www-form-urlencoded',
  'Content-Length: '.strlen($data)
  );
  $context = array(
    'http'=> array(
    'method'=> 'POST',
    'header'=> implode("\r\n", $header),
    'content'=> $data
    )
  );
  $url ='http://www.aflo.com/s/Search/search';
  // $url ='http://www.aflo.com';
  // echo file_get_contents($url, false, stream_context_create($context));

  $html = file_get_html($url, false, stream_context_create($context));
  // echo "<br><br>".$html;

  // // 画像取得
  // $html = file_get_html($exm_url_q);
  // echo "<!--   ".$exm_url_q."-->";

  if(!$html)
  {
    echo "<!-- file_get_html_NG -->";
    return "NG";
  }
  //  //
  $img_cnt=0;
  //img
  foreach ($html->find($img_tag) as $element)
  {
    $rtn['img'][$img_cnt]= $element->src; 
    $img_cnt++;
  }
  $rtn_imgs = $rtn;
  //
  $html->clear();
  unset($rtn);
  return $rtn_imgs;
}
//多言語
function f_get_tran($db_conn,$language_id,$item)
{
  $aryname = array();
  $strSQL = "SELECT `item`, `content` FROM `tbl_language` WHERE `langid`=$language_id AND `item`= '$item'";
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
    $content = $value;
  }
     return $content;
}

function f_get_ad($is_mobile)
{
  // スポンサー枠
  $st_ad = '';
  $st_ad .= '<div class="col-md-12" style="margin-top: 20px;text-align: center;">';
  $st_ad .= '<p class="text-left">＜スポンサーリンク＞</p>';
  if ($is_mobile)
  {
      // ピクスタ
      $st_ad .= '<div class="col-xs-12" style="margin-top: 20px;text-align: center;">';
      $st_ad .= '<a href="http://px.a8.net/svt/ejp?a8mat=2BYMF0+AKG46Y+2NLY+69WPT" target="_blank">';
      $st_ad .= '<img border="0" width="300" height="250" alt="" src="http://www29.a8.net/svt/bgt?aid=141023484639&wid=006&eno=01&mid=s00000012391001054000&mc=1"></a>';
      $st_ad .= '<img border="0" width="1" height="1" src="http://www13.a8.net/0.gif?a8mat=2BYMF0+AKG46Y+2NLY+69WPT" alt="">';
      $st_ad .= '</div>';
      // シャッターストック
      $st_ad .= '<div class="col-xs-12" style="margin-top: 20px;text-align: center;">';
      $st_ad .= '<a href="http://px.a8.net/svt/ejp?a8mat=2HM4FX+FUYTRU+33D6+6CWQP" target="_blank">';
      $st_ad .= '<img border="0" width="300" height="250" alt="" src="http://www24.a8.net/svt/bgt?aid=150518013959&wid=006&eno=01&mid=s00000014433001068000&mc=1"></a>';
      $st_ad .= '<img border="0" width="1" height="1" src="http://www14.a8.net/0.gif?a8mat=2HM4FX+FUYTRU+33D6+6CWQP" alt="">';
      $st_ad .= '</div>';
  }else{
      // ピクスタ
      $st_ad .= '<div class="col-md-4" style="margin-top: 20px;text-align: center;">';
      $st_ad .= '<a href="http://px.a8.net/svt/ejp?a8mat=2BYMF0+AKG46Y+2NLY+69WPT" target="_blank">';
      $st_ad .= '<img border="0" width="300" height="250" alt="" src="http://www29.a8.net/svt/bgt?aid=141023484639&wid=006&eno=01&mid=s00000012391001054000&mc=1"></a>';
      $st_ad .= '<img border="0" width="1" height="1" src="http://www13.a8.net/0.gif?a8mat=2BYMF0+AKG46Y+2NLY+69WPT" alt="">';$st_ad .= '</div>';
      // シャッターストック
      $st_ad .= '<div class="col-xs-4" style="margin-top: 20px;text-align: center;">';
      $st_ad .= '<a href="http://px.a8.net/svt/ejp?a8mat=2HM4FX+FUYTRU+33D6+6CWQP" target="_blank">';
      $st_ad .= '<img border="0" width="300" height="250" alt="" src="http://www24.a8.net/svt/bgt?aid=150518013959&wid=006&eno=01&mid=s00000014433001068000&mc=1"></a>';
      $st_ad .= '<img border="0" width="1" height="1" src="http://www14.a8.net/0.gif?a8mat=2HM4FX+FUYTRU+33D6+6CWQP" alt="">';
      $st_ad .= '</div>';  
  }
  $st_ad .= '</div>';
  // .スポンサー枠
  return $st_ad;
}
// キワード記録
function f_insert_keyword($db_conn,$id,$keyword)
{
  $sql = "INSERT INTO `tbl_keyword` (`id`, `keyword`) VALUES ('$id','$keyword')";
  $result = mysqli_query( $db_conn,$sql);
  if(!$result)
  {
    $rtn = "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}
//カウント取得
function f_get_disporder($db_conn,$id)
{
  $aryname = array();
  $strSQL = "SELECT `id`, `disporder` FROM `tbl_imagesite` WHERE `id` = '$id'";
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
//カウントインサート
function f_update_disporder($db_conn,$id,$disporder)
{
  $sql = "UPDATE  `tbl_imagesite` set `disporder` = $disporder where `id` = $id;";
  $result = mysqli_query($db_conn,$sql);
  if(!$result)
  {
    $rtn = "NG";
  }else{
    $rtn = "OK";
  }
  return $rtn;
}
// 
// 
/////////////////////////////////////////////////////////////////////////////
// function f_get_if_cul($db_conn,$tab,$cid,$html_page)
/////////////////////////////////////////////////////////////////////////////
function f_get_if_cul($db_conn,$exm_carno,$exm_itemno,$tab,$html_page)
{
  // mysql_set_charset('utf8'); // ←変更
  $rtn_st = "";
  if (is_mobile())
  {
    $exm_cnt = 1;
  }else{
    $exm_cnt = 6;
  }
  // all処理追加
  if($tab==99)
  {
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay`,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite`  order by `disporder` desc ,`id` asc";
  }else{
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay`,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite` WHERE `tab`= $tab order by `disporder` desc ,`id` asc";
  }
  $result = @mysqli_query($db_conn,$sql);
  if($result)
  {
    //  <!--カルーセﾙ本体-->
    $rtn_st .= '<div id="Carousel" class="carousel slide col-md-12">';
    $numrows = mysqli_num_rows($result); 
    $exm_numrows = ceil($numrows / $exm_cnt); // 切り上げ
    // <!-- カルーセルページャ -->
    $rtn_st .= '<ol class="hidden-xs carousel-indicators">';// <!--carousel-inner-->
    for ($i=0;$i<=$exm_numrows;$i++) 
    { 
      if($exm_carno==$i){$class_active = ' class="active"';}else{$class_active = '';}
      $rtn_st .= '<li data-target="#Carousel" data-slide-to="'.$i.'" '.$class_active.'></li>';
    }
    $rtn_st .= '</ol>';
    // <!-- .カルーセルページャ --> 
    // <!-- carousel-inner -->
    $rtn_st .= '<div class="carousel-inner">';
    $r=1;
    $ii=0;//active判定用
    while($link = mysqli_fetch_row($result))
    {
      list($id,$url,$name,$description,$pay,$cc0,$person,$food,$landscape,$animal,$plant,$building) = $link;
      // タイトル
      $name_str = mb_strimwidth( $name, 0, 18, "...", "UTF-8" );
      // タブ用画像パス
      $img_path = "/img/tab/".$id.".png";
      // 
      if($id==$exm_itemno)
      {
          $exm_name = $name;
          $exm_url = $url;
          $bk_col = '"background-color:#f5f5f5;"';
          // カウント
          $disporder = f_get_disporder($db_conn,$exm_itemno);
          f_update_disporder($db_conn,$exm_itemno,$disporder+1);
      }else{
        $bk_col = '"background-color:#f0f0f0;"';
      }
      // カテゴリーカラー
      $cc0_on="";
      $person_on="";
      $food_on="";
      $landscape_on="";
      $animal_on="";
      $plant_on="";
      $building_on="";
      if($cc0==1){$cc0_on='style="color: #955251;"';}
      if($person==1){$person_on='style="color: #777777;"';}
      if($food==1){$food_on='style="color: #777777;"';}
      if($landscape==1){$landscape_on='style="color: #777777;"';}
      if($animal==1){$animal_on='style="color: #777777;"';}
      if($plant==1){$plant_on='style="color: #777777;"';}
      if($building==1){$building_on='style="color: #777777;"';}
      // 1件目
      if($r==1)
      {
        $exm_ii = ceil($ii / $exm_cnt); // 切り上げ
        if($exm_carno==$exm_ii){$active="active";}else{$active="";}//アクティブ
        // カルーセル
        $rtn_st .='<div class=" item '.$active.'">';//item
      }
      if($pay==1)
      {
        $img_class = "img-responsive img-circle img-responsive-overwrite";
      }else{
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite";
      }
      // アイテム
      $rtn_st .='<div class="col-md-2 col-sm-6 col-xs-12" >';//col-md-2
      $rtn_st .='<a href="'.$html_page.'?exm_carno='.$exm_ii.'&exm_itemno='.$id.'&q='.$q.'" class="thumbnail">';
      // $rtn_st .='<img src="'.$img_path.'" alt="'.$name.'" style="max-width:100%;'.$bk_col.'">';

      // 
      $rtn_st .='<img class="'.$img_class.'" src="'.$img_path.'" alt="'.$name.'" style="max-width:100%;'.$bk_col.'">';

      $rtn_st .='<div class="carousel-captionR" style="text-align: center;">';//caption
      $rtn_st .='<h3 class="h5">'.$name_str.'</h3>';
      $rtn_st .='</div>';//.caption
      // カテゴリアイコン
      $rtn_st .= '<div  style="text-align: center;">';
      $rtn_st .= '<ul class="icon-buttons">';
      $rtn_st .= '<span class="glyphicon glyphicon-subtitles" '.$cc0_on.'></span>';//CC0
      $rtn_st .= '<span class="glyphicon glyphicon-user" '.$person_on.'></span>';//人物
      $rtn_st .= '<span class="glyphicon glyphicon-glass" '.$food_on.'></span>'; //食物
      $rtn_st .= '<span class="glyphicon glyphicon-picture" '.$landscape_on.'></span>'; //風景
      $rtn_st .= '<i class="fa fa-paw" '.$animal_on.'></i>'; //動物
      $rtn_st .= '<span class="glyphicon glyphicon-tree-conifer" '.$plant_on.'></span>'; //動物
      $rtn_st .= '<i class="fa fa-university" '.$building_on.'></i>'; //建物
      $rtn_st .= '</ul>';
      $rtn_st .= '</div>';
      // .カテゴリアイコン
      $rtn_st .='</a>';
      $rtn_st .='</div>';//.col-md-2
      // .アイテム
      if($r==$exm_cnt)
      {
        $rtn_st .='</div>';//.item
        $r=1;
      }else{
        $r++;
      }
      $ii++;
    }
    if($r==1){}else{$rtn_st .='</div>';}//.item}
    $rtn_st .='</div>';// <!--.carousel-inner-->
    $rtn_st .='<a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>';
    $rtn_st .='<a data-slide="next" href="#Carousel" class="right carousel-control">›</a>';
    $rtn_st .='</div>';// <!--.カルーセﾙ本体-->
  }else{
      $rtn_st .= "ZERO";
  }
  // iframe
  if(!$exm_url)
  {

  }else{
    $rtn_st .= '<div class="row">';
    $rtn_st .='<div class="col-md-12 text-center">';
    $rtn_st .= '<hr>';
    $rtn_st .= '<h2 style="color:white;">[<a class="" style="color:white;" href="'.$exm_url.'" target="_blank">'.$exm_name.'</a>]</h2>';
    $rtn_st .= '<hr>';
    $rtn_st .= '<iframe src="'.$exm_url.'" frameborder="0" width="600" height="1600" style="width:100%"></iframe>';
    $rtn_st .= '<hr>';
    $rtn_st .='</div>';//.col-md-12
    $rtn_st .='</div>';//.row    
  }
  return $rtn_st;
}
// 
function f_get_list($db_conn,$payflg,$tabno,$img_class)
{
  if($payflg==99&&$tabno==99)
  {
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay` ,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite`  order by `disporder` desc ,`id` asc";
  }else{
    $sql = "SELECT `id`, `url`, `name`, `description`,`pay` ,`cc0`,`person`,`food`,`landscape`,`animal`,`plant`,`building` FROM `tbl_imagesite` WHERE `tab`=$tabno order by `disporder` desc ,`id` asc";
  }
  // echo $sql;
  $result = @mysqli_query($db_conn,$sql);
  if($result)
  {
    $rtn_st = "";
    $index=0;
    $max=3;
    while($link = mysqli_fetch_row($result))
    {
      list($id,$url,$name,$description,$pay,$cc0,$person,$food,$landscape,$animal,$plant,$building) = $link;
      // タイトル
      $name_str = mb_strimwidth( $name, 0, 18, "...", "UTF-8" );
      $description_str = mb_strimwidth( $description, 0, 80, "...", "UTF-8" );
      // タブ用画像パス
      $img_path = "/img/tab/".$id.".png";
      if ( file_exists( "img/tab/".$id.".png" )) 
      {} else 
      {
        $img_path = "/img/tab/now.png";
      }
      // カテゴリーカラー
      $cc0_on="";
      $person_on="";
      $food_on="";
      $landscape_on="";
      $animal_on="";
      $plant_on="";
      $building_on="";
      if($cc0==1){$cc0_on='style="color: #955251;"';}
      if($person==1){$person_on='style="color: #777777;"';}
      if($food==1){$food_on='style="color: #777777;"';}
      if($landscape==1){$landscape_on='style="color: #777777;"';}
      if($animal==1){$animal_on='style="color: #777777;"';}
      if($plant==1){$plant_on='style="color: #777777;"';}
      if($building==1){$building_on='style="color: #777777;"';}

      if($pay==1)
      {
        $img_class = "img-responsive img-circle img-responsive-overwrite";
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite" ;
        $img_style = 'style ="border: 3px #955251 solid;"';
      }else{
        $img_class = "img-responsive img-thumbnail img-responsive-overwrite";
        $img_style = '';
      }
      // 
      $url = 'exm.php?id='.$id.'&url='.$url;
      // 
      // $rtn_st .= '<div class="col-md-2 col-sm-6 col-xs-12 text-center" style="margin-top:60px;">';
      $rtn_st .='<div class="col-md-3 col-sm-6 col-xs-12" style="margin-top:60px;">';//col-md-2
      $rtn_st .= '<div>';
      $rtn_st .= '<a href="'.$url.'" target="_blank">';
      $rtn_st .= '<img class="'.$img_class.'" src="'.$img_path.'" alt="'.$name.'" '.$img_style.'/></a>';
      $rtn_st .= '</div>';
      $rtn_st .= '<div>';
      $rtn_st .= '<p><a href="'.$url.'" target="_blank" style="color:white;">'.$name_str.'</a></p>';
      $rtn_st .= '</div>';
      // $rtn_st .= '<div style="height:20px;">';
      // $rtn_st .= $description_str;
      // $rtn_st .= '</div>';
      $rtn_st .= '<div>';
      $rtn_st .= '<ul class="icon-buttons">';
      $rtn_st .= '<span class="glyphicon glyphicon-subtitles" '.$cc0_on.'></span>';//CC0
      $rtn_st .= '<span class="glyphicon glyphicon-user" '.$person_on.'></span>';//人物
      $rtn_st .= '<span class="glyphicon glyphicon-glass" '.$food_on.'></span>'; //食物
      $rtn_st .= '<span class="glyphicon glyphicon-picture" '.$landscape_on.'></span>'; //風景
      $rtn_st .= '<i class="fa fa-paw" '.$animal_on.'></i>'; //動物
      $rtn_st .= '<span class="glyphicon glyphicon-tree-conifer" '.$plant_on.'></span>'; //動物
      $rtn_st .= '<i class="fa fa-university" '.$building_on.'></i>'; //建物
      $rtn_st .= '</ul>';
      $rtn_st .= '</div>';
      $rtn_st .= '</div>';
    }
    return $rtn_st;
  }else{
    return "f_get_tab_img_NG";
  }
}
###################################################################################
#汎用名前取得エンコード関数 //////////////////////////////////////////
###################################################################################
function f_get_comon_item($db_conn,$tableName,$Namefiled,$Idfiled,$id)
{
  $aryname = array();
  $strSQL = "SELECT $Idfiled,$Namefiled FROM $tableName WHERE $Idfiled = $id";
  $tbl_tmp = mysqli_query($db_conn, $strSQL);
  if($tbl_tmp)
  {
    while($rec_tmp = mysqli_fetch_row($tbl_tmp))
    {
      $aryname[$rec_tmp[0]] = $rec_tmp[1];
    }
  }
  foreach ($aryname as $key => $value)
  {
    $name = $value;
  }
  return $name;
}
?>
