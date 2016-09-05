<?php

namespace Deployer\Controller;

use \Deployer\Routing\RouteProvider as Provider;
use \Symfony\Component\Routing\RequestContext as Context;
use \Symfony\Component\Routing\Matcher\UrlMatcher as UrlMatcher;
use \Symfony\Component\HttpKernel\Controller\ControllerResolver as ControllerResolver;

class FrontController
{
    /** @var Provider */
    protected $routeProvider;
    /** @var Context */
    protected $context;

    /** @var ControllerResolver  */
    protected $controllerResolver;

    /**
     * FrontController constructor.
     * @param Provider $routeProvider
     * @param Context $context
     * @param ControllerResolver $controllerResolver
     */
    public function __construct(
        Provider $routeProvider,
        Context $context,
        ControllerResolver $controllerResolver

    )
    {
        $this->routeProvider = $routeProvider;
        $this->context = $context;
        $this->controllerResolver = $controllerResolver;
    }


    public function dispatch()
    {
        $routeProvider = $this->routeProvider;
        $routeCollection = $routeProvider->getCollection();
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        $context = $this->context;

        $context->fromRequest($request);

        $matcher = new UrlMatcher($routeCollection, $context);

        $result = $matcher->match($request->getPathInfo());
        $request->attributes->add($result);
        $controllerR = $this->controllerResolver;
        $rs = $controllerR->getController($request);

        $result = call_user_func_array($rs, [$result, $request]);
        /** @TODO: ResponseHandler */
        echo $result;
    }
}