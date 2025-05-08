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
        // Verify password
        if (password_verify($psw, $user["Password"])) {
            $_SESSION["id_utente"] = $user["ID"];
            // Check if user is admin
            $adminQuery = "SELECT * FROM admin WHERE ID = ?";
            $adminStmt = $conn->prepare($adminQuery);
            $adminStmt->execute([$user['ID']]);
            if ($adminStmt->fetch()) {
                header('Location: ../../php-pages/admin.php');
                exit;
            }
            header('Location: ../../php-pages/user.php');
            exit;
        }
    }
    header('Location: ../../index.php');
    exit;

} catch(PDOException $e) {
    die("Errore del database: " . $e->getMessage());
} finally {
    $stmt = null;
    $adminStmt = null;
}
?>