<?php
    include("../db.php");

    $name = $_POST["username"];
    $psw = $_POST["password"];

    $query = "SELECT * from user where user.Username = ? and user.Password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $psw);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $id = $row["ID"];
        $adminQuery = "SELECT * from admin where admin.ID = ?";
        $response = $conn->prepare($adminQuery);
        $response->bind_param("i", $id);
        $response->execute();
        $presence = $response->get_result();
        if($presence->num_rows > 0){
            header('Location: ../admin/admin_prova.php');
        }

        echo "CIAO: " . htmlspecialchars($row["Username"]);
    } else {
        header('Location: ../errors/pages/create-account.html');
    }
?>