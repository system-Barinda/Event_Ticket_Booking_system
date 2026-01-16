<?php
require "../../config/database.php";

$result = $conn->query(
    "SELECT user_id,name,email,role,created_at FROM users"
);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
