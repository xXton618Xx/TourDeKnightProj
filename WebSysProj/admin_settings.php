<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour de Knight - Admin Settings</title>
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
            <div class="linkRef" onclick="window.location.href='admin_dashboard.php'">
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
            <div class="linkRef" style="background-color: rgba(255, 255, 255, 0.3);" onclick="window.location.href='admin_settings.php'">
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

        <div class="dashViewport">
            <h1 style="margin: 0 0 10px 0; font-size: 2.2em;">System Settings</h1>
            <p style="margin: 0 0 30px 0; color: #666;">Global Configuration for the platform.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                <div style="border: 1px solid #ddd; border-radius: 16px; padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1.1em;">System theme</h3>
                    <p style="margin: 0 0 15px 0; color: #666; font-size: 0.9em;">Default appearance for all users.</p>
                    <select style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #bba9d1; background-color: #fffbeb; cursor: pointer; font-weight: 500;">
                        <option>Follow system</option>
                        <option>Light</option>
                        <option>Dark</option>
                    </select>
                </div>

                <div style="border: 1px solid #ddd; border-radius: 16px; padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1.1em;">Account options</h3>
                    <p style="margin: 0 0 15px 0; color: #666; font-size: 0.9em;">User registration controls.</p>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 0.95em;">Allow new registrations</label>
                            <input type="checkbox" style="width: 40px; height: 24px; cursor: pointer; accent-color: rgb(105, 0, 153);">
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 0.95em;">Require email verification</label>
                            <input type="checkbox" style="width: 40px; height: 24px; cursor: pointer; accent-color: rgb(105, 0, 153);">
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 0.95em;">Allow account deletion</label>
                            <input type="checkbox" style="width: 40px; height: 24px; cursor: pointer; accent-color: rgb(105, 0, 153);">
                        </div>
                    </div>
                </div>

                <div style="border: 1px solid #ddd; border-radius: 16px; padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1.1em;">Board verifier algorithm</h3>
                    <p style="margin: 0 0 15px 0; color: #666; font-size: 0.9em;">Strategy used to validate tours.</p>
                    <select style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #bba9d1; background-color: #fffbeb; cursor: pointer; font-weight: 500; margin-bottom: 15px;">
                        <option>Warnsdorff's heuristic</option>
                        <option>Brute Force</option>
                        <option>Backtracking</option>
                    </select>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label style="font-size: 0.95em;">Strict mode</label>
                        <input type="checkbox" style="width: 40px; height: 24px; cursor: pointer; accent-color: rgb(105, 0, 153);">
                    </div>
                </div>

                <div style="border: 1px solid #ddd; border-radius: 16px; padding: 20px;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1.1em;">Mini-report generator</h3>
                    <p style="margin: 0 0 15px 0; color: #666; font-size: 0.9em;">Export usage and audit reports.</p>
                    <select style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #bba9d1; background-color: #fffbeb; cursor: pointer; font-weight: 500; margin-bottom: 15px;">
                        <option>Weekly</option>
                        <option>Daily</option>
                        <option>Monthly</option>
                        <option>Quarterly</option>
                    </select>
                    <button style="width: 100%; padding: 12px; background-color: rgb(105, 0, 153); color: #fffbeb; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 1em;">Generate report</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
