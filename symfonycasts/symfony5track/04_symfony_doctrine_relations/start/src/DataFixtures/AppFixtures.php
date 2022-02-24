<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questions = QuestionFactory::createMany(20);

        QuestionFactory::new()
            ->unpublished()
            ->many(5)
            ->create()
        ;

//        # create object and persist
//        QuestionFactory::new()->unpublished()->create()

//        $answer = new Answer();
//        $answer->setContent('This question is the best? I wish... I knew the answer.');
//        $answer->setUsername('weaverryan');
//
//        $question = new Question();
//        $question->setName('How to un-disappear your wallet.');
//        $question->setQuestion('... I should not have done this...');
//
//        $answer->setQuestion($question);
//
//        $manager->persist($answer);
//        $manager->persist($question);

//        AnswerFactory::createMany(100, [
//            #random() grabs random question from existing/database, applies for
//            'question' => QuestionFactory::random()
//        ]);

//        AnswerFactory::createMany(100,
//            function() {
//                return ['question' => QuestionFactory::random()];
//            });

        AnswerFactory::createMany(100, function() use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]

            ];
        });

//        $question = QuestionFactory::createOne();
//
//        $answer1 = new Answer();
//        $answer1->setContent('answer 1');
//        $answer1->setUsername('weaverryan');
//
//        $answer2 = new Answer();
//        $answer2->setContent('answer 2');
//        $answer2->setUsername('weaverryan');
//
//        $question->addAnswer($answer1);
//        $question->addAnswer($answer2);
//
//        $manager->persist($answer1);
//        $manager->persist($answer2);

        $manager->flush();
    }
}
