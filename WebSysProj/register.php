<?php require_once "backend/auth.php";
session_start();
if (isset($_SESSION['username'])) {
  if ($_SESSION['role'] == "player") {
    header("Location: player_dashboard.php");
  } else {
    header("Location: admin_dashboard.php");
  }
  exit();
}
$auth = new authenticate();
$success = false;
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["acctid"];
  // continue by xXton618Xx
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Log In or Register</title>
  </head>
  <body class="regBody">
    <div class="regsField">
      <div class="regCenter">
        <h2 class="header">Create your Account!</h2>
        <h4 class="header">Begin Your Tour in a Minute</h4>
        <div class="regFormContent">
          <form method="post">
            <div class="inputField">
              <div class="regLabel">
                <label for="acctid">Account ID</label>
              </div>
              <div class="regInput">
                <input type="text" class="singLineField" name="acctid" id="acctid" readonly>
              </div>
            </div>
            <div class="nameField">
              <div class="firstname">
                <div class="regLabel">
                  <label for="fname">First Name</label>
                </div>
                <div class="regInput">
                  <input type="text" name="fname" required>
                </div>
              </div>
              <div class="lastname">
                <div class="regLabel">
                  <label for="sname">Surname</label>
                </div>
                <div class="regInput">
                  <input type="text" name="sname" required>
                </div>
              </div>
            </div>
            <div class="inputField">
              <div class="regLabel">
                <label for="email">Email Address</label>
              </div>
              <div class="regInput">
                <input type="text" class="singLineField" name="email"  required>
              </div>
            </div>
            <div class="nameField">
              <div class="firstname">
                <div class="regLabel">
                  <label for="usrnm">Username</label>
                </div>
                <div class="regInput">
                  <input type="text" name="usrnm" required>
                </div>
              </div>
              <div class="lastname">
                <div class="regLabel">
                  <label for="dob">Date of Birth</label>
                </div>
                <div class="regInput">
                  <input type="date" name="dob" required>
                </div>
              </div>
            </div>
            <div class="nameField">
              <div class="firstname">
                <div class="regLabel">
                  <label for="ipass">Set Password</label>
                </div>
                <div class="regInput">
                  <input type="password" id="ipass" required>
                </div>
              </div>
              <div class="lastname">
                <div class="regLabel">
                  <label for="cpass">Confirm Password</label>
                </div>
                <div class="regInput">
                  <input type="password" name="cpass" id="cpass" required>
                </div>
              </div>
            </div>
            <div class="isAdmin">
              <input type="checkbox" name="isAdmin" id="isAdmin" value="admin">
              <label for="isAdmin">Register as Administrator</label>
            </div>
            <div class="submit">
              <button type="submit">Register</button>
            </div>
          </form>
        </div>
        <div class=anchor>
          Have an Account? <a href="index.php">Sign In</a>
        </div>
      </div>
    </div>
    <div class="regInterface">
      <div class="bgHeader">
        <div class="icon">♞</div>
        <div class="headName">Tour de Knight</div>
      </div>
      <div class="titleContent">
        <div>
          <h1>Join thousands of knights on the board</h1>
          <p class=subheader>Track your tours, design custom levels, and compete with the players worldwide</p>
        </div>
      </div>
    </div>
    <script src="script.js"></script>
  </body>
</html>
