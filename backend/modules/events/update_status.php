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

    if (!isset($_POST['event_id'], $_POST['status'])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields"
        ]);
        exit;
    }

    $event_id = intval($_POST['event_id']);
    $status = $_POST['status'];

    // Allowed statuses
    $allowedStatus = ['pending', 'approved', 'cancelled'];
    if (!in_array($status, $allowedStatus)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid status value"
        ]);
        exit;
    }

    $query = "UPDATE events SET status = ? WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $event_id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Event status updated successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update event status"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error",
        "error" => $e->getMessage()
    ]);
}