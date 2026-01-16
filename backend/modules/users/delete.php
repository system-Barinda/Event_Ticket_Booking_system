<?php
require "../../config/database.php";

$id = $_POST['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
$stmt->bind_param("i", $id);

echo $stmt->execute()
    ? json_encode(["success" => "Deleted"])
    : json_encode(["error" => "Failed"]);
