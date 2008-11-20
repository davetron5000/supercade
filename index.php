<?php
    require "php_includes/include.php";
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico" >
<META name="verify-v1" content="c99nqQvwY9dBZBlB+ZYezdbdbOGVMGjrJwvuansMu50=" />
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
<?php require "shows_include.php"; ?>
    <br>
<?php require "mailing_list_include.php"; ?>
</td>
<td id="rightcolumn">
<?php require "news_include.php"; ?>
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
