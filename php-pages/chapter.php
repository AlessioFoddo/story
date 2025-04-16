
<?php
$id = $_POST['id_chapter']; // Puoi settare 1 come default o usare GET per test
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Visualizza Capitolo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .container {
      width: 500px;
      margin: auto;
    }
    label {
      font-weight: bold;
    }
    textarea {
      width: 100%;
      height: 100px;
      margin-top: 5px;
      resize: vertical;
    }
    button {
      margin-top: 10px;
      padding: 8px 20px;
      cursor: pointer;
    }
    .pdf-viewer {
      margin-top: 20px;
      width: 100%;
      height: 600px;
      border: 1px solid #000;
    }
  </style>
</head>
<body>

<div class="container">
  <form method="post" action="salva_recensione.php">
    <input type="hidden" name="id_chapter" value="<?= htmlspecialchars($id) ?>">
    
    <label for="recensione">Scrivi una recensione</label><br>
    <textarea id="recensione" name="recensione" placeholder="Scrivi qui la tua recensione..."></textarea><br>
    <button type="submit">Invia recensione</button>
  </form>

  <div class="pdf-viewer">
    <iframe src="visualizza_pdf.php?id_chapter=<?= urlencode($id) ?>" width="100%" height="100%"></iframe>
  </div>
</div>

</body>
</html>
// include("../db.php");
// $id = $_POST["id_chapter"];


// try {
//     $sql = "SELECT file FROM capitoli WHERE id_capitolo = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute([$id]);
    
//     // Recupera il contenuto binario del PDF
//     $pdfContent = $stmt->fetchColumn();
    
//     if ($pdfContent) {
//         header("Content-Type: application/pdf");
//         echo $pdfContent;
//         exit; // Importante per evitare output aggiuntivo
//     } else {
//         echo "PDF non trovato!";
//     }
    
// } catch(PDOException $e) {
//     die("Errore durante il recupero del PDF: " . $e->getMessage());
// } finally {
//     $stmt = null; // Chiude lo statement
// }
?>
