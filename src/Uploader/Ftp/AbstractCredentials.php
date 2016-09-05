<?php

namespace Deployer\Uploader;

class AbstractCredentials implements Credentials
{
    /**
     * @var
     */
    private $credentials;

    /**
     * @param array $credentialsData
     */
    public function set(array $credentialsData)
    {
        $this->credentials = $credentialsData;
    }

    /**
     * @param null $key
     * @return null
     */
    public function get($key = null)
    {
        if (isset($this->credentials[$key])) {
            return $this->credentials[$key];
        }

        return null;
    }
}
