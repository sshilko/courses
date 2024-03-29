<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        QuestionFactory::new()->create();
        QuestionFactory::createMany(3);
        QuestionFactory::createOne();

        QuestionFactory::new()->unpublished()->createMany(5);

        /** OVERTAKEN BY FACTORY/QUESTIONFACTORY by fixture factory https://github.com/zenstruck/foundry */
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
//        $manager->persist($question);
//        $manager->flush();
    }
}
