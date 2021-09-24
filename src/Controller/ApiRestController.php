<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiRestController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/api/product', name: 'postNewProduct', methods: 'POST')]
    public function postNewProduct(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setImgMiniature($data['img_miniature']);
        $product->setPrice($data['price']);
        $product->setAddedAt(new \DateTime($data['added_at']));
        $product->setIsOnline($data['isOnline']);
        $product->setImg1($data['img1']);
        $product->setImg2($data['img2']);
        $product->setImg3($data['img3']);

        $user = $userRepository->find($data['user']);
        $product->setUser($user);

        $entityManager->persist($product);
        $entityManager->flush();

        $product = $serializer->serialize($product, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($product, 200, [], true);
    }

}
