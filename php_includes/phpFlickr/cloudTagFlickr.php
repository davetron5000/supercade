<?php


/* 

Dan Steingart's Awesometastic Flickr Cloud

Version 1.5 - At Jim Bumgardner's request I added a mininum tag threshold as well as a "bad words filter", for geotags, and other "not pretty thing"  user customizable!
Version 1.1 - Added gradient stuff
Version 1.0 - Initial release: from procrastination hacking to commented code in 1 hour!

Some sort of CC License applies to this: use this freely, hack the shit out of it, just let them know where you got it from

I read that “The tag cloud is the mullet of the internet.” Sign me up!

Now here’s all you gotta do (once you have phpFlickr and a flickrApi key):

Change the values under setup to fit default user name, API key, default max size, and default min size

If using caching, enter appropriate DB values and enable or disable caching

Place this file in the same directory your phpFlickr.php file on your web server

All this does is produce a string of words of different sizes. There’s no right or left alignment, nor any other sytle applied. So when placing it in your code, it should inherit the existing properties, except for font size, and if set, color

Call the string in a browswer to test it out like so “http://yoursite.com/phpFlickrPath/cloudTagFlickr.php”
If you see a string of your tags listed alphabetically and varied in size, your in business. To place it in your text just use a php include call.

Modifying the string: you can adjust the min and max font, the sort order, and the username all by applying arugments to the URL.


The default setting is to sort alphabetically with no color gradient and size according to the default values you set below.  So you if pass no arguments, this is what you'll get.

New additions!  
By changing the "mintagcounthreshold" field you can set what the mininum tag count needs to be to display.

By adding a "$tagstoignore='X';" line you can filter out a string that you'd rather not show up, such as "geolat" or "flickrdate" or "zip."  This tool does a sub string match, so if you set "zip" as a tag to ignore, then zip94703 will be filtered, etc.

examples:

“http://yoursite.com/phpFlickrPath/cloudTagFlickr.php?max=50&min=2″ sets the max font size to 50 and the min font size to 2. Remember that depending on your distribution, the minimum is a bottoming out point, but none of your tags may be so small.
“http://yoursite.com/phpFlickrPath/cloudTagFlickr.php?name=doofus” applies this script to user name doofus’s tags.
“http://yoursite.com/phpFlickrPath/cloudTagFlickr.php?sort=random” shuffles the order of the tags in the string. ‘asc’ sorts from lowest to highest popularity, ‘desc’ from highest to lowest.
“http://yoursite.com/phpFlickrPath/cloudTagFlickr.php?color=greyscale” makes the most popular darker and lighter from there. ‘hotcold’ goes red to blue. Adding &spread=150 (or anything less than 200) narrows the spectrum produced.
Mix and match as your like, for example: “http://yoursite.com/phpFlickrPath/cloudTagFlickr.php?sort=asc&max=60&user=nicksthings” would do exactly what you think it should.
Now, if you want to be really, really lazy, you can just hit my server up for the work IF you add me as a contact on flickr (allthingsalceste), because I’m a big loser and I smell.

*/

//Setup
$username = "user"; //flickr user name here
$flickrapikey = "key"; //key in here
$maximumdefaultdesiredfontsize = 25; //max font size here
$minimumdefaultdesiredfontsize = 8;  //min font size here
$defaultgradientoffset = 100; //Use to control the spread of colors/greys if you want to use color coding, use 0 to 200.
$linkage = ""; //set to show to link to a slideshow, anything else yields the standard flickr tag page
$mintagcounthreshold = 5; //mininum tag count to displayp
$tagstoignore[] = "flickrdate";
$tagstoignore[] = "zip";
$tagstoignore[] = "geolat";
$tagstoignore[] = "geolong";
$tagstoignore[] = "iama";


//Only need if you're using a DB cache
$cachingenabled = true; //switch to true if you rock MySQL
$dbUser = "user";//database user here
$dbPass = "pass";//database password here
$dbAddress = "localhost"; //location of database
$dbTable = "table";//location of table, will create one this is it doesn't exist
//NB wordpress users:  If you're going to use caching make sure you point this to your WP table.  It didn't mess mine up, I sure hope it doesn't mess with yours!

// Create new phpFlickr object
session_start();
require_once("phpFlickr.php");
$f = new phpFlickr($flickrapikey);
if ($cachingenabled == true)
{
$f->enableCache(
    "db",
    "mysql://$dbUser:$dbPass@$dbAddress/$dbTable"
);
}


//No Need to Change

if (isset($_GET['name']) and ($_GET['name'] != "")){
	$username = $_GET['name'];

		
	}

//only works if user is rocking a name
if (!empty($username)) {
    
    //Determine NSID and get tag arra
    $nsid = $f->people_findByUsername($username);
    $something = $f->tags_getListUserPopular($nsid,1000);
    
    
   //Drill Down to Pertinent Information
	$tags = $something['tags'];
	$tog = $tags['tag'];
	$stog = $tog[0];
	$sstog = $stog['_value'];
	
	//if max sized is passed in URL use it, otherwise use default
	if (isset($_GET['maxsize']) and ($_GET['maxsize'] != "")){
	$i = $_GET['maxsize'];
	settype($i, "integer");
	$maximumdesiredfontsize = $i;
	}
	else{
	$maximumdesiredfontsize=$maximumdefaultdesiredfontsize;
	}
	
	//if min sized is passed in URL use it, otherwise use default
	if (isset($_GET['minsize']) and ($_GET['minsize'] != "")){
	$i = $_GET['minsize'];
	settype($i, "integer");
	$minimumdesiredfontsize = $i;
	}
	else{
	$minimumdesiredfontsize=$minimumdefaultdesiredfontsize;
	}
	
	// min is set greater than max, go to default
	if ($minimumdesiredfontsize > $maximumdesiredfontsize)
	{
		$minimumdesiredfontsize=$minimumdefaultdesiredfontsize;
		$maximumdesiredfontsize=$maximumdefaultdesiredfontsize;
	}
	
	
	//determine maximum tagcount
	$i = 0;
	foreach($tog as $togo)
	{
		$sizecheckthing[$i] = $togo['count'];
		$i++;
	}
	
	
	
	$foundmax = max($sizecheckthing);

	//sorting options
	if (isset($_GET['sort']) and ($_GET['sort'] != "")){
	$mixing = $_GET['sort'];
		if ($mixing == "random")
		{
			shuffle($tog); //mess up the mix
		}
		elseif ($mixing == "asc")
		{
			sort($tog); //rank starting with lowest popularity
		}
		elseif ($mixing == "desc")
		{
			rsort($tog); //rank starting with highest popularity
		}
	}
	
	//Graident Offset Requested?
	if (isset($_GET['spread']) and ($_GET['spread'] != ""))
	{
		$offset = $_GET['spread'];
		settype($offset, "integer");	
	}
	else
	{
		$offset = $defaultgradientoffset;
	}

	if ($linkage == "show")
	{
		$linktag = "show";
	}
	else
	{
		$linktag = "";
	}
	//make cloud
	foreach( $tog as $togo)
	{
	//mininum tag count, defaulted to zero
	if ($togo['count'] >= $mintagcounthreshold)
	{
		$a = 0;
		foreach ($tagstoignore as $badword)
		{ if (strpos($togo['_value'],$badword)===false) $a++; }
		
		if ($a == count($tagstoignore))
		{
		
		//calculate font size 
		$thisfont = ($maximumdesiredfontsize-$minimumdesiredfontsize)*(sqrt($togo['count']/$foundmax))+$minimumdesiredfontsize;
	
		//calculate color
		$thiscolor =255-ceil((255-$offset)*(sqrt($togo['count']/$foundmax))+$offset);
    	$thisred = 255 - $thiscolor;
    	$thisblue = $thiscolor ;
 
    	//implement based on request gradient
    	if (isset($_GET['color']) and ($_GET['color'] != "")){
			$gradient = $_GET['color'];
			if ($gradient == "hotcold")
			{
				echo "<span><a style=\"font-size:".$thisfont."px; color: rgb(".$thisred.",0,".$thisblue.");\" href=\"http://www.flickr.com/photos/$nsid/tags/".$togo['_value']."/$linktag\">".$togo['_value']."</a> </span>";
			}
			elseif ($gradient == "greyscale")
			{	    
				echo "<span><a style=\"font-size:".$thisfont."px; color: rgb(".$thiscolor.",".$thiscolor.",".$thiscolor.");\" href=\"http://www.flickr.com/photos/$nsid/tags/".$togo['_value']."/$linktag\">".$togo['_value']."</a> </span>";
			}
			else
			{
			echo "<span><a style=\"font-size:".$thisfont."px;\"> href=\"http://www.flickr.com/photos/$nsid/tags/".$togo['_value']."/$linktag\">".$togo['_value']."</a> </span>";
			}
		}
		else
		{
			echo "<span ><a style=\"font-size:".$thisfont."px;\" href=\"http://www.flickr.com/photos/$nsid/tags/".$togo['_value']."/$linktag\">".$togo['_value']."</a> </span>";
		}
	
	}		
	}}
}
?>
