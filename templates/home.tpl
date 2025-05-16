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
        .separator {
    flex-basis: 100%; /* Forces it to take full width of the container */
    text-align: center;
    margin: 2em 0;
    font-weight: bold;
    font-size: 1.2em;
    color: #111;
    border-top: 1px solid #555;
    padding-top: 1em;
}

        .book-card h3 {
            font-size: 1.1em;
            margin: 0 0 0.5em;
        }

        .book-card p {
            font-size: 0.9em;
            color: #555;
        }
        .star-button {
    font-size: 1.5em;
    background: none;
    border: none;
    color: #aaa;
    cursor: pointer;
    transition: color 0.2s;
}


.star-button.selected {
    color: gold;
}
input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 0;
    height: 0;
    background: transparent;
    border: none;
}

input[type=range]::-moz-range-thumb {
    width: 0;
    height: 0;
    background: transparent;
    border: none;
}

input[type=range]::-ms-thumb {
    width: 0;
    height: 0;
    background: transparent;
    border: none;
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
</div>

    <form class="search-bar" id="searchForm"
      style="display: flex; gap: 0.5em; margin-left: auto;">
        {{back_from_search}}
        <input type="text" id="searchInput" name="query" placeholder="Caută o carte..."
               style="padding: 0.5em; border: none; border-radius: 5px;">
    </form>
    <button type="button" id="searchButton"
    style="padding: 0.5em 1em; background-color: #555; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 0.5em;">
    Search
</button>
    
    <select id="searchType" name="type" style="padding: 0.5em; border-radius: 5px; margin-left: 0.5em;">
    <option value="titlu">titlu</option>
    <option value="autor">autor</option>   
    <option value="editura">editura</option>
    <option value="an">an</option>
  </select>
  
    <button type="button"
    onclick="window.location.href='/WebInfoAn2SpilevoiAnton/settings/index'"
    style="width: 36px; height: 36px; border-radius: 50%; background-color: white; color: #333; border: 1px solid #ccc; cursor: pointer; font-weight: bold; margin-left: 1em;">⚙
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
