<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Couchbase\defaultDecoder;

class ModeratorController extends AbstractController
{
    #[Route('/moderator/dashboard', name: 'moderator_dashboard')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('moderator/index.html.twig', [
            'products' => $products,
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

    #[Route('/moderator/script', name: 'moderator_script')]
    public function generateProducts(EntityManagerInterface $entityManager, UserRepository$userRepository, UserPasswordHasherInterface $userPasswordHasher, RoleRepository $roleRepository)
    {
        $randomUser1 = $userRepository->findOneBy(['email' => 'ramdomAccount1@mail.com']);
        if ($randomUser1 == null) {
            $randomUser1 = new User();
            $randomUser1->setName("randomName1");
            $randomUser1->setSurname("randomSurname1");
            $randomUser1->setPassword($userPasswordHasher->hashPassword($randomUser1, "123456789"));
            $randomUser1->setEmail('ramdomAccount1@mail.com');
            $role = $roleRepository->findBy(['role' => 'ROLE_USER']);
            $randomUser1->setRoles($role);

            $entityManager->persist($randomUser1);
            $entityManager->flush();
        }
        $randomUser2 = $userRepository->findOneBy(['email' => 'ramdomAccount2@mail.com']);
        if ($randomUser2 == null) {
            $randomUser2 = new User();
            $randomUser2->setName("randomName2");
            $randomUser2->setSurname("randomSurname2");
            $randomUser2->setPassword($userPasswordHasher->hashPassword($randomUser2, "123456789"));
            $randomUser2->setEmail('ramdomAccount2@mail.com');
            $role = $roleRepository->findBy(['role' => 'ROLE_USER']);
            $randomUser2->setRoles($role);

            $entityManager->persist($randomUser2);
            $entityManager->flush();
        }
        $randomUser3 = $userRepository->findOneBy(['email' => 'ramdomAccount3@mail.com']);
        if ($randomUser3 == null) {
            $randomUser3 = new User();
            $randomUser3->setName("randomName3");
            $randomUser3->setSurname("randomSurname3");
            $randomUser3->setPassword($userPasswordHasher->hashPassword($randomUser3, "123456789"));
            $randomUser3->setEmail('ramdomAccount3@mail.com');
            $role = $roleRepository->findBy(['role' => 'ROLE_USER']);
            $randomUser3->setRoles($role);

            $entityManager->persist($randomUser3);
            $entityManager->flush();
        }

        $users = [];
        $allUsers = $userRepository->findAll();
        foreach ($allUsers as $user) {
            if (in_array('ROLE_USER', $user->getRoles())) {
                array_push($users, $user);
            }
        }
        $images = ["avion.PNG", "canard.jpg", "casquette.jpg", "chau0000.png", "chaussettes.jpg", "manteau.jpg"];
        if ($users != null) {
            for ($i = 0; $i < 150; $i++) {
                $randomUser = $users[array_rand($users)];
                $image = $images[array_rand($images)];
                $product = new Product();
                $product->setName("random Product ".substr($image, 0, -4).$i);
                $product->setDescription("Description " .substr($image, 0, -4));
                $product->setImgMiniature($image);
                $product->setAddedAt(new \DateTime());
                $product->setIsOnline((bool)rand(0,1));
                $product->setUser($randomUser);
                $product->setPrice(rand(1, 2000));

                $entityManager->persist($product);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('moderator_dashboard');
    }
}