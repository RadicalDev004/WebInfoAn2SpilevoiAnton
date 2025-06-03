<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{title}}</title>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        .book-header {
        position: relative;
        background: linear-gradient(to right, #1e3a5f, #0f172a);
        color: white;
        padding: 2em;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background-color: transparent;
            border: 2px solid #ffffff55;
            border-radius: 6px;
            color: white;
            font-size: 1.2em;
            padding: 0.4em 0.6em;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .header-button:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .back-button {
            left: 1em;
        }

        .settings-button {
            right: 1em;
        }

        .book-container {
            max-width: 900px;
            margin: 2em auto;
            background-color: #1c1c1c;
            border: 1px solid #1e3a5f;
            border-radius: 12px;
            padding: 2em;
            display: flex;
            flex-wrap: wrap;
            gap: 2em;
            box-shadow: 0 0 20px rgba(30, 58, 95, 0.5);
            animation: fadeInUp 0.6s ease-out;
        }

        .book-cover {
            width: 200px;
            height: 300px;
            background-color: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            color: #aaa;
            border: 1px solid #3b82f6;
            border-radius: 8px;
        }

        .book-details {
            flex: 1;
            min-width: 250px;
        }

        .book-details h2 {
            margin-top: 0;
            margin-bottom: 0.5em;
            color: #ffffff;
        }

        .book-details p {
            margin: 0.3em 0;
            color: #cccccc;
        }

        .rating-section, .review-section {
            max-width: 900px;
            margin: 2em auto 0;
            background: #1c1c1c;
            padding: 2em;
            border: 1px solid #1e3a5f;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(30, 58, 95, 0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        .rating-section h3,
        .review-section h3 {
            margin-top: 0;
            font-size: 1.3em;
            color: #90cdf4;
        }

        .stars {
            color: gold;
        }

        .review-section textarea {
            width: 100%;
            height: 120px;
            padding: 0.8em;
            background-color: #2a2a2a;
            color: #fff;
            border: 1px solid #555;
            border-radius: 8px;
            resize: vertical;
        }

        .star-input {
            display: flex;
            gap: 6px;
            margin-top: 1em;
            flex-direction: row-reverse;
        }

        .star-input input[type="radio"] {
            display: none;
        }

        .star-input label {
            font-size: 2em;
            color: #555;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star-input input[type="radio"]:checked ~ label,
        .star-input label:hover,
        .star-input label:hover ~ label {
            color: gold;
        }

        .review-section button {
            margin-top: 1em;
            padding: 0.6em 1.2em;
            background-color: #1e3a5f;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .review-section button:hover {
            background-color: #3b82f6;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .progress-box {
    max-width: 925px;
    margin: 2em auto 0;
    padding: 1.2em;
    background-color: #1c1c1c;
    border: 1px solid #1e3a5f;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 115, 230, 0.2);
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
#pagesInput::placeholder {
    color: white;
    opacity: 1; 
  }

</style>

</head>
<header class="book-header">
    <button type="button" onclick="window.location.href='/home/index'" class="header-button back-button">←</button>

    <h1 class="header-title">Detalii Carte</h1>

    <button type="button" onclick="window.location.href='/settings/index'" class="header-button settings-button">⚙</button>
</header>



<br><br>
<body>

    <div class="book-container">
        <div class='book-cover'>
        <div style='width: 100%; height: 300px; border-radius: 4px; overflow: hidden; margin-bottom: 0em;'>
            <img src='{{url_cover}}' alt='Copertă'
            style='width: 100%; height: 100%; object-fit: cover; display: block;'
         onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=&quot;width: 100%; height: 100%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em;&quot;>Copertă</div>';">
        </div>
        </div>
        <div class="book-details">
            <h2>{{title}}</h2>
            <p {{hide}}><strong>Autor: </strong> {{author}}</p>
            <p {{hide}}><strong>An: </strong> {{year}}</p>
            <p {{hide}}><strong>Editura: </strong> {{publisher}}</p>
            <p {{hide}}><strong>Pagini: </strong> {{total_pages}}</p>
            <p {{hide}} style='color: gold;'><strong style='color: white; !important;'>Rating: </strong>{{avarage_rating}} /5★</p>
            <p><strong>Descriere: </strong><br>{{description}}</p>           
        </div>
    </div>
    
        <div class="progress-box" {{hide}}>
    <h3 style="color:rgb(118, 194, 245);">Progres lectură</h3
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1em; flex-wrap: wrap;">
        <div style="flex: 1; display: flex; align-items: center; gap: 0.8em;">
            <span id="totalPagesLabel">{{pages_read}}</span>
            <input type="range" id="progressSlider" min="0" max="100" value="0" 
                   style="flex-grow: 1; pointer-events: none;">
            <span id="progressPercent">0%</span>
        </div>

        <div style="display: flex; align-items: center; gap: 0.5em; ">
            <input type="number" id="pagesInput" placeholder="Pagini citite" 
                   style="width: 100px; padding: 0.3em; background-color: #0073e6; color: white; border-radius: 6px;">
            <button onclick="updateProgressAsync()" 
                    style="padding: 0.4em 0.8em; background-color: #0073e6; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Actualizează
            </button>
        </div>
    </div>
</div>



    

    <div class="review-section" {{hide}}>
        <h3>Adaugă o recenzie</h3>
        <form id="reviewForm" onsubmit="submitReview(event)">
            <textarea name="review" id="reviewInput" placeholder="Scrie recenzia ta aici..."></textarea>

            <div class="star-input">               
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>                
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>                
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>                
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
            </div>

            <button type="submit">Trimite recenzia</button>
        </form>
        
    </div>
    
    <div class="rating-section"{{hide}}>
    <h3>Recenzii utilizatori</h3>
    {{user_reviews}}
    </div>
    <script>
function submitReview(event) {
    event.preventDefault();
    console.log("text");

    const bookId = '{{book_id}}';
    const text = encodeURIComponent(document.getElementById('reviewInput').value.trim());
    const ratingInput = document.querySelector('input[name="rating"]:checked');
    const rating = ratingInput ? -ratingInput.value + 6 : 0;

    if (!text || !rating) {
        alert("Completează recenzia și selectează un rating.");
        return;
    }
    
    
    fetch('/api/review.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: bookId != '0' ? JSON.stringify({ book_id : bookId, text : text, stars : rating }) :  JSON.stringify({ external : true, text : text, stars : rating, link : '{{link}}' })
})
.then(res => {
    return res.text();                          
})
.then(text => {  
    console.log(text);
    try {
        const json = JSON.parse(text);    
        location.reload();       
    } catch (e) {
        console.error('JSON parse error:', e);
    }
})
.catch(err => {
     
});
}
let totalPages = {{total_pages}};
let progress = {{pages_read}};

function updateProgress(newPages) {
    const input = document.getElementById('pagesInput');
    const slider = document.getElementById('progressSlider');
    const display = document.getElementById('progressPercent');
    const pages = document.getElementById('totalPagesLabel');

    progress = progress + newPages;

    if (progress > totalPages) progress = totalPages;
    if(progress < 0) progress = 0;

    const percent = Math.round((progress / totalPages) * 100);
    slider.value = percent;
    display.textContent = percent + "%";
    
    pages.textContent = progress;

    slider.style.background = `linear-gradient(to right, #3b82f6 ${percent}%, #e0e0e0 ${percent}%)`;
}
function updateProgressAsync()
{
    const input = document.getElementById('pagesInput');
    const slider = document.getElementById('progressSlider');
    const display = document.getElementById('progressPercent');
    const bookId = '{{book_id}}';
    

    let pagesRead = parseInt(input.value);
    console.log(pagesRead);
    
    if (isNaN(pagesRead)) {
        alert("Introduceți un număr valid de pagini.");
        return;
    }
    
    updateProgress(pagesRead);
    
    fetch('/api/read.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: bookId != '0' ? JSON.stringify({ pages: pagesRead, book_id : bookId }) : JSON.stringify({ pages: pagesRead, external : true, link : '{{link}}', totalPages : totalPages })
})
.then(res => {
    return res.text();                          
})
.then(text => {  
    try {
        const json = JSON.parse(text);           
    } catch (e) {
        console.error('JSON parse error:', e);
        updateProgress(-pagesRead);
    }
})
.catch(err => {
     updateProgress(-pagesRead);
     
});
}
updateProgress(0);
</script>
    <br><br>
    
</body>
</html>
