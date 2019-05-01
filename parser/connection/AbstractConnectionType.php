<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.19
 * Time: 16:33
 */

interface AbstractConnectionType
{
    public function setSiteUrl($url);
    public function setRequestParameters($parameters, $headers);
    public function connection();
    public function getSiteCode();
}