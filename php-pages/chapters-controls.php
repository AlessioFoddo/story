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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/chapters-control.css">
    <link rel="stylesheet" href="../css/background.css">
    <script src="../js/updateChapter.js" defer></script>
    <title>Gestione Capitoli</title>
</head>
<body>
    <main>
        <h1>Cuori in Contrasto</h1>
        <h2>Gestione Capitoli</h2>
        <?php
            if (isset($_GET['error'])) {
                echo "<div class='alert alert-danger alert-message' role='alert'>".$_GET['error']."</div>";
            }
        ?>
        <form action="./admin.php">
            <button class="btn btn-outline-primary">
                BACK
            </button>
        </form>
        <div class="row mx-auto main">
            <div class="col-6 div-chibi">
                <img class="btn-chibi btn-jyle" data-bs-toggle="collapse" data-bs-target="#adding-form" aria-expanded="false" aria-controls="adding-form" src="../images/idea-jyle.png" alt="">
            </div>
            <div class="col-6">
                <div class="pre-card">
                    <div class="collapse collapse-horizontal" id="adding-form">
                        <div class="p-1 card card-body gestione-capitolo">
                            <form class="row aggiunta" action="../php-actions/aggiunta_capitolo.php" method="POST" enctype="multipart/form-data">
                                <div class="col-6 inputs-aggiunta">
                                    <label for="titolo-capitolo">Titolo:</label>
                                    <input type="text" name="titolo" id="capitolo-aggiunta" required>
                                    <label for="capitolo-aggiunta">Seleziona File:</label>
                                    <input type="file" name="file" accept="application/pdf" id="capitolo-aggiunta" required>
                                    <label for="selezione-capitolo">Capitolo:</label>
                                    <input type="number" name="chapter_id" id="selezione-capitolo">
                                    <button class="mt-2 btn btn-primary">Aggiungi</button>
                                </div>
                                <div class="col-6">
                                    <label for="riassunto-aggiunta">Scrivi il Riassunto:</label>
                                    <textarea name="resume" id="riassunto-aggiunta" required></textarea>
                                </div>
                            </form>       
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 div-chibi">
                <img class="btn-chibi btn-alice" data-bs-toggle="collapse" data-bs-target="#modify-form" aria-expanded="false" aria-controls="modify-form" src="../images/happy-alice.png" alt="">
            </div>
            <!--update chapter-->
            <div class="col-6">
                <div class="pre-card">
                    <div class="collapse collapse-horizontal" id="modify-form">
                        <div class="p-1 card card-body gestione-capitolo">
                            <form class="row aggiunta" action="../php-actions/modifica_capitolo.php" method="POST" enctype="multipart/form-data">
                                <div class="col-6 inputs-aggiunta">
                                    <select name="id_chapter" required>
                                        <?php
                                            $query = "SELECT * FROM capitoli";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $chpaters = $stmt->fetchAll();
                                            foreach ($chpaters as $chp):
                                        ?>
                                            <option value="<?= $chp['ID_Capitolo']; ?>">
                                                <?= $chp['Titolo']; ?>
                                            </option>
                                        <?php 
                                            endforeach;
                                        ?>
                                    </select>
                                    <div class="title-modifica">
                                        <label for="titolo-modifica">Titolo:</label>
                                        <input id="titolo-modifica" type="text" name="titolo" placeholder="Titolo capitolo">
                                    </div>
                                    <div class="btn-modifica">
                                        <button name="update" class="btn btn-primary">MODIFICA</button>
                                        <button name="delete" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo capitolo?');">ELIMINA</button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="riassunto-modifica">Riassunto:</label>
                                    <textarea id="riassunto-modifica" name="resume"></textarea>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>