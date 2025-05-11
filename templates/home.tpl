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
    <div><h1>{{headerTitle}}</h1></div>

    <form class="search-bar" id="searchForm" style="display: flex; align-items: center; gap: 0.5em;">
        {{back_from_search}}
        <input type="text" id="searchInput" name="query" placeholder="Caută o carte..."
               style="padding: 0.5em; border: none; border-radius: 5px;">
    </form>
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
