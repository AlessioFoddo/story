<?php
    include("../db.php");
    session_start();
    $id_chp = $_POST["id_chapter"];

    //comtrollo presenza nei preferiti
    $query = "SELECT * FROM capitoli_preferiti WHERE ID = ? AND ID_Capitolo = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION["id_utente"], $id_chp]);
    if($stmt->fetch()){
        $query = "DELETE FROM capitoli_preferiti WHERE ID = ? AND ID_Capitolo = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION["id_utente"], $id_chp]);
    }else{
        $query = "INSERT INTO capitoli_preferiti (ID, ID_Capitolo) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION["id_utente"], $id_chp]);
    }

    header("Location: ../php-pages/chapter.php?id_chapter=".$id_chp);
?>