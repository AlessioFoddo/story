<?php
    include("../db.php");
    session_start();

    $query = "DELETE FROM user WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION["id_utente"]]);

    $query = "DELETE FROM capitoli_preferiti WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION["id_utente"]]);

    session_destroy();
    header("Location: ../index.php");
?>