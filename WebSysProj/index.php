<?php require_once "backend/auth.php";
session_start();
if (isset($_SESSION['username'])) {
  if ($_SESSION['role'] == "admin") {
    header("Location: admin_dashboard_c.php");
  } else {
    header("Location: player_dashboard.php");
  }
  exit();
}
$auth = new authenticate();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usrnm = trim($_POST["usrnm"]);
  $pass = $_POST["psswd"];
  $res = $auth->login($usrnm, $pass);
  if ($res["success"]) {
    // if logged in user is admin, redirect to admin_dashboard.
    if ($_SESSION['role'] === "player") {
      header("Location: player_dashboard.php");
      exit();
    } else {
      header("Location: admin_dashboard_c.php");
      exit();
    }
  } else {
    echo "<script>alert('" . $res['message'] . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Log In or Signup</title> 
  </head>
  <body class="logBody">
    <div class="logImage">
      <div class="bgHeader">
        <div class="icon">♞</div>
        <div class="headName">Tour de Knight</div>
      </div>
      <div class="titleContent">
        <div>
          <h1>Welcome Back, Grandmasters and Knights</h1>
          <p class=subheader>Pick up the tour, share strategies, and climb up the leaderboard.</p>
        </div>
      </div>
    </div>
    <div class="logField">
      <div>
        <h2 class="header">Sign In</h2>
        <h4 class=header>Enter your credentials to continue</h4>
        <div class="regFormContent">
          <form method="post">
            <div class="inputField">
              <div class="regLabel">
                <label for="usrnm">Username or Email</label>
              </div>
              <div class="regInput">
                <input type="text" class="singLineField" name="usrnm" id="usrnm" required>
              </div>
            </div>
            <div class="inputField">
              <div class="regLabel">
                <label for="psswd">Password</label>
              </div>
              <div class="regInput">
                <input type="password" class="singLineField" name="psswd" id="psswd">
              </div>
            </div>
            <div class="inputField">
              <input type="checkbox" name="cookie" id="cookie" class="cookie">
              <label for="cookie" class="label">Keep me logged in</label>
            </div>
            <div class="submit">
              <button type="submit">Log In</button>
            </div>
          </form>
        </div>
        <div class=anchor>
          New user? <a href="register.php">Create your Account here!</a>
        </div>
      </div>
    </div>
  </body>
</html>