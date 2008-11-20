<?php
    require_once "php_includes/include.php";
    require_once "php_includes/phpFlickr/phpFlickr.php";
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico" >
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://blog.myspace.com/blog/rss.cfm?friendID=28248390" />
<title>Supercade - high-energy indie pop from Washington, DC</title>
<?php
    $stylesheet = "style";
    if ($_GET["style"])
    {
        $stylesheet = $stylesheet . $_GET["style"];
    }
    $stylesheet = $stylesheet . ".css";
    echo "<link rel=\"StyleSheet\" HREF=\"";
    echo $stylesheet;
    echo "\" TYPE=\"text/css\">";
?>
</head>
<body>
<?php
    require "header.php"; 
?>
<table id="maintable">
<tr>
<td id="leftcolumn">
<?php require "shows_include.php"; ?>
</td>
<td id="rightcolumn">
<div id="pictures">
<table id="picturestitletable"><tr><td>
<div id="picturessectiontitle">PICTURES&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://api.flickr.com/services/feeds/photos_public.gne?id=80021819@N00&tags=supercade_website&format=rss_200"><img src="images/xml.gif" border=0></a></div></td></tr></table>
<?php 

    $tags = "supercade_website";
    $pictype_param = "";
    if ($_GET['pictype'])
    {
        $pictype = $_GET['pictype'];
        $tags .= "," . $pictype;
        $pictype_param = "pictype=$pictype";
    }
    $pictypes = array(
        "Press" => "press",
        "Live" => "live",
        "Flyers" => "flyer",
        "Other" => "misc");
    echo "<div class=\"members\">";
    echo "<a class=\"members\" href=\"pictures.php\">All</a> ";
    foreach (array_keys($pictypes) as $pictype)
    {
        $pictype_tag = $pictypes[$pictype];
        if ($_GET['pictype'] && $_GET['pictype'] == "$pictype_tag") 
        {
            echo "$pictype "; 
        }
        else 
        {
            echo "<a class=\"members\" href=\"pictures.php?pictype=$pictype_tag\">$pictype</a> ";
        }
    }
    echo "</div><br>";

    echo "<div class=\"pictures\">";

    $f = new phpFlickr("3825516eb8f7f996c0ea6db0341f986c");
    $f->enableCache("fs","/Users/davec/Sites/pix_cache",3600);

    $id = $f->people_findByUsername("davetron5000");


    $pix = $f->photos_search(array("tags" => $tags, "tag_mode" => "all", "user_id" => $id));
    $i = 0;
    $shuffled_photos = $pix['photo'];
    shuffle($shuffled_photos);
    foreach ($shuffled_photos as $photo)
    {
        $url = $f->buildPhotoURL($photo,"medium");
        $p_info = $f->photos_getInfo($photo['id'],$photo['secret']);
        //$photo_desc = htmlspecialchars($p_info['description'], ENT_QUOTES);
        $photo_desc = $p_info['description'];
        echo "<span class=\"photo\"><a href=\"$url\">";
        echo "<img border=0 title=\"" . $photo_desc . "\" src=" . $f->buildPhotoURL($photo,"Square") . ">";
        echo "</a></span>";
        $i++;
        if ($i % 4 == 0)
        {
            echo "<br><br>";
        }
    }
    echo "<br><a class=\"members\" target=\"_new\" href=\"http://www.flickr.com/photos/tags/supercade\">More on Flickr</a> ";
?>
<br>
<?php
    echo "</div>";
?>
</td></tr></table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
    _uacct = "UA-724870-1";
    urchinTracker();
</script>
</body>
</html>
