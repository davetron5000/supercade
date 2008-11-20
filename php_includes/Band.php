<?php

class Band
{
    var $id; //int
    var $name; //string
    var $website; //string

    function Band(
        $name=null,
        $website=null)
    {
        $this->name = $name;
        $this->website = $website;
    }

    function link()
    {
        if ($this->website != null)
        {
            return "<a href=\"$this->website\">$this->name</a>";
        }
        else
        {
            return $this->name;
        }
    }
}
class BandFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function BandFactory(
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
    
    var $selectSQL = "select id,name,website from band_band";

    function getBandById(
        $id
        )
    {
        $sql = $this->selectSQL . " where id = " . $id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new Band($row[1],$row[2]);
        $object->id = $row[0];
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewBand($object)
    {
        $sql = "insert into band_band(name,website) values ('" . $object->name . "','" . $object->website . "'" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updateBand($object)
    {
        $sql = "update band_band set name = '" . $object->name . "',website = '" . $object->website . "' where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deleteBand($object)
    {
        $sql = "delete from band_band where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getBandWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new Band($row[1],$row[2]);
        $object->id = $row[0];
        $returnMe[] = $object;

        }
        return $returnMe;
    }

    function getBandByName($name)
    {
        $results = $this->getBandWithWhereClause(" name = \"$name\"");
        if (count($results) == 0)
        {
            return null;
        }
        else
        {
            return $results[0];
        }
    }


}?>
