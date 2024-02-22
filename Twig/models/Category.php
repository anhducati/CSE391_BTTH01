<?php


include("config.php");

class Category{

    public function getAllCategory(){
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        // B2. Truy vấn
        $sql = "SELECT * FROM  theloai ";
        
        // Mảng (danh sách) các đối tượng Article Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Bước 03: Trả về dữ liệu
        $categorys = $stmt->fetchAll();
        return $categorys;
    }
    
    public function AddCategory($category){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         
         $sql = "INSERT INTO theloai (ma_tloai,ten_tloai) VALUES (NULL,:tenloai)";     
        
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":tenloai", $category);
         $stmt->execute();
     }

     public function getCategoryById($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         $sql = "SELECT * FROM `theloai` WHERE  ma_tloai = :id;";     
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
 
         $category = $stmt->fetch();
         return $category;
     }

     public function UpdateCategory($category,$id){
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection(); 
       $sql = "UPDATE `theloai` SET ten_tloai = :ten_tloai WHERE  ma_tloai =:id"; 
       
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":ten_tloai", $category);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }


    public function DeleteCategory($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         
         $sql = "DELETE FROM `theloai`  WHERE `theloai`.`ma_tloai`= :id";  
      
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     }

}