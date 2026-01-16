<?php
require "../../config/database.php";

$id = $_POST['session_id'];

$stmt = $conn->prepare("DELETE FROM sessions WHERE session_id=?");
$stmt->bind_param("i", $id);

echo $stmt->execute()
    ? json_encode(["success" => "Session deleted"])
    : json_encode(["error" => "Delete failed"]);
