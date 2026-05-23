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
$auth = new authenticate();
$recentGames = $auth->getRecentGames($_SESSION['user_id']);
$savedGames = $auth->getSavedGames($_SESSION['user_id']);
$count = $auth->playCounts($_SESSION['user_id']);
$wCount = $auth->countWins($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tour de Knight</title>
  </head>
  <body class=pDashBody>
    <div class="overlayHide" id="gameOverlay">
      <div class="modalContent">
        <span id="close-overlay" class="close-btn">&times;</span>
        <h3>Select Level</h3>
        <form id="form-start-game">
          <div class="form-group">
            <label for="select-difficulty">Difficulty</label>
            <select name="difficulty" id="select-difficulty">
              <option value="Easy">Easy</option>
              <option value="Average">Average</option>
              <option value="Hard">Hard</option>
              <option value="Advanced">Advanced</option>
            </select>
          </div>
          <div class="form-group">
            <label for="select level">Select Level</label>
            <select name="select-level" id="select-level">
              <option value="">Select A difficulty first</option>
            </select>
          </div>
          <button type="submit" id="btn-start-play">Play</button>
        </form>
      </div>
    </div>
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
        <div class="headerCard">
          <div class="welcomeTitle">
            Welcome back, <?= $_SESSION['username']; ?>
          </div>
          <div class="welcomeSubtitle">
            Pick up where you left off, or start a new tour
          </div>
          <div class="newGameDiv">
            <div class="newGameButton" id="newGameButton">+ New Game</div>
          </div>
        </div>
        <div class="tripleCards">
          <div class="totalPlays">
            <div class="cardTitle">Total Plays</div>
            <div class="cardCount"><?= $count; ?></div>
          </div>
          <div class="winsCard">
            <div class="cardTitle">Total Wins</div>
            <div class="cardCount"><?= $wCount; ?></div>
          </div>
          <div class="totalStreak">
            <div class="cardTitle">Streak</div>
            <div class="cardCount">0</div>
          </div>
        </div>
        <div class="playHistory">
          <div class="recentPlaythru">
            <div class="recentHeader">Recent Playthrhoughs</div>
            <?php if (empty($recentGames)): ?>
              <div class="history-item">No recent games played.</div>
            <?php else: ?>
              <?php foreach ($recentGames as $game): ?>
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
            <div class="recentHeader">Saved Games</div>
            <?php if (empty($savedGames)): ?>
              <div class="saved-item">No saved games.</div>
            <?php else: ?>
              <?php foreach ($savedGames as $saved): ?>
                <div class="saved-item">
                  <div class="saved-diff"><?= htmlspecialchars($saved['difficulty']) ?> Level</div>
                  <div class="saved-moves">Moves: <?= $saved['total_moves'] ?></div>
                  <div class="saved-date">Saved: <?= $saved['date_saved'] ?></div>
                  <button class="resume-btn" onclick="window.location.href='playing_area.php?session_id=<?= $saved['session_id'] ?>'">
                    Resume Game
                  </button>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <script src="scripts/test.js"></script>
  </body>
</html>