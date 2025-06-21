<?php
session_start();
if (!isset($_SESSION['user_id'])) exit("Not logged in");

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['user_message'], $data['bot_response'])) {
    $conn = new mysqli("localhost", "root", "", "study_assist");
    if ($conn->connect_error) exit("DB error");

    $stmt = $conn->prepare("INSERT INTO chat_history (user_id, user_message, bot_response) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $data['user_message'], $data['bot_response']);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo "Saved";
} else {
    echo "Missing data";
}
?>
