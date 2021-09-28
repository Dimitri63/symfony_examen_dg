<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PublicRestController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/user', name: 'postNewUser', methods: 'POST')]
    public function postNewUser(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        RoleRepository $roleRepository,
        UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setName($data['name']);
        $user->setSurname($data['surname']);
        $user->setEmail($data['email']);
        $user->setPassword($userPasswordHasher->hashPassword($user, $data['password']));

        $roles = $roleRepository->findAll();
        $roleList = [];
        foreach ($roles as $role) {
            if ($role->getRole()==$data['roles']) {
                array_push($roleList, $role);
            }
        }
        $user->setRoles($roleList);

        $entityManager->persist($user);
        $entityManager->flush();

        $user = $serializer->serialize($user, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($user, 200, [], true);
    }

    /**
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/users', name: 'getAllUsers', methods: 'GET')]
    public function getAllUsers(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $userRepository->findAll();

        $users = $serializer->serialize($users, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($users, 200, [], true);
    }

    /**
     * @param int $userId
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/user/{userId}', name: 'getUserById', methods: 'GET')]
    public function getUserById(int $userId, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $user = $userRepository->find($userId);

        $user = $serializer->serialize($user, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($user, 200, [], true);
    }

    /**
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/products', name: 'getAllProducts', methods: 'GET')]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();

        $products = $serializer->serialize($products, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($products, 200, [], true);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/public/product', name: 'postNewProduct', methods: 'POST')]
    public function postNewProduct(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setImgMiniature($data['img_miniature']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setAddedAt(new \DateTime($data['added_at']));
        $product->setIsOnline($data['isOnline']);

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

    /**
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/products/online', name: 'getAllProductsIsOnline', methods: 'GET')]
    public function getAllProductsIsOnline(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findBy(['isOnline' => true]);

        $products = $serializer->serialize($products, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($products, 200, [], true);
    }

    /**
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/public/products/online/user/{userId}', name: 'getAllProductsIsOnlineByUser', methods: 'GET')]
    public function getAllProductsIsOnlineByUser(int $userId, ProductRepository $productRepository, SerializerInterface $serializer, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($userId);
        $products = $productRepository->findBy(['isOnline' => true, 'User' => $user]);

        $products = $serializer->serialize($products, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($products, 200, [], true);
    }


    #[Route('/public/products/{page}', name: 'getAllProductsIsOnlineByPage', methods: 'GET')]
    public function getAllProductsIsOnlineByPage(int $page, Request $request, ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $page = $page * 20 - 20;
        $products = $productRepository->findBy(['isOnline' => true], null, 20, $page);
        $products = $serializer->serialize($products, "json", [
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            }
        ]);

        return new JsonResponse($products, 200, [], true);
    }
}