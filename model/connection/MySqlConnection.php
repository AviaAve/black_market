<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 14.04.19
 * Time: 10:50
 */

require_once "AbstractDbConnection.php";

class MySqlConnection implements AbstractDbConnection
{
    protected $mySqlDbObject;

    public function setConnectionParameters($host, $dbName, $userName, $password)
    {
        $this->mySqlDbObject = new mysqli($host, $userName, $password, $dbName)
        or die("Error with db connection: " . mysqli_error($link));
    }

    public function query($sqlQuery)
    {
        $result = [];

        $data = $this->mySqlDbObject->query($sqlQuery)
        or die("Error with query: " . mysqli_error($this->mySqlDbObject));

        while (!is_bool($data) && $data_item = mysqli_fetch_assoc($data))
            $result[] = $data_item;

        return $result;
    }
}