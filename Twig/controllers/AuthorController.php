<?php
include("models/Author.php");
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class AuthorController{
    public function index(){
        $loader = new FilesystemLoader('views/admin/author');
       $twig = new Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
         $authorService =new Author();
         $authors = $authorService ->getAllAuthor();
        //$articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        echo $twig->render('author.twig', ['authors' => $authors]);
       
    }
    public function add(){
        $loader = new FilesystemLoader('views/admin/author');
        $twig = new Environment($loader);
        $authorService =new Author();
        $author = $authorService ->getAllAuthor();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tentgia = trim($_POST["tentgia"]);
            $hinhtgia = trim($_POST["hinhtgia"]);
            $authorService = new Author();
            $author = $authorService->AddAuthor($tentgia,$hinhtgia);
            header("location: index.php?controller=author");
        }        
        echo $twig->render('add.twig',['author' => $author]);
    
    }

    public function update(){
        $loader = new FilesystemLoader('views/admin/author');
        $twig = new Environment($loader);
        $id = $_GET['id'];
        $authorService = new Author();
        $author = $authorService->getAuthorById($id);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tentgia = trim($_POST["tentgia"]);
            $hinhtgia = trim($_POST["hinhtgia"]);
            $authorService = new Author();
            $author = $authorService->UpdateAuthor($tentgia,$hinhtgia,$id);
            header("location: index.php?controller=author");
        }
        echo $twig->render('edit.twig',['author' => $author]);
        
    }

    public function delete(){
        $loader = new FilesystemLoader('views/admin/author');
        $twig = new Environment($loader);
        $id = trim($_GET["id"]);
   
           $authorService = new Author();
           $author = $authorService->DeleteAuthor($id);
           header("location: index.php?controller=author");
               
        echo $twig->render('author.twig',['id' => $id]);
        
    }


}