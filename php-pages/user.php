<?php
    include("../db.php");
    session_start();
    if ($_SESSION["id_utente"] == null) {
        header("Location: ../index.html");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/user-page.css">
        <title>Pagina utente</title>
    </head>

    <body>
            <div class="copertina">
                <div class="row my-5">
                    <div class="12">
                        <div class="w-75 mx-auto">
                            <img class="w-100" src="../images/copertina.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="row mb-5 mx-1">
                        <div class="w-100">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad aspernatur et quibusdam porro
                                nobis cumque saepe repellendus incidunt tenetur illo perspiciatis facilis nulla
                                molestiae deserunt, velit nihil ullam. Voluptatum, architecto!
                            </p>
                    </div>
                </div>
            </div>
            <div class="contenuto py-5">
                <h1 class="mb-4">
                    CUORI IN CONTRASTO
                </h1>
                <div class="container row">
                <?php
                    try {
                        $sql = "SELECT * FROM capitoli";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $chapters = $stmt->fetchAll();

                        if ($chapters):
                            $num_tmp = 1;
                            foreach ($chapters as $chp): 
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
                                            Capitolo <?= $num_tmp ?>
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
                            echo "<div class='alert alert-warning'>PDF non trovato!</div>";
                        endif;
                    } catch (PDOException $e) {
                        echo "<div class='alert alert-danger'>Errore durante il recupero del PDF: " . htmlspecialchars($e->getMessage()) . "</div>";
                    } finally {
                        $stmt = null;
                    }
                ?>
                </div>
            </div>
            <div class="user-menu">
                <!--recensioni-->
                <form action="./recensioni.php">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                    </button>
                </form>
                
                <!--capitoli preferiti-->
                <form action="./capitoli_preferiti.php">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                        </svg>
                    </button>
                </form>

                <!--home-->
                <form action="../index.html">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                        </svg>
                    </button>
                </form>

                <!--profilo utente-->
                <form action="./user_profile.php">
                    <button>
                        <?php
                            $query = "SELECT * FROM user WHERE ID = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->execute([$_SESSION["id_utente"]]);
                            $user = $stmt->fetch();
                            if($user["profile_image"] == null):
                        ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            </svg>
                        <?php
                            else:
                        ?>
                            <img src="../php-actions/get_pfp.php" alt="Immagine Profilo" width="100%" class="rounded-circle">
                        <?php
                            endif;
                        ?>
                    </button>
                </form>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

</html>