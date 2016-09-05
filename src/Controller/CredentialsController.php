<?php

namespace Deployer\Controller;

use Deployer\Block\AbstractBlock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Deployer\Bootstrap as Bootstrap;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CredentialsController extends Controller
{
    /** @var Bootstrap */
    protected $diContainer;
    /** @var  AbstractBlock */
    private $block;

    /**
     * CredentialsController constructor.
     */
    public function __construct()
    {
        $this->diContainer = new Bootstrap();
        $this->setContainer($this->diContainer->getDiContainer());
        $this->block = new AbstractBlock();
    }

    public function indexAction($result, $request)
    {
        $this->block->setArguments([
            'result' => $result,
            'request' => $request
        ]);

        $this->block->setTemplatesDir(realpath(__DIR__));
        $this->block->findTemplates($result);


        return new Response($this->block->toHtml());
    }

    public function saveCredentialsAction(
        $result,
        \Symfony\Component\HttpFoundation\Request $request
    )
    {
        /** @var array $postData */
        $postData = $request->request->all();
        /** @var \Deployer\Cvs\GIT\Api\Bitbucket\CredentialFacade $credentialFacade */
        $credentialFacade = $this->container->get('credentialFacade');

        if ($postData) {
            try {
                $credentialFacade->obtainPrimaryCredentials(
                    null, $postData['consumerPublicKey'],
                    $postData['consumerSecretKey'],
                    $postData['consumerCode']
                );
                $referer = $request->headers->get('referer');

                return $this->redirect($referer);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function obtainRefreshTokenAction(
        $result,
        \Symfony\Component\HttpFoundation\Request $request
    )
    {
        /** @var \Deployer\Cvs\GIT\Api\Bitbucket\CredentialFacade $credentialFacade */
        $credentialFacade = $this->container->get('credentialFacade');

        $credentialFacade->requestRefreshToken($_REQUEST['id']);
    }

    public function obtainNewAccessTokenAction(
        $result,
        \Symfony\Component\HttpFoundation\Request $request
    )
    {
        /** @var \Deployer\Cvs\GIT\Api\Bitbucket\CredentialFacade $credentialFacade */
        $credentialFacade = $this->container->get('credentialFacade');

        $credentialFacade->requestRefreshToken($_REQUEST['id']);

    }
}