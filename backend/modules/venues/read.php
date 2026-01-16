<?php
require "../../config/database.php";

$result = $conn->query("SELECT * FROM venues ORDER BY created_at DESC");
$venues = [];

while ($row = $result->fetch_assoc()) {
    $venues[] = $row;
}

echo json_encode($venues);
