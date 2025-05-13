
<?php
include("../db.php");
session_start();
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
  <title>Gestione Utenti</title>
</head>
<body style="padding: 0;">
  <div class="row">
    <div class="col-2">
    </div>
    <div class="col-8">
      <div class="text-center">
          <h1>CUORI IN CONTRASTO</h1>
          <h2>Gestione Utenti:</h2>
      </div>
      <div class="row">
          <form class="my-4" action="./admin.php">
            <button class="btn btn-outline-primary">BACK</button>
          </form>
        <?php
            $query = "SELECT * FROM user JOIN utenti ON utenti.ID = user.ID";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $all_users = $stmt->fetchAll();
            if($all_users):
              foreach ($all_users as $user):
                //conteggio recensioni per singolo capitolo
                $sql = "SELECT * FROM recensioni WHERE ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$user["ID"]]);

                $recensioni = $stmt->fetchAll();
        ?>
                <div class="card card-capitolo my-1">
                    <div class="titolo-capitolo my-2">
                        <div class="recensioni">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25px" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            </svg>
                            <p class="nome">
                                <?= $user["Username"]?>
                            </p>
                            <p class="numero">
                                <?= count($recensioni) ?>
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </div>
                        <div>
                            <form action="../php-actions/delete_user.php" method="POST">
                                <input type="hidden" name="id_user" value=<?= $user["ID"] ?>>
                                <button name="delete" class="btn btn-danger">ELIMINA</button>
                            </form>
                        </div>
                    </div>
                </div>
        <?php
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
