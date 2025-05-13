
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
    <link rel="stylesheet" href="../css/user-page.css">
    <link rel="stylesheet" href="../css/background.css">
  <title>Capitoli preferiti</title>
</head>
<body style="padding: 0;">
  <div class="row">
    <div class="col-2">
    </div>
    <div class="col-8">
      <h1>CUORI IN CONTRASTO</h1>
      <h2>Capitoli preferiti:</h2>
      <div class="row">
          <form class="my-4" action="./user.php">
            <button class="btn btn-outline-primary">BACK</button>
          </form>
        <?php
            $query = "SELECT * FROM capitoli_preferiti WHERE ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$_SESSION["id_utente"]]);
            $capitoli_preferiti = $stmt->fetchAll();
            if($capitoli_preferiti):
              $num_tmp = 1;
              foreach ($capitoli_preferiti as $chp):   
                $query = "SELECT * FROM capitoli WHERE ID_Capitolo = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$chp["ID_Capitolo"]]);
                $chp = $stmt->fetch();

                $collapseId = "collapseExample" . $num_tmp;

                //conteggio recensioni per singolo capitolo
                $sql = "SELECT * FROM recensione_capitolo WHERE ID_Capitolo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$chp["ID_Capitolo"]]);

                $recensioni = $stmt->fetchAll();
            ?>
                <div class="card card-capitolo my-1">
                    <div class="titolo-capitolo my-2">
                        <p>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                                Capitolo <?= $chp["ID_Capitolo"] ?>
                            </button>
                        </p>
                        <p class="titolo">
                            <?= $chp["Titolo"] ?>
                        </p>
                        <div class="recensioni">
                            <p class="numero">
                                <?= count($recensioni) ?>
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="collapse mb-3" id="<?= $collapseId ?>">
                        <div class="card card-body">
                        <?php
                            echo $chp["Riassunto"];
                        ?>
                        <form class="capitolo" action="./chapter.php" method="POST">
                            <input type="hidden" name="id_chapter" type="number" value='<?php  echo($chp["ID_Capitolo"])?>'>
                            <button type="submit" class="btn btn-primary">LEGGI</button>
                        </form>
                        </div>
                    </div>
                </div>
            <?php
                        $num_tmp++;
                    endforeach;
                else:
                    echo "<div class='alert alert-warning'>NON CI SONO CAPITOLI PREFERITI!</div>";
                endif;
            ?>
      </div>
    </div>
    <div class="col-2">
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
