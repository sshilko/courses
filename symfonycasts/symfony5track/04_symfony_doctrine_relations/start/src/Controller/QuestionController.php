<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }


    /**
     * @Route("/{page<\d+>}", name="app_homepage")
     */
   #public function homepage(QuestionRepository $repository, Request $request, int $page = 1)
    public function homepage(QuestionRepository $repository, int $page = 1)
    {
        $qbuilder = $repository->createAskedOrderedByNewestQueryBuilder();

        $pagerfanta = new Pagerfanta(
            new QueryAdapter($qbuilder)
        );
        $pagerfanta->setMaxPerPage(5);
#        $pagerfanta->setCurrentPage($request->query->get('page', 1));
        $pagerfanta->setCurrentPage($page);

        return $this->render('question/homepage.html.twig', [
            'pager' => $pagerfanta,
        ]);

//        return $this->render('question/homepage.html.twig', [
//            'questions' => $questions,
//        ]);
    }

    /**
     * @Route("/questions/new")
     */
    public function new()
    {
        return new Response('Sounds like a GREAT feature for V2!');
    }


    /**
     * @Route("/questions/{id<\d+>}", name="app_question_showbyid")
     */
    public function showbyid(Question $question, EntityManagerInterface $entityManager)
    {
        if ($this->isDebug) {
            $this->logger->info('We are in AAA mode!');
        }

        #$arepo = $entityManager->getRepository(Answer::class);
        #$answers = $arepo->findBy(['question' => $question]);

        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show(Question $question)
    {
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }

        return $this->render('question/show.html.twig', [
            'question' => $question
        ]);
    }

//    /**
//     * @Route("/questions/{slug}", name="app_question_show")
//     */
//    public function show(Question $question)
//    {
//        if ($this->isDebug) {
//            $this->logger->info('We are in debug mode!');
//        }
//
//        $answers = $question->getAnswers();
//
//        return $this->render('question/show.html.twig', [
//            'question' => $question,
//            'answers' => $answers,
//        ]);
//    }

    /**
     * @Route("/questions/{slug}/vote", name="app_question_vote", methods="POST")
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        #access POST data, unencoded
        $direction = $request->request->get('direction');

        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug()
        ]);
    }
}
