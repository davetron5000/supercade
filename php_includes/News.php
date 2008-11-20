<?php

class News
{
    var $content; //string
    var $id; //int
    var $newsDate; //date
    var $title; //string

    function News(
        $content=null,
        $newsDate=null,
        $title=null)
    {
        $this->content = $content;
        $this->newsDate = $newsDate;
        $this->title = $title;
    }

    function niceDate()
    {
        $year = substr($this->newsDate,0,4);
        $month = substr($this->newsDate,5,2);
        $day = substr($this->newsDate,8,2);
        $date = mktime(0,0,0,$month,$day,$year);
        return date("D. M, jS",$date);
    }
}
class NewsFactory
{
    var $handle;

    var $host;

    var $username;

    var $password;

    var $dbName;

    function NewsFactory(
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
    
    var $selectSQL = "select content,id,news_date,title from band_news";

    function getNewsById(
        $id
        )
    {
        $sql = $this->selectSQL . " where id = " . $id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        if ($row = mysql_fetch_row($result))
        {
            $object = new News($row[0],$row[2],$row[3]);
        $object->id = $row[1];
        return $object;

        }
        else
        {
            return null;
        }
    }
    function createNewNews($object)
    {
        $sql = "insert into band_news(content,news_date,title) values ('" . $object->content . "','" . $object->newsDate . "','" . $object->title . "'" . ")";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function updateNews($object)
    {
        $sql = "update band_news set content = '" . $object->content . "',news_date = '" . $object->newsDate . "',title = '" . $object->title . "' where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }

    function deleteNews($object)
    {
        $sql = "delete from band_news where id = " . $object->id . " ";

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
    }
    function getNewsWithWhereClause($where_clause)
    {
        $sql = $this->selectSQL .  " where " . $where_clause;

        $result = mysql_query($sql)
            or die ("Error executing '" . $sql . "' : " . mysql_error());
        $returnMe = array();
        while ($row = mysql_fetch_row($result))
        {
        $object = new News($row[0],$row[2],$row[3]);
        $object->id = $row[1];
        $returnMe[] = $object;

        }
        return $returnMe;
    }

    /** Returns all news items (up to max_news) ordered by date, with the newest first */
    function getAllNews($no_future=false,$max_news=-1)
    {
        if ($no_future)
        {
            $sql = " news_date <= CURRENT_DATE() ";
        }
        else
        {
            $sql = " 1=1 ";
        }
        $sql .= " order by news_date DESC";
        $results = $this->getNewsWithWhereClause($sql);
        if ($max_news == -1)
        {
            return $results;
        }
        else
        {
            return array_slice($results,0,$max_news);
        }
    }


}?>
