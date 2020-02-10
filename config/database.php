<?php
    define("HOST", "localhost");
    define("DB_NAME", "gesco");
    define("USERNAME", "root");
    define("PASSWORD", "");
    // $host = "localhost";
    // $db_name = "gesco";
    // $username = "root";
    // $password = "";
    
    try {
        // $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
        $con = new PDO("mysql:host=". HOST . ";dbname=" . DB_NAME, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $exception){
        echo "Erreur de connection: " . $exception->getMessage();
    }
?>