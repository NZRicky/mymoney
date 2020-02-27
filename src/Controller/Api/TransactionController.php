<?php

/**
 * A controller used by API request
 */

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/transaction", name="api_transaction_")
 */
class TransactionController extends AbstractController
{
    /**
     * Create new transaction
     *
     * @Route("/new", name="new", methods={"POST"})
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
                throw new \Exception('Amount is not defined', 400);
            }

            //todo: validate category

            $transaction = new Transaction();
            $transaction->setAmount(floatval($data['amount']));
            $transaction->setCreatedAt(new \DateTimeImmutable());

            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return new JsonResponse(['message' => 'Transaction was created successfully'], 201);
        } catch (\Exception $ex) {
            return new JsonResponse([
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ], $ex->getCode());
        }
    }


    /**
     * List all transactions
     *
     * @Route("/list", name="list", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
    {
        $datas = [];

        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAll();
        foreach ($transactions as $transaction) {
            $datas[] = [
                'date' => $transaction->getCreatedAt()->format('d/m/Y'),
                'id' => $transaction->getId(),
                'amount' => $transaction->getAmount()
            ];
        }

        return new JsonResponse($datas);
    }
}