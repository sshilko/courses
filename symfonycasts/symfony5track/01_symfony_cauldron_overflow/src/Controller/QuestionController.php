<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     *
     * @return Response
     */
    public function homepage(Request $request, Environment $twigEnv): Response
    {
        //$html = $twigEnv->render('question/homepage.html.twig');
        //return new Response($html);
        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{someArg2}", name="app_question_show")
     *
     */
    public function show($someArg2)
    {
        $answers = [
            "Answer 1",
            'Answer 2',
            'Answer 3'
        ];

        //dd($someArg2, $this);
        //dump($someArg2, $this);
        #dump($this);

        return $this->render('question/show.html.twig',
            [
                'question' => ucwords(str_replace('-', ' ', $someArg2)),
                'fookijasdfasdfautocompleteme' => 'bar' . time(),
                'answers' => $answers
            ]);
    }

//    /**
//     * @Route("/json1")
//     *
//     * @param Request $request
//     * @return Response
//     */
//    public function jsonpage(Request $request): Response
//    {
//        $myresponse = new Response(content: 'Hello json world ' . $request->getHost());
//        $myresponse->setDate(date: new \DateTime('-1 day'));
//        /**
//         * By Extending the Abstract class we now have access to shortcuts (i.e. $this->json) methods
//         */
//        return $this->json($myresponse->getContent());
//    }

//    /**
//     * @Route("/questions1/{someArg1}")
//     *
//     */
//    public function showhtml($someArg1)
//    {
//        return new Response("slug-value=" . strtoupper($someArg1));
//    }
//
//    /**
//     * @Route("/notquestions/abcdefg")
//     *
//     */
//    public function show1()
//    {
//        return new Response("todo");
//    }

}