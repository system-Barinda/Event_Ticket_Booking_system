<?php
require "../../config/database.php";

$id = $_POST['notif_id'];

$conn->query("
    UPDATE notifications SET is_read=1
    WHERE notif_id=$id
");

echo json_encode(["success" => "Notification marked as read"]);
