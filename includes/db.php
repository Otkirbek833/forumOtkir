<?php
$conn = new mysqli('localhost', 'root', 'root', 'forumdb');
if ($conn->connect_error) { die('DB connection failed: ' . $conn->connect_error); }
?>