<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #e0e0e0;
        }

        header {
            background: linear-gradient(to right, #1e3a5f, #0f172a);
            color: white;
            padding: 1.2em 2em;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1em;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }


        .search-bar input[type="text"] {
            display: flex; gap: 0.5em; margin-left: auto;
            padding: 0.5em;
            border: none;
            border-radius: 5px;
            background-color: rgb(37, 99, 235);
            color: white;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5em;
            padding: 2em;
            justify-content: center;
        }

        .book-card {
            background-color: #1c1c1c;
            border: 1px solid #1e3a5f;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
            width: 220px;
            padding: 1em;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.6);
        }

        .book-card h3 {
            font-size: 1.1em;
            margin-bottom: 0.5em;
            color: #ffffff;
        }

        .book-card p {
            font-size: 0.9em;
            color: #cccccc;
            margin: 0.3em 0;
        }

        .separator {
            flex-basis: 100%;
            text-align: center;
            margin: 2em 0;
            font-weight: bold;
            font-size: 1.2em;
            color: #90cdf4;
            border-top: 1px solid #3b82f6;
            padding-top: 1em;
        }

        .star-button {
            font-size: 1.8em;
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star-button.selected {
            color: gold;
        }

        input[type='range'] {
            width: 100%;
            height: 8px;
            border-radius: 5px;
            appearance: none;
            background: #2a2a2a;
        }

        input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 0;
    height: 0;
    background: transparent;
    border: none;
}

        input[type='range']::-webkit-slider-thumb,
        input[type='range']::-moz-range-thumb,
        input[type='range']::-ms-thumb {
            width: 0;
            height: 0;
            background: transparent;
            border: none;
        }

        .link-extern {
            position: absolute;
            bottom: 1em;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
        }

        .link-extern button {
            width: 95%;
            height: 2em;
            background-color: #1e3a5f;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        .external-card {
    position: relative;
    padding-bottom: 3em;
}
            .header-button {
            background-color: transparent;
            border: 2px solid #ffffff55;
            border-radius: 6px;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        

        .header-button:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .settings-button {
            right: 1em;
        }
        .search-button{
           padding: 0.4em 1em;
                background-color: rgb(37, 99, 235);
                border: none;
                color: white;
                border-radius: 6px;
                font-weight: bold;
                font-size: 0.9em;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
                transform: translateY(0px); 
        }
        #searchInput::placeholder {
    color: white;
    opacity: 1;
  }
        
    </style>

    
</head>
<body>

<header>
    
<div style="display: flex; align-items: center; gap: 1em;">
    <h1 style="margin: 0;">{{headerTitle}}</h1>
    <button type="button"
        onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/{{favorites_button_action}}'"
        style="font-size: 3em; background: none; border: none; color: {{favorites_selected}}; cursor: pointer; transform: translateY(-5px);">
        ★
    </button>
    <button type="button"
        onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/{{unfinished_button_action}}'"
        style="font-size: 1em; background: none; border: none; color: {{favorites_selected2}}; cursor: pointer; transform: translateY(5px);">
        <span style="display: inline-block; transform: scale(6);">•</span>
    </button>
    <button type="button"
        onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/{{top_button_action}}'"
        style="font-size: 2.5em; background: none; border: none; color: {{favorites_selected3}}; cursor: pointer; transform: translateY(0x); ">
        ▲
    </button>
    <button type="button"
        onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/rss'"
        style="font-size: 2em; background: none; border: none; cursor: pointer; transform: translateY(5px);">
    <img src="/imgs/rss.png" alt="RSS Feed" style="width: 1em; height: 1em;">
    </button>
</div>

    <form class="search-bar" id="searchForm"
      style="display: flex; gap: 0.5em; margin-left: auto;">
        {{back_from_search}}
        <input type="text" id="searchInput" name="query" placeholder="Caută o carte..."
               style="padding: 0.5em; border: none; border-radius: 5px; color: white;">
    </form>
    <button type="button" id="searchButton"
    class = "search-button">
    Search
</button>
    
    <select id="searchType" name="type" class = "header-button">
    <option value="titlu">titlu</option>
    <option value="autor">autor</option>   
    <option value="editura">editura</option>
    <option value="an">an</option>
  </select>
  
    <button type="button"
    onclick="window.location.href='/WebInfoAn2SpilevoiAnton/settings/index'"
    style="width: 36px; height: 36px; cfont-weight: bold;" class = "header-button">⚙
</button>
</header>

    <main class="container">
        {{bookCards}}
        <div class="separator">External Library</div>
        {{extra_bookCards}}
    </main>

</body>
<script>
document.getElementById('searchInput').value = "{{search_term}}";
document.getElementById('searchType').value = "{{search_type}}";

document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
  const query = document.getElementById('searchInput').value.trim();
  const type = document.getElementById('searchType').value;

  if (query) {
    window.location.href = `/WebInfoAn2SpilevoiAnton/home/search/${type}/${encodeURIComponent(query)}`;
  }
});

document.getElementById('searchButton').addEventListener('click', function () {
    const query = document.getElementById('searchInput').value.trim();
    const type = document.getElementById('searchType').value;

    if (query) {
        window.location.href = `/WebInfoAn2SpilevoiAnton/home/search/${type}/${encodeURIComponent(query)}`;
    }
});

function toggleFavorite(button) {
    const bookId = button.getAttribute('data-book-id');
    console.log(JSON.stringify({ book_id: bookId }));

    button.classList.toggle('selected');
    
    fetch('/WebInfoAn2SpilevoiAnton/api/favorite.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ book_id: bookId })
})
.then(res => {
    return res.text();                          
})
.then(text => {  
     console.log(text); 
    try {
        const json = JSON.parse(text);           
    } catch (e) {
        console.error('JSON parse error:', e);
         button.classList.toggle('selected');
    }
})
.catch(err => {
     button.classList.toggle('selected');
});
}

function toggleFavoriteExternal(button, link) {
    console.log(link);
    console.log(JSON.stringify({ external: true, link: link }));
    button.classList.toggle('selected');
    
    fetch('/WebInfoAn2SpilevoiAnton/api/favorite.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ external: true, link: link })
    
})
.then(res => {
    return res.text();                          
})
.then(text => { 
    console.log(text); 
    try {
        const json = JSON.parse(text);           
    } catch (e) {
        
        console.error('JSON parse error:', e);
        button.classList.toggle('selected');
    }
})
.catch(err => {
     button.classList.toggle('selected');
});
}
</script>
</html>
