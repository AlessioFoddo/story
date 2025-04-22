
<?php
session_start();
$id = $_POST['id_chapter'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/chapter.css">
  <title>Visualizza Capitolo</title>
</head>
<body>
  <div class="row ">
    <div class="col-4">
      <img width="100%" src="../images/piggyback.jpg" alt="">
    </div>
    <div class="col-4">
      <div class="my-5">
        <form method="post" action="../php-actions/salva_recensione.php">
          <input type="hidden" name="id_chapter" value="<?= $id ?>">
          <input type="hidden" name="id_user" value="<?= $_SESSION["id_utente"] ?>">
          
          <label for="recensione">Scrivi una recensione</label><br>
          <textarea id="recensione" name="recensione" placeholder="Scrivi qui la tua recensione..."></textarea><br>
          <select name="target">
            <option value="capitolo">Capitolo</option>
            <option value="storia">Storia</option>
          </select>
          <button type="submit">Invia recensione</button>
        </form>

        <form class="mt-3" action="./user.php">
          <button>BACK</button>
        </form>
      </div>
      <div class="pdf-viewer">
        <iframe src="../php-actions/visualizza_pdf.php?id_chapter=<?= $id ?>" width="100%" height="100%"></iframe>
      </div>
    </div>
    <div class="col-4">
      <img width="100%" src="../images/piggyback.jpg" alt="">
    </div>
  </div>
</body>
</html>
