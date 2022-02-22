<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments/{id}/vote/{direction<up|down>}", methods="POST")
     */
    public function commentVote($id, $direction, LoggerInterface $logger)
    {
        //use id to query to database

        // use real to save/fetch
        if ($direction === 'up') {
            $logger->info('Voting up');
            $currentVoteCount = random_int(7, 100);
        } else {
            $logger->info('Voting down');
            $currentVoteCount = random_int(0, 5);
        }

        //return new JsonResponse(['votes' => $currentVoteCount]);
        return $this->json(['votes' => $currentVoteCount]);
    }
}