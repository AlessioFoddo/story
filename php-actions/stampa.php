<?php
include("../db.php");

$id = $_POST['id_capitolo']; // ID del PDF da visualizzare

try {
    $sql = "SELECT file FROM capitoli WHERE id_capitolo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    
    // Recupera il contenuto binario del PDF
    $pdfContent = $stmt->fetchColumn();
    
    if ($pdfContent) {
        header("Content-Type: application/pdf");
        echo $pdfContent;
        exit; // Importante per evitare output aggiuntivo
    } else {
        echo "PDF non trovato!";
    }
    
} catch(PDOException $e) {
    die("Errore durante il recupero del PDF: " . $e->getMessage());
} finally {
    $stmt = null; // Chiude lo statement
}
?>