<?php
session_start();
require_once 'database.php';
require_once 'auth.php';
header('Content-Type: application/json');

// Ensure user is logged in and we have their ID
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized or session expired.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$level_id = $data['level_id'] ?? '';

if (!$level_id) {
    echo json_encode(['status' => 'error', 'message' => 'No level selected.']);
    exit;
}

try {
    $dbClass = new authenticate(); // Re-using your OOP class to get the connection
    $db = new database();
    $conn = $db->connect();

    $session_id = uniqid('sess_');
    $user_id = $_SESSION["user_id"];
    
    // Default starting state (empty array for visited cells)
    $initial_state = '[]'; 

    $stmt = $conn->prepare("INSERT INTO game_sessions (session_id, acct_id, level_id, current_state) VALUES (?, ?, ?, ?)");
    
    // Using "ssss" because user_information ID is typically a string in your register function
    $stmt->bind_param("ssss", $session_id, $user_id, $level_id, $initial_state);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'session_id' => $session_id]);
    } else {
        throw new Exception("Could not start game session.");
    }
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    die($e->getMessage());
}
?>