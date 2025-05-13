<?php
include("../db.php");

    $titolo = $_POST['titolo'];
    $file = $_FILES['file']['tmp_name'];
    $riassunto = $_POST['resume'];
    $chapter_id = $_POST['chapter_id'];
    if (!empty($file) && is_uploaded_file($file)) {
        $pdfContent = file_get_contents($file);
        var_dump($chapter_id, $titolo, strlen($pdfContent), $riassunto);

        if($chapter_id == ''){
            $sql = "INSERT INTO capitoli (Titolo, File, Riassunto) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$titolo, $pdfContent, $riassunto]);
            header("Location: ../php-pages/chapters-controls.php");
        }else{
            $chapter_id = (int)$chapter_id;
            $sql = "SELECT * FROM capitoli WHERE ID_Capitolo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$chapter_id]);
            $chapter = $stmt->fetch();
            if($chapter){
                header("Location: ../php-pages/chapters-controls.php?error=Capitolo già esistente, bisogna modificarlo!");
            }else{
                $sql = "INSERT INTO capitoli (ID_Capitolo, Titolo, File, Riassunto) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$chapter_id, $titolo, $pdfContent, $riassunto]);
                header("Location: ../php-pages/chapters-controls.php");
            }
        }
        
    } else {
        echo "Errore nel caricamento del file.";
    }

?>
