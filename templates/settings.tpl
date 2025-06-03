<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
             position: relative;
        color: white;
        padding: 2em;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1em;
        }
        .header-title {
            margin: 0;
            font-size: 1.5em;
            font-weight: 600;
            color: #ffffff;
        }

        .header-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 6px;
            background-color: transparent;
            color: #1e3a5f;
            border: 2px solid #ffffff55;
            color: white;
            font-size: 1.2em;
            padding: 0.4em 0.6em;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .header-button:hover {
            background-color: #3b82f6;
            color: white;
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
        .back-button {
            left: 1em;
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
            <button type="button" onclick="window.location.href='/home/index'" class="header-button back-button">←</button>
            <h1 class = "header-title">Setări</h1>
    </header>

    <div class="settings-container">
        <h2>{{title}}</h2>
        <div class="settings-item"><strong>Nume utilizator:</strong> {{username}}</div>
        <div class="settings-item">📚 Cărți începute: {{startedBooks}}</div>
        <div class="settings-item">✅ Cărți terminate: {{finishedBooks}}</div>
        <div class="settings-item">💬 Recenzii: {{commentsCount}}</div>
        <div class="settings-item">⭐ Favorite: {{favoritesCount}}</div>

        <a href="/auth/logout"><button class="action-btn">Logout</button></a>
        <a href="/settings/export"><button class="action-btn">Export Date</button></a>
        <a href="/api/spec.html"><button class="action-btn">Specificații</button></a>
    </div>
</body>
</html>
