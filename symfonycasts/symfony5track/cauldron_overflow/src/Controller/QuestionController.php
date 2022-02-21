<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController
{
    /**
     * @Route("/")
     *
     * @param Request $request
     * @return Response
     */
    public function homepage(Request $request): Response
    {
        $myresponse = new Response(content: 'Hello world ' . $request->getHost());
        $myresponse->setDate(date: new \DateTime('-1 day'));
        /**
         * In Symfony, a controller is required to return a Response object
         * https://symfony.com/doc/current/controller.html#the-request-and-response-object
         */
        return new JsonResponse($myresponse->getContent());
    }

    /**
     * @Route("/questions/{someArg1}")
     *
     */
    public function show($someArg1)
    {
        return new Response("slug-value=" . strtoupper($someArg1));
    }

    /**
     * @Route("/notquestions/abcdefg")
     *
     */
    public function show1()
    {
        return new Response("todo");
    }

}