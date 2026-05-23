<?php require_once "database.php";
class authenticate {
  private $conn;
  public function __construct() {
    $db = new database();
    $this->conn = $db->connect();
  }

  public function register_user($id, $fname, $sname, $addr, $usr, $dob, $pwd, $role) {
    $hash = password_hash($pwd, PASSWORD_BCRYPT);
    $stmt = $this->conn->prepare("INSERT INTO user_information VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $id, $fname, $sname, $addr, $usr, $dob, $hash, $role);
    if ($stmt->execute()) {
      return ["success" => true, "message" => "User Account Created! Log in to your account."];
    } else {
      return ["success" => false, "message" => "Registration failed. Try again."];
    }
  }

  public function login($login, $pass) {
    $stmt = $this->conn->prepare("SELECT acct_id, username, email_addr, password, role FROM user_information where username=? OR email_addr=?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
      return ["success" => false, "message" => "Email or username does not exist"];
    } else {
      $user = $res->fetch_assoc();
      if (password_verify($pass, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["user_id"] = $user["acct_id"];
        return ["success" => true, "message" => "200"];
      } else {
        return ["success" => false, "message" => "Incorrect Password, try again"];
      }
    }
  }

  public function getRecentGames($acct_id) {
    $stmt = $this->conn->prepare("
      SELECT gs.session_id, gs.total_moves, gs.status, DATE_FORMAT(gs.last_played, '%M %d, %Y') as date_played, l.difficulty 
      FROM game_sessions gs 
      JOIN levels_list l ON gs.level_id = l.level_id 
      WHERE gs.acct_id = ? AND gs.status != 'in_progress' 
      ORDER BY gs.last_played DESC LIMIT 7
    ");
    $stmt->bind_param("s", $acct_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $games = [];
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
    return $games;
  }

  public function getSavedGames($acct_id) {
    $stmt = $this->conn->prepare("
      SELECT gs.session_id, gs.total_moves, DATE_FORMAT(gs.last_played, '%M %d, %Y') as date_saved, l.difficulty 
      FROM game_sessions gs 
      JOIN levels_list l ON gs.level_id = l.level_id 
      WHERE gs.acct_id = ? AND gs.status = 'in_progress' 
      ORDER BY gs.last_played DESC
    ");
    $stmt->bind_param("s", $acct_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $games = [];
    while ($row = $result->fetch_assoc()) {
      $games[] = $row;
    }
    return $games;
  }
  
  public function accountPopulation() {
    $stmt = $this->conn->query("SELECT COUNT(*) AS population FROM user_information");
    $res = $stmt->fetch_assoc();
    return $res['population'];
  }

  public function levelsCount() {
    $stmt = $this->conn->query("SELECT COUNT(*) AS levelCount FROM levels_list");
    $res = $stmt->fetch_assoc();
    return $res['levelCount'];
  }

  public function countWins($acctId) {
    $stmt = $this->conn->query("SELECT COUNT(*) AS winCount FROM game_sessions WHERE status='completed' AND acct_id='$acctId'");
    $res = $stmt->fetch_assoc();
    return $res['winCount'];
  }
  public function playCounts($acctId) {
    $stmt = $this->conn->query("SELECT COUNT(*) AS playCount FROM game_sessions where acct_id='$acctId'");
    $res = $stmt->fetch_assoc();
    return $res['playCount'];
  }

  public function allGames() {
    $stmt = $this->conn->query("SELECT COUNT(*) as totalPlay FROM game_sessions");
    $res = $stmt->fetch_assoc();
    return $res['totalPlay'];
  }

  public function getAllGames() {
    $stmt = $this->conn->query("
      SELECT gs.session_id, gs.total_moves, gs.status, DATE_FORMAT(gs.last_played, '%M %d, %Y') as date_played, l.difficulty 
      FROM game_sessions gs 
      JOIN levels_list l ON gs.level_id = l.level_id 
      WHERE gs.status != 'in_progress' 
      ORDER BY gs.last_played DESC LIMIT 7
    ");
    $games = [];
    while ($row = $stmt->fetch_assoc()) {
        $games[] = $row;
    }
    return $games;
  }
}
?>