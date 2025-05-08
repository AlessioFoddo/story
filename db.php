<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storia";

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Creazione admin se non esiste
    $stmt = $conn->query("SELECT COUNT(*) FROM Admin");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Inserisce l'admin solo se non esiste ancora
        $username = "foddo";
        $password = "JyleAlice";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Inserisce l'utente
        $stmtUser = $conn->prepare("INSERT INTO User (Username, Password) VALUES (?, ?)");
        $stmtUser->execute([$username, $hashedPassword]);

        // Ottiene l'ID dell'utente appena creato
        $userId = $conn->lastInsertId();

        // Inserisce nella tabella Admin
        $stmtAdmin = $conn->prepare("INSERT INTO Admin (ID) VALUES (?)");
        $stmtAdmin->execute([$userId]);
    }
    
} catch(PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}
?>