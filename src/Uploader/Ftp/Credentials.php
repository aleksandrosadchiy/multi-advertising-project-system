<?php

namespace Deployer\Uploader;

interface Credentials
{
    /**
     * host; password; username; port
     *
     * @param array $credentialsData
     * @return $this
     */
    public function set(array $credentialsData);

    /**
     * @return array
     */
    public function get($key = null);
}