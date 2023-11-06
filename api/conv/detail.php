<?php

try{
    session_start();

    require('../database/mysql.php');

    connect_db();

    $id = $_GET['id'];

    $sql = "SELECT * FROM conversations WHERE id=$id";

    $result = mysqli_query($_SESSION['conn'], $sql);

    header('Content-Type: application/json');

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(array("code" => "0", "msg" => "ok", "data" => $row));
    } else {
        echo json_encode(array("code" => "1", "msg" => "error"));
    }
} catch (Exception $e) {
    echo json_encode(array("code" => "-1", "msg" => $e -> getMessage()));
}
?>