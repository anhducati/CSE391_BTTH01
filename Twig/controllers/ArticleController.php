<?php
include("models/Article.php");
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;



class ArticleController{
    // Hàm xử lý hành động index
    public function index(){
        $loader = new FilesystemLoader('views/admin/article');
        $twig = new Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
         $articelService =new Article();
         $articles = $articelService ->getAllArticles_admin();
        //$articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        echo $twig->render('article.twig', ['articles' => $articles]);
       
    }
    public function add(){
        $loader = new FilesystemLoader('views/admin/article');
        $twig = new Environment($loader);
        $articelService =new Article();
        $categorys = $articelService ->getAllCategory();
        $authors = $articelService ->getAllAuthor();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tieude = trim($_POST["tieude"]);
            $ten_bhat = trim($_POST["ten_bhat"]);
            $ten_tloai = trim($_POST["ten_tloai"]);
            $tomtat = trim($_POST["tomtat"]);
            $noidung = trim($_POST["noidung"]);
            $ten_tlgia = trim($_POST["ten_tlgia"]);
            $hinhanh = trim($_POST["hinhanh"]);
            $articelService =new Article();
            $articles = $articelService ->Add($tieude,$ten_bhat,$ten_tloai,$tomtat,$noidung,$ten_tlgia,$hinhanh);
            header("location: index.php?controller=article");
        }

        echo $twig->render('add.twig', ['categorys'=> $categorys,'authors' => $authors]);
      //  echo $twig->render('add.twig', ['authors' => $authors]);
    }
   
    public function update(){
        $loader = new FilesystemLoader('views/admin/article');
        $twig = new Environment($loader);
        $id = $_GET['id'];
        $articelService =new Article();
        $article = $articelService ->getArticleById($id);
        $categorys = $articelService ->getAllCategory();
        $authors = $articelService ->getAllAuthor();
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tieude = trim($_POST["tieude"]);
            $ten_bhat = trim($_POST["ten_bhat"]);
            $ten_tloai = trim($_POST["ten_tloai"]);
            $tomtat = trim($_POST["tomtat"]);
            $noidung = trim($_POST["noidung"]);
            $ten_tlgia = trim($_POST["ten_tlgia"]);
            $hinhanh = trim($_POST["hinhanh"]);
            $articelService =new Article();
            $article = $articelService ->update($tieude,$ten_bhat,$ten_tloai,$tomtat,$noidung,$ten_tlgia,$hinhanh, $id);
            header("location: index.php?controller=article");
        }
   
        echo $twig->render('edit.twig', ['article'=> $article,'categorys'=> $categorys,'authors' => $authors]);
        
    }
    public function delete(){
        $loader = new FilesystemLoader('views/admin/article');
        $twig = new Environment($loader);
        $id = trim($_GET["id"]);
   
           $articleService = new Article();
           $article = $articleService->DeleteArticle($id);
           header("location: index.php?controller=article");
               
        echo $twig->render('article.twig',['id' => $id]);
        
    }
    
}