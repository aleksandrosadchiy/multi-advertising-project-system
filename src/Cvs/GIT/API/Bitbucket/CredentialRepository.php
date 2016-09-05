<?php

namespace Deployer\Cvs\GIT\Api\Bitbucket;

use Deployer\Entity\Credentials;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class CredentialRepository
{
    const DEV_MOD = true;

    /** @var  EntityManager */
    protected $entityManager;

    /** @var array|null  */
    protected $connectionParams = [];

    public function __construct($connectionParams)
    {
        $this->connectionParams = $connectionParams;
    }

    /**
     * @return EntityManager
     */
    public function createEntityManager()
    {
        /** @TODO: change configuration path */
        $config = Setup::createAnnotationMetadataConfiguration(array(PROJECT_DIR . "/src/Entity/"), self::DEV_MOD, null, null, false);
        /** @var  \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = EntityManager::create($this->connectionParams, $config);

        return $entityManager;
    }

    /**
     * @param Credentials $credentials
     * @return void
     */
    public function saveCredentials(Credentials $credentials)
    {
        /** @var \Doctrine\ORM\EntityManager $manager */
        $manager = $this->createEntityManager();

        if (!$credentials->getId()) {
            $manager->persist($credentials);
            $manager->flush();
        } else {
            $manager->merge($credentials);
            $manager->flush();
        }
    }

    /**
     * @param $entityName
     * @param $id
     * @return null|object
     */
    public function findById($id)
    {
        /** @var \Doctrine\ORM\EntityManager $manager */
        $manager = $this->createEntityManager();
        $entity = $manager->getRepository(Credentials::class)->find($id);

        return $entity;
    }
}

