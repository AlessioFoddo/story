<?php
    include("../db.php");

    $id_capitolo = $_POST["id_chapter"];
    
    if (isset($_POST['delete'])) {
        // ELIMINA CAPITOLO
        $query = "DELETE FROM capitoli WHERE ID_Capitolo = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_capitolo]);
    }else{
        $titolo = $_POST["titolo"];
        $riassunto = $_POST["resume"];
        $query = "UPDATE capitoli SET Titolo = :titolo, Riassunto = :riassunto WHERE ID_Capitolo = :id_capitolo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':titolo', $titolo);
        $stmt->bindParam(':riassunto', $riassunto);
        $stmt->bindParam(':id_capitolo', $id_capitolo);
        $stmt->execute();
    }


    header("Location: ../php-pages/chapters-controls.php");
    exit();
?>