<table id="shows">
<tr>
<td colspan=4 class="showsheader">UPCOMING SHOWS<br>
<a href="webcal://www.google.com/calendar/ical/n2fh3u56e4igblt9penkmb5djo@group.calendar.google.com/public/basic.ics"><img src="images/ical.gif" border=0></a> <a href="http://www.google.com/calendar/feeds/n2fh3u56e4igblt9penkmb5djo@group.calendar.google.com/public/basic"><img src="images/xml.gif" border=0></a> <a target="_blank" href="http://www.google.com/calendar/render?cid=n2fh3u56e4igblt9penkmb5djo@group.calendar.google.com"><img height=14 src="http://www.google.com/calendar/images/ext/gc_button1.gif" border=0></a></td>
</tr>
<tr>
<td class="showsheader">Date</td>
<td class="showsheader">Location</td>
<td class="showsheader">Time</td>
<td class="showsheader">Price</td>
</tr>
<?php
    $showsfactory = new ShowFactory($host,$user,$password,$database);
    $venuefactory = new VenueFactory($host,$user,$password,$database);
    $bandfactory = new BandFactory($host,$user,$password,$database);

    $shows = $showsfactory->getUpcomingShows();
    $denormalized = array();

    for ($i = 0;$i < count($shows);$i++)
    {
        $show = $shows[$i];
        $de_show = $showsfactory->denormalizeShow($show,$venuefactory,$bandfactory);
        $denormalized[] = $de_show;
    }
    for ($i = 0;$i < count($denormalized);$i++)
    {
        $one_show = $denormalized[$i];
    ?>
    <tr>
    <td class="showdate">
    <?php
        echo $one_show->niceDate();
    ?>
    </td>
    <td class="showvenue">
    <?php
        $venue = $one_show->venue;
        echo $venue->link();
    ?><div class="showvenue"><?php echo $venue->city; echo ", "; echo $venue->state; echo " " . $venue->maplink() ?></div>
    </td>
    <td class="showtime">
    <?php
        echo $one_show->niceTime();
    ?>
    </td>
    <td class="showprice">
    <?php if ($one_show->price == 0) { echo "FREE!"; }
    else { ?>
        $<?php
            echo $one_show->price;
        }?>
    </td>
    </tr>
    <tr>
    <td colspan=4 class="showbands">
    with
    <?php
        $bands = $one_show->bands;
        for ($j = 0;$j < count($bands);$j++)
        {
            $one_band = $bands[$j];
            echo $one_band->link();
            if ($j != (count($bands) - 1))
            {
                echo ", ";
            }
        }
    ?>
    </td>
    </tr>
    <?php
        if ($one_show->comments != null)
        {
        ?>
        <tr><td></td><td class="showcomments" colspan=3>
        <?php echo $one_show->comments; ?>
        </td></tr>
        <?php
        }
    ?>
    <tr><td class="showdivider" colspan=4></td></tr>
    <?php
    }
    if ($dont_show_past_link && ($dont_show_past_link == 1))
    {
    }
    else
    {
?>
<tr><td colspan=4><a class="showsoldlink" href="past_shows.php">Past Shows...</a></td></tr>
<?php } ?>
</table>
