const editorState = {
  width: 8,
  height: 8,
  difficulty: 'Easy',
  blockedCells: new Set(), // stores strings like "x,y"
  startPos: null,          // {x, y}
  endPos: null,            // {x, y}
  currentTool: 'block'
};

const boardGrid = document.getElementById('board-grid');

function renderBoard() {
  boardGrid.innerHTML = '';
  // Dynamically set CSS grid columns
  boardGrid.style.gridTemplateColumns = `repeat(${editorState.width}, 50px)`;

  for (let y = 0; y < editorState.height; y++) {
    for (let x = 0; x < editorState.width; x++) {
      const cell = document.createElement('div');
      cell.classList.add('cell');
      // Checkerboard pattern
      if ((x + y) % 2 !== 0) cell.classList.add('dark');
      const coordStr = `${x},${y}`;
      // Apply states
      if (editorState.blockedCells.has(coordStr)) {
        cell.classList.add('blocked');
      } else if (editorState.startPos && editorState.startPos.x === x && editorState.startPos.y === y) {
        cell.classList.add('start');
        cell.innerText = 'S';
      } else if (editorState.endPos && editorState.endPos.x === x && editorState.endPos.y === y) {
        cell.classList.add('end');
        cell.innerText = 'E';
      }
      // Handle Click
      cell.addEventListener('mousedown', () => applyTool(x, y));
      // Optional: allow drag-to-draw for blocking cells
      cell.addEventListener('mouseenter', (e) => {
        if (e.buttons === 1) applyTool(x, y); 
      });
      boardGrid.appendChild(cell);
    }
  }
}

function applyTool(x, y) {
  const coordStr = `${x},${y}`;

  if (editorState.currentTool === 'block') {
    if (editorState.difficulty === 'Easy' || editorState.difficulty === 'Average') return; // Enforce rules
    editorState.blockedCells.add(coordStr);
    // Clear start/end if they were on this cell
    if (editorState.startPos?.x === x && editorState.startPos?.y === y) editorState.startPos = null;
    if (editorState.endPos?.x === x && editorState.endPos?.y === y) editorState.endPos = null;
  } 
  else if (editorState.currentTool === 'erase') {
    editorState.blockedCells.delete(coordStr);
    if (editorState.startPos?.x === x && editorState.startPos?.y === y) editorState.startPos = null;
    if (editorState.endPos?.x === x && editorState.endPos?.y === y) editorState.endPos = null;
  }
  else if (editorState.currentTool === 'start') {
    editorState.blockedCells.delete(coordStr); // Start can't be blocked
    editorState.startPos = {x, y};
    // Ensure start and end aren't the same
    if (editorState.endPos?.x === x && editorState.endPos?.y === y) editorState.endPos = null;
  }
  else if (editorState.currentTool === 'end') {
    editorState.blockedCells.delete(coordStr); // End can't be blocked
    editorState.endPos = {x, y};
    // Ensure start and end aren't the same
    if (editorState.startPos?.x === x && editorState.startPos?.y === y) editorState.startPos = null;
  }
  renderBoard();
}

// --- Event Listeners ---

document.getElementById('btn-generate').addEventListener('click', () => {
  editorState.width = parseInt(document.getElementById('board-width').value);
  editorState.height = parseInt(document.getElementById('board-height').value);
  // Clear board on resize
  editorState.blockedCells.clear();
  editorState.startPos = null;
  editorState.endPos = null;
  renderBoard();
});

document.getElementById('board-difficulty').addEventListener('change', (e) => {
  editorState.difficulty = e.target.value;
  const advTools = document.getElementById('advanced-tools');
  // UI logic for tools
  if (editorState.difficulty === 'Advanced') {
    advTools.style.display = 'block';
  } else {
    advTools.style.display = 'none';
    editorState.startPos = null;
    editorState.endPos = null;
    // If they select Easy/Average, clear blocks
    if (editorState.difficulty !== 'Hard') {
      editorState.blockedCells.clear();
    }
    // reset tool to erase if they were on an invalid tool
    document.querySelector('input[value="erase"]').click(); 
  }
  renderBoard();
});
// Update selected tool
document.querySelectorAll('input[name="tool"]').forEach(radio => {
  radio.addEventListener('change', (e) => {
    editorState.currentTool = e.target.value;
  });
});

// Save Payload generation
document.getElementById('btn-save').addEventListener('click', () => {
  if (editorState.difficulty === 'Hard') {
    if (editorState.blockedCells.size < 2 || editorState.blockedCells.size > 3) {
      alert("Hard difficulty must have exactly 2 or 3 blocked cells.");
      return; // Stops the save process
    }
  } 
  else if (editorState.difficulty === 'Advanced') {
    // Enforcing: 4+ blocks AND Start/End positions
    if (editorState.blockedCells.size < 4) {
      alert("Advanced difficulty requires 4 or more blocked cells.");
      return; 
    }
    if (!editorState.startPos || !editorState.endPos) {
      alert("Advanced difficulty requires both a Start (S) and End (E) position.");
      return;
    }
  }
  const payload = {
    width: editorState.width,
    height: editorState.height,
    difficulty: editorState.difficulty,
    startPos: editorState.startPos,
    endPos: editorState.endPos,
    blockedCells: Array.from(editorState.blockedCells).map(coord => {
        const [x, y] = coord.split(',');
        return { x: parseInt(x), y: parseInt(y) };
    })
  };
  // Here we will add the fetch() API call to your PHP endpoint later
  const saveBtn = document.getElementById('btn-save');
  saveBtn.disabled = true;
  saveBtn.innerText = 'Saving...';

  // IMPORTANT: Update the path to match your folder structure. 
  // If the HTML file running this script is in the root folder, use './backend/save_level.php'
  // If the HTML file is inside a /pages folder, use '../backend/save_level.php'
  fetch('backend/save_level.php', { 
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      alert('Success: ' + data.message);
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Fetch error:', error);
    alert('A network error occurred while saving.');
  })
  .finally(() => {
    saveBtn.disabled = false;
    saveBtn.innerText = 'Save Level';
  });
});
// Initial Render
renderBoard();

