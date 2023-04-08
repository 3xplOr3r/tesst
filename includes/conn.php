<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "admission";


    $conn = mysqli_connect($servername, $username, $password, $db);

    if(!$conn) {
        die("conncetion failed: " . mysqli_connect_error());
    }

?>