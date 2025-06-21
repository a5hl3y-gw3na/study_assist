<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "study_assist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "Error: Database connection failed.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Ensure data is an array of flashcards
    if (!is_array($data)) {
        echo "Error: Invalid input format. Expected an array of flashcards.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Prepare statement once
    $stmt = $conn->prepare("INSERT INTO flashcards (question, answer, user_id) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Error: Database error: failed to prepare statement.";
        exit;
    }

    foreach ($data as $entry) {
        if (
            !isset($entry['question']) || trim($entry['question']) === '' ||
            !isset($entry['answer']) || trim($entry['answer']) === ''
        ) {
            echo "Error: Each flashcard must have a question and an answer.";
            $stmt->close();
            exit;
        }

        $question = trim($entry['question']);
        $answer = trim($entry['answer']);

        $stmt->bind_param("ssi", $question, $answer, $user_id);
        if (!$stmt->execute()) {
            echo "Error: Error saving one of the flashcards.";
            $stmt->close();
            exit;
        }
    }

    $stmt->close();
    echo "Success: Flashcards saved successfully.";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT question, answer FROM flashcards WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $flashcards = [];
    while ($row = $result->fetch_assoc()) {
        $flashcards[] = $row;
    }

    // Output flashcards as plain text
    if (empty($flashcards)) {
        echo "No flashcards found.";
    } else {
        foreach ($flashcards as $flashcard) {
            echo "Question: " . htmlspecialchars($flashcard['question']) . " | Answer: " . htmlspecialchars($flashcard['answer']) . "<br>";
        }
    }
    $stmt->close();
}

$conn->close();
?>
