<table id="shows">
<tr>
<?php 
    $colspan = 2;
    if ($show_draw == 1) { $colspan += 2; }
    if ($show_pictures == 1) { $colspan += 1; }
?>
<td colspan=<?php echo $colspan ?> class="showsheader">PAST SHOWS</td>
</tr>
<tr>
<td class="showsheader">Date</td>
<td class="showsheader">Location</td>
<?php if ($show_draw == 1) { ?>
<td class="showsheader">Attendance</td>
<td class="showsheader">Our Draw</td>
<?php } ?>
<?php if ($show_pictures == 1) { ?>
    <td class="showsheader">Pictures</td>
<?php } ?>
</tr>
<?php
    $showsfactory = new ShowFactory($host,$user,$password,$database);
    $venuefactory = new VenueFactory($host,$user,$password,$database);
    $bandfactory = new BandFactory($host,$user,$password,$database);
    $picturefactory = new PictureFactory($host,$user,$password,$database);

    $shows = $showsfactory->getPastShows();
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
        $pictures = array();
        if ($show_pictures)
        {
            $pictures = $picturefactory->getByShowId($one_show->id);
        }
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
    ?><div class="showvenue"><?php echo $venue->city; echo ", "; echo $venue->state; ?></div>
    </td>
<?php if ($show_draw == 1) { ?>
    <td class="showtime">
    <?php
        echo $one_show->attendance;
    ?>
    </td>
    <td class="showprice">
    <?php
        echo $one_show->draw;
    ?>
    </td>
<?php } ?>
    <td rowspan=2>
    <?php
        if (count($pictures) > 0)
        {
            for ($k=0;$k< count($pictures); $k++)
            {
                $pic = $pictures[$k];
                $fullsize = "pictures/" . $pic->filename;
                $thumb = "pictures/thumbs/" . $pic->filename;
            ?>
                <a href="<?php echo $fullsize ?>"><img alt="<?php echo $pic->description ?>" border=0 src="<?php echo $thumb ?>"></a>&nbsp;
            <?php
                if (($k+1) % 6 == 0)
                {
                    echo "<br>";
                }
            }
        }
    ?></td>
    </tr>
    <tr>
    <?php if ($show_draw == 1) { ?>
    <td colspan=4 class="showbands">
    <?php } else { ?>
    <td colspan=2 class="showbands">
    <?php } ?>
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
    }
?>
</table>
