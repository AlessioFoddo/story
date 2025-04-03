<?php

include("../db.php");

if (isset($_POST['submit'])) {
    $titolo = $_POST['titolo'];
    $file = $_FILES['file']['tmp_name'];
    
    if ($file) {
        $pdfContent = file_get_contents($file);
        $pdfContent = mysqli_real_escape_string($conn, $pdfContent);

        $sql = "INSERT INTO capitoli (titolo, file) VALUES ('$titolo', '$pdfContent')";

        if ($conn->query($sql) === TRUE) {
            echo "File PDF caricato con successo!";
        } else {
            echo "Errore: " . $conn->error;
        }
    } else {
        echo "Errore nel caricamento del file.";
    }
}

$conn->close();
?>

<form action="" method="post" enctype="multipart/form-data">
    Titolo: <input type="text" name="titolo" required><br>
    Seleziona PDF: <input type="file" name="file" accept="application/pdf" required><br>
    <input type="submit" name="submit" value="Carica PDF">
</form>
<form action="./stampa.php" method="post">
    <input type="text" name="id_capitolo">
    <input type="submit">
</form>
