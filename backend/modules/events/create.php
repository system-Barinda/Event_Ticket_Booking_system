<?php
require "../../config/database.php";

/* =========================
   BASIC VALIDATION
========================= */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

/* =========================
   COLLECT & SANITIZE INPUT
========================= */
$organizer_id = intval($_POST['organizer_id'] ?? 0);
$title        = trim($_POST['title'] ?? '');
$category     = trim($_POST['category'] ?? '');
$city         = trim($_POST['city'] ?? '');
$language     = trim($_POST['language'] ?? '');
$status       = $_POST['status'] ?? 'pending';
$description  = trim($_POST['description'] ?? '');
$access       = trim($_POST['accessibility_notes'] ?? '');

/* =========================
   REQUIRED FIELDS CHECK
========================= */
if (empty($title) || empty($category) || empty($city)) {
    die("Required fields are missing");
}

/* =========================
   IMAGE UPLOAD HANDLING
========================= */
$imagePath = null;

if (!empty($_FILES['event_image']['name'])) {

    $uploadDir = "../../../uploads/events/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file      = $_FILES['event_image'];
    $fileSize  = $file['size'];
    $fileTmp   = $file['tmp_name'];
    $fileError = $file['error'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    if ($fileError !== 0) {
        die("Image upload error");
    }

    if ($fileSize > 2 * 1024 * 1024) {
        die("Image must be less than 2MB");
    }

    if (!in_array(mime_content_type($fileTmp), $allowedTypes)) {
        die("Invalid image type");
    }

    // Unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName   = uniqid("event_", true) . "." . $extension;
    $imagePath = "uploads/events/" . $newName;

    move_uploaded_file($fileTmp, "../../../" . $imagePath);
}

/* =========================
   INSERT INTO DATABASE
========================= */
$stmt = $conn->prepare(
    "INSERT INTO events 
    (organizer_id, title, category, city, language, status, event_image, description, accessibility_notes)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "issssssss",
    $organizer_id,
    $title,
    $category,
    $city,
    $language,
    $status,
    $imagePath,
    $description,
    $access
);

if ($stmt->execute()) {
    echo "Event created successfully (pending approval)";
} else {
    echo "Failed to create event";
}

$stmt->close();
$conn->close();
