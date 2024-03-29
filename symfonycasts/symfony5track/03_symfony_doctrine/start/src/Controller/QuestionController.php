<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
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
     * @Route("/", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $entityManager, QuestionRepository $repo)
    {
        #$repo = $entityManager->getRepository(Question::class);
        #$questions = $repo->findBy([], ['askedAt' => 'DESC']);
        #dd($questions);

        $questions = $repo->findAllAskedOrderedByNewest();

        return $this->render('question/homepage.html.twig', [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/questions/new")
     */
    public function new(MarkdownHelper $markdownHelper, EntityManagerInterface $entityManager)
    {
//        $question = new Question();
//        $question->setName('Missing pants')
//            ->setSlug('missing-pants-' . random_int(0, 9999))
//            ->setQuestion(<<<EOF
//Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
//to make my dishes wash themselves. But while I was casting it,
//I slipped a little and I think `I also hit my pants with the spell`.
//When I woke up this morning, I caught a quick glimpse of my pants
//opening the front door and walking out! I've been out all afternoon
//(with no pants mind you) searching for them.
//Does anyone have a spell to call your pants back?
//EOF
//            );
//        if (random_int(1, 10) > 2) {
//            $question->setAskedAt(new \DateTimeImmutable('-' . random_int(1, 100) . ' days'));
//        }
//
//        $question->setVotes(random_int(-20, 50));
//
//        $entityManager->persist($question);
//        $entityManager->flush();

        return new Response('great feature for v2 forms');
    }

    /**
     * @Route("/questions/oldnew")
     */
    public function oldnew(MarkdownHelper $markdownHelper, EntityManagerInterface $entityManager)
    {
        $question = new Question();
        $question->setName('Missing pants')
            ->setSlug('missing-pants-' . random_int(0, 9999))
            ->setQuestion(<<<EOF
Hi! So... I'm having a *weird* day. Yesterday, I cast a spell
to make my dishes wash themselves. But while I was casting it,
I slipped a little and I think `I also hit my pants with the spell`.
When I woke up this morning, I caught a quick glimpse of my pants
opening the front door and walking out! I've been out all afternoon
(with no pants mind you) searching for them.
Does anyone have a spell to call your pants back?
EOF
            );
        if (random_int(1, 10) > 2) {
            $question->setAskedAt(new \DateTimeImmutable('-' . random_int(1, 100) . ' days'));
        }

        $question->setVotes(random_int(-20, 50));

        $entityManager->persist($question);
        $entityManager->flush();

        return new Response(sprintf('Hello! New question id is #%d, slug %s', $question->getId(), $question->getSlug()));
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show(Question $question)
   #public function show($slug, MarkdownHelper $markdownHelper, EntityManagerInterface $entityManager)
    {
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }

//        $repository = $entityManager->getRepository(Question::class);
//        /** @var Question|null $question */
//        $question = $repository->findOneBy(['slug' => $slug]);
//
//        if (!$question) {
//            throw $this->createNotFoundException('No question found for slug');
//        }
        //dd($question);

        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        #$questionText = 'I\'ve been turned into a cat, any *thoughts* on how to turn back? While I\'m **adorable**, I don\'t really care for cat food.';

        #$parsedQuestionText = $markdownHelper->parse($questionText);

        return $this->render('question/show.html.twig', [
            #'question' => ucwords(str_replace('-', ' ', $slug)),
            'question' => $question,
            #'questionText' => $parsedQuestionText,
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/questions/{slug}/vote", name="app_question_vote", methods={"POST"})
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        $direction = $request->request->get('direction');
        if ($direction === 'up') {
            $question->upvote();
        } elseif ($direction === 'down') {
            $question->downvote();
        }

        /**
         * Smart to do update instead of insert
         */
        $entityManager->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug()
        ]);
    }

}
