<?php

class Picture
{
    var $description; //string
    var $filename; //string
    var $id; //int
    var $showId; //int

    function Picture(
        $description=null,
        $filename=null,
        $showId=null)
    {
        $this->description = $description;
        $this->filename = $filename;
        $this->showId = $showId;
    }
}
class PictureFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function PictureFactory(
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
    
    var $selectSQL = "select description,filename,id,show_id from band_picture";

    function getPictureById(
        $id
        )
    {
        $sql = $this->selectSQL . " where id = " . $id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new Picture($row[0],$row[1],$row[3]);
        $object->id = $row[2];
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewPicture($object)
    {
        $sql = "insert into band_picture(description,filename,show_id) values ('" . $object->description . "','" . $object->filename . "'," . $object->showId . "" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updatePicture($object)
    {
        $sql = "update band_picture set description = '" . $object->description . "',filename = '" . $object->filename . "',show_id = " . $object->showId . " where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deletePicture($object)
    {
        $sql = "delete from band_picture where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getPictureWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new Picture($row[0],$row[1],$row[3]);
        $object->id = $row[2];
        $returnMe[] = $object;

        }
        return $returnMe;
    }

    /** Gets all pictures for a given show, or all non-show-related pictures if show_id is <= 0 */
    function getByShowId($show_id)
    {
        if ($show_id > 0)
        {
            return $this->getPictureWithWhereClause("show_id = $show_id");
        }
        else
        {
            return $this->getPictureWithWhereClause("show_id is null");
        }
    }

}?>
