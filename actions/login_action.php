<?php
session_start();
include('../includes/db.php');
$email = $_POST['email'];
$password = $_POST['password'];
$query = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$query->store_result();
if ($query->num_rows > 0) {
    $query->bind_result($id, $hashed_password);
    $query->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: ../pages/forum.php");
        exit();
    }
}
echo "Login qáte.";
?>