<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data= $form;
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

}