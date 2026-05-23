<?php
session_start();
require_once 'database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$difficulty = $_GET['difficulty'] ?? 'Easy';

$database = new database();
$conn = $database->connect();

$stmt = $conn->prepare("SELECT level_id FROM levels_list WHERE difficulty = ? AND is_published = 1");
$stmt->bind_param("s", $difficulty);
$stmt->execute();
$result = $stmt->get_result();

$levels = [];
while ($row = $result->fetch_assoc()) {
    $levels[] = $row['level_id'];
}
$stmt->close();
$conn->close();

echo json_encode(['status' => 'success', 'levels' => $levels]);
?>