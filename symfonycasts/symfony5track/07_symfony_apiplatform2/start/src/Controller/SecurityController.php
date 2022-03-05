<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function login(IriConverterInterface $iriConverter): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json(['error' => 'Invalid content type header'], 400);
        }
//        return $this->json([
//            'user' => $this->getUser() ? $this->getUser()->getId() : null
//        ]);

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($this->getUser())
        ]);
    }
}
