let btnNewGame = document.getElementById('newGameButton');
let overlay = document.getElementById('gameOverlay');
let closeBtn = document.getElementById('close-overlay');
btnNewGame.addEventListener('click', () => {
  overlay.classList.remove('overlayHide');
});
// Close Overlay via 'X'
closeBtn.addEventListener('click', () => {
  overlay.classList.add('overlayHide');
});
// Close Overlay by clicking the dark background
overlay.addEventListener('click', (event) => {
  // If the actual clicked element is the overlay background, close it.
  // This prevents closing if they click inside the white modal box.
  if (event.target === overlay) {
      overlay.classList.add('overlayHide');
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const btnNewGame = document.getElementById('newGameButton');
  const overlay = document.getElementById('gameOverlay');
  const closeBtn = document.getElementById('close-overlay');
  const difficultySelect = document.getElementById('select-difficulty');
  const levelSelect = document.getElementById('select-level');
  const formStart = document.getElementById('form-start-game');

  // Toggle Overlay
  btnNewGame.addEventListener('click', () => overlay.classList.remove('overlayHide'));
  closeBtn.addEventListener('click', () => overlay.classList.add('overlayHide'));

  // Fetch levels when difficulty changes
  function fetchLevels(difficulty) {
    fetch(`backend/get_levels.php?difficulty=${difficulty}`)
      .then(response => response.json())
      .then(data => {
        levelSelect.innerHTML = ''; // Clear current options
        if (data.status === 'success' && data.levels.length > 0) {
          levelSelect.disabled = false;
          data.levels.forEach(level => {
            const option = document.createElement('option');
            option.value = level;
            option.textContent = level.replace('lvl_', 'Level ');
            levelSelect.appendChild(option);
          });
        } else {
          levelSelect.disabled = true;
          levelSelect.innerHTML = '<option value="">No levels available</option>';
        }
      })
      .catch(err => console.error("Error fetching levels:", err));
  }

  // Initial fetch on load
  fetchLevels(difficultySelect.value);
  // Fetch on change
  difficultySelect.addEventListener('change', (e) => fetchLevels(e.target.value));
  // Handle Form Submit
  formStart.addEventListener('submit', (e) => {
    e.preventDefault();
    const selectedLevel = levelSelect.value;
    
    if (!selectedLevel) return;

    const btn = document.getElementById('btn-start-play');
    btn.innerText = "Loading...";
    btn.disabled = true;

    fetch('backend/start_game.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ level_id: selectedLevel })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        // Redirect using the new session_id, NOT the level_id
        window.location.href = `playing_area.php?session_id=${data.session_id}`;
      } else {
        alert(data.message);
        btn.innerText = "Play";
        btn.disabled = false;
      }
    })
    .catch(err => {
      console.error("Session error:", err);
      alert("Failed to start game.");
      btn.innerText = "Play";
      btn.disabled = false;
    });
  });

});