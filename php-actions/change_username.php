<?php
include("../db.php");
session_start();

$id_user = $_SESSION["id_utente"];
$new_name = $_POST["new_username"];

$sql = "UPDATE user SET Username = ? WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$new_name, $id_user]);

header("Location: ../php-pages/user_profile.php");

?>