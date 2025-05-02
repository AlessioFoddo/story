<?php
    session_start();
    include("../db.php"); // Assicurati che connessione sia corretta
    $id_utente = $_SESSION["id_utente"];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
        
        // Verifica che il file sia caricato correttamente
        if ($_FILES["profile_image"]["error"] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES["profile_image"]["tmp_name"]);
            
            $stmt = $conn->prepare("UPDATE user SET profile_image = ? WHERE ID = ?");
            $stmt->bindParam(1, $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(2, $id_utente, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                header("Location: ../php-pages/user_profile.php"); // O dove vuoi reindirizzare
                exit();
            } else {
                echo "Errore nell'upload dell'immagine.";
            }
        } else {
            echo "Errore nel file: " . $_FILES["profile_image"]["error"];
        }
    } else {
        echo "Nessun file ricevuto.";
    }
    
?>