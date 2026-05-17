<?php require_once "database.php";
class authenticate {
  private $conn;
  public function __construct() {
    $db = new database();
    $this->conn = $db->connect();
  }

  public function register_user($id, $fname, $sname, $addr, $usr, $dob, $pwd, $role) {
    $stmt = $this->conn->prepare("INSERT INTO user_information VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $id, $fname, $sname, $addr, $usr, $dob, $pwd, $role);
    if ($stmt->execute()) {
      return ["success" => true, "message" => "User Account Created! Log in to your account"]
    }
  }
}
?>