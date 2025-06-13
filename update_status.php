<?php
$servername = "localhost";
$username = "root";
$password = "polo0210";
$dbname = "initial-final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed']));
}

if (isset($_POST['appli_num']) && isset($_POST['status'])) {
    $appli_num = (int)$_POST['appli_num'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE appli_details SET status = ? WHERE Appli_Num = ?");
    $stmt->bind_param("si", $status, $appli_num);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}

$conn->close();
?>