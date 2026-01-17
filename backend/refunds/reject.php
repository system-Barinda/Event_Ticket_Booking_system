<?php
require "../../config/database.php";

$refundId = $_POST['refund_id'];

$conn->query("
    UPDATE refunds
    SET status='rejected', processed_at=NOW()
    WHERE refund_id=$refundId
");

echo json_encode(["success" => "Refund rejected"]);
