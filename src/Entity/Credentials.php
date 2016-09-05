<?php

namespace Deployer\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="consummer_entity")
 */
class Credentials
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     */
    protected $consummerPublicKey;

    /**
     * @ORM\Column(type="string",  nullable=true, length=180)
     */
    protected $consummerSecretKey;


    /**
     * @ORM\Column(type="string", nullable=true,  length=180)
     */
    protected $consummerCode;

    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     */
    protected $consummerActivationToken;

    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     */
    protected $consummerRefreshToken;

    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     *
     */

    protected $tokenType;

    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     *
     */

    protected $tokenScopes;

    /**
     * @ORM\Column(type="datetime", nullable=true, length=180)
     *
     */

    protected $expiresIn;

    /**
     * @ORM\Column(type="datetime", nullable=true, length=180)
     *
     */
    protected $createAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, length=180)
     *
     */
    protected $refreshTokenLastUpdate;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @param $consummer_public_key
     * @return mixed
     */
    public function setConsummerPublicKey($consummerPublicKey)
    {
        return $this->consummerPublicKey = $consummerPublicKey;
    }

    public function getConsummerPublicKey()
    {
        return $this->consummerPublicKey;
    }

    /**
     * @param $consummer_secret_key
     * @return mixed
     */
    public function setConsummerSecretKey($consummerSecretKey)
    {
        return $this->consummerSecretKey = $consummerSecretKey;
    }

    public function getConsummerSecretKey()
    {
        return $this->consummerSecretKey;
    }

    /**
     * @param $consummer_code
     * @return mixed
     */
    public function setConsummerCode($consummerCode)
    {
        return $this->consummerCode = $consummerCode;
    }

    /**
     * @param $consummer_code
     * @return mixed
     */
    public function getConsummerCode()
    {
        return $this->consummerCode;
    }

    /**
     * @param $consummer_activation_token
     * @return mixed
     */
    public function setConsummerActivationToken($consummerActivationToken)
    {
        return $this->consummerActivationToken = $consummerActivationToken;
    }

    /**
     * @return mixed
     */
    public function getConsummerActivationToken()
    {
        return $this->consummerActivationToken;
    }

    /**
     * @param $consummer_refresh_token
     * @return mixed
     */
    public function setConsummerRefreshToken($consummerRefreshToken)
    {
        return $this->consummerRefreshToken = $consummerRefreshToken;
    }

    /**
     * @return mixed
     */
    public function getConsummerRefreshToken()
    {
        return $this->consummerRefreshToken;
    }

    /**
     * @param $refresh_token_last_update
     * @return mixed
     */
    public function setRefreshTokenLasUpdate()
    {
        return $this->refreshTokenLastUpdate = $this->prepareDateToSave();
    }

    /**
     * @return mixed
     */
    public function getRefreshTokenLasUpdate()
    {
        return $this->refreshTokenLastUpdate;
    }

    /**
     * @param $token_type
     * @return mixed
     */
    public function setTokenType($token_type)
    {
        return $this->token_type = $token_type;
    }

    /**
     * @return mixed
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @param $token_scopes
     * @return mixed
     */
    public function setTokenSkopes($tokenScopes)
    {
        return $this->tokenScopes = $tokenScopes;
    }

    /**
     * @return mixed
     */
    public function getTokenSkopes()
    {
        return $this->tokenScopes;
    }

    /**
     * @param $expires_in
     */
    public function setTokenExpiresIn($expiresIn)
    {
        $this->expiresIn = $this->prepareDateToSave($expiresIn);
    }

    /**
     * @return mixed
     */
    public function getTokenExpiresIn()
    {
        return $this->expiresIn;
    }
    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createAt;
    }
}