<?php
include "../../config/dbconfig.php";
// Sanitize input to avoid sql injections
$crime = sanitizeInput(filter_input(INPUT_POST, 'crime', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$number = sanitizeInput(filter_input(INPUT_POST, 'number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$status = sanitizeInput(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$casualties = sanitizeInput(filter_input(INPUT_POST, 'casualties', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$description = sanitizeInput(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  // Prepare SQL statement
  $query = $pdo->prepare("INSERT INTO cdata (crime, number, status, casualties, description) 
  VALUES (:crime, :number, :status, :casualties, :description)");

  // Bind parameters
  $query->bindParam(':crime', $crime, PDO::PARAM_STR);
  $query->bindParam(':number', $number, PDO::PARAM_STR);
  $query->bindParam(':status', $status, PDO::PARAM_STR);
  $query->bindParam(':casualties', $casualties, PDO::PARAM_STR);
  $query->bindParam(':description', $description, PDO::PARAM_STR);

  // Execute query
  if ($query->execute()) {
    // Registration successful
    echo json_encode("success");
  } else {
    // Registration failed
    echo json_encode("Failed to register crime");
  }
?>