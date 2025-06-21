<?php
$servername = "localhost"
$username = "root"; 
$password = ""; 
$dbname = "study_assist"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'];
    $x = $_POST['x'];
    $y = $_POST['y'];
    $width = $_POST['width'];
    $height = $_POST['height'];


    $stmt = $conn->prepare("INSERT INTO nodes (text, x, y, width, height) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiii", $text, $x, $y, $width, $height);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['status' => 'success']);
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM nodes");
    $nodes = [];
    while ($row = $result->fetch_assoc()) {
        $nodes[] = $row;
    }
    echo json_encode($nodes);
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data); 
    $id = $data['id']; 
    
    
    $stmt = $conn->prepare("DELETE FROM nodes WHERE id = ?"); 
    $stmt->bind_param("i", $id); 
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete node.']);
    }
    $stmt->close();
}


$conn->close();
?>
