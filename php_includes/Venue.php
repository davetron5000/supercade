<?php

class Venue
{
    var $bookingContact; //string
    var $city; //string
    var $id; //int
    var $name; //string
    var $phone; //string
    var $state; //string
    var $street; //string
    var $website; //string
    var $zip; //string

    function Venue(
        $bookingContact=null,
        $city=null,
        $name=null,
        $phone=null,
        $state=null,
        $street=null,
        $website=null,
        $zip=null)
    {
        $this->bookingContact = $bookingContact;
        $this->city = $city;
        $this->name = $name;
        $this->phone = $phone;
        $this->state = $state;
        $this->street = $street;
        $this->website = $website;
        $this->zip = $zip;
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

    function maplink()
    {
        if ( ($this->street == null)
            || ($this->city == null)
            || ($this->state == null) )
        {
            return "";
        }

        $query = "$this->street, $this->city, $this->state";
        $query = ereg_replace("/","+",$query);
        $query = ereg_replace(" ","+",$query);
        return "<a href=\"http://maps.google.com/maps?q=$query\">Map...</a>";
    }
}
class VenueFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function VenueFactory(
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
    
    var $selectSQL = "select booking_contact,city,id,name,phone,state,street,website,zip from band_venue";

    function getVenueById(
        $id
        )
    {
        $sql = $this->selectSQL . " where id = " . $id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new Venue($row[0],$row[1],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
        $object->id = $row[2];
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewVenue($object)
    {
        $sql = "insert into band_venue(booking_contact,city,name,phone,state,street,website,zip) values ('" . $object->bookingContact . "','" . $object->city . "','" . $object->name . "','" . $object->phone . "','" . $object->state . "','" . $object->street . "','" . $object->website . "','" . $object->zip . "'" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updateVenue($object)
    {
        $sql = "update band_venue set booking_contact = '" . $object->bookingContact . "',city = '" . $object->city . "',name = '" . $object->name . "',phone = '" . $object->phone . "',state = '" . $object->state . "',street = '" . $object->street . "',website = '" . $object->website . "',zip = '" . $object->zip . "' where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deleteVenue($object)
    {
        $sql = "delete from band_venue where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getVenueWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new Venue($row[0],$row[1],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
        $object->id = $row[2];
        $returnMe[] = $object;

        }
        return $returnMe;
    }

    function getVenueNamed($name)
    {
        $result = $this->getVenueWithWhereClause("name = \"$name\"");
        if (count($result) == 0)
        {
            return null;
        }
        else
        {
            return $result[0];
        }
    }

    function getAllVenues()
    {
        return $this->getVenueWithWhereClause("1 = 1 order by name");
    }


}?>
