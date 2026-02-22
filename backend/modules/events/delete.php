<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once "../../config/database.php";

try {
    // OPTIONAL (enable later for security)
    // session_start();
    // if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //     echo json_encode([
    //         "success" => false,
    //         "message" => "Unauthorized access"
    //     ]);
    //     exit;
    // }

    if (!isset($_POST['event_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Event ID is required"
        ]);
        exit;
    }

    $event_id = intval($_POST['event_id']);

    // Check if event exists
    $checkQuery = "SELECT event_id FROM events WHERE event_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $event_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
        echo json_encode([
            "success" => false,
            "message" => "Event not found"
        ]);
        exit;
    }

    // Delete event
    $deleteQuery = "DELETE FROM events WHERE event_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $event_id);

    if ($deleteStmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Event deleted successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to delete event"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error",
        "error" => $e->getMessage()
    ]);
}