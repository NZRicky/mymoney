<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{

    /**
     * @Route("/abc", name="index")
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function index(UserPasswordEncoderInterface $encoder) {
        return new Response('ok');
        /*
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($encoder->encodePassword($user,'admin'));
        $em->persist($user);
        $em->flush();*/
    }

}