<?php require_once "backend/auth.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
if ($_SESSION['role'] == "admin") {
  header("Location: admin_dashboard_c.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tour de Knight - Play</title>
  </head>
  <body class="pDashBody">
    <div class="leftSidebar">
      <div class="dashbgHeader">
        <div class="dashIcon">♞</div>
        <div>
          <div class="dashheadName">Tour de Knight</div>
          <div>Player</div>
        </div>
      </div>
      <div class="linkList">
        <div class="linkRef" onclick="window.location.href='player_dashboard.php'">
          Home
        </div>
        <div class="linkRef">
          Discussions
        </div>
        <div class="linkRef">
          Settings
        </div>
      </div>
      <div class="dashbgFooter">
        <div class="dashIcon">♞</div>
        <div>
          <a class="dashFootName" href="backend/logout.php">
            Log Out
          </a>
        </div>
      </div>
    </div>
    <div class="mainViewport">
      <div class="searchHeader">
        <div class="i-collapse">&#9776</div>
        <div class="searchbar">
          <form method="post">
            <input type="text" name="search" class="search" id="search" placeholder="Search Here">
          </form>
        </div>
        <div class="capital">KD</div>
      </div>
      <div class="dashViewport">
        <div class="welcomeTitle playTitle">
          Tour Map
        </div>
        <div class="welcomeSubtitle playSubtitle">
          Cover all of the squares given on the board, visit all of them exactly once.
        </div>
        <div class="playingInterface">
          <div class="chessBoard" id="chessBoard">

          </div>
          <div class="playStatus">
            <div class="statusSubtitle">Status</div>
            <div class="statusTable">
              <table class="statusTbl">
                <tr>
                  <td class="tblclass">Position</td>
                  <td class="tbldata">4,3</td>
                </tr>
                <tr>
                  <td class="tblclass">Moves</td>
                  <td class="tbldata">0/72</td>
                </tr>
                <tr>
                  <td class="tblclass">Difficulty</td>
                  <td class="tbldata">Default</td>
                </tr>
              </table>
            </div>
            <div class="statusSubtitle">Options</div>
            <button id="btn-save-game" class="primary-btn">Save Game</button>
          <button id="btn-abandon-game" class="danger-btn" style="background: red; color: white;">Abandon</button>
          </div>
        </div>
      </div>
    </div>
    <script src="scripts/gameplay.js"></script>
  </body>
</html>