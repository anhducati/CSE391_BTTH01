<?php
include("models/Member.php");
include("models/Email.php");
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MemberController{
    public function signup(){
            $loader = new FilesystemLoader('views/home');
            $twig = new Environment($loader);
    
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $full_name = trim($_POST["full_name"]);
                $username = trim($_POST["username"]);
                $email = trim($_POST["email"]);
                $password = trim($_POST["password"]);
                $repassword = trim($_POST["repassword"]);
                if($full_name == '' && $username == '' && $email == '' && $password =='' &&  $repassword =='' ){
                   echo "<script>alert('Hãy nhập thông tin đầy đủ');</script>";
                   
                }
                else{
                if($password != $repassword){
                    echo "<script>alert('Mật khẩu không khớp! Vui lòng nhập lại mật khẩu.');</script>";
                    
                }
                else{
                    $memberService = new Member();
                    $count = $memberService->check_account($username,$email);
                    if($count > 0 ){
                        echo "<script>alert('Tên đăng nhập hoặc Email đã được sử dụng');</script>";
                     
                    }else{
                    $memberService = new Member();
                    $member = $memberService->Singup($full_name,$username,$email,$password,$repassword);
                    echo "<script>alert('Đăng kí thành công, vui lòng check Email để kích hoạt tài khoản');
                            window.location.href = 'index.php';
                        </script>";
                                    
                    $memberService = new Member();
                    $member = $memberService->Get_Account($username);
                    $emailServer = new MyEmailServer();
                    $emailSender = new EmailSender($emailServer);
                    $emailSender->send($member['email'] ,$username, $member['active_code'] );
                    }
                   
                }}

            
        }
        echo $twig->render('signup.twig');
    }
    public function active(){
        $loader = new FilesystemLoader('views/admin/member');
        // $loader = new FilesystemLoader('views/home');
        $twig = new Environment($loader);
        $username = $_GET['user'];
        $token = $_GET['token'];
        $memberService = new Member();
        $admins = $memberService->Active($username,$token);
       
        echo $twig->render('active.twig');
    }
    public function loginthang(){
        $loader = new FilesystemLoader('views/admin');
        $twig = new Environment($loader);
        $adminService = new Member();
        $admin = $adminService->getAllCount();
        echo $twig->render('index.twig',['admin' => $admin]);

       
    }
    public function index(){
        $loader = new FilesystemLoader('views/admin/member');
        $twig = new Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
         $membersService =new Member();
         $members = $membersService ->getAllMember();
        //$articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        echo $twig->render('member.twig', ['members' => $members]);
       
    }

    public function login() {
        $loader = new FilesystemLoader('views/home');
        $twig = new Environment($loader);
    
       if($_SERVER["REQUEST_METHOD"] == "POST"){
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            $memberService = new Member();
            $count = $memberService->check_account($username,$username);
            if($count > 0){
            $memberService = new Member();
            $account = $memberService->Get_Account($username);
            $password_saved = $account['password'];
            if(password_verify($password,$password_saved) && $account['is_active']==1){
                $memberService = new Member();
                $admin = $memberService->Login($username,$password);
            }
            else{
            
                echo "<script>alert('Kiểm tra mật khẩu hoặc bạn chưa kích hoạt tài khoản. Vui lòng kiểm tra lại'); </script>"; 
                   
            }
            }else{
              
                echo "<script>alert('Tài khoản không tồn tại. Vui lòng kiểm tra lại'); </script>"; 
            }
            
        }
    
        echo $twig->render('login.twig');
        
    }
    public function delete(){
        $loader = new FilesystemLoader('views/admin/member');
        $twig = new Environment($loader);
        $id = trim($_GET["id"]);
   
           $memberService = new Member();
           $member = $memberService->DeleteMember($id);
           header("location: index.php?controller=member");
               
        echo $twig->render('member.twig',['id' => $id]);
        
    }
    public function update(){
        $loader = new FilesystemLoader('views/admin/member');
        $twig = new Environment($loader);
        $id = $_GET['id'];
        $memberService = new Member();
        $member = $memberService->getMemberById($id);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $full_name = trim($_POST["full_name"]);
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $is_active = trim($_POST["is_active"]);
            $memberService = new Member();
            $member = $memberService->UpdateMember($full_name,$username,$email,$is_active,$id);
            header("location: index.php?controller=member");
        }
        echo $twig->render('edit.twig',['member' => $member]);
        
    }

}
