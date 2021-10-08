<?php
require_once "dbconfig.php";

    // create & check connection

try {
    $connection = new PDO(
        "mysql:dbname=$db_name;
        host=$db_host;
        port=$db_port", 
        $db_user, 
        $db_pass);
    $connection->setAttribute(
        PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION);
    session_start();
} catch (PDOException $e) {
    die("Error msg: ".$e->getMessage());
}
   



