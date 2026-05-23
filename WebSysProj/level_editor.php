<?php require_once "backend/auth.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
if ($_SESSION['role'] == "player") {
  header("Location: player_dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_style.css">
    <title>Tour de Knight - Editor</title>
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
      <div class="linkList" >
        <div class="linkRef" onclick="window.location.href='admin_dashboard_c.php'">Home</div>
        <div class="linkRef">Level Editor</div>
        <div class="linkRef">Discussions</div>
        <div class="linkRef" onclick="window.location.href='admin_settings.php'">Settings</div>
      </div>
      <div class="dashbgFooter">
        <div class="dashIcon">♞</div>
        <div>
          <a class="dashFootName" href="backend/logout.php">Log Out</a>
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
        <div class="editor-container">
          <!-- Editor Viewport (Left/Center) -->
          <div class="board-viewport">
            <div class="editor-settings">
              <label>Width: <input type="number" id="board-width" min="5" max="15" value="8"></label>
              <label>Height: <input type="number" id="board-height" min="5" max="15" value="8"></label>
              <label>Difficulty: 
                <select id="board-difficulty">
                  <option value="Easy">Easy</option>
                  <option value="Average">Average</option>
                  <option value="Hard">Hard</option>
                  <option value="Advanced">Advanced</option>
                </select>
              </label>
              <button id="btn-generate">Regenerate Board</button>
            </div>
            <div id="board-grid" class="board-grid"></div>
          </div>
          <!-- Right Sidebar / Toolbox -->
          <div class="right-toolbar">
            <h3>Toolbox</h3>
            <div class="tool-group">
              <label><input type="radio" name="tool" value="block" checked> Block Cell</label>
              <label><input type="radio" name="tool" value="erase"> Erase</label>
              <!-- These should only be visible/enabled for Advanced difficulty -->
              <div id="advanced-tools" style="display: none; margin-top: 10px;">
                <label><input type="radio" name="tool" value="start"> Set Start (S)</label>
                <label><input type="radio" name="tool" value="end"> Set End (E)</label>
              </div>
            </div>
            <div class="action-buttons">
              <button id="btn-verify">Verify Board</button>
              <button id="btn-save">Save Level</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="scripts/script.js"></script>
  </body>
</html>