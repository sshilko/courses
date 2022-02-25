<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Tag;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionTagFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        TagFactory::createMany(100);

        #QuestionTagFactory::createMany(10);

        #$questions = QuestionFactory::createMany(20);

//        $questions = QuestionFactory::createMany(20, [
//            'questionTags' => QuestionTagFactory::randomRange(0, 5)
//        ]);

        $questions = QuestionFactory::createMany(20, function() {
            /**
             * QuestionTagFactory inside is aware that it's being called by QuestionFactory
             * it will RE-USE Question instead of creating a new one inside QuestionTagFactory::new()
             *
             * but we have addQuestionTag and removeQuestionTag, but
             * NO setQuestionTag in App\Entity\Question
             * accessor is smart to use those
             * but it expects array/collection, WORK AROUND with many(1)
             */
            return ['questionTags' => QuestionTagFactory::new(function() {
                /**
                 * use callback to randomize on EACH of Question creation
                 */
                return ['tag' => TagFactory::random()];
            })->many(1, 5)];
        });
        /** ABOVE AND BELOW IS SAME AS PRE-CREATING questions and tags */
        #$questions = QuestionFactory::createMany(20);
//        QuestionTagFactory::createMany(100, function() {
//            return [
//                'tag' => TagFactory::random(),
//                'question' => QuestionFactory::random(),
//            ];
//        });


//        $questions = QuestionFactory::createMany(20, [
//            'tags' => TagFactory::randomRange(0, 5)
//        ]);

        #$questions = QuestionFactory::createMany(20, function() {
        #    return ['tags' => TagFactory::randomRange(0, 5)];
        #});


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

        AnswerFactory::new(function () use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]
            ];
        })->needsApproval()->many(20)->create();

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

        #get proxy object
        #$question = QuestionFactory::createOne();

        #get pure entity object
        $question = QuestionFactory::createOne()->object();
        $tag1 = new Tag();
        $tag1->setName('dinosaurs');
        $tag2 = new Tag();
        $tag2->setName('monster trucks');

        #$tag1->addQuestion($question);
        #$tag2->addQuestion($question);

        $manager->persist($tag1);
        $manager->persist($tag2);

        #$question->addTag($tag1);
        #$question->addTag($tag2);

        $manager->flush();
    }
}
