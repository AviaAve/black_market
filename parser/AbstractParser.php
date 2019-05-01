<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.19
 * Time: 15:31
 */

interface AbstractParser
{
    public function getDeliveryNetworkName();
    public function setSiteCode(AbstractConnectionType $connectionType);
    public function parseProductsFromCode();
    public function getProductsData();
}