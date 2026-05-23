<?php
session_start();
require_once 'database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
  exit();
}

$session_id = $_GET['session_id'] ?? '';

$db = new database();
$conn = $db->connect();

// JOIN game_sessions with levels_list to get everything in one go
$stmt = $conn->prepare("
  SELECT gs.current_state, gs.total_moves, l.* FROM game_sessions gs 
  JOIN levels_list l ON gs.level_id = l.level_id 
  WHERE gs.session_id = ? AND gs.acct_id = ?
");
$stmt->bind_param("ss", $session_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo json_encode(['status' => 'error', 'message' => 'Session not found or access denied.']);
  exit();
}
$data = $result->fetch_assoc();
$stmt->close();

// Get Blocked Cells
$blockStmt = $conn->prepare("SELECT x_pos, y_pos FROM blocked_cells WHERE level_id = ?");
$blockStmt->bind_param("s", $data['level_id']);
$blockStmt->execute();
$blockResult = $blockStmt->get_result();

$blockedCells = [];
while ($row = $blockResult->fetch_assoc()) {
  $blockedCells[] = ['x' => (int)$row['x_pos'], 'y' => (int)$row['y_pos']];
}
$blockStmt->close();
$conn->close();

echo json_encode([
  'status' => 'success',
  'session' => [
    'saved_state' => json_decode($data['current_state'], true), // Convert JSON string back to array
    'saved_moves' => (int)$data['total_moves']
  ],
  'level' => [
    'width' => (int)$data['board_width'],
    'height' => (int)$data['board_height'],
    'difficulty' => $data['difficulty'],
    'start_x' => $data['start_x'] !== null ? (int)$data['start_x'] : null,
    'start_y' => $data['start_y'] !== null ? (int)$data['start_y'] : null,
    'end_x' => $data['end_x'] !== null ? (int)$data['end_x'] : null,
    'end_y' => $data['end_y'] !== null ? (int)$data['end_y'] : null,
    'blocked' => $blockedCells
  ]
]);
?>