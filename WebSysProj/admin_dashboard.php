<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour de Knight - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="pDashBody">
    <div class="leftSidebar">
        <div class="dashbgHeader" style="padding: 15px 10px;">
            <span class="dashIcon">♞</span>
            <div style="margin-left: 10px;">
                <div class="dashheadName">Tour de Knight</div>
                <div style="font-size: 0.85em; color: #fffbeb;">Admin</div>
            </div>
        </div>

        <div class="linkList">
            <div class="linkRef" style="background-color: rgba(255, 255, 255, 0.3);" onclick="window.location.href='admin_dashboard.php'">
                <span>🏠</span>
                <span style="margin-left: 10px;">Home</span>
            </div>
            <div class="linkRef" onclick="window.location.href='level_editor.php'">
                <span>🎮</span>
                <span style="margin-left: 10px;">Create Level</span>
            </div>
            <div class="linkRef">
                <span>💬</span>
                <span style="margin-left: 10px;">Discussion</span>
            </div>
            <div class="linkRef" onclick="window.location.href='admin_settings.php'">
                <span>⚙️</span>
                <span style="margin-left: 10px;">Settings</span>
            </div>
        </div>

        <div class="dashbgFooter" style="padding: 15px 10px; justify-content: space-between;">
            <div>
                <div class="dashFootName">Log out</div>
            </div>
        </div>
    </div>

    <div class="mainViewport">
        <div class="searchHeader">
            <span class="i-collapse">☰</span>
            <div class="searchbar">
                <input type="text" class="search" placeholder="Search...">
            </div>
            <div style="margin-left: auto; margin-right: 20px; display: flex; gap: 15px; align-items: center;">
                <span style="font-size: 1.5em; cursor: pointer;">📋</span>
                <div class="capital" style="cursor: pointer;">KD</div>
            </div>
        </div>

        <div class="dashViewport" style="overflow-y: auto;">
            <div style="background: linear-gradient(135deg, rgb(105, 0, 153) 0%, rgb(140, 0, 190) 100%); border-radius: 20px; padding: 30px; margin-bottom: 25px; color: #fffbeb;">
                <div style="font-size: 0.85em; font-weight: 600; letter-spacing: 1px; margin-bottom: 10px;">ADMIN</div>
                <h1 style="margin: 0 0 8px 0; font-size: 2.5em; font-weight: bold;">Command Center</h1>
                <p style="margin: 0; color: rgba(255, 251, 235, 0.9); font-size: 1em;">Monitor system activity, audits and player engagement.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
                <div style="border: 2px solid rgb(105, 0, 153); border-radius: 16px; padding: 25px; background: #fffbeb;">
                    <h3 style="margin: 0 0 15px 0; font-size: 1em; color: #666; font-weight: 500;">Total Plays</h3>
                    <div style="font-size: 2.8em; font-weight: bold; margin-bottom: 10px;">13,542</div>
                    <div style="color: rgb(76, 175, 80); font-size: 0.95em; font-weight: 500;">+8.5% this week</div>
                </div>

                <div style="border: 2px solid rgb(255, 193, 7); border-radius: 16px; padding: 25px; background: #fffbeb;">
                    <h3 style="margin: 0 0 15px 0; font-size: 1em; color: #666; font-weight: 500;">Total accounts</h3>
                    <div style="font-size: 2.8em; font-weight: bold; margin-bottom: 10px;">2,834</div>
                    <div style="color: rgb(76, 175, 80); font-size: 0.95em; font-weight: 500;">+3.5% this week</div>
                </div>

                <div style="border: 2px solid rgb(76, 175, 80); border-radius: 16px; padding: 25px; background: #fffbeb;">
                    <h3 style="margin: 0 0 15px 0; font-size: 1em; color: #666; font-weight: 500;">Active Today</h3>
                    <div style="font-size: 2.8em; font-weight: bold; margin-bottom: 10px;">324</div>
                    <div style="color: rgb(76, 175, 80); font-size: 0.95em; font-weight: 500;">+1.8% this week</div>
                </div>
            </div>

            <div style="border: 1px solid #ddd; border-radius: 16px; padding: 25px; background: #fffbeb; margin-bottom: 25px;">
                <h3 style="margin: 0 0 20px 0; font-size: 1.15em; font-weight: 600;">Plays this week</h3>
                <svg viewBox="0 0 700 200" style="width: 100%; height: 250px;">
                    <line x1="50" y1="30" x2="680" y2="30" stroke="#e0e0e0" stroke-width="1"/>
                    <line x1="50" y1="70" x2="680" y2="70" stroke="#e0e0e0" stroke-width="1"/>
                    <line x1="50" y1="110" x2="680" y2="110" stroke="#e0e0e0" stroke-width="1"/>
                    <line x1="50" y1="150" x2="680" y2="150" stroke="#e0e0e0" stroke-width="1"/>
                    
                    <text x="20" y="35" font-size="12" fill="#666">1800</text>
                    <text x="20" y="75" font-size="12" fill="#666">1350</text>
                    <text x="20" y="115" font-size="12" fill="#666">900</text>
                    <text x="20" y="155" font-size="12" fill="#666">450</text>
                    <text x="25" y="185" font-size="12" fill="#666">0</text>
                    
                    <polyline points="80,120 140,80 200,100 260,60 320,85 380,55 440,75 500,35 560,65 620,45 680,30" 
                              fill="none" stroke="rgb(105, 0, 153)" stroke-width="2.5" stroke-linejoin="round"/>
                    
                    <text x="75" y="175" font-size="12" fill="#666" text-anchor="middle">mon</text>
                    <text x="135" y="175" font-size="12" fill="#666" text-anchor="middle">tue</text>
                    <text x="195" y="175" font-size="12" fill="#666" text-anchor="middle">wed</text>
                    <text x="255" y="175" font-size="12" fill="#666" text-anchor="middle">thursday</text>
                    <text x="315" y="175" font-size="12" fill="#666" text-anchor="middle">friday</text>
                    <text x="375" y="175" font-size="12" fill="#666" text-anchor="middle">saturday</text>
                    <text x="435" y="175" font-size="12" fill="#666" text-anchor="middle">sunday</text>
                </svg>
            </div>

            <div style="border: 1px solid #ddd; border-radius: 16px; padding: 25px; background: #fffbeb; min-height: 180px;">
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
