<?php
    include("../db.php");

    $id_chapter = $_POST["id_chapter"];
    $text = $_POST["recensione"];
    $id_user = $_POST["id_user"];
    $target = $_POST["target"];

    $query = "INSERT INTO Recensioni (ID, File) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_user, $text]);
    $id_feedback = $conn->lastInsertId();

    if($target == "capitolo"){
        $query = "INSERT INTO Recensione_capitolo (ID_Recensione, ID_Capitolo) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_feedback, $id_chapter]);
    }else{
        $query = "INSERT INTO Recensione_storia (ID_Recensione, ID) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_feedback, $id_user]);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>RECENSIONE CREATA</h1>
    <form action="../php-pages/chapter.php" method="POST">
        <input type="hidden" name="id_chapter" value="<?= $id_chapter?>">
        <button>BACK</button>
    </form>
</body>
</html>