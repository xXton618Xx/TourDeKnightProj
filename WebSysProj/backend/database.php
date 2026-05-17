<?php
class database {
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $name = "knights_tour";
  private $conn;
  public function connect() {
    $this->conn = new mysqli(
      $this->host,
      $this->user,
      $this->pass,
      $this->name
    );
    if ($this->conn->connect_error) {
      die("Connection Failed" . $this->conn->connect_error);
    }
    return $this->conn;
  }
}
?>