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
<?php require "shows_include.php"; ?>
</td>
<td id="rightcolumn">
<div class="biotitle">BIO</div>
<p class="bioLight">
<img src="http://static.flickr.com/75/210597623_938d643ac3_m.jpg" align=left>
Supercade began life in March of 2004, when bassist Dave Copeland left Full Minute of Mercury to start a new band.
After fierce negotiations on craigslist.org, two jamband guitarists, one bluegrass veteran and a
hip-hop-MC-turned-indierock guitar player named Tony Blankenship came to Dave in a vision. Only Tony was real. He,
Dave, and Dave's computer began working on material. Chords, Basslines and quantized drum beats were written to disk.
</p>
<p class="bioDark">
Channeling the ghost of Simon Cowell, Tony and Dave heard from a myriad of wannabe singers. Channeling the ghosts of
Randy Jackson and Paula Abdul, they promised all of them they would call them back. They actually did call back Devon
Randolph who sang the most difficult song for her audition...and sang it well. Chords became
parts, material became songs, and by December of 2004, it was time to find a real drummer.
</p>
<p class="bioLight">
In a Best of Seven Series Triple Threat Barbed-Wire Deathmatch, Michelle Schreiber won the Title to become The Unnamed Band's Drummer. 
Soon after, a large contribution to the '05 Real Estate Bubble was made, and the band began meeting regularly in the 
basement of a northeast bungalow.
</p>
<p class="bioDark">
Blown turnarounds, missed
notes and massive feedback gave way to a tight sound channeling the pop sensibility of the 80s, the stylistic freedom
of the 90s, and the modern sound of 21st century indie rock with a soulful, contemporary female voice. The Unnamed
Band was now Supercade.
</p>
<br clear=all>
<a href="http://www.sonicbids.com/Supercade">Electronic Press Kit</a>
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
