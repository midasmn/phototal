<?php
switch ($html_page) {
  case 'index.php':
    $index_st = 'class="active"';
    break;
  case 'free.php':
    $free_st = 'class="active"';
    break;
  case 'pay.php':
    $pay_st = 'class="active"';
    break;
  case 'all.php':
    $all_st = 'class="active"';
    break;
  case 'list.php':
    $list_st = 'class="active"';
    break;
  case 'keyword.php':
    $keyword_st = 'class="active"';
    break;
  case 'news.php':
    $news_st = 'class="active"';
    break;
}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarEexample4">
        <span class="sr-only">Toggle navigation</span>
<!--         <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
 -->        MENU
      </button>
      <a class="navbar-brand" href="/">
        <img alt="Brand" src="menulogo.png" style="height: 24px;">Phototal
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarEexample4">
      <ul class="nav navbar-nav">
        <li <?php echo $keyword_st;?>><a href="keyword.php"><?php echo $menu_tab1_st;?><small> (<?php echo $tab_keyword_cnt;?> site )</small></a></li>
        <li <?php echo $free_st;?>><a href="free.php"><?php echo $menu_tab2_st;?><small> (<?php echo $tab_free_cnt;?> site )</small></a></li>
        <li <?php echo $pay_st;?>><a href="pay.php"><?php echo $menu_tab3_st;?><small> (<?php echo $tab_pay_cnt;?> site )</small></a></li>
        <li <?php echo $index_st;?>><a href="/"><?php echo $menu_tab4_st;?><small> (<?php echo $tab_all_cnt;?> site )</small></a></li>
        <li <?php echo $list_st;?>><a href="list.php"><?php echo $menu_tab5_st;?><small> (<?php echo $tab_all_cnt;?> site )</small></a></li>
        <li <?php echo $news_st;?>><a href="news.php"><?php echo $menu_tab6_st;?><small></small></a></li>
      </ul>
      <!-- 右メニュー -->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown ">
          <a href="" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-pencil"></span> サイト追加 <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li class="">
              <a href="add.php">
                <span class="glyphicon glyphicon-pencil"></span> サイト追加フォーム
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- 右メニュー -->
    </div>
  </div>
</nav>