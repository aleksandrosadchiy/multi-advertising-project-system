<?php

namespace Deployer\Transport\Adapter;

use Deployer\Transport\AdapterInterface;

class Curl implements AdapterInterface
{
    /** @var array */
    private static $methodMap = [
        'PUT' => CURLOPT_PUT,
        'POST' => CURLOPT_POST
    ];

    /** @var  array */
    private $headers = [];
    /** @var  array */
    private $sendingData;
    /** @var  array */
    private $autorizationParams;
    /** @var  resource */
    private $resource;
    /** @var  array */
    private $options;
    /** @var array */
    private $autorizeCredentials = [];

    /** @var  string */
    private $method;

    const API_URL = 'https://bitbucket.org/site/oauth2/access_token';

    private function init()
    {
        $this->resource = curl_init();
    }

    public function call()
    {
        if (!$this->resource) {

        }

        $this->init();
        $this->initMethod();
        $this->_autorize();
        curl_setopt($this->resource, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt_array($this->resource, $this->options);

        return curl_exec($this->resource);
    }

    private function initMethod()
    {
        if (isset($this->headers[$this->method]) && isset(self::$methodMap[$this->headers[$this->method]])) {
            curl_setopt($this->resource, self::$methodMap[$this->headers[$this->method]], true);
        }
    }
    
    /**
     * @param array $sendingData
     */
    public function setSendingData(array $sendingData)
    {
        $this->sendingData = $sendingData;
    }

    /**
     * @param array $authorizedCredentials
     */
    public function authorize($authorizedCredentials = [])
    {
        $this->autorizeCredentials = $authorizedCredentials;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->options = array(
            CURLOPT_URL => self::API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        );
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    protected function _autorize()
    {
        if (!empty($this->autorizeCredentials['user_name']) && !empty($this->autorizeCredentials['user_password'])) {
            curl_setopt(
                $this->resource,
                CURLOPT_USERPWD,
                $this->autorizeCredentials['user_name'] . ":" . $this->autorizeCredentials['user_password']);
        };
    }
}