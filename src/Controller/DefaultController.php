<?php
/**
 * Created by PhpStorm.
 * User: addi
 * Date: 2019-05-13
 * Time: 10:36
 */

// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route(name="default")
     */
    public function index()
    {
        return $this->render('default.html.twig');
    }
}