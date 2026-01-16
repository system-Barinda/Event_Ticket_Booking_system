<?php
require "../../config/database.php";

$title       = htmlspecialchars($_POST['title']);
$description = htmlspecialchars($_POST['description']);
$category    = $_POST['category'];
$city        = $_POST['city'];
$language    = $_POST['language'];
$access      = htmlspecialchars($_POST['accessibility_notes']);
$organizer   = $_POST['organizer_id'];

if (empty($title) || empty($category) || empty($city)) {
    echo json_encode(["error" => "Required fields missing"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO events
    (organizer_id, title, description, category, city, language, accessibility_notes)
    VALUES (?,?,?,?,?,?,?)"
);

$stmt->bind_param(
    "issssss",
    $organizer,
    $title,
    $description,
    $category,
    $city,
    $language,
    $access
);

echo $stmt->execute()
    ? json_encode(["success" => "Event created, pending approval"])
    : json_encode(["error" => "Failed to create event"]);
