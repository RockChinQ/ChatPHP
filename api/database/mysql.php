<?php 
session_start();

function connect_db() {
    
    $host = getenv('MYSQL_HOST');
    $user = getenv('MYSQL_USER');
    $pass = getenv('MYSQL_PASSWORD');
    $db = getenv('MYSQL_DATABASE');

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $_SESSION['conn'] = $conn;

    // init db
    $sql = "CREATE TABLE IF NOT EXISTS `conversations` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `messages` text NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    mysqli_query($conn, $sql);

    return $conn;
}
?>