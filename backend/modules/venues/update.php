<?php
require "../../config/database.php";

$id       = $_POST['venue_id'];
$name     = htmlspecialchars($_POST['name']);
$address  = htmlspecialchars($_POST['address']);
$capacity = intval($_POST['capacity']);
$wheel    = $_POST['wheelchair_access'];

$stmt = $conn->prepare(
    "UPDATE venues
     SET name=?, address=?, capacity=?, wheelchair_access=?
     WHERE venue_id=?"
);

$stmt->bind_param(
    "ssiii",
    $name,
    $address,
    $capacity,
    $wheel,
    $id
);

echo $stmt->execute()
    ? json_encode(["success" => "Venue updated"])
    : json_encode(["error" => "Update failed"]);
