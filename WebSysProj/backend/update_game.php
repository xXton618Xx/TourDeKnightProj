<?php
session_start();
require_once 'database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Unauthorized']); exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$session_id = $data['session_id'] ?? '';
$action = $data['action'] ?? 'save'; 
$moves = (int)($data['moves'] ?? 0);
$state = json_encode($data['state'] ?? []); // Encode JS array back to JSON string

// Map JS actions to DB ENUM
$status = 'in_progress';
if ($action === 'abandon') $status = 'abandoned';
if ($action === 'win') $status = 'completed';
if ($action === 'lose') $status = 'failed';

$db = new database();
$conn = $db->connect();
$stmt = $conn->prepare("UPDATE game_sessions SET status = ?, total_moves = ?, current_state = ? WHERE session_id = ? AND acct_id = ?");
$stmt->bind_param("sisss", $status, $moves, $state, $session_id, $_SESSION['user_id']);

if ($stmt->execute()) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Failed to update game state.']);
}
$stmt->close();
$conn->close();
?>