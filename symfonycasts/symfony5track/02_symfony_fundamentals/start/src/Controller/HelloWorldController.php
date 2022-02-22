<?php

namespace App\Controller;

use App\Util\SayWhatInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    private LoggerInterface $logger;

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/hello")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SayWhatInterface $helloWorld, LoggerInterface $log)
    {
        #$sameService = $this->container->get('App\Services\HelloWorldService');
        #$log->info($sameService->sayWhat()->getContent());
        $this->logger->info('hello this logger was autowired via required setter');

        return $helloWorld->sayWhat();
    }

}