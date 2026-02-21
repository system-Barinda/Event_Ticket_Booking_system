<?php
session_start();
require "../../config/database.php";

header("Content-Type: application/json");

// =========================
// AUTH CHECK
// =========================
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'] ?? 'user';

// =========================
// REQUEST METHOD
// =========================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

// =========================
// INPUT
// =========================
$event_id    = intval($_POST['event_id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$category    = trim($_POST['category'] ?? '');
$city        = trim($_POST['city'] ?? '');
$language    = trim($_POST['language'] ?? '');
$description = trim($_POST['description'] ?? '');
$access      = trim($_POST['accessibility_notes'] ?? '');

// Admin only
$status = ($role === 'admin' && isset($_POST['status']))
    ? $_POST['status']
    : null;

if ($event_id === 0 || empty($title) || empty($category) || empty($city)) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

// =========================
// OWNERSHIP CHECK
// =========================
$checkSql = "
    SELECT organizer_id, event_image
    FROM events
    WHERE event_id = ?
";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("i", $event_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Event not found"]);
    exit;
}

$event = $result->fetch_assoc();

if ($role !== 'admin' && $event['organizer_id'] != $user_id) {
    echo json_encode(["success" => false, "message" => "Forbidden"]);
    exit;
}

$currentImage = $event['event_image'];
$checkStmt->close();

// =========================
// IMAGE UPLOAD (OPTIONAL)
// =========================
$imagePath = $currentImage;

if (!empty($_FILES['event_image']['name'])) {
    $uploadDir = "../../../uploads/events/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['event_image'];

    if ($file['error'] !== 0) {
        echo json_encode(["success" => false, "message" => "Image upload error"]);
        exit;
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(["success" => false, "message" => "Image must be under 2MB"]);
        exit;
    }

    $allowedExt = ['jpg', 'jpeg', 'png'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExt)) {
        echo json_encode(["success" => false, "message" => "Invalid image type"]);
        exit;
    }

    $newName = uniqid("event_", true) . "." . $extension;
    $imagePath = "uploads/events/" . $newName;

    move_uploaded_file($file['tmp_name'], "../../../" . $imagePath);
}

// =========================
// UPDATE QUERY
// =========================
$sql = "
UPDATE events SET
    title = ?,
    category = ?,
    city = ?,
    language = ?,
    description = ?,
    accessibility_notes = ?,
    event_image = ?
";

$params = [
    $title,
    $category,
    $city,
    $language,
    $description,
    $access,
    $imagePath
];

$types = "sssssss";

if ($status !== null) {
    $sql .= ", status = ?";
    $params[] = $status;
    $types .= "s";
}

$sql .= " WHERE event_id = ?";

$params[] = $event_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

// =========================
// EXECUTE
// =========================
if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Event updated successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update event"
    ]);
}

$stmt->close();
$conn->close();