<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Repository\ProductRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/user/register', name: 'user_register',methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager, RoleRepository $roleRepository): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserRegisterType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
            // $role = $roleRepository->findBy(['role' => 'ROLE_USER'],null,20, ($page-1)*20);
            $role = $roleRepository->findBy(['role' => 'ROLE_USER']);
            $user->setRoles($role);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'userForm' => $userForm->createView()]);
    }

    #[Route('/user/dashboard', name: 'user_dashboard')]
    public function userDashboard(ProductRepository $productRepository, UserRepository $userRepository): Response {
        $user = $userRepository->find($this->getUser());

        $products = $productRepository->findBy(["User" => $user]);

        return $this->render('user/dashboard.html.twig',[
            'products' => $products
        ]);
    }

    #[Route('/user/settings', name: 'user_settings')]
    public function userSettings(): Response {


        return $this->render('user/setting.html.twig');
    }

}
