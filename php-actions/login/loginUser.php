<?php
include("../../db.php");

try {
    $name = $_POST["username"] ?? '';
    $psw = $_POST["password"] ?? '';

    $query = "SELECT * FROM user WHERE Username = ? AND Password = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $psw]);
    $user = $stmt->fetch();

    if ($user) {
        // Check if user is admin
        $adminQuery = "SELECT * FROM admin WHERE ID = ?";
        $adminStmt = $conn->prepare($adminQuery);
        $adminStmt->execute([$user['ID']]);
        
        if ($adminStmt->fetch()) {
            header('Location: ../../admin/admin_prova.php');
            exit;
        }

        echo "CIAO: " . htmlspecialchars($user["Username"]);
    } else {
        header('Location: ../../index.html');
        exit;
    }

} catch(PDOException $e) {
    die("Errore del database: " . $e->getMessage());
} finally {
    $stmt = null;
    $adminStmt = null;
}
?>