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
<td id="centercolumn">
<?php 
    $dont_show_past_link = 1;
    require "shows_include.php";
?>
<hr>
<?php 
require "past_shows_include.php"; ?>
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
