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
    $stmt = $this->conn->prepare("SELECT username, email_addr, password FROM user_information where username=? OR email_addr=?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
      return ["success" => false, "message" => "Email or username does not exist"];
    } else {
      $user = $res->fetch_assoc() {
        if (password_verify($pass, $user["password"])) {
          session_regenerate_id(true);
          $_SESSION["username"] = $user["username"];
          $_SESSION["role"] = $user["role"];
          return ["success" => true, "message" => "200"];
        } else {
          return ["success" => false, "message" => "Incorrect Password, try again"].
        }
      }
    }
  }

  #public function what function
}
?>