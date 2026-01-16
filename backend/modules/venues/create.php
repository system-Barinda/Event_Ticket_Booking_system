<?php
require "../../config/database.php";

$name     = htmlspecialchars($_POST['name']);
$address  = htmlspecialchars($_POST['address']);
$capacity = intval($_POST['capacity']);
$wheel    = isset($_POST['wheelchair_access']) ? 1 : 0;

/* File upload */
$fileName = "";
if (!empty($_FILES['seating_map']['name'])) {
    $allowed = ["image/jpeg", "image/png"];
    if (!in_array($_FILES['seating_map']['type'], $allowed)) {
        echo json_encode(["error" => "Invalid image type"]);
        exit;
    }

    if ($_FILES['seating_map']['size'] > 2 * 1024 * 1024) {
        echo json_encode(["error" => "File too large"]);
        exit;
    }

    $fileName = uniqid() . "_" . $_FILES['seating_map']['name'];
    move_uploaded_file(
        $_FILES['seating_map']['tmp_name'],
        "../../uploads/" . $fileName
    );
}

$stmt = $conn->prepare(
    "INSERT INTO venues
    (name, address, seating_map, capacity, wheelchair_access)
    VALUES (?,?,?,?,?)"
);

$stmt->bind_param(
    "sssii",
    $name,
    $address,
    $fileName,
    $capacity,
    $wheel
);

echo $stmt->execute()
    ? json_encode(["success" => "Venue created"])
    : json_encode(["error" => "Failed to create venue"]);
