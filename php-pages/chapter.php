
<?php
include("../db.php");
session_start();
if (isset($_POST['id_chapter'])) {
  $id = $_POST['id_chapter'];
} elseif (isset($_GET['id_chapter'])) {
  $id = $_GET['id_chapter'];
}
if ($_SESSION["id_utente"] == null) {
  header("Location: ../index.php");
  exit();
}else{
  $query = "SELECT * FROM admin WHERE ID = ?";
  $stmt = $conn->prepare($query);
  $stmt->execute([$_SESSION["id_utente"]]);
  if ($stmt->rowCount() != 0) {
      header("Location: ../index.php");
      exit();
  }
}
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
      <div class="mt-5">
        <!--form scrittura, invio recensione e aggiunta ai preferiti-->
        
          <form method="post" action="../php-actions/salva_recensione.php">
            <input type="hidden" name="id_chapter" value="<?= $id ?>">
            <input type="hidden" name="id_user" value="<?= $_SESSION["id_utente"] ?>">
            
            <label for="recensione">SCRIVI UNA RECENSIONE:</label><br>
            <textarea id="recensione" name="recensione" placeholder="Scrivi qui la tua recensione..."></textarea><br>
            <select name="target" class="tipo-recensione">
              <option value="capitolo">Capitolo</option>
              <option value="storia">Storia</option>
            </select>
            <button class="btn btn-outline-primary" type="submit">Invia recensione</button>
          </form>

        <!--spostamento tra i capitoli-->
        <div class="mt-1 spostamento-capitoli">
          <?php
            $query = "SELECT * FROM Capitoli WHERE ID_Capitolo = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([($id-1)]);
            $pre_chapter = $stmt->fetch();
            if($pre_chapter):
          ?>
            <form action="./chapter.php" method="POST">
              <input type="hidden" name="id_chapter" value=<?=$pre_chapter["ID_Capitolo"]?>>
              <button class="btn btn-outline-primary">CAPITOLO PRECEDENTE</button>
            </form>
          <?php
            endif;
            $query = "SELECT * FROM Capitoli WHERE ID_Capitolo = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([($id+1)]);
            $post_chapter = $stmt->fetch();
            if($post_chapter):
          ?>
            <form action="./chapter.php" method="POST">
              <input type="hidden" name="id_chapter" value=<?=$post_chapter["ID_Capitolo"]?>>
              <button class="btn btn-outline-primary">CAPITOLO SUCCESSIVO</button>
            </form>
          <?php
            endif;
          ?>
        </div>

        <div class="caratteristiche-capitolo">
          <form class="mt-1" action="./user.php">
            <button class="btn btn-outline-primary">BACK</button>
          </form>
          <!--agguhnta prefeirti-->
          <form action="../php-actions/aggiunta_preferiti.php" method="POST" class="btn-preferiti">
            <button>
              <input type="hidden" name="id_chapter" value=<?= $id ?>>
              <?php
                $query = "SELECT * FROM capitoli_preferiti WHERE ID = ? AND ID_Capitolo = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$_SESSION["id_utente"], $id]);
                if($stmt->fetchAll()):
              ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill preferiti" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
              <?php
                else:
              ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star preferiti" viewBox="0 0 16 16">
                  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                </svg>
              <?php
                endif;
              ?>
            </button>
          </form>
        </div>
      </div>
      <div class="mt-4 pdf-viewer">
        <iframe src="../php-actions/visualizza_pdf.php?id_chapter=<?= $id ?>" width="100%" height="100%"></iframe>
      </div>
    </div>
    <div class="col-4">
      <img width="100%" src="../images/piggyback.jpg" alt="">
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
