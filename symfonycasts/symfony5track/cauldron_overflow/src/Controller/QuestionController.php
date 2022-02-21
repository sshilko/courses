<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
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
     * @Route("/json1")
     *
     * @param Request $request
     * @return Response
     */
    public function jsonpage(Request $request): Response
    {
        $myresponse = new Response(content: 'Hello json world ' . $request->getHost());
        $myresponse->setDate(date: new \DateTime('-1 day'));
        /**
         * By Extending the Abstract class we now have access to shortcuts (i.e. $this->json) methods
         */
        return $this->json($myresponse->getContent());
    }

    /**
     * @Route("/questions/{someArg2}")
     *
     */
    public function show($someArg2)
    {
        $answers = [
            'aaa',
            'bbb',
            'ccc'
        ];

        return $this->render('question/show.html.twig',
            [
                'question' => ucwords(str_replace('-', ' ', $someArg2)),
                'fookijasdfasdfautocompleteme' => 'bar' . time(),
                'answers' => $answers
            ]);
    }


    /**
     * @Route("/questions1/{someArg1}")
     *
     */
    public function showhtml($someArg1)
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