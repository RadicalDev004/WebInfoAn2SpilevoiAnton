<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        header {
            background: #333;
            color: white;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 0.5em;
            border: none;
            border-radius: 5px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            padding: 2em;
        }

        .book-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            width: 200px;
            padding: 1em;
        }

        .book-card h3 {
            font-size: 1.1em;
            margin: 0 0 0.5em;
        }

        .book-card p {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>

<header>
    
<div style="display: flex; align-items: center; gap: 1em;">
    <h1 style="margin: 0;">{{headerTitle}}</h1>
    <button type="button"
        onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/favorites'"
        style="font-size: 3em; background: none; border: none; color: #aaa; cursor: pointer; transform: translateY(-5px); " onmouseover="this.style.color='gold'" onmouseout="this.style.color='#aaa'">
        ★
    </button>
</div>

    <form class="search-bar" id="searchForm"
      style="display: flex; gap: 0.5em; margin-left: auto;">
        {{back_from_search}}
        <input type="text" id="searchInput" name="query" placeholder="Caută o carte..."
               style="padding: 0.5em; border: none; border-radius: 5px;">
    </form>
    <button type="button"
    onclick="window.location.href='/WebInfoAn2SpilevoiAnton/settings/index'"
    style="width: 36px; height: 36px; border-radius: 50%; background-color: white; color: #333; border: 1px solid #ccc; cursor: pointer; font-weight: bold; margin-left: 1em;">⚙
</button>
</header>

    <main class="container">
        {{bookCards}}
    </main>

</body>
<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        window.location.href = `/WebInfoAn2SpilevoiAnton/home/search/${encodeURIComponent(query)}`;
    }
});
</script>
</html>
