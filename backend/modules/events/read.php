<?php
require "../../config/database.php";
session_start();

header("Content-Type: application/json");

// =========================
// ROLE CHECK (OPTIONAL)
// =========================
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// =========================
// FILTERS (OPTIONAL)
// =========================
$status   = $_GET['status']   ?? null;
$category = $_GET['category'] ?? null;
$city     = $_GET['city']     ?? null;

// =========================
// BASE QUERY
// =========================
$sql = "
SELECT 
    e.event_id,
    e.title,
    e.category,
    e.city,
    e.language,
    e.status,
    e.event_image,
    e.created_at,
    u.name AS organizer
FROM events e
JOIN users u ON e.organizer_id = u.user_id
WHERE 1
";

// =========================
// PUBLIC USERS SEE ONLY APPROVED EVENTS
// =========================
if (!$isAdmin) {
    $sql .= " AND e.status = 'approved'";
}

// =========================
// OPTIONAL FILTERS
// =========================
$params = [];
$types  = "";

if ($status && $isAdmin) {
    $sql .= " AND e.status = ?";
    $params[] = $status;
    $types .= "s";
}

if ($category) {
    $sql .= " AND e.category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($city) {
    $sql .= " AND e.city = ?";
    $params[] = $city;
    $types .= "s";
}

$sql .= " ORDER BY e.created_at DESC";

// =========================
// PREPARE & EXECUTE
// =========================
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// =========================
// FETCH DATA
// =========================
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode([
    "success" => true,
    "count"   => count($events),
    "data"    => $events
]);

$stmt->close();
$conn->close();