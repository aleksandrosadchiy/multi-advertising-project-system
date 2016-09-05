<?php

namespace Deployer\Uploader;

class Ftp extends AbstractCredentials
{
    const DEFAULT_FTP_PORT = 21;

    /**
     * @return null
     */
    public function getPassword()
    {
        /** @TODO: password should be saved as crypt entity */
        return $this->get("password");
    }

    public function getHost()
    {
        return $this->get("host");
    }

    public function getUser()
    {
        return $this->get("user");
    }
    
    public function getPort()
    {
        return $this->get("port") ?: self::DEFAULT_FTP_PORT; 
    }
}
