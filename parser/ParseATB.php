<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.19
 * Time: 19:29
 */
require_once "parser/AbstractParser.php";

class ParseATB implements AbstractParser
{
    private $deliveryNetworkName;
    private $url;
    private $productsData;
    private $siteCode;
    private $domObject;
    private $storesCode;
    private $storeList;
    private $cityId;

    public function __construct()
    {
        $this->deliveryNetworkName = atbName;
        $this->url = atdUrl;
    }

    public function setSiteCode(AbstractConnectionType $connectionType)
    {
        $connectionType->setSiteUrl(atdUrl);

        $connectionType->setRequestParameters(atbRequestParameters, atbHeaders);
        $connectionType->connection();
        $this->siteCode = $connectionType->getSiteCode();
    }

    public function getDeliveryNetworkName()
    {
        return $this->deliveryNetworkName;
    }

    protected function convertHtmlToDom()
    {
        $this->domObject = phpQuery::newDocument($this->siteCode);
    }

    protected function validatePricePartForm($selector, $domObject)
    {
        $pricePart = trim( utf8_decode( $domObject->find($selector)->text() ) );
        $pricePart = str_replace('грн', '', $pricePart);
        $pricePart = trim($pricePart);
        return $pricePart;
    }

    public function parseProductsFromCode()
    {
        $this->convertHtmlToDom();

        foreach ($this->domObject->find('#cat0 li') as $product)
        {
            $product = pq($product);
            $img = atbDomen . $product->find('img')->attr('src');
            $name = utf8_decode($product->find('.promo_info_text')->text());
            $coins = $this->validatePricePartForm('.promo_price span', $product);
            $price =  $this->validatePricePartForm('.promo_price', $product);
            $price = str_replace($coins, '.' . $coins, $price);

            $this->productsData[] = [
                'title' => $name,
                'weight' => 0,
                'price' => $price,
                'old_price' => 0,
                'img' => $img,
                'start' => '',
                'end' => ''
            ];
        }
    }

    public function getProductsData()
    {
        return $this->productsData;
    }

    public function setStoreCode(AbstractConnectionType $connectionType)
    {
        $connectionType->setSiteUrl(AtbCityListUrl);
        $connectionType->setRequestParameters();
        $connectionType->connection();
        $this->storesCode = $connectionType->getSiteCode();
    }

    private function setCityId() {
        foreach (json_decode($this->storesCode)->cities as $cityId => $cityDescription) {
            if ($cityDescription->title == atbCityName)
                $this->cityId = $cityId;
        }
    }

    public function setStoreList()
    {
        $this->setCityId();

        foreach(json_decode($this->storesCode)->shops as $cityId => $storesInCity)
        {
            if ($cityId == $this->cityId) {
                foreach ($storesInCity as $store) {
                    $this->storeList[] = [
                        'city' => silpoCityName,
                        'address' => $store->address,
                        'lat' => $store->latitude,
                        'lng' => $store->longitude
                    ];
                }
            }
        }

        return $this->storeList;
    }
}