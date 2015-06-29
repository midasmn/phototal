<?php
// require_once("lib.php");
require_once("mysql-ini.php");
// データベースに接続
$db_conn = new mysqli($host, $user, $pass, $dbname)
or die("データベースとの接続に失敗しました");
$db_conn->set_charset('utf8');

////////////////////////////////////////
function f_id_sitemap($db_conn)
{
    $time = date("c");
    // 
    $header = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $header .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
    // 固定ページ
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>1.0</priority>'."\n";
    $header .= '</url>'."\n";
    // 
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/free.php</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>0.8</priority>'."\n";
    $header .= '</url>'."\n";
    // 
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/pay.php</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>0.8</priority>'."\n";
    $header .= '</url>'."\n";
    // 
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/keyword.php</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>1.0</priority>'."\n";
    $header .= '</url>'."\n";
    // 
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/list.php</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>0.8</priority>'."\n";
    $header .= '</url>'."\n";
    // 
    $header .= '<url>'."\n";
    $header .= '<loc>http://phototal.link/news.php</loc>'."\n";
    $header .= '<lastmod>'.$time.'</lastmod>'."\n";
    $header .= '<changefreq>weekly</changefreq>'."\n";
    $header .= '<priority>0.8</priority>'."\n";
    $header .= '</url>'."\n";

    //googleサイトマップ制限 URL50000,50MB 500ファイル
    $base_dir = "/home/midasmn/phototal.link/public_html/";
    $sitemap_name = "sitemap";
    $baseurl = 'http://phototal.link/all.php?exm_itemno=';
    $max_url = 50000;   //1ファイルURL制限
    $max_filecnt = 500; //xmlファイル数制限
    $urlcnt = 1;    //url数初期値
    $filecnt = 0;   //xmlファイル数初期値
    //
    $sql = 'SELECT `id`, `craatedate` FROM `tbl_imagesite` order by id asc ';
    $result = @mysqli_query($db_conn,$sql);
    if($result)
    {
        while($link = mysqli_fetch_row($result))
        {
            list($id,$craatedate) = $link;    
            if($urlcnt<=$max_url)   //5000URL制限
            {
                if($urlcnt==1)
                {
                    ////xmlファイル500制限まで
                    if($filecnt<$max_filecnt)
                    {
                        //ファイル作成
                        $filecnt++; //xmlファイル数
                        $filename = $base_dir.$sitemap_name.'.xml';
                        if (FALSE == ($fp = fopen($filename, "w")))
                        {
                            echo "<br>filename".$filename;
                            print "サイトマップを作成に失敗。ディレクトリのパーミッションを見直してください";
                            exit();
                        }else{
                            echo "<br>filecnt=".$filecnt;
                        }
                    }else{
                        //終了
                        exit();
                    }
                    $temp = $header;
                }
                $url = $baseurl.$id;
                $temp .= '<url>'."\n";
                $temp .= '<loc>'.$url.'</loc>'."\n";
                $temp .= '<lastmod>'.$time.'</lastmod>'."\n";
                $temp .= '<changefreq>daily</changefreq>'."\n";
                $temp .= '<priority>0.5</priority>'."\n";
                $temp .= '</url>'."\n";
                $urlcnt++;
            }
            if($urlcnt==$max_url)
            {
                $temp .= '</urlset>'."\n";
                fputs($fp,$temp);
                fclose($fp);
                $urlcnt = 1;
                // $filecnt++;
                $temp ="";
            }   
        }
        $temp .= '</urlset>'."\n";
        fputs($fp,$temp);
        fclose($fp);
        return $filecnt;
    }
    return "NG";
}

$rtn = f_id_sitemap($db_conn);
echo $rtn;
?>