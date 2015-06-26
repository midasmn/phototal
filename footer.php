<?php
$footer_sitename = $site_name;
$fb_url = "https://www.facebook.com/photomottoxyz";
$tw_url = "https://twitter.com/photomottoZ";
$gp_url = "https://google.com/+PhotomottoXyzZ";

$tb_url= "tumblr";
$git_url= "github";
$pin_url= "pinterest";
$in_url= "linkedin";
?>

<!-- フッター -->
<div class="footer">
	<div class="container" class="col-md-12"">
		<div class="whiteband clearfix">
			<ul class="pull-left">
				<li><a href="<?php echo $base_url;?>" target="_self"><span class="glyphicon glyphicon-home" style="color:white;"></span></a></li>
<!-- 				<li><a href="/tour" target="_self">使い方</a> /</li>
				<li><a href="#">ヘルプ</a> /</li>
				<li><a href="/contact" target="_self">お問い合わせ</a></li> -->
			</ul>
			<div class="pull-right">
				<a class="social-icon" href="<?php echo $fb_url;?>" target="_blank" rel="fb_share" data-original-title="Like us on Facebook">
					<i id="social" class="fa fa-facebook-square fa-2x social-fb"></i>
				</a>
				<a class="social-icon" href="<?php echo $tw_url;?>" target="_blank" rel="fb_share" data-original-title="Follow us on Twitter">
					<i id="social" class="fa fa-twitter-square fa-2x social-tw"></i>
				</a>
				<a class="social-icon" href="<?php echo $gp_url;?>" target="_blank" rel="fb_share" data-original-title="Follow us on Google+">
					<i id="social" class="fa fa-google-plus-square fa-2x social-gp"></i>
				</a>
			</div>
		</div>
		<div style="font-family:'EB Garamond',serif;color:white;">
			&copy;<?php echo date('Y');?><?php echo $footer_sitename;?>
			<i class="glyphicon glyphicon-globe"></i>日本語
		</div>
	</div>
</div>

<!-- ソーシャルボタン -->
<!-- {Permalink}を記事URL、{Title}を記事タイトル、{BlogURL}をブログトップURL -->
<p class="social-button">
<a href="http://b.hatena.ne.jp/entry/<?php echo $og_url;?>" title="この記事をはてなブックマークに追加" target="_blank">
<img src="/img/sns/Hatebu.png"></a> 
<a href="http://twitter.com/intent/tweet?url=<?php echo $og_url;?>&text=<?php echo $title;?>" target="_blank">
<img src="/img/sns/Twitter.png"></a> 
<a href="http://www.facebook.com/sharer.php?src=bm&u=<?php echo $og_url;?>&amp;t=<?php echo $title;?>" target="_blank">
<img src="/img/sns/Facebook.png"></a> 
<a href="https://plus.google.com/share?url=<?php echo $og_url;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
<img src="/img/sns/Google+.png"></a> 
<a href="http://line.me/R/msg/text/?<?php echo $title;?>%0D%0A<?php echo $og_url;?>>">
<img src="/img/sns/Line.png"></a> 
<a href="http://getpocket.com/edit?url=<?php echo $og_url;?>&<?php echo $title;?>=<?php echo $title;?>" target="_blank">
<img src="/img/sns/Pocket.png"></a> 
<!-- <a href="http://cloud.feedly.com/#subscription%2Ffeed%2F{BlogURL}feed" target="_blank">
<img src="/img/sns/Feedly.png"></a></p> -->
<!-- ソーシャルボタン -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!-- asny-bootstrap -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<script src="js/def.js"></script>

<!-- 画面ローダー -->
<script src="js/loadingoverlay.min.js"></script>
<!--  -->

<!-- タブURL -->
<script>
$( document ).ready(function() {
// Javascript to enable link to tab
var hash = document.location.hash;
var prefix = "tabref-";
if (hash) {
    $('.nav-justified a[href='+hash.replace(prefix,"")+']').tab('show');
} 
// Change hash for page-reload
$('.nav-justified a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash.replace("#", "#" + prefix);
});
});
</script>

<!-- // カルーセル -->
<script>
$(document).on(function() {
    $('#Carousel').carousel('pause');
});
</script>


<script>
// ソーシャルボタン　フェードイン・アウト
$(function(){
	$(window).bind("scroll", function() {
	if ($(this).scrollTop() > 150) { 
		$(".social-button").fadeIn();
	} else {
		$(".social-button").fadeOut();
	}

	// ソーシャルボタンリンクを右下に固定
	$(".social-button").css({"position":"fixed","bottom": "100px"});

	});
});
</script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63817927-1', 'auto');
  ga('send', 'pageview');
  ga(‘set’, ‘&uid’, {{USER_ID}}); // ログインしている user_id を使用してUser-ID を設定します。

</script>