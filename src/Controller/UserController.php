<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/register', name: 'user_register',methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, RoleRepository $roleRepository): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserRegisterType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
            $role = $roleRepository->findBy(['role' => 'ROLE_USER']);
            $user->setRoles($role);

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login');
    }
}
