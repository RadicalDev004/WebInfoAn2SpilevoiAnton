<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }

        header {
            background: #333;
            color: white;
            padding: 2em;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1em;
        }

        .header-button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: white;
            color: #333;
            border: 1px solid #ccc;
            cursor: pointer;
            font-weight: bold;
        }

        .settings-container {
            max-width: 800px;
            margin: 2em auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5em;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .settings-container h2 {
            margin-top: 0;
            margin-bottom: 1em;
        }

        .settings-item {
            margin: 1em 0;
            font-size: 1.2em;
        }

        .action-btn {
            margin-top: 1em;
            padding: 0.5em 1em;
            background-color: #0073e6;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<header>
    <div class="header-left">
        <button type="button" onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/index'" class="header-button">←</button>
        <h1 style="margin: 0;">Setări</h1>
    </div>
</header>

<body>
    <div class="settings-container">
        <h2>{{title}}</h2>
        <div class="settings-item"><strong>Nume utilizator:</strong> {{username}}</div>
        <div class="settings-item">📚 Cărți începute: {{startedBooks}}</div>
        <div class="settings-item">✅ Cărți terminate: {{finishedBooks}}</div>
        <div class="settings-item">💬 Comentarii: {{commentsCount}}</div>
        <div class="settings-item">⭐ Favorite: {{favoritesCount}}</div>


        <a href="/WebInfoAn2SpilevoiAnton/auth/logout"><button class="action-btn">Logout</button></a>
        <a href="/WebInfoAn2SpilevoiAnton/auth/logout"><button class="action-btn">Export Date</button></a>
    </div>
</body>
</html>
