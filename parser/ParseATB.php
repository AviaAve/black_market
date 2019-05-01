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
//echo "<pre>";
//print_r(count($this->domObject->find('#cat0 li') ));
//echo "</pre>";
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
}