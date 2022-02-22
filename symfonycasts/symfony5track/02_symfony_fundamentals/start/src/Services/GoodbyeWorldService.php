<?php

namespace App\Services;

use App\Util\SayWhatInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class GoodbyeWorldService implements SayWhatInterface
{
    private $request;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
    }

    public function sayWhat()
    {
        if ($this->request->query->has('who')) {
            return new Response('Bye ' . $this->request->query->get('who'));
        }
        return new Response('Bye world');
    }

}