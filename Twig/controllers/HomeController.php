<?php
include("models/Article.php");
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;



class HomeController{
    // Hàm xử lý hành động index
    public function index(){
        $loader = new FilesystemLoader('views/home');
       $twig = new Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
         $articelService =new Article();
         $articles = $articelService ->getAllArticles();
        //$articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        echo $twig->render('index.twig', ['articles' => $articles]);
       
    }

    public function detail(){
        $loader = new FilesystemLoader('views/home');
        $twig = new Environment($loader);

        $id = isset($_GET['id'])? $_GET['id']: 2;
        $articleService = new Article();
        $article = $articleService->getArticlesDetail($id);
        echo $twig->render('detail.twig', ['article' => $article]);
    }
    public function login(){
        $loader = new FilesystemLoader('views/home');
        $twig = new Environment($loader);

        echo $twig->render('login.twig');
    }
    
}