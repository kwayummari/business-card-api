<?php

include "../../config/dbconfig.php";

// Sanitize input
$fullname = sanitizeInput(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$phone = sanitizeInput(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$email = sanitizeInput(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$password = sanitizeInput(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));


// Check if email or full name already exists in the database
$existingUserQuery = $pdo->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
$existingUserQuery->bindParam(':email', $email, PDO::PARAM_STR);
$existingUserQuery->bindParam(':phone', $phone, PDO::PARAM_STR);
$existingUserQuery->execute();

if ($existingUserQuery->rowCount() > 0) {
  // User already exists
  $existingUser = $existingUserQuery->fetch(PDO::FETCH_ASSOC);

  if ($existingUser['email'] === $email) {
    // Email already exists
    echo json_encode("Email exists");
  } elseif ($existingUser['phone'] === $phone) {
    echo json_encode("Phone number exists");
  }
} else {
  // Hash password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare SQL statement
  $query = $pdo->prepare("INSERT INTO users (email, fullname, password, phone,role,status,create_at) 
  VALUES (:email, :fullname, :password, :phone, :role, :status, :create_at)");

  // Bind parameters
  $role = '0';
  $status = '0';
  $create_at = date("Y/m/d");
  $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->bindParam(':phone', $phone, PDO::PARAM_STR);
  $query->bindParam(':role', $role, PDO::PARAM_STR);
  $query->bindParam(':status', $status, PDO::PARAM_STR);
  $query->bindParam(':create_at', $create_at, PDO::PARAM_STR);

  // Execute query
  if ($query->execute()) {
    // Registration successful
    echo json_encode("success");
  } else {
    // Registration failed
    echo json_encode("Failed to register user");
  }
}
?>