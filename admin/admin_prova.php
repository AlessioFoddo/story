<?php
include("../db.php");

if (isset($_POST['submit'])) {
    $stmt = null;
    try {
        $titolo = $_POST['titolo'] ?? '';
        $file = $_FILES['file']['tmp_name'] ?? '';

        if (!empty($file) && is_uploaded_file($file)) {
            $pdfContent = file_get_contents($file);
            
            // Aggiunta di una transazione esplicita
            $conn->beginTransaction();
            
            $sql = "INSERT INTO capitoli (titolo, file) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$titolo, $pdfContent]);
            
            // Verifica esplicita dell'inserimento
            if ($stmt->rowCount() > 0) {
                $conn->commit(); // Conferma la transazione
                echo "File PDF caricato con successo!";
            } else {
                $conn->rollBack(); // Annulla in caso di errore
                echo "Nessun record inserito";
            }
        } else {
            echo "Errore nel caricamento del file.";
        }
    } catch(PDOException $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("Database error: " . $e->getMessage());
        echo "Errore del database: Operazione non riuscita";
    } catch(Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("General error: " . $e->getMessage());
        echo "Errore generico: Operazione non riuscita";
    } finally {
        // Chiude correttamente lo statement e resetta la connessione
        if ($stmt !== null) {
            $stmt->closeCursor();
        }
        $conn = null;
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    Titolo: <input type="text" name="titolo" required><br>
    Seleziona PDF: <input type="file" name="file" accept="application/pdf" required><br>
    <input type="submit" name="submit" value="Carica PDF">
</form>

<form action="../php-actions/stampa.php" method="post">
    <input type="text" name="id_capitolo">
    <input type="submit">
</form>
