<?php
include "php_includes/lastRSS.php";
$blog_url = "http://makedatamakesense.com/myspace/?url=http%3A%2F%2Fblog.myspace.com%2Fsupercadedc";
$backup_blog_url = "http://blog.myspace.com/blog/rss.cfm?friendID=28248390";
?>
<div id="news">
<table id="newstitletable"><tr><td><div id="newssectiontitle">NEWS&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $backup_blog_url; ?>"><img src="images/xml.gif" border=0></a></div>
</td></tr></table>
<?php
$rss = new lastRSS;
$rss->stripHTML = False;
$rss->date_format = "D. M, jS";
$rss->cache_dir = './news_cache';
$rss->cache_time = 1200;
$rss->CDATA = "content";
$rss->items_limit = 10;


// the makedatamakesense feed screws up the dates, so we'll get the dates
// from the myspace feed
$rs = $rss->get($blog_url);
$backup_rs = $rss->get($backup_blog_url);

if (!$rs)
{
    echo "<!-- Backup news... -->";
    $rs = $backup_rs;
}

if ($rs)
{
    $index = 0;
    foreach ($rs['items'] as $item) 
    {
        $backup_item = $backup_rs['items'][$index];
        $pub_date = $backup_item[pubDate];
        echo "<div class=\"newstitle\">\n";
        //echo "<span class=\"newstitledate\">$item[pubDate]</span>\n";
        echo "<span class=\"newstitledate\">$pub_date</span>\n";
        echo " - \n";
        echo "<span class=\"newstitletitle\">$item[title]</span>\n</div>\n";
        echo "<div class=\"newscontent\">\n";
        $desc = str_replace("&lt;","<",$item[description]);
        $desc = str_replace("&gt;",">",$desc);
        $desc = str_replace("&quot;","'",$desc);
        echo $desc;
        echo "\n</div>\n";
        $index++;
    }
}
else 
{
    echo "Problem getting latest news, check <a href=\"http://www.myspace.com/supercadedc\">our myspace page</a> for updates";
}

?>
</div>
