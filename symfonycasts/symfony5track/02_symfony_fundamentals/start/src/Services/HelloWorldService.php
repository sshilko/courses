<?php

namespace App\Services;

use App\Util\SayWhatInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldService implements SayWhatInterface
{
    private $request;
    private $container;
    private ContainerBagInterface $bag;

    public function __construct(RequestStack $requestStack, ContainerInterface $container, ContainerBagInterface $bag)
    {
        $this->request = $requestStack->getMasterRequest();
        $this->container = $container;
        $this->bag = $bag;
    }

    public function sayWhat()
    {
        $param1 = $this->container->getParameter('env(SOME_ENV)');
        $param2 = $this->bag->get('some_dsn');
        $param3 = $this->bag->get('app.maintenance_mode');
        $dummystr = $this->request->query->get('who') .
            ': ' .
            $param1 .
            '=' .
            $param2 . ' ' . (int) $param3;

        #$dummystr .= json_encode($_ENV);


        if ($this->request->query->has('who')) {
            return new Response('Hello ' . $dummystr);
        }
        return new Response('Hello world');
    }

}