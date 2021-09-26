<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserRegisterType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, UserPasswordHasherInterface $userPasswordHasher, RoleRepository $roleRepository, EntityManagerInterface $entityManager): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $userForm = $this->createForm(UserRegisterType::class, $user);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'userForm' => $userForm->createView()]);
    }

    /**
     * @Route("user/password_forget", name="passwordForget")
     */
    public function passwordForget() {
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('app_login');
    }
}
