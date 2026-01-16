<?php
require "../../config/database.php";

$name  = htmlspecialchars($_POST['name']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role  = $_POST['role'];

if (!$email) {
    echo json_encode(["error" => "Invalid email"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)"
);
$stmt->bind_param("ssss", $name, $email, $pass, $role);

if ($stmt->execute()) {
    echo json_encode(["success" => "User created"]);
} else {
    echo json_encode(["error" => "Email already exists"]);
}
