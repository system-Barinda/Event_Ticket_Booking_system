<?php
require "../../config/database.php";

$id      = $_POST['event_id'];
$title   = htmlspecialchars($_POST['title']);
$status  = $_POST['status'];
$category= $_POST['category'];
$city    = $_POST['city'];

$stmt = $conn->prepare(
    "UPDATE events
     SET title=?, category=?, city=?, status=?
     WHERE event_id=?"
);

$stmt->bind_param("ssssi", $title, $category, $city, $status, $id);

echo $stmt->execute()
    ? json_encode(["success" => "Event updated"])
    : json_encode(["error" => "Update failed"]);
