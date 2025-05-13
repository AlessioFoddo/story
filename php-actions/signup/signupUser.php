<?php
include("../../db.php");
session_start();

try {
    $name = $_POST["username"] ?? '';
    $psw = $_POST["password"] ?? '';

    $query = "SELECT * FROM user WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name]);
    $user = $stmt->fetch();

    if ($user) {
        header('Location: ../../html-pages/advice-pages/user-already-exist.html');
    } else {
        $query = "INSERT INTO User (Username, Password) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $psw = password_hash($psw, PASSWORD_DEFAULT);
        $stmt->execute([$name, $psw]);
        $id = $conn->lastInsertId();
        $_SESSION["id_utente"] = $id;
        $query = "INSERT INTO utenti (ID) VALUES (?);";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        header('Location: ../../php-pages/user.php');
        exit;
    }

} catch(PDOException $e) {
    die("Errore del database: " . $e->getMessage());
} finally {
    $stmt = null;
    $adminStmt = null;
}
?>