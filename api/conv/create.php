<?php
try{
    require("../database/mysql.php");

    connect_db();

    // 新建一个，返回id
    $title = $_POST['title'];
    $messages = '[]';
    $sql = "INSERT INTO conversations (title, messages) VALUES ('$title', '$messages')";
    $result = mysqli_query($_SESSION['conn'], $sql);

    header('Content-Type: application/json');

    if ($result) {
        $id = mysqli_insert_id($_SESSION['conn']);
        echo json_encode(array("code" => "0", "msg" => "ok", "data" => array("id" => $id)));
    } else {
        echo json_encode(array("code" => "1", "msg" => "error"));
    }
} catch (Exception $e) {
    echo json_encode(array("code" => "-1", "msg" => $e -> getMessage()));
}

?>