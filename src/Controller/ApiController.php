<?php

/**
 * A controller used by API request
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(UserPasswordEncoderInterface $encoder): Response
    {

        $a = 'b';
        return new Response('ok');
    }

    /**
     * Create new transaction
     *
     * @Route("/transaction/new", name="transaction_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        try {
            $content = $request->getContent();
            $data = json_decode($content, true);

            // validate incoming content
            if (!isset($data['amount'])) {
                throw new \Exception('Amount is not defined.', 400);
            }

            //todo: validate category

            $transaction = new Transaction();
            $transaction->setAmount($data['amount']);
            $transaction->setCreatedAt(new \DateTimeImmutable());

            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return new JsonResponse(['message' => 'Transaction was created successfully'], 201);
        } catch (\Exception $ex) {
            return new JsonResponse(['message' => $ex->getMessage()], $ex->getCode());
        }

    }
}