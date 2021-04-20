<?php
namespace Lyricorn\System;

class DbCrud extends DbConnect
{

    function __construct()
    {
        
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
}



















































// {
// // public function getPost(){
// //     $sql = "SELECT * FROM tbl_posts";
// //     $stmt = $this->connect()->query($sql);

// //     while($row = $stmt->fetch()){
// //         var_dump($row);
// //     }
// // }
// // public function getSelectPost($title){
// //     $sql = "SELECT * FROM tbl_posts WHERE title = ?";
// //     $stmt = $this->connect()->prepare($sql);
// //     $stmt->execute([
// //         $title
// //     ]);
// //     $names = $stmt->fetchAll();

// //     foreach ($names as $value) {
// //         var_dump($value);
// //     }
// // }

// // public function setPost($title, $body, $author){
// //     $sql = "INSERT INTO tbl_posts(title, body, author) VALUES(?,?,?)";
// //     $stmt = $this->connect()->prepare($sql);
// //     $stmt->execute([
// //         $title,
// //         $body,
// //         $author
// //     ]);
// // }
// }