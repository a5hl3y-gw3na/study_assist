<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("Not logged in");

$userId = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "study_assist");
if ($conn->connect_error) exit("DB error");

$conn->query("DELETE FROM chat_history WHERE user_id = $userId");
$conn->close();
echo "Deleted";
?>
