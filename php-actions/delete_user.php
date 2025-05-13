<?php
    include("../db.php");
    session_start();

    if(isset($_POST["delete"])){
        $id_user = $_POST["id_user"];
        $redirect = "Location: ../php-pages/users-controls.php";
    }else{
        $id_user = $_SESSION["id_utente"];
        $redirect = "Location: ../index.php";
    }

    $query = "DELETE FROM user WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_user]);

    $query = "DELETE FROM capitoli_preferiti WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_user]);

    session_destroy();
    header($redirect);
?>