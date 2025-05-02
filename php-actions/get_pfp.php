<?php
    session_start();
    include("../db.php"); // o il tuo file connessione

    $id = $_SESSION["id_utente"]; // o passa via GET

    $stmt = $conn->prepare("SELECT profile_image FROM user WHERE ID = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row && $row['profile_image']) {
        header("Content-Type: image/jpeg"); // o image/png a seconda del tipo
        echo $row['profile_image'];
    } else {
        http_response_code(404);
    }
?>
