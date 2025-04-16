<?php
include("../db.php");

$id = $_GET["id_chapter"] ?? null;

if (!$id) {
    die("ID capitolo non specificato.");
}

try {
    $sql = "SELECT file FROM capitoli WHERE id_capitolo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    
    $pdfContent = $stmt->fetchColumn();
    
    if ($pdfContent) {
        header("Content-Type: application/pdf");
        echo $pdfContent;
        exit;
    } else {
        echo "PDF non trovato!";
    }
    
} catch(PDOException $e) {
    die("Errore durante il recupero del PDF: " . $e->getMessage());
} finally {
    $stmt = null;
}
?>
