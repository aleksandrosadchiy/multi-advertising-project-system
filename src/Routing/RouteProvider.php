<?php

namespace Deployer\Routing;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteProvider
 * @package Deployer\Routing
 */
class RouteProvider
{
    /**
     * @return RouteCollection
     */
    public function getCollection()
    {
        $locator = new FileLocator(array(PROJECT_DIR));
        $loader = new XmlFileLoader($locator);
        $routeCollection = $loader->load('configurations/routes.xml');

        return $routeCollection;
    }
}