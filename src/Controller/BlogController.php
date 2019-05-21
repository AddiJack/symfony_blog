<?php
/**
 * Created by PhpStorm.
 * User: addi
 * Date: 2019-05-13
 * Time: 10:36
 */

// src/Controller/BlogController.php
namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * Show all row from article's entity
     *
     * @Route("/", name="app_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * Show all row from article's entity
     *
     * @Route("/blog/category/{category}", name="show_category")
     * @return Response A response instance
     */

    /* public function showByCategory(string $category)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($category);
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            -> findByCategory($category,['id'=> 'DESC'],3);

        return $this->render(
            'blog/category.html.twig',
        [
            'category' => $category,
            'articles' => $article
        ]
        );
    }
    */

    /**
     * Show all row from article's entity
     *
     * @Route("/blog/category/{name}", name="show_category")
     * @return Response A response instance
     */

     public function showByCategory(Category $category)
    {
        $article = $category->getArticles();

        return $this->render(
            'blog/category.html.twig',
        [
            'category' => $category,
            'articles' => $article
        ]
        );
    }
}