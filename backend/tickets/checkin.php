<?php
require "../../config/database.php";

$code = $_POST['ticket_code'];

$stmt = $conn->prepare("
    SELECT * FROM tickets
    WHERE ticket_code=? AND checked_in=0
");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Invalid or already used ticket"]);
    exit;
}

$conn->query("
    UPDATE tickets SET checked_in=1
    WHERE ticket_code='$code'
");

echo json_encode(["success" => "Entry allowed"]);
