<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f172a, #1e3a5f);
            padding: 0;
            margin: 0;
            color: #e0e0e0;
        }

        header {
            background: #1e3a5f;
            color: white;
            padding: 1.5em 2em;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
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
            color: #1e3a5f;
            border: 1px solid #ccc;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .header-button:hover {
            background-color: #3b82f6;
            color: white;
            transform: scale(1.05);
        }

        .settings-container {
            max-width: 800px;
            margin: 3em auto;
            background: #1c1c1c;
            border: 1px solid #3b82f6;
            border-radius: 12px;
            padding: 2em;
            box-shadow: 0 0 20px rgba(30, 58, 95, 0.4);
            text-align: center;
        }

        .settings-container h2 {
            margin-top: 0;
            margin-bottom: 1em;
            color: #90cdf4;
        }

        .settings-item {
            margin: 1em 0;
            font-size: 1.2em;
        }

        .action-btn {
            margin-top: 1.2em;
            padding: 0.6em 1.2em;
            background-color: #2563eb;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #3b82f6;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <button type="button" onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/index'" class="header-button">←</button>
            <h1 style="margin: 0;">Setări</h1>
        </div>
    </header>

    <div class="settings-container">
        <h2>{{title}}</h2>
        <div class="settings-item"><strong>Nume utilizator:</strong> {{username}}</div>
        <div class="settings-item">📚 Cărți începute: {{startedBooks}}</div>
        <div class="settings-item">✅ Cărți terminate: {{finishedBooks}}</div>
        <div class="settings-item">💬 Recenzii: {{commentsCount}}</div>
        <div class="settings-item">⭐ Favorite: {{favoritesCount}}</div>

        <a href="/WebInfoAn2SpilevoiAnton/auth/logout"><button class="action-btn">Logout</button></a>
        <a href="/WebInfoAn2SpilevoiAnton/settings/export"><button class="action-btn">Export Date</button></a>
    </div>
</body>
</html>
