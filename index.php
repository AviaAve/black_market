<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 9000);

header('Content-type: text/html; charset=utf-8');
require_once 'vendor/electrolinux/phpquery/phpQuery/phpQuery.php';
require_once "parser/connection/ConnectionByCurl.php";
require_once "parser/ParseSilpo.php";
require_once "parser/ParseATB.php";
require_once "system/ProductDataController.php";
require_once "model/connection/MySqlConnection.php";
require_once "system/StoreDataController.php";

$dbConnection = new MySqlConnection();
$dbConnection->setConnectionParameters(mySqlHost, mySqlDbName, mySqlUser, mySqlPassword);
$productController = new ProductDataController();
$productController->modelInit($dbConnection);
$storeController = new StoreDataController();
$storeController->modelInit($dbConnection);
$categoryController = new CategoryDataController();

$data = [
    'products' => $productController->getAllProduct(),
    'categories' => $categoryController->getCategories(),
    'delivery_networks' => $storeController->getDeliveryNetworks()
];

echo "<pre>";
print_r($data);
echo "</pre>";

