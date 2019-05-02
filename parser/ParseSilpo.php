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
    private $storesCode;
    private $storeList;

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

    public function setStoreCode(AbstractConnectionType $connectionType)
    {
        $connectionType->setSiteUrl(silpoUrl);
        $connectionType->setRequestParameters(silpoRequestShopParameters, silpoStoresHeaders);
        $connectionType->connection();
        $this->storesCode = $connectionType->getSiteCode();
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

    public function setStoreList()
    {
        foreach(json_decode($this->storesCode)->data->stores->items as $store)
        {
            if ($store->city->title == silpoCityName)
            {
                $this->storeList[] = [
                    'city' => silpoCityName,
                    'address' => $store->title,
                    'lat' => $store->location->lat,
                    'lng' => $store->location->lng
                ];
            }
        }
    }

    public function getProductsData()
    {
        return $this->productsData;
    }
}