<?php
require "../../config/database.php";

$id = $_POST['type_id'];

$stmt = $conn->prepare("DELETE FROM ticket_types WHERE type_id=?");
$stmt->bind_param("i", $id);

echo $stmt->execute()
    ? json_encode(["success" => "Ticket deleted"])
    : json_encode(["error" => "Delete failed"]);
