<?php
    include("../db.php");

    $idfb = $_POST["id_fb"];

    $sql = "DELETE FROM recensioni WHERE ID_Recensione = ?";
    $stmt = $conn->prepare($sql);  
    $stmt->execute([$idfb]);

    header("Location: ../php-pages/recensioni-controls.php");
?>