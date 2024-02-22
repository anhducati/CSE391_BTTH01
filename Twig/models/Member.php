<?php
include("config.php");

    class Member {

        // private $id;
        // private $username;
        // private $password;
        // private $full_name;


        // public function __construct($id,$username,$password,$full_name){
        //     $this->id = $id;
        //     $this->username = $username;
        //     $this->password = $password;
        //     $this->full_name = $full_name;
        // }
        //     // Setter và Getter
        // public function setid(){
        //     return $this->id;
        // }
        // public function setusername(){
        //     return $this->username;
        // }
        // public function getpassword(){
        //     return $this->password;
        // }
        // public function getfull_name(){
        //     return $this->full_name;
        // }
        public function getAllCount(){
            // 4 bước thực hiện
           $dbConn = new DBConnection();
           $conn = $dbConn->getConnection();
    
            // B2. Truy vấn
            $sql = "select (SELECT COUNT(*) FROM baiviet ) as bv, (SELECT COUNT(*) FROM theloai ) as tl , 
            (SELECT COUNT(*) FROM tacgia ) as tg , (SELECT COUNT(*) FROM users )as users;";          
           // $stmt = $conn->query($sql);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            $admins = $stmt->fetch();
        
            return $admins;
        }
        public function getAllMember(){
            // 4 bước thực hiện
            $dbConn = new DBConnection();
            $conn = $dbConn->getConnection();
            
            // B2. Truy vấn
            $sql = "SELECT * FROM  users" ;
            
            // Mảng (danh sách) các đối tượng Article Model
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            // Bước 03: Trả về dữ liệu
            $members = $stmt->fetchAll();
            return $members;
        }


        public function Singup($full_name,$username,$email,$password,$repassword){
            $dbConn = new DBConnection();
            $conn = $dbConn->getConnection();
            
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $code_hash = md5(random_bytes(20));

            $sql = "INSERT INTO users (`full_name`,`username`, `password`, `id`, `email`, `active_code`)
            VALUES (:full_name,:username,:pass_hash, NULL,:email,:active_code)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":full_name", $full_name);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":pass_hash",$pass_hash);
            $stmt->bindParam(":active_code", $code_hash);
            $stmt->execute();
        }
        public function check_account($username,$email){
            // 4 bước thực hiện
           $dbConn = new DBConnection();
           $conn = $dbConn->getConnection();
    
            $sql = "SELECT * FROM users WHERE username = :username OR email= :email";     
   
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
    
            $count = $stmt->rowCount();
            return $count;
        }
        public function Get_Account($username){
            // 4 bước thực hiện
           $dbConn = new DBConnection();
           $conn = $dbConn->getConnection();
    
            $sql = "SELECT * FROM users WHERE username = :username OR email= :username";     
           // $stmt = $conn->query($sql);
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
    
            $account = $stmt->fetch();
            return $account;
        }   public function Active($username,$token){
        
            $dbConn = new DBConnection();
            $conn = $dbConn->getConnection();
     
                 $sql = "UPDATE users SET is_active=1 WHERE username=:username";
                 $stmt = $conn->prepare($sql); 
                 $stmt->bindParam(":username", $username);
                 $stmt->execute();
            
         }
         public function Login($username,$password){
            session_start();
                                     
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;                            
            header('Location:?controller=member&action=loginthang');
                                       
             
        }public function getMemberById($id){
            $dbConn = new DBConnection();
            $conn = $dbConn->getConnection();
     
             $sql = "SELECT * FROM `users`  WHERE `users`.`id`= :id;";     
             $stmt = $conn->prepare($sql);
             $stmt->bindParam(":id", $id);
             $stmt->execute();
     
             $member = $stmt->fetch();
             return $member;
         }
        public function DeleteMember($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         
         $sql = "DELETE FROM `users`  WHERE `users`.`id`= :id";  
      
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     }
     public function UpdateMember($full_name,$username,$email,$is_active,$id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection(); 
        $sql = "UPDATE `users` SET full_name= :full_name ,username = :username ,email = :email, is_active = :is_active WHERE   `users`.`id` =:id"; 
        
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":full_name", $full_name);
         $stmt->bindParam(":username", $username);
         $stmt->bindParam(":email", $email);
         $stmt->bindParam(":is_active", $is_active);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     }
  
    }

        
    
        


