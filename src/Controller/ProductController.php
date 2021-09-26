<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/app/add/product', name: 'add_product')]
    public function addProduct(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $product = new Product();
        $productForm = $this->createForm(ProductFormType::class, $product);
        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $file = $productForm['imgMiniature']->getData();
            if ($file) {
                $newFilename = uniqid().'.'.$file->guessExtension();
                try {
                    if ($file->move($this->getParameter('img_directory'), $newFilename)) {
                        $product->setImgMiniature($newFilename);
                    }
                } catch (FileException $e) {
                    dd($e);
                }
            }

            $product->setAddedAt(new \DateTime());

            $user = $userRepository->find($this->getUser());
            $product->setUser($user);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('product/index.html.twig', [
            'productForm' => $productForm->createView(),
        ]);
    }
}
