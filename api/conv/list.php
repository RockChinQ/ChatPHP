<?php 

try{
    session_start();

    require('../database/mysql.php');

    connect_db();

    $sql = "SELECT * FROM conversations";
    $result = mysqli_query($_SESSION['conn'], $sql);

    header('Content-Type: application/json');

    $resp = array();

    if ($result) {
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        $resp = array("code" => "0", "msg" => "ok", "data" => $rows);
    } else {
        $resp = array("code" => "0", "msg" => "ok", "data" => array());
    }
} catch (Exception $e) {
    $resp = array("code" => "-1", "msg" => $e -> getMessage());
} finally {
    echo json_encode($resp);
}
?>