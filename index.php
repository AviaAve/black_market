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

/*$connectionType = new ConnectionByCurl();
$silpoParser = new ParseATB();
$silpoParser->setSiteCode($connectionType);
$silpoParser->parseProductsFromCode();
echo "<pre>";
print_r($silpoParser->getProductsData());
echo "</pre>";*/
$connectionType = new ConnectionByCurl();

$dbConnection = new MySqlConnection();
$dbConnection->setConnectionParameters(mySqlHost, mySqlDbName, mySqlUser, mySqlPassword);

$controller = new ProductDataController();
$controller->modelInit($dbConnection);

$silpoParser = new ParseSilpo();
$silpoParser->setSiteCode($connectionType);

$atbParser = new ParseATB();
$atbParser->setSiteCode($connectionType);

$controller->productProcessing($silpoParser);
$controller->productProcessing($atbParser);

$silpoParser->setStoreCode($connectionType);
$silpoParser->setStoreList();
//echo "<pre>";
//print_r($controller->getAllProduct());
//echo "</pre>";