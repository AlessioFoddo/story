<?php
include("../../db.php");

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
        $stmt->execute([$name, $psw]);
        $user = $stmt->fetch();
        $query = "SELECT user.ID FROM user WHERE Username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$name]);
        $id = $stmt->fetch();
        $query = "INSERT INTO utenti (ID) VALUES (?);";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id["ID"]]);
        $user = $stmt->fetch();
        header('Location: ../../html-pages/advice-pages/user-created.html');
        exit;
    }

} catch(PDOException $e) {
    die("Errore del database: " . $e->getMessage());
} finally {
    $stmt = null;
    $adminStmt = null;
}
?>