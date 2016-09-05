<?php

namespace DeployerTest\Cvs\GIT\Api\Bitbucket;

use Deployer\Entity\Credentials as Credentials;
use Deployer\Transport\AdapterInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CredentialFacadeTest extends \PHPUnit_Framework_TestCase
{
    /** @var  CredentialFacade */
    private $credentialFacade;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $credentialsMock;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $adapter;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $repositoryMock;

    public function setUp()
    {
        $this->repositoryMock = $this->getMockBuilder(\Deployer\Cvs\GIT\Api\Bitbucket\CredentialRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->credentialsMock = $this->getMock(Credentials::class);
        $this->adapter = $this->getMock(AdapterInterface::class);
        $method = "POST";

        $this->credentialFacade = new CredentialFacade(
            $this->repositoryMock,
            $this->credentialsMock,
            $this->adapter,
            $method
        );
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\Exception
     * @expectedExceptionMessage Customer with id:2 not found
     */
    public function testRequestTokenWithInvalidCustomerId()
    {
        $fakeId = 2;
        $this->credentialFacade->requestRefreshToken($fakeId);
    }

    public function testRequestTokenWithExistingId()
    {
        $id = 1;
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(Credentials::class, $id)
            ->willReturn($this->credentialsMock);
        $this->credentialsMock->expects($this->any())
            ->method('getConsummerCode')
            ->willReturn("consumerCode");
        $this->credentialFacade->requestRefreshToken($id);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\Exception
     * @expectedExceptionMessage Customer with id:3 not found
     */
    public function testRequestNewTokenWithInvalidCustomerId()
    {
        $testId = 3;
        $this->credentialFacade->requestNewToken($testId);
    }

    public function testRequestNewTokenWithExistingId()
    {
        $testId = 3;
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(Credentials::class, $testId)
            ->willReturn($this->credentialsMock);
        $this->credentialsMock->expects($this->any())
            ->method('getConsummerRefreshToken')
            ->willReturn('refreshToken');

        $this->credentialFacade->requestRefreshToken($testId);
    }

}