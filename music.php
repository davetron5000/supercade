<?php
    require "php_includes/include.php";
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
<?php require "header.php"; ?>
<table id="maintable">
<tr>
<td id="leftcolumn">
<?php require "shows_include.php"; 
?>
</td>
<td id="rightcolumn">
<div class="songs">
<div class="songstitle">LISTEN</div>
<p class="songslist">
Stream 4 songs, Download 2 on <a href="http://www.myspace.com/supercadedc">MySpace</a>.
<br>
Download 2 songs from <a href="http://mp3.washingtonpost.com/bands/supercade.shtml">Washington Post MP3 Site</a>
</p>
<div class="songstitle">BUY</div>
<p class="songslist">
<br>
<TABLE width="400" style="border: thin solid #019A9A" cellspacing="0" cellpadding="2"><TR><TD><TABLE width="100%" border="0" cellpadding="2"  cellspacing="0"><TR><TD width="100"><A href="cdbaby_redirect.php"><img src="http://cdbaby.name/s/u/supercade_small.jpg" width="100" height="100" alt="album cover" border="0"  /></A></TD><TD align="left" class="sans"><B>A Drawn Out Turn Down</B><br><br>6 of our greatest hits!<br><br><div align="right">
<a href="cdbaby_redirect.php">Order the CD</a> from CDBaby<br>
<a href="http://phobos.apple.com/WebObjects/MZStore.woa/wa/viewAlbum?id=192630095&s=143441">Download the CD</a> from iTunes.</div></td></tr></TABLE></TD></TR></TABLE>
Coming soon to Napster and Rhapsody.
</p>
</div>
</td>
</tr>
</table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
    _uacct = "UA-724870-1";
    urchinTracker();
</script>
</body>
</html>
