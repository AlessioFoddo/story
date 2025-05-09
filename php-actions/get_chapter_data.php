<?php
include("../db.php");

if (isset($_GET["id"])) {
    $stmt = $conn->prepare("SELECT Titolo, Riassunto FROM capitoli WHERE ID_Capitolo = ?");
    $stmt->execute([$_GET["id"]]);
    $capitolo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($capitolo) {
        echo json_encode([
            "success" => true,
            "titolo" => $capitolo["Titolo"],
            "riassunto" => $capitolo["Riassunto"]
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false]);
}
?>
