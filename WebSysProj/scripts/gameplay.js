document.addEventListener('DOMContentLoaded', () => {
    // Extract level_id from URL: playing_area.php?level_id=lvl_xxxx
    const urlParams = new URLSearchParams(window.location.search);
    const sessionId = urlParams.get('session_id');
    if (!sessionId) {
      alert("Invalid game session!");
      window.location.href = 'player_dashboard.php';
      return;
    }
    const boardContainer = document.getElementById('chessBoard');
    // UI Elements mapped to your HTML
    const statusPos = document.querySelector('.statusTbl tr:nth-child(1) .tbldata');
    const statusMoves = document.querySelector('.statusTbl tr:nth-child(2) .tbldata');
    const statusDiff = document.querySelector('.statusTbl tr:nth-child(3) .tbldata');
    let gameState = {
      width: 0, height: 0, difficulty: 'Easy',
      knightX: 0, knightY: 0,
      movesCount: 0, totalTarget: 0,
      visited: new Set(),
      blocked: new Set(),
      endPos: null
    };
    // Knight Moves (L-Shapes)
    const knightOffsets = [
      [1, 2], [2, 1], [-1, 2], [-2, 1], [1, -2], [2, -1], [-1, -2], [-2, -1]
    ];
    function fetchLevelData() {
        // 2. Fetch using session_id
    fetch(`backend/get_level_data.php?session_id=${sessionId}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'error') {
          alert(data.message);
          window.location.href = 'player_dashboard.php';
          return;
        }
        initializeGame(data.level, data.session);
      });
    }

    function initializeGame(level, session) {
      gameState.width = level.width;
      gameState.height = level.height;
      gameState.difficulty = level.difficulty;
      level.blocked.forEach(cell => gameState.blocked.add(`${cell.x},${cell.y}`));
      if (level.end_x !== null && level.end_y !== null) {
        gameState.endPos = { x: level.end_x, y: level.end_y };
      }
      gameState.totalTarget = (level.width * level.height) - gameState.blocked.size;

      // LOAD SAVED STATE OR START FRESH
      if (session.saved_state && session.saved_state.length > 0) {
        gameState.visited = new Set(session.saved_state);
        gameState.movesCount = session.saved_moves;
        
        // The Knight's current position is the LAST item in the visited array
        const lastPos = session.saved_state[session.saved_state.length - 1];
        const [lx, ly] = lastPos.split(',');
        gameState.knightX = parseInt(lx);
        gameState.knightY = parseInt(ly);
      } else {
        // Fresh Start Logic (from previous version)
        if (level.start_x !== null && level.start_y !== null) {
            gameState.knightX = level.start_x;
            gameState.knightY = level.start_y;
        } else {
          outer: for (let y = 0; y < level.height; y++) {
            for (let x = 0; x < level.width; x++) {
              if (!gameState.blocked.has(`${x},${y}`)) {
                gameState.knightX = x;
                gameState.knightY = y;
                break outer;
              }
            }
          }
        }
        gameState.visited.add(`${gameState.knightX},${gameState.knightY}`);
        gameState.movesCount = 1;
      }
      updateUI();
      renderBoard();
    }
    function syncGameState(actionType) {
      const payload = {
        session_id: sessionId,
        action: actionType, // 'save', 'abandon', 'win', 'lose'
        moves: gameState.movesCount,
        state: Array.from(gameState.visited) // Converts Set to Array
      };
      return fetch('backend/update_game.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      }).then(res => res.json());
    }
    function renderBoard() {
      boardContainer.innerHTML = '';
      boardContainer.style.display = 'grid';
      boardContainer.style.gridTemplateColumns = `repeat(${gameState.width}, 50px)`;

      const validMoves = getValidMoves(gameState.knightX, gameState.knightY);

      for (let y = 0; y < gameState.height; y++) {
        for (let x = 0; x < gameState.width; x++) {
          const cell = document.createElement('div');
          cell.style.width = '50px';
          cell.style.height = '50px';
          cell.style.display = 'flex';
          cell.style.justifyContent = 'center';
          cell.style.alignItems = 'center';
          // Checkerboard pattern
          cell.style.backgroundColor = (x + y) % 2 === 0 ? '#eee' : '#78009c';
          const coord = `${x},${y}`;
          // Render States
          if (gameState.blocked.has(coord)) {
            cell.style.backgroundColor = '#d9534f'; // Blocked
          } else if (gameState.visited.has(coord) && !(x === gameState.knightX && y === gameState.knightY)) {
            cell.style.backgroundColor = '#5cb85c'; // Visited footprint
          } else if (gameState.endPos && gameState.endPos.x === x && gameState.endPos.y === y) {
            cell.style.border = '3px solid #f0ad4e'; // Highlight required end
          }

          // Render Knight
          if (x === gameState.knightX && y === gameState.knightY) {
            const img = document.createElement('img');
            img.src = 'knight.png'; // Ensure you have this image in your root/assets
            img.style.width = '40px';
            cell.appendChild(img);
          }

          // Highlight and Enable Valid Next Moves
          if (validMoves.some(m => m.x === x && m.y === y)) {
            cell.style.cursor = 'pointer';
            cell.style.boxShadow = 'inset 0 0 10px yellow'; // Highlight
            cell.addEventListener('click', () => executeMove(x, y));
          }
          boardContainer.appendChild(cell);
        }
      }
    }
    function getValidMoves(currentX, currentY) {
      let moves = [];
      for (let [dx, dy] of knightOffsets) {
        let nx = currentX + dx;
        let ny = currentY + dy;
        let coord = `${nx},${ny}`;
        
        // Check bounds, blocked status, and visited status
        if (nx >= 0 && nx < gameState.width && ny >= 0 && ny < gameState.height) {
          if (!gameState.blocked.has(coord) && !gameState.visited.has(coord)) {
            moves.push({ x: nx, y: ny });
          }
        }
      }
      return moves;
    }

    function executeMove(targetX, targetY) {
      gameState.knightX = targetX;
      gameState.knightY = targetY;
      gameState.visited.add(`${targetX},${targetY}`);
      gameState.movesCount++;
      updateUI();
      renderBoard();
      checkWinCondition();
    }

    function updateUI() {
      statusPos.textContent = `${gameState.knightX}, ${gameState.knightY}`;
      statusMoves.textContent = `${gameState.movesCount} / ${gameState.totalTarget}`;
      statusDiff.textContent = gameState.difficulty;
    }
    function checkWinCondition() {
      if (gameState.movesCount === gameState.totalTarget) {
        let win = true;
        if (gameState.difficulty === 'Advanced' && (gameState.knightX !== gameState.endPos.x || gameState.knightY !== gameState.endPos.y)) {
          win = false;
        }
        if (win) {
            syncGameState('win').then(() => {
              alert("Tour Complete! You won!");
              window.location.href = 'player_dashboard.php';
            });
        } else {
            syncGameState('lose').then(() => {
              alert("Failure. You did not end on the designated square.");
              window.location.href = 'player_dashboard.php';
            });
        }
      } else if (getValidMoves(gameState.knightX, gameState.knightY).length === 0) {
        syncGameState('lose').then(() => {
          alert("Game Over! The Knight is trapped.");
          window.location.href = 'player_dashboard.php';
        });
      }
    }
    document.getElementById('btn-save-game')?.addEventListener('click', () => {
      const btn = document.getElementById('btn-save-game');
      btn.innerText = "Saving...";
      syncGameState('save').then(data => {
        if(data.status === 'success') {
          btn.innerText = "Saved!";
          setTimeout(() => btn.innerText = "Save Game", 2000);
        }
      });
    });

    document.getElementById('btn-abandon-game')?.addEventListener('click', () => {
      if (confirm("Are you sure you want to abandon this game? It will count as a loss.")) {
        syncGameState('abandon').then(() => {
          window.location.href = 'player_dashboard.php';
        });
      }
    });
    // Start
    fetchLevelData();
});