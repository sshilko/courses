<?php

namespace App\Controller;

use App\Services\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class QuestionController extends AbstractController
{
    private LoggerInterface $logger;
    private bool $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $twigEnvironment)
    {
        /*
        // fun example of using the Twig service directly!
        $html = $twigEnvironment->render('question/homepage.html.twig');

        return new Response($html);
        */

        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show($slug, MarkdownParserInterface $markdownParser, CacheInterface $cache, MarkdownHelper $markdownsvc)
    {
        if ($this->isDebug) {
            $this->logger->info('Meow we are in debug mode');
        }

        //sentry integration test
        //throw new \Exception('bad stuff happened ' . date('c'));

        #dump($this->getParameter('cache_adapter'));

        #dump($this->get('my.markdownhelper'));
        #dump($this->container->get('twig'));

        $answers = [
            'Make sure your cat is sitting purrrfectly still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try `saying` the spell backwards?',
        ];

        $questionText = 'I\'ve been turned into a **cat**, any *thoughts* on how to turn back? While I\'m adorable, I don\'t really care for cat food.';
        $mdText = $markdownsvc->parse($questionText);

        //dump($cache);

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'answers' => $answers,
            'questionText' => $mdText
        ]);
    }
}
