<?php require_once "backend/auth.php";
session_start();
if (isset($_SESSION['username'])) {
  if ($_SESSION['role'] == "player") {
    header("Location: player_dashboard.php");
  } else {
    header("Location: admin_dashboard_c.php");
  }
  exit();
}
$auth = new authenticate();
$message = "";
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isAdmin = isset($_POST['isAdmin']) ? 'admin' : 'player';
  $res = $auth->register_user(
    $_POST["acctid"], $_POST["fname"], $_POST["sname"], $_POST["email"],
    $_POST["usrnm"], $_POST["dob"], $_POST["cpass"], $isAdmin
  );
  $message = $res['message'];
  $success = $res['success'];
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
                  <input type="text" name="fname" id="fname" required>
                </div>
              </div>
              <div class="lastname">
                <div class="regLabel">
                  <label for="sname">Surname</label>
                </div>
                <div class="regInput">
                  <input type="text" name="sname" id="sname" required>
                </div>
              </div>
            </div>
            <div class="validName" id="validName"></div>
            <div class="inputField">
              <div class="regLabel">
                <label for="email">Email Address</label>
              </div>
              <div class="regInput">
                <input type="email" class="singLineField" name="email" placeholder="example@mail.com" required>
              </div>
            </div>
            <div class="nameField">
              <div class="firstname">
                <div class="regLabel">
                  <label for="usrnm">Username</label>
                </div>
                <div class="regInput">
                  <input type="text" name="usrnm" id="usrnm" required>
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
            <div class="validUsrnm" id="validUsrnm"></div>
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
            <div class="validatePass" id="validatePass">
              <ul>
                <li id="isEight">Must contain at least 8 characters</li>
                <li id="hasNums">Must contain 0-9</li>
                <li id="hasChars">Must contain special characters</li>
              </ul>
            </div>
            <div class="isAdmin">
              <input type="checkbox" name="isAdmin" id="isAdmin" value="admin">
              <label for="isAdmin">Register as Administrator</label>
            </div>
            <div class="submit">
              <button type="submit" id="submit" disabled>Register</button>
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
    <div class="modalWindow" id="modalWindow" style="display: <?= $success ? 'flex' : 'none'; ?>;">
      <div class="modalContent">
        <p><?= $message; ?></p> 
        <p>Use your email or username to log in</p>
        <div class="login">
          <a href="index.php" id="loginRedir">Log In</a>
        </div>
      </div>
    </div>
    <script src="scripts/validate.js"></script>
    <script>
      // script to generate account ID, sensitive to 
      // row count and what is the last row.
      function generateAccountId() {
        let init = "abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
        let output = ""
        for (let i = 0; i < 15; i++) {
          let randNum = Math.floor(Math.random() * init.length);
          output += init.charAt(randNum)
        }
        return output
      }
      let acctid = document.getElementById("acctid")
      acctid.value = generateAccountId()
    </script>
  </body>
</html>