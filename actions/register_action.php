<?php
include('../includes/db.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Parolni shifrlaw
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// userdi bazaǵa qosıw
$query = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$query->bind_param("ss", $email, $hashed_password);

if ($query->execute()) {
    // Tabıslı ótildi
    header("Location: ../login.html");
    exit();
} else {
    echo "Qátelik júz berdi: " . $conn->error;
}
?>