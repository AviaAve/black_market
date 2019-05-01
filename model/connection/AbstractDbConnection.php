<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 14.04.19
 * Time: 10:39
 */

interface AbstractDbConnection
{
    public function setConnectionParameters($host, $dbName, $userName, $password);
    public function query($sqlQuery);
}