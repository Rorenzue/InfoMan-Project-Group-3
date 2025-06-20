<?php
$servername = "localhost";
$username = "root";
$password = "polo0210";
$dbname = "main database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

if (isset($_POST['appli_num']) && isset($_POST['status'])) {
    $appli_num = (int)$_POST['appli_num'];
    $status = trim($_POST['status']);

    // Optional: Check if applicant exists
    $check = $conn->prepare("SELECT 1 FROM appli_details WHERE Appli_Num = ?");
    $check->bind_param("i", $appli_num);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Applicant not found']);
        $check->close();
    } else {
        $check->close();

        $stmt = $conn->prepare("UPDATE appli_details SET status = ? WHERE Appli_Num = ?");
        $stmt->bind_param("si", $status, $appli_num);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No rows updated']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}

$conn->close();
?>
