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

$connectionType = new ConnectionByCurl();

$dbConnection = new MySqlConnection();
$dbConnection->setConnectionParameters(mySqlHost, mySqlDbName, mySqlUser, mySqlPassword);

$productController = new ProductDataController();
$productController->modelInit($dbConnection);
$productController->delete();

$storeController = new StoreDataController();
$storeController->modelInit($dbConnection);
$storeController->delete();

$silpoParser = new ParseSilpo();
$silpoParser->setSiteCode($connectionType);
$silpoParser->setStoreCode($connectionType);

$atbParser = new ParseATB();
$atbParser->setSiteCode($connectionType);
$atbParser->setStoreCode($connectionType);

$productController->productProcessing($silpoParser, silpoName);
$productController->productProcessing($atbParser, atbName);

$storeController->add( $silpoParser->setStoreList(), silpoName );
$storeController->add( $atbParser->setStoreList(), atbName );
