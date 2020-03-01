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

            if (!preg_match("/^[0-9]+(\.[0-9]+)?$/",$data['amount'])) {
                throw new \Exception('Amount must be a valid number', 400);
            }

            //validate category
            if (!isset($data['category'])) {
                throw new \Exception('Category is not defined', 400);
            }

            if (!preg_match("/[0-9]+/",$data['category'])) {
                throw new \Exception('Category must be a valid number', 400);
            }

            $em = $this->getDoctrine()->getManager();

            $category = $em->getRepository('Category')->findOneById($data['category']);
            if (!$category) {
                throw new \Exception('Category is valid', 400);
            }

            $transaction = new Transaction();
            $transaction->setAmount(floatval($data['amount']));
            $transaction->setCreatedAt(new \DateTimeImmutable());
            $transaction->setCategory($category);


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