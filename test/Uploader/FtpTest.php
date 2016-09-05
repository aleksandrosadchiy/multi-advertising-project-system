<?php

namespace DeployerTest\Credentials;

use Deployer\Uploader\Ftp;

class FtpTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Ftp */
    protected $_ftpCredentials;

    public function setUp()
    {
        $this->_ftpCredentials = new Ftp();
    }

    public function testGetCredentialsWithAllData()
    {
        $credentials = [
            "host" => "127.0.0.1",
            "password" => "123321",
            "port" => 22,
            "user" => "sereban"
        ];

        $this->_ftpCredentials->set($credentials);

        $this->assertEquals("127.0.0.1", $this->_ftpCredentials->getHost());
        $this->assertEquals("123321", $this->_ftpCredentials->getPassword());
        $this->assertEquals(22, $this->_ftpCredentials->getPort());
        $this->assertEquals("sereban", $this->_ftpCredentials->getUser());
    }

    public function testGetCredentialsWithoutPort()
    {
        $credentials = [
            "host" => "127.0.0.1",
            "password" => "123321",
            "user" => "sereban"
        ];

        $this->_ftpCredentials->set($credentials);

        $this->assertEquals("127.0.0.1", $this->_ftpCredentials->getHost());
        $this->assertEquals("123321", $this->_ftpCredentials->getPassword());
        $this->assertEquals(Ftp::DEFAULT_FTP_PORT, $this->_ftpCredentials->getPort());
        $this->assertEquals("sereban", $this->_ftpCredentials->getUser());
    }
}
