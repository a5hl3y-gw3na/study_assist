<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("Not logged in");

$userId = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "study_assist");
if ($conn->connect_error) exit("DB error");

$result = $conn->query("SELECT user_message, bot_response, created_at FROM chat_history WHERE user_id = $userId ORDER BY created_at DESC");
$history = [];

while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}
echo json_encode($history);
$conn->close();
?>
