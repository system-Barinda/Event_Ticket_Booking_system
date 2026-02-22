<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "../../config/database.php";

try {
    // OPTIONAL (recommended later)
    // session_start();
    // if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //     echo json_encode([
    //         "success" => false,
    //         "message" => "Unauthorized access"
    //     ]);
    //     exit;
    // }

    $query = "
        SELECT 
            event_id,
            title,
            category,
            city,
            language,
            description,
            accessibility_notes,
            status,
            created_at
        FROM events
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $events = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $events
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch events",
        "error" => $e->getMessage()
    ]);
}