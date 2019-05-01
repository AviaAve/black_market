<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.19
 * Time: 16:36
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 9000);
require_once "AbstractConnectionType.php";
header('Content-type: text/html; charset=utf-8');

class ConnectionByCurl implements AbstractConnectionType
{
    protected $url;
    protected $requestParameters;
    protected $headers;
    protected $siteCode = [];

    public function setSiteUrl($url) {
        $this->url = $url;
    }

    public function setRequestParameters($parameters, $headers) {
        $this->requestParameters = $parameters;
        $this->headers = $headers;
    }

    public function connection() {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        if (isset( $this->requestParameters['get'] ))
            $this->addGetParametersToUrl();

        if (isset( $this->requestParameters['post'] ))
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestParameters['post']);

        if ($this->headers != [])
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $this->siteCode = curl_exec($ch);
        curl_close($ch);
    }

    protected function addGetParametersToUrl($parameters) {
        $parametersString = "";

        foreach ($parameters as $key => $parameter) {
            $parametersString += "&" . $key . "=" . $parameter;
        }

        $this->url .= "?" . substr($parametersString, 1);
    }

    public function getSiteCode() {
        return $this->siteCode;
    }
}