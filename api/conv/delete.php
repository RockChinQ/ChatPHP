<?php 
session_start();

try{
    require('../database/mysql.php');

    connect_db();

    $id = $_POST['id'];

    $sql = "DELETE FROM conversations WHERE id=$id";

    $result = mysqli_query($_SESSION['conn'], $sql);

    header('Content-Type: application/json');

    if ($result) {
        echo json_encode(array("code" => "0", "msg" => "ok"));
    } else {
        echo json_encode(array("code" => "1", "msg" => "error"));
    }
} catch (Exception $e) {
    echo json_encode(array("code" => "-1", "msg" => $e -> getMessage()));
}

?>