<?php
    $db_host = "localhost";
    $db_user = "IBKCenter";
    $db_password = "0305";
    $db_name = "loginibk";

    $conn = mysqli_connect($db_host, $db_user, $db_password,$db_name);

    if(!$conn){
        exit();
    }

?>