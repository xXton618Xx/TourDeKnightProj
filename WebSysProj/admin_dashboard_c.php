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
$auth = new authenticate();
$count = $auth->accountPopulation();
$levels = $auth->levelsCount();
$allPlays = $auth->allGames();
$allGames = $auth->getAllGames();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_style.css">
    <title>Tour de Knight - Admin</title>
  </head>
  <body class=pDashBody>
    <div class="leftSidebar">
      <div class="dashbgHeader">
        <div class="dashIcon">♞</div>
        <div>
          <div class="dashheadName">Tour de Knight</div>
          <div>Player</div>
        </div>
      </div>
      <div class="linkList" >
        <div class="linkRef">Home</div>
        <div class="linkRef" onclick="window.location.href='level_editor.php'">Level Editor</div>
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
        <div class="headerCard">
          <div class="welcomeTitle">
            Command Center 
          </div>
          <div class="welcomeSubtitle">
            Manage Games, Create levels, and Monitor status
          </div>
          <div class="welcomeSubtitle">
            Administrator: <?= $_SESSION['username']; ?>
          </div>
        </div>
        <div class="tripleCards">
          <div class="totalPlays">
            <div class="cardTitle">Total Games</div>
            <div class="cardCount"><?= $allPlays; ?></div>
          </div>
          <div class="winsCard">
            <div class="cardTitle">Accounts created</div>
            <div class="cardCount"><?= $count; ?></div>
          </div>
          <div class="totalStreak">
            <div class="cardTitle">Levels Count</div>
            <div class="cardCount"><?= $levels; ?></div>
          </div>
        </div>
        <div class="playHistory">
          <div class="recentPlaythru">
            <div class="recentHeader">Recent Playthroughs</div>
            <?php if (empty($allGames)): ?>
              <div class="history-item">No recent games played.</div>
            <?php else: ?>
              <?php foreach ($allGames as $game): ?>
                <div class="history-item">
                  <div class="history-diff"><?= htmlspecialchars($game['difficulty']) ?> Level</div>
                  <div class="history-moves">Moves: <?= $game['total_moves'] ?></div>
                  <div class="history-status <?= $game['status'] ?>"><?= strtoupper($game['status']) ?></div>
                  <div class="history-date"><?= $game['date_played'] ?></div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <div class="savedGames">
            <div class="recentHeader">Playthrough Summary</div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>