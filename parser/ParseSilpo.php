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
        foreach( (array)json_decode($this->siteCode)->data->offersSplited->products->items as $product)
        {
            $product = (array)$product;
            $this->productsData[] = [
                'title' => $product['title'],
                'weight' => $product['weight'],
                'price' => $product['price'],
                'old_price' => $product['oldPrice'],
                'img' => $product['image']->url,
                'start' => $product['activePeriod']->start,
                'end' => $product['activePeriod']->end
            ];
        }
    }

    public function getProductsData()
    {
        return $this->productsData;
    }
}