<?php
    include("../db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>

<body id="index-main">
    <div class="mx-5">
        <div class="row">
            <div class="col-3">
                <div class="row my-5">
                    <div class="12">
                        <div class="w-75 mx-auto">
                            <img class="w-100" src="../images/copertina.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="row mb-5 mx-1">
                    <div class="12">
                        <div class="w-100">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad aspernatur et quibusdam porro
                                nobis cumque saepe repellendus incidunt tenetur illo perspiciatis facilis nulla
                                molestiae deserunt, velit nihil ullam. Voluptatum, architecto!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <h1>
                    CUORI IN CONTRASTO
                </h1>
                <div class="container row">
                    <?php
                        try {
                            $sql = "SELECT * FROM capitoli";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            
                            // Recupera il contenuto binario del PDF
                            $chapters = $stmt->fetchAll();
                            
                            if ($chapters) {
                                $num_tmp = 1;
                                foreach ($chapters as $chp) {
                                    echo "
                                            <p class='d-inline-flex gap-1'>
                                                <button class='btn btn-primary collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseExample$num_tmp' aria-expanded='false' aria-controls='collapseExample'>
                                                    Button with data-bs-target
                                                </button>
                                            </p>
                                            <div class='collapse' id='collapseExample$num_tmp'>
                                                <div class='card card-body'>
                                                    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                                </div>
                                            </div>
                                        ";
                                    $num_tmp++;
                                }
                                exit; // Importante per evitare output aggiuntivo
                            } else {
                                echo "PDF non trovato!";
                            }
                            
                        } catch(PDOException $e) {
                            die("Errore durante il recupero del PDF: " . $e->getMessage());
                        } finally {
                            $stmt = null; // Chiude lo statement
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>