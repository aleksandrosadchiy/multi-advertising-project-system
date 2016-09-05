<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.09.16
 * Time: 17:49
 */

namespace DeployerTest\Cvs\GIT\Api\Bitbucket;

use Doctrine\ORM\EntityManager;
use Deployer\Entity\Credentials as Credentials;

class CredentialRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $connectionParams;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;

    private $credentialsMock;

    /** @var  CredentialRepository */
    private $credentialsRepository;

    public function setUp()
    {
        $this->credentialsMock = $this->getMockBuilder(Credentials::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->connectionParams = [
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'dbname' => 'deployer_db',
            'user' => 'root',
            'password' => ''
        ];

        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->credentialsRepository = $this->getMockBuilder(CredentialRepository::class)
            ->setMethods(['createEntityManager'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->credentialsRepository->expects($this->atLeastOnce())
            ->method('createEntityManager')
            ->willReturn($this->entityManager);
    }

    public function testSaveCredentialsOfNotExistCustomer()
    {
        $this->credentialsRepository->saveCredentials($this->credentialsMock);
    }

    public function testSaveCredentialsOfExistCustomer()
    {
        $id = 1;
        $this->credentialsMock->setId($id);
        $this->credentialsRepository->saveCredentials($this->credentialsMock);
    }

    public function testFindById()
    {
        $entityRepository = $this->getMockBuilder(\Doctrine\ORM\EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($this->credentialsMock);
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($entityRepository);

        $this->credentialsRepository->findById(1);
    }
}
