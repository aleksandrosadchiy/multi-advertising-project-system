<?php

namespace Deployer\Cvs\GIT\Api\Bitbucket;

use Deployer\Entity\Credentials as Credentials;
use Deployer\Transport\AdapterInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CredentialFacade
{
    /** @var CredentialRepository */
    protected $repository;

    /** @var Credentials */
    protected $credentials;

    /** @var AdapterInterface */
    protected $adapter;

    /** @var  string */
    private $method;

    const GRANT_TYPE_AUTORIZATION_CODE = 'authorization_code';

    const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';

    /**
     * CredentialFacade constructor.
     * @param CredentialRepository $repository
     * @param Credentials $credentials
     */
    public function __construct(
        CredentialRepository $repository,
        Credentials $credentials,
        AdapterInterface $adapter,
        $method //ADD Through di
    ) {
        $this->repository = $repository;
        $this->credentials = $credentials;
        $this->adapter = $adapter;
        $this->method = $method;
    }

    /**
     * @param $publicKey
     * @param $secretKey
     * @param $code
     */
    public function obtainPrimaryCredentials($id = null, $publicKey, $secretKey, $code)
    {
        $this->credentials->setId($id);
        $this->credentials->setConsummerPublicKey($publicKey);
        $this->credentials->setConsummerSecretKey($secretKey);
        $this->credentials->setConsummerCode($code);

        $this->repository->saveCredentials($this->credentials);
    }

    /**
     * @param $id
     */
    public function requestRefreshToken($id)
    {
        /** @var Credentials $entity */
        $entity = $this->repository->findById(Credentials::class, (int)$id);

        if (!is_null($entity) && $entity instanceof Credentials) {
            $obtainedCredential = json_decode(
                $this->obtainInformation($entity, self::GRANT_TYPE_AUTORIZATION_CODE, false),true);

            if ($obtainedCredential && isset($obtainedCredential['refresh_token'])) {

                $entity->setConsummerActivationToken($obtainedCredential['access_token']);
                $entity->setTokenSkopes($obtainedCredential['scopes']);
                $entity->setTokenType($obtainedCredential['token_type']);
                $entity->setConsummerRefreshToken($obtainedCredential['refresh_token']);

                $this->repository->saveCredentials($entity);
            } else {
                echo $obtainedCredential['error_description'];
            }
        } else {
            throw new Exception('Customer with id:' . $id . ' not found');
        }
    }

    /**
     * @param $id
     */
    public function requestNewToken($id)
    {
        /** @var Credentials $entity */
        $entity = $this->repository->findById(Credentials::class, (int)$id);

        if (!is_null($entity) && $entity instanceof Credentials) {
            $obtainedCredential = json_decode(
                $this->obtainInformation($entity, self::GRANT_TYPE_REFRESH_TOKEN, true), true);

            if ($obtainedCredential && isset($obtainedCredential['access_token'])) {

                $entity->setConsummerActivationToken($obtainedCredential['access_token']);
                $entity->setTokenSkopes($obtainedCredential['scopes']);
                $entity->setTokenType($obtainedCredential['token_type']);
                $entity->setConsummerRefreshToken($obtainedCredential['refresh_token']);

                $this->repository->saveCredentials($entity);
            } else {
                echo $obtainedCredential['error_description'];
            }
        } else {
            throw new Exception('Customer with id:' . $id . ' not found');
        }
    }

    private function preparePostData(Credentials $credentials, $refresh, $grantType)
    {
        $postData['grant_type'] = $grantType;

        if (!$refresh) {
            $postData['code'] = $credentials->getConsummerCode();
        } else {
            $postData[self::GRANT_TYPE_REFRESH_TOKEN] = $credentials->getConsummerRefreshToken();
        }

        return $postData;
    }

    /**
     * @param Credentials $credentials
     * @param $grantType
     * @param bool $refresh
     * @return mixed
     */
    protected function obtainInformation(Credentials $credentials, $grantType, $refresh)
    {
        $this->adapter->authorize([
            AdapterInterface::USER_NAME => $credentials->getConsummerPublicKey(),
            'user_password' => $credentials->getConsummerSecretKey()
        ]);
        $this->adapter->setData($this->preparePostData($credentials, $refresh, $grantType));
        $this->adapter->setMethod($this->method);

        return $this->adapter->call();
    }
}