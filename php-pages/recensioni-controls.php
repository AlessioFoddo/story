
<?php
  include("../db.php");
  session_start();
  if ($_SESSION["id_utente"] == null) {
    header("Location: ../index.php");
    exit();
  }else{
    $query = "SELECT * FROM admin WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION["id_utente"]]);
    if ($stmt->rowCount() == 0) {
        header("Location: ../index.php");
        exit();
    }
  }
  if(isset($_POST["tipo_recensioni"])){
    $type_recensioni = $_POST["tipo_recensioni"];
  } else {
    $type_recensioni = "all";
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
    <link rel="stylesheet" href="../css/recensione.css">
    <link rel="stylesheet" href="../css/background.css">
  <title>Gestione Recensioni</title>
</head>
<body>
  <h1 class="text-center">CUORI IN CONTRASTO</h1>
  <form action="./admin.php" class="my-2">
    <button class="btn btn-outline-dark">
      BACK
    </button>
  </form>
  <div class="row ">
    <div class="col-5">
      <h2 class="mb-3">Le ultime recensioni:</h2>
      <div class="row">
        <?php
          $query = "SELECT * FROM recensioni ORDER BY ID_Recensione DESC LIMIT 4";
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $last_recensioni = $stmt->fetchAll();
          if($last_recensioni):
            $num_tmp = 1;
            foreach ($last_recensioni as $lastr):     
                $sql = "SELECT * FROM user WHERE ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$lastr["ID"]]);
                $user = $stmt->fetch();    
        ?>
        <div class="card card-capitolo my-1">
          <div class="titolo-recensione mt-2">
            <div class="username">
              <svg xmlns="http://www.w3.org/2000/svg" width="25px" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
              </svg>
              <p>
                <?= $user["Username"] ?>
              </p>
            </div>
            <form action="../php-actions/delete_feedback.php" method="POST">
              <input type="hidden" name="id_fb" value=<?= $lastr["ID_Recensione"] ?>>  
              <button>ELEMINA</button>
            </form>
          </div>
          <div class="card card-body recensione">
            <?php
              echo $lastr["File"];
            ?>
          </div>
        </div>
        <?php
            $num_tmp++;
            endforeach;
          else:
            echo "<div class='alert alert-danger'>Non ci sono recensioni!</div>";
          endif;
        ?>
      </div>
    </div>
    <div class="col-1"></div>
    <div class="col-6">
      <form class="d-flex justify-content-between" action="" method="POST">
        <select name="tipo_recensioni" class="w-75 form-select my-2">
          <option value="personal" <?= $type_recensioni == "all" ? "selected" : "" ?>>Tutte le recensioni</option>
          <option value="story" <?= $type_recensioni == "story" ? "selected" : "" ?>>Recensioni storia</option>
          <option value="chapter" <?= $type_recensioni == "chapter" ? "selected" : "" ?>>Recensioni capitoli</option>
        </select>
        <button class="mb-2 btn btn-outline-dark">
          FILTRA
        </button>
      </form>
      <div class="row">
        <?php
          switch ($type_recensioni) :
            case "story":
              $query = "SELECT * FROM recensioni JOIN recensione_storia ON recensioni.ID_Recensione = recensione_storia.ID_Recensione";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              $story_recensione = $stmt->fetchAll();
              if($story_recensione):
                foreach ($story_recensione as $storyfb):
                    $sql = "SELECT * FROM user WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$storyfb["ID"]]);
                    $user = $stmt->fetch();      
        ?>
                  <div class="card card-capitolo my-1">
                    <div class="titolo-recensione mt-2">
                      <div class="username">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4vw" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <p>
                          <?= $user["Username"] ?>
                        </p>
                      </div>
                      <form action="../php-actions/delete_feedback.php" method="POST">
                        <input type="hidden" name="id_fb" value=<?= $storyfb["ID_Recensione"] ?>>
                        <button>ELIMINA</button>
                      </form>
                    </div>
                    <div class="card card-body recensione">
                      <?php
                        echo $storyfb["File"];
                      ?>
                    </div>
                  </div>
        <?php
                endforeach;
              else:
                echo "<div class='alert alert-danger'>Non ci sono recensioni!</div>";
              endif;
              break;

            case "chapter":
              $query = "SELECT * FROM recensioni JOIN recensione_capitolo ON recensioni.ID_Recensione = recensione_capitolo.ID_Recensione";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              $chapter_recensione = $stmt->fetchAll();
              if($chapter_recensione):
                foreach ($chapter_recensione as $chpfb):   
                    $sql = "SELECT * FROM user WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$chpfb["ID"]]);
                    $user = $stmt->fetch();   
        ?>
                  <div class="card card-capitolo my-1">
                    <div class="titolo-recensione mt-2">
                      <div class="username">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4vw" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <p>
                          <?= $user["Username"] ?>
                        </p>
                      </div>
                      <form action="../php-actions/delete_feedback.php" method="POST">
                        <input type="hidden" name="id_fb" value=<?= $chpfb["ID_Recensione"] ?>>
                        <button>ELIMINA</button>
                      </form>
                    </div>
                    <div class="card card-body recensione">
                      <?php
                        echo $chpfb["File"];
                      ?>
                    </div>
                  </div>
        <?php
                endforeach;
              else:
                echo "<div class='alert alert-danger'>Non ci sono recensioni!</div>";
              endif;
              break;
              
            case "all":
            default:
                $query = "SELECT * FROM recensioni";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              $chapter_recensione = $stmt->fetchAll();
              if($chapter_recensione):
                foreach ($chapter_recensione as $allfb):   
                    $sql = "SELECT * FROM user WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$allfb["ID"]]);
                    $user = $stmt->fetch();   
        ?>
                  <div class="card card-capitolo my-1">
                    <div class="titolo-recensione mt-2">
                      <div class="username">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4vw" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        <p>
                          <?= $user["Username"] ?>
                        </p>
                      </div>
                      <form action="../php-actions/delete_feedback.php" method="POST">
                        <input type="hidden" name="id_fb" value=<?= $allfb["ID_Recensione"] ?>>
                        <button>ELIMINA</button>
                      </form>
                    </div>
                    <div class="card card-body recensione">
                      <?php
                        echo $allfb["File"];
                      ?>
                    </div>
                  </div>
        <?php
                endforeach;
              else:
                echo "<div class='alert alert-danger'>Non ci sono recensioni!</div>";
              endif;

          endswitch;
        ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
