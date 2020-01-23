<?php

/**
 * Security controller
 */

declare(strict_types=1);

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_security_login", methods={"POST"})
     * @return Response
     */
    public function login(): Response
    {

        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername()
        ]);
    }

}