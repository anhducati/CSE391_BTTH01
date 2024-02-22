<?php
include("config.php");

class  Article {
    // Thuộc tính

    // private $ma_bviet;
    // private $tieude;
    // private $ten_bhat;
    // private $ma_tloai;
    // private $tomtat;
    // private $noidung;
    // private $ma_tgia;
    // private $ngayviet;
    // private $hinhanh;


    // public function __construct($ma_bviet, $tieude,$ten_bhat,$ma_tloai,$tomtat,$noidung,$ma_tgia,$ngayviet,$hinhanh){
    //     $this->ma_bviet = $ma_bviet;
    //     $this->tieude = $tieude;
    //     $this->ten_bhat = $ten_bhat;
    //     $this->ma_tloai = $ma_tloai;
    //     $this->tomtat = $tomtat;
    //     $this->noidung = $noidung;
    //     $this->ma_tgia = $ma_tgia;
    //     $this->ngayviet = $ngayviet;
    //     $this->hinhanh = $hinhanh;
    // }

    // // Setter và Getter
    // public function setma_bviet(){
    //     return $this->ma_bviet;
    // }
    // public function settieude(){
    //     return $this->tieude;
    // }
    // public function getten_bhat(){
    //     return $this->ten_bhat;
    // }
    // public function getma_tloai(){
    //     return $this->ma_tloai;
    // }
    // public function gettomtat(){
    //     return $this->tomtat;
    // }
    // public function getnoidung(){
    //     return $this->noidung;
    // }
    // public function setma_tgia(){
    //     return $this->ma_tgia;
    // }
    // public function setngayviet(){
    //     return $this->ngayviet;
    // }
    // public function sethinhanh(){
    //     return $this->hinhanh;
    // }


    public function getAllArticles(){
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        // B2. Truy vấn
        $sql = "SELECT baiviet.ma_bviet,baiviet.tieude,baiviet.ten_bhat,theloai.ten_tloai,baiviet.tomtat,baiviet.noidung,tacgia.ten_tgia,baiviet.ngayviet,baiviet.hinhanh
    FROM baiviet INNER JOIN theloai on baiviet.ma_tloai = theloai.ma_tloai INNER JOIN tacgia on baiviet.ma_tgia = tacgia.ma_tgia ORDER BY baiviet.ma_bviet ASC LIMIT 8; ";
        
        // Mảng (danh sách) các đối tượng Article Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Bước 03: Trả về dữ liệu
        $articles = $stmt->fetchAll();
        return $articles;
    }

    public function getArticlesDetail($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
         // B2. Truy vấn
         $sql = "SELECT baiviet.ma_bviet,baiviet.tieude,baiviet.ten_bhat,theloai.ten_tloai,baiviet.tomtat,baiviet.noidung,tacgia.ten_tgia,baiviet.ngayviet,baiviet.hinhanh
         FROM baiviet INNER JOIN theloai on baiviet.ma_tloai = theloai.ma_tloai INNER JOIN tacgia on baiviet.ma_tgia = tacgia.ma_tgia WHERE  ma_bviet = :id  ;";         
         
 
         $stmt = $conn->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
         $stmt->execute();
         $articles = $stmt->fetch(PDO::FETCH_ASSOC);
 
         return $articles;
     }
     public function getAllArticles_admin(){
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        
        // B2. Truy vấn
        $sql = "SELECT baiviet.ma_bviet,baiviet.tieude,baiviet.ten_bhat,theloai.ten_tloai,baiviet.tomtat,baiviet.noidung,tacgia.ten_tgia,baiviet.ngayviet,baiviet.hinhanh
                                FROM baiviet INNER JOIN theloai on baiviet.ma_tloai = theloai.ma_tloai INNER JOIN tacgia on baiviet.ma_tgia = tacgia.ma_tgia ORDER BY baiviet.ma_bviet ";
        
        // Mảng (danh sách) các đối tượng Article Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Bước 03: Trả về dữ liệu
        $articles = $stmt->fetchAll();
        return $articles;
    }
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

    public function Add($tieude,$ten_bhat,$ten_tloai,$tomtat,$noidung,$ten_tlgia,$hinhanh){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

         $sql = "INSERT INTO `baiviet` (`ma_bviet`, `tieude`, `ten_bhat`, `ma_tloai`, `tomtat`, `noidung`, `ma_tgia`, `ngayviet`, `hinhanh`) 
         VALUES (NULL,:tieude,:ten_bhat,:ten_tloai,:tomtat,:noidung ,:ten_tlgia,NOW(),:hinhanh)";     
        
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":tieude", $tieude);
         $stmt->bindParam(":ten_bhat",$ten_bhat);
         $stmt->bindParam(":ten_tloai",$ten_tloai);
         $stmt->bindParam(":tomtat",$tomtat);
         $stmt->bindParam(":noidung",$noidung);
         $stmt->bindParam(":ten_tlgia",$ten_tlgia);
         $stmt->bindParam(":hinhanh",$hinhanh);
         $stmt->execute();
     } 
     public function getArticleById($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         $sql = "SELECT baiviet.ma_bviet,baiviet.tieude,baiviet.ten_bhat,theloai.ten_tloai,baiviet.tomtat,baiviet.noidung,tacgia.ten_tgia,baiviet.ngayviet,baiviet.hinhanh
         FROM baiviet INNER JOIN theloai on baiviet.ma_tloai = theloai.ma_tloai INNER JOIN tacgia on baiviet.ma_tgia = tacgia.ma_tgia WHERE  ma_bviet = :id;";     
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
 
         $article = $stmt->fetch();
         return $article;
     }

     public function update($tieude,$ten_bhat,$ten_tloai,$tomtat,$noidung,$ten_tlgia,$hinhanh, $id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

         $sql = "UPDATE `baiviet`  SET tieude = :tieude ,ten_bhat = :ten_bhat,ma_tloai =:ten_tloai,tomtat = :tomtat,
                    noidung = :noidung,ma_tgia = :ten_tlgia,hinhanh = :hinhanh,ngayviet = NOW() WHERE ma_bviet =:id";     
        
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":tieude", $tieude);
         $stmt->bindParam(":ten_bhat",$ten_bhat);
         $stmt->bindParam(":ten_tloai",$ten_tloai);
         $stmt->bindParam(":tomtat",$tomtat);
         $stmt->bindParam(":noidung",$noidung);
         $stmt->bindParam(":ten_tlgia",$ten_tlgia);
         $stmt->bindParam(":hinhanh",$hinhanh);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     } 

     public function DeleteArticle($id){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
 
         $sql = "DELETE FROM `baiviet`  WHERE `baiviet`.`ma_bviet`= :id";  
      
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(":id", $id);
         $stmt->execute();
     }

}