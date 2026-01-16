<?php
require "../../config/database.php";

$id    = $_POST['type_id'];
$price = floatval($_POST['price']);
$rules = htmlspecialchars($_POST['rules']);

$stmt = $conn->prepare(
    "UPDATE ticket_types SET price=?, rules=? WHERE type_id=?"
);

$stmt->bind_param("dsi", $price, $rules, $id);

echo $stmt->execute()
    ? json_encode(["success" => "Ticket updated"])
    : json_encode(["error" => "Update failed"]);
