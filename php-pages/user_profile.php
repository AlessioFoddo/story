
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
    <link rel="stylesheet" href="../css/user-page.css">
  <title>Profilo</title>
</head>
<body>
  <div class="row">
    <div class="col-3">
    </div>
    <div class="col-6 text-center">
      <h1 class="mt-3">IL TUO PROFILO</h1>
      <?php
        $query = "SELECT * FROM user WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION["id_utente"]]);
        $user = $stmt->fetch();
      ?>
      <div class="w-75 mx-auto my-5">
        <?php
          if ($user["profile_image"] == null):
        ?>
          <svg xmlns="http://www.w3.org/2000/svg" width="30%" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
          </svg>
        <?php
          else:
        ?>
          <img src="../php-actions/get_pfp.php" alt="Immagine Profilo" class="pfp">
        <?php
          endif;
        ?>
        <br />
        <button type="button" class="mt-1 btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#pfpModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="1vw" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
          </svg>
        </button>
        <div class="modal fade" id="pfpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="my-5">
                <p class="mb-5">INSERISCI LA NUOVA IMMAGINE PROFILO:</p>
                <div class="w-75 mx-auto">
                  <form action="../php-actions/change_pfp.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_image" accept="image/*" class="form-control">
                    <button class="mt-3 btn btn-outline-primary mt-3" type="submit">
                      INVIO
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3">
          <!--username-->
          <div class="btn-group">
            <button type="button" class="btn btn-danger"><?= $user["Username"] ?></button>
            <button type="button" class="btn btn-danger rounded-end-1" data-bs-toggle="modal" data-bs-target="#usernameModal">
              <svg xmlns="http://www.w3.org/2000/svg" width="1vw" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
              </svg>
            </button>
            <div class="modal fade" id="usernameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="my-5">
                    <p class="mb-5">INSERISCI IL NUOVO USERNAME:</p>
                    <div class="w-75 mx-auto">
                      <form action="../php-actions/change_username.php" method="POST">
                        <input type="text" name="new_username" placeholder="<?= $user["Username"] ?>" class="form-control">
                        <button class="mt-3 btn btn-outline-primary mt-3" type="submit">
                          INVIO
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-25 row my-5 mx-auto">
            <div class="col-12">
              <svg xmlns="http://www.w3.org/2000/svg" width="50%" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                  <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
              </svg>
              <span>
                <?php
                  $query = "SELECT * FROM recensioni WHERE ID = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->execute([$_SESSION["id_utente"]]);
                  $recensioni = $stmt->fetchAll();
                  echo count($recensioni);
                ?>
              </span>
            </div>
            <div class="col-12">
              <svg xmlns="http://www.w3.org/2000/svg" width="50%" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
              </svg>
              <span>
                <?php
                  $query = "SELECT * FROM capitoli_preferiti WHERE ID = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->execute([$_SESSION["id_utente"]]);
                  $recensioni = $stmt->fetchAll();
                  echo count($recensioni);
                ?>
              </span>
            </div>
          </div>
        </div>
        <div>
          <form action="../php-actions/login/logoutUser.php" method="POST">
          <input type="hidden" name="logout" VALUES="1">
            <button class="btn btn-outline-danger">
              LOGOUT
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
              </span>
            </button>
          </form>
          <form class="my-1" action="../php-actions/deleteUser.php" method="POST">
            <input type="hidden" name="control" VALUES="1">
            <button class="btn btn-outline-danger">
              DELETE ACCOUNT
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                </svg>
              </span>
            </button>
          </form>
          <form action="./user.php">
            <button class="btn btn-outline-danger">
              BACK
            </button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-3">
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
