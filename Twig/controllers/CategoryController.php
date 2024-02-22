<?php
include("models/Category.php");
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class CategoryController{
    public function index(){
        $loader = new FilesystemLoader('views/admin/category');
       $twig = new Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
         $categoryService =new Category();
         $categorys = $categoryService ->getAllCategory();
        //$articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        echo $twig->render('category.twig', ['categorys' => $categorys]);
       
    }
    public function add(){
        $loader = new FilesystemLoader('views/admin/category');
        $twig = new Environment($loader);
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $category = trim($_POST["tenloai"]);
            $categoryService = new Category();
            $category = $categoryService->AddCategory($category);
            header("location: index.php?controller=category");
        }        
        echo $twig->render('add.twig');
    
    }

    public function update(){
        $loader = new FilesystemLoader('views/admin/category');
        $twig = new Environment($loader);
        $id = $_GET['id'];
        $categoryService = new Category();
        $category = $categoryService->getCategoryById($id);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $category = trim($_POST["ten_tloai"]);
            $categoryService = new Category();
            $category = $categoryService->UpdateCategory($category,$id);
            header("location: index.php?controller=category");
        }
        echo $twig->render('edit.twig',['category' => $category]);
        
    }

    public function delete(){
        $loader = new FilesystemLoader('views/admin/category');
        $twig = new Environment($loader);
        $id = trim($_GET["id"]);
   
           $categoryService = new Category();
           $category = $categoryService->DeleteCategory($id);
           header("location: index.php?controller=category");
               
        echo $twig->render('category.twig',['id' => $id]);
        
    }
  


}