<?php require_once 'database.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}
// Include your database file
class LevelManager {
    private $db;
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    public function saveLevel($data) {
        try {
            // 1. Begin Transaction
            $this->db->begin_transaction();
            $level_id = uniqid('lvl_');
            $width = (int)$data['width'];
            $height = (int)$data['height'];
            $difficulty = $data['difficulty'];
            // Handle nulls for coordinates safely
            $start_x = isset($data['startPos']['x']) ? (int)$data['startPos']['x'] : null;
            $start_y = isset($data['startPos']['y']) ? (int)$data['startPos']['y'] : null;
            $end_x = isset($data['endPos']['x']) ? (int)$data['endPos']['x'] : null;
            $end_y = isset($data['endPos']['y']) ? (int)$data['endPos']['y'] : null;
            $stmt = $this->db->prepare("
                INSERT INTO levels_list (level_id, board_width, board_height, difficulty, start_x, start_y, end_x, end_y) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("siisiiii", $level_id, $width, $height, $difficulty, $start_x, $start_y, $end_x, $end_y);
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert level data.");
            }
            $stmt->close();
            // 3. Prepare & Execute Blocked Cells Insert (if any)
            if (!empty($data['blockedCells'])) {
                $blockStmt = $this->db->prepare("
                    INSERT INTO blocked_cells (level_id, x_pos, y_pos) 
                    VALUES (?, ?, ?)
                ");
                foreach ($data['blockedCells'] as $cell) {
                    $bx = (int)$cell['x'];
                    $by = (int)$cell['y'];
                    // "sii" = string, int, int
                    $blockStmt->bind_param("sii", $level_id, $bx, $by);
                    
                    if (!$blockStmt->execute()) {
                        throw new Exception("Failed to insert blocked cell at {$bx}, {$by}");
                    }
                }
                $blockStmt->close();
            }
            // 4. Commit Transaction
            $this->db->commit();
            return ['status' => 'success', 'message' => 'Level saved successfully!', 'level_id' => $level_id];
        } catch (Exception $e) {
            // Rollback if anything fails
            $this->db->rollback();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
// === Process the Request ===
// Initialize Database
$database = new database();
$dbConnection = $database->connect();
// Get JSON Payload
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    // Instantiate the manager and save
    $levelManager = new LevelManager($dbConnection);
    $response = $levelManager->saveLevel($data);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid payload received.']);
}
// Close connection
$dbConnection->close();
?>