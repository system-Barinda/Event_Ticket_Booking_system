<?php
require "../../config/database.php";

$session = $_POST['session_id'];
$name    = htmlspecialchars($_POST['name']);
$price   = floatval($_POST['price']);
$total   = intval($_POST['quantity_total']);
$rules   = htmlspecialchars($_POST['rules']);

if ($total <= 0 || $price <= 0) {
    echo json_encode(["error" => "Invalid price or quantity"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO ticket_types
    (session_id, name, price, quantity_total, quantity_remaining, rules)
    VALUES (?,?,?,?,?,?)"
);

$stmt->bind_param(
    "isdiis",
    $session,
    $name,
    $price,
    $total,
    $total, // remaining = total at start
    $rules
);

echo $stmt->execute()
    ? json_encode(["success" => "Ticket type created"])
    : json_encode(["error" => "Creation failed"]);
