<?php

class Showwith
{
    var $bandId; //int
    var $foreign; //key
    var $showId; //int

    function Showwith(
        $bandId=null,
        $foreign=null,
        $showId=null)
    {
        $this->bandId = $bandId;
        $this->foreign = $foreign;
        $this->showId = $showId;
    }
}
class ShowwithFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function ShowwithFactory(
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
    
    var $selectSQL = "select band_id,foreign,show_id from band_showwith";

    function getShowwithById(
        $bandId,
        $showId
        )
    {
        $sql = $this->selectSQL . " where band_id = " . $bandId . " and show_id = " . $showId . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new Showwith($row[0],$row[1],$row[2]);
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewShowwith($object)
    {
        $sql = "insert into band_showwith(band_id,foreign,show_id) values (" . $object->bandId . "," . $object->foreign . "," . $object->showId . "" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updateShowwith($object)
    {
        $sql = "update band_showwith set foreign = " . $object->foreign . " where band_id = " . $object->bandId . " and show_id = " . $object->showId . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deleteShowwith($object)
    {
        $sql = "delete from band_showwith where band_id = " . $object->bandId . " and show_id = " . $object->showId . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getShowwithWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new Showwith($row[0],$row[1],$row[2]);
        $returnMe[] = $object;

        }
        return $returnMe;
    }


}?>