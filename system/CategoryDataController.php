<?php
require_once "model/connection/MySqlConnection.php";
require_once "model/category.php";
require_once "config/parameters.php";

class CategoryDataController
{
    private $model;
    public function __construct()
    {
        $this->model = new category();
        $connection = new MySqlConnection();
        $connection->setConnectionParameters(mySqlHost, mySqlDbName, mySqlUser, mySqlPassword);
        $this->model->setConnection($connection);
    }
    public function getCategories()
    {
        return $this->model->getCategories();
    }

}