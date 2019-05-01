<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.19
 * Time: 16:14
 */
require_once "config/parameters.php";
require_once 'vendor/electrolinux/phpquery/phpQuery/phpQuery.php';
require_once 'AbstractParser.php';

class ParseSilpo implements AbstractParser
{
    private $deliveryNetworkName;
    private $url;
    private $productsData;
    private $siteCode;

    public function __construct()
    {
        $this->deliveryNetworkName = silpoName;
        $this->url = silpoUrl;
    }

    public function setSiteCode(AbstractConnectionType $connectionType)
    {
        $connectionType->setSiteUrl(silpoUrl);
        $connectionType->setRequestParameters(silpoRequestParameters, silpoHeaders);
        $connectionType->connection();
        $this->siteCode = $connectionType->getSiteCode();
    }

    public function getDeliveryNetworkName()
    {
        return $this->deliveryNetworkName;
    }

    public function parseProductsFromCode()
    {
        foreach( (array)json_decode($this->siteCode)->data->offersSplited->products->items as $poduct)
        {

            $poduct = (array)$poduct;
//            echo "<pre>";
//            print_r([
//                'title' => $poduct['title'],
//                'weight' => $poduct['weight'],
//                'price' => $poduct['price'],
//                'old_price' => $poduct['oldPrice'],
//                'img' => $poduct['image']->url,
//                'start' => $poduct['activePeriod']->start,
//                'end' => $poduct['activePeriod']->end
//            ]);
//            echo "</pre>";
            $this->productsData[] = [
                'title' => $poduct['title'],
                'weight' => $poduct['weight'],
                'price' => $poduct['price'],
                'old_price' => $poduct['oldPrice'],
                'img' => $poduct['image']->url,
                'start' => $poduct['activePeriod']->start,
                'end' => $poduct['activePeriod']->end
            ];
        }
    }

    public function getProductsData()
    {
        return $this->productsData;
    }
}