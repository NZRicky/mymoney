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
/**
 * @Route("/api")
 */
class ApiController
{

    /**
     * @Route("/", name="api_index")
     * @return Response
     */
    public function index(UserPasswordEncoderInterface $encoder): Response
    {

        $a = 'b';
        return new Response('ok');
    }

}