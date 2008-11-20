<?php

class Show
{
    var $attendance; //int
    var $draw; //int
    var $id; //int
    var $price; //int
    var $showDate; //date
    var $showTime; //string
    var $venueId; //int
    var $comments;

    function Show(
        $attendance=null,
        $draw=null,
        $price=null,
        $showDate=null,
        $showTime=null,
        $venueId=null,
        $comments=null)
    {
        $this->attendance = $attendance;
        $this->draw = $draw;
        $this->price = $price;
        $this->showDate = $showDate;
        $this->showTime = $showTime;
        $this->venueId = $venueId;
        $this->comments = $comments;
    }


}
class ShowDenormalized
{
    var $attendance; //int
    var $draw; //int
    var $id; //int
    var $price; //int
    var $showDate; //date
    var $showTime; //string
    var $venue; // Venue
    var $bands; // array of Band
    var $comments; // string

    function ShowDenormalized(
        $show,
        $venue,
        $bands)
    {
        $this->id = $show->id;
        $this->attendance = $show->attendance;
        $this->draw = $show->draw;
        $this->price = $show->price;
        $this->showDate = $show->showDate;
        $this->showTime = $show->showTime;
        $this->venue = $venue;
        $this->bands = $bands;
        $this->comments = $show->comments;
    }

    function niceDate()
    {
        $year = substr($this->showDate,0,4);
        $month = substr($this->showDate,5,2);
        $day = substr($this->showDate,8,2);
        $date = mktime(0,0,0,$month,$day,$year);
        return date("D. M, jS",$date);
    }

    function niceTime()
    {
        if ($this->showTime != null)
        {
            $hour = substr($this->showTime,0,2);
            $min = substr($this->showTime,2,2);
            $date = mktime($hour,$min);
            return date("g:i a",$date);
        }
        else
        {
            return "TBA";
        }
    }
}

class ShowFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function ShowFactory(
        $host, $username, $password, $dbName, $handle=null
        )
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        if ($handle == null) 
        {
            $this->handle = mysql_connect($host,$username,$password) or die ("Cannot connect to mysql database at " . $host . " with credentials " . $username . "/" . $password);
        }
        else
        {
            $this->handle = $handle;
        }
        mysql_select_db($dbName);
    }
    
    var $selectSQL = "select attendance,draw,id,price,show_date,show_time,venue_id,comments from band_show";

    function getShowById(
        $id
        )
    {
        $sql = $this->selectSQL . " where id = " . $id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new Show($row[0],$row[1],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
        $object->id = $row[2];
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewShow($object)
    {
        $sql = "insert into band_show(attendance,draw,price,show_date,show_time,venue_id,comments) values (" . $object->attendance . "," .  $object->draw . "," . $object->price . ",'" . $object->showDate . "','" . $object->showTime . "'," . $object->venueId . ",'" .  $object->comments . "'" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updateShow($object)
    {
        $sql = "update band_show set attendance = " . $object->attendance . ",draw = " . $object->draw . ", price = " . $object->price .  ",show_date = '" . $object->showDate . "',show_time = '" . $object->showTime . "',venue_id = " . $object->venueId . ", comments = '" . $object->comments . "'" . " where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deleteShow($object)
    {
        $sql = "delete from band_show where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getShowWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new Show($row[0],$row[1],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
        $object->id = $row[2];
        $returnMe[] = $object;

        }
        return $returnMe;
    }

    function getUpcomingShows()
    {
        return $this->getShowWithWhereClause(" show_date >= CURRENT_DATE and confirmed = 'T' order by show_date");
    }

    function getShowToday()
    {
        $result = $this->getShowWithWhereClause(" show_date = CURRENT_DATE and confirmed = 'T' ");
        if (count($result) == 0)
        {
            return null;
        }
        else
        {
            return $results[0];
        }
    }

    function getPastShows()
    {
        return $this->getShowWithWhereClause(" show_date < CURRENT_DATE and confirmed='T' order by show_date desc");
    }

    function denormalizeShow($show,$venuefactory,$bandfactory)
    {
        $venue = $venuefactory->getVenueById($show->venueId);
        $result = mysql_query("select band_id from band_showwith where show_id = " . $show->id)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $bands = array();
        while ($row = mysql_fetch_row($result))
        {
            $id = $row[0];
            $band = $bandfactory->getBandById($id);
            if ($band != null)
            {
                $bands[] = $band;
            }
        }
        $denorm = new ShowDenormalized($show,$venue,$bands);
        /*
        $denorm->venue = $venue;
        $denorm->bands = $bands;
        */
        return $denorm;
    }


}?>
