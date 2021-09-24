<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function postNewUser(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setName($data['name']);
        $user->setSurname($data['surname']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

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
}
