<?php
require "../../config/database.php";

$id = $_POST['venue_id'];

$stmt = $conn->prepare("DELETE FROM venues WHERE venue_id=?");
$stmt->bind_param("i", $id);

echo $stmt->execute()
    ? json_encode(["success" => "Venue deleted"])
    : json_encode(["error" => "Delete failed"]);
