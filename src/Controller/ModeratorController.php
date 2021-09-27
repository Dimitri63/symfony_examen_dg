<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ModeratorController extends AbstractController
{
    #[Route('/moderator/dashboard', name: 'moderator_dashboard')]
    public function index(): Response
    {
        return $this->render('moderator/index.html.twig', [
            'controller_name' => 'ModeratorController',
        ]);
    }

    #[Route('/dev/moderator', name: 'add_account_moderator', methods: 'POST')]
    public function addAccountModerator(RoleRepository $roleRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setName("Moderator");
        $user->setSurname('Moderator');
        $user->setEmail("moderator@mod.com");
        $user->setPassword($userPasswordHasher->hashPassword($user, "123456789"));

        $role = $roleRepository->findBy(['role' => 'ROLE_MODERATOR']);
        $user->setRoles($role);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

}