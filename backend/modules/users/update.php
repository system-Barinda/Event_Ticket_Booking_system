<?php
require "../../config/database.php";

$id   = $_POST['user_id'];
$name = htmlspecialchars($_POST['name']);
$role = $_POST['role'];

$stmt = $conn->prepare(
    "UPDATE users SET name=?, role=? WHERE user_id=?"
);
$stmt->bind_param("ssi", $name, $role, $id);

echo $stmt->execute()
    ? json_encode(["success" => "Updated"])
    : json_encode(["error" => "Failed"]);
