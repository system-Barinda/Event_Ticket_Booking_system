<?php
require "../../config/database.php";
header("Content-Type: application/json");

$name    = $_POST['name'] ?? '';
$address = $_POST['address'] ?? null;
$map     = $_POST['seating_map'] ?? null;
$capacity = $_POST['capacity'] ?? 0;
$wheelchair = isset($_POST['wheelchair_access']) ? 1 : 0;

if (!$name || !$capacity) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO venues (name, address, seating_map, capacity, wheelchair_access)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssii", $name, $address, $map, $capacity, $wheelchair);
$stmt->execute();

echo json_encode(["success" => true]);