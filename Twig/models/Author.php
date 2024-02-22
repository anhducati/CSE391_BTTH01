<?php
include("config.php");

class Author{

    public function getAllAuthor(){
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        // B2. Truy vấn
        $sql = "SELECT * FROM  tacgia ";
        
        // Mảng (danh sách) các đối tượng Article Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Bước 03: Trả về dữ liệu
        $authors = $stmt->fetchAll();
        return $authors;
    }
    public function AddAuthor($tentgia,$hinhtgia){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         
         $sql = "INSERT INTO tacgia (ma_tgia,ten_tgia,hinh_tgia) VALUES (NULL,:tentgia,:hinhtgia)";     
        
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":tentgia", $tentgia);
         $stmt->bindParam(":hinhtgia",$hinhtgia);
         $stmt->execute();
     } public function getAuthorById($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         $sql = "SELECT * FROM `tacgia` WHERE  ma_tgia = :id;";     
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
 
         $author = $stmt->fetch();
         return $author;
     }

     public function UpdateAuthor($tentgia,$hinhtgia,$id){
       $dbConn = new DBConnection();
       $conn = $dbConn->getConnection(); 
       $sql = "UPDATE `tacgia` SET ten_tgia= :tentgia ,hinh_tgia = :hinhtgia WHERE  ma_tgia =:id"; 
       
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":tentgia", $tentgia);
        $stmt->bindParam(":hinhtgia", $hinhtgia);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
    public function DeleteAuthor($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         
         $sql = "DELETE FROM `tacgia`  WHERE `tacgia`.`ma_tgia`= :id";  
      
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     }

}