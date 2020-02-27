<?php

/**
 * A controller used by API request
 */

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category", name="api_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * Create new category
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
            if (!isset($data['name'])) {
                throw new \Exception('Name is not defined', 400);
            }

            //todo: validate category

            $category = new Category();
            $category->setName($data['name']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new JsonResponse(['message' => 'Category was created successfully'], 201);
        } catch (\Exception $ex) {
            return new JsonResponse([
                'code' => $ex->getCode(),
                'message' => $ex->getMessage(),
            ], $ex->getCode());
        }
    }


    /**
     * List all categories
     *
     * @Route("/list", name="list", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
    {
        $datas = [];

        $categorys = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        foreach ($categorys as $category) {
            $datas[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return new JsonResponse($datas);
    }
}