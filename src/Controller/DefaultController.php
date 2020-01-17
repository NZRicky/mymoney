<?php

/**
 * Default controller
 */

declare(strict_types=1);

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(UserPasswordEncoderInterface $encoder): Response
    {
        return new Response('ok');
    }

}