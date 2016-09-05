<?php

namespace Deployer;

use Deployer\Controller\FrontController;

require PROJECT_DIR . 'vendor/autoload.php';


/**
 * Class DI
 * @package Deployer\App
 */
class Bootstrap
{
    /**
     * @return self
     */
    public function start()
    {
        /** @var FrontController $frontController */
        $frontController = $this->getDiContainer()->get('frontController');
        $frontController->dispatch();
        return $this;
    }


    public function getDiContainer($serviceFile = 'configurations/service.xml')
    {
        /** @var \Symfony\Component\DependencyInjection\ContainerBuilder $diContainer */
        $diContainer = new \Symfony\Component\DependencyInjection\ContainerBuilder();

        /** @var \Symfony\Component\DependencyInjection\Loader\XmlFileLoader $xmlFileLoader */
        $xmlFileLoader = new \Symfony\Component\DependencyInjection\Loader\XmlFileLoader($diContainer,
            new \Symfony\Component\Config\FileLocator(PROJECT_DIR));

        $xmlFileLoader->load(PROJECT_DIR . $serviceFile);

        return $diContainer;
    }
}
