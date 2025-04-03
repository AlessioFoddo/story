<?php

include("./db.php");

$id = $_POST['id_capitolo']; // ID del PDF da visualizzare

$sql = "SELECT file FROM capitoli WHERE id_capitolo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($pdfContent);
$stmt->fetch();
$stmt->close();

if ($pdfContent) {
    header("Content-Type: application/pdf");
    echo $pdfContent;
} else {
    echo "PDF non trovato!";
}
?>
