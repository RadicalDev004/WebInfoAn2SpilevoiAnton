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

        .book-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5em;
            display: flex;
            gap: 2em;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .book-cover {
            width: 200px;
            height: 300px;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            color: #888;
            border: 1px solid #ccc;
        }

        .book-details {
            flex: 1;
        }

        .book-details h2 {
            margin-top: 0;
            margin-bottom: 0.5em;
        }

        .book-details p {
            margin: 0.3em 0;
        }

        .rating-section {
    max-width: 800px;
    margin: 2em auto 0;
    background: #fff;
    padding: 1.5em;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.rating-section h3 {
    margin-top: 0;
    margin-bottom: 1em;
    font-size: 1.2em;
    color: #333;
}

        .stars {
            color: gold;
        }

        .review-section {
            max-width: 800px;
            margin: 2em auto 0;
            background: #fff;
            padding: 1.5em;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .review-section h3 {
            margin-top: 0;
        }

        .review-section textarea {
            width: 100%;
            height: 100px;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .star-input {
            display: flex;
            gap: 5px;
            margin-top: 0.8em;
             flex-direction: row-reverse;
        }

        .star-input input[type="radio"] {
            display: none;
        }

        .star-input label {
            font-size: 1.5em;
            color: #ccc;
            cursor: pointer;
        }

        .star-input input[type="radio"]:checked ~ label {
            color: gold;
        }

        .star-input label:hover,
        .star-input label:hover ~ label {
            color: gold;
        }

        .review-section button {
            margin-top: 1em;
            padding: 0.5em 1em;
            background-color: #0073e6;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .review-section button:hover {
            background-color: #005bb5;
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
.progress-section {
    max-width: 800px;
    margin: 2em auto 0;
    background: #fff;
    padding: 1.5em;
    border: 1px solid #ddd;
    border-radius: 8px;
}
.progress-section h3 {
    margin-top: 0;
    margin-bottom: 1em;
    font-size: 1.2em;
    color: #333;
}

input[type=range] {
    -webkit-appearance: none;
    appearance: none;
    height: 8px;
    border-radius: 5px;
    width: 100%;
    background: linear-gradient(to right, #0073e6 0%, #e0e0e0 0%);
    pointer-events: none; /* optional */
    border: none;
}

/* Remove the knob */
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
<header>
    <div class="header-left">
        <button type="button" onclick="window.location.href='/WebInfoAn2SpilevoiAnton/home/index'" class="header-button">←</button>
        <h1 style="margin: 0;">Detalii Carte</h1>
    </div>

    <button type="button" onclick="window.location.href='/WebInfoAn2SpilevoiAnton/settings/index'" class="header-button">⚙</button>
</header>

<br><br>
<body>

    <div class="book-container">
        <div class="book-cover" {{hide}}>
            Copertă
        </div>
        <div class="book-details">
            <h2>{{title}}</h2>
            <p {{hide}}><strong>Autor: </strong> {{author}}</p>
            <p {{hide}}><strong>An: </strong> {{year}}</p>
            <p {{hide}}><strong>Editura: </strong> {{publisher}}</p>
            <p {{hide}}><strong>Pagini: </strong> {{total_pages}}</p>
            <p {{hide}} style='color: gold;'><strong style='color: black; !important;'>Rating: </strong>{{avarage_rating}} /5★</p>
            <p><strong>Descriere: </strong><br>{{description}}</p>           
        </div>
    </div>
    
        <div class="progress-section" {{hide}}>
    <h3>Progres lectură</h3>
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1em;">
        
        <!-- Left side: total pages and slider with percentage -->
        <div style="flex: 1; display: flex; align-items: center; gap: 0.8em;">
            <span id="totalPagesLabel">{{pages_read}}</span>
            <input type="range" id="progressSlider" min="0" max="100" value="0" 
                   style="flex-grow: 1; pointer-events: none;">
            <span id="progressPercent">0%</span>
        </div>
        
        <!-- Right side: input + button -->
        <div style="display: flex; align-items: center; gap: 0.5em;">
            <input type="number" id="pagesInput" placeholder="Pagini citite" 
                   style="width: 100px; padding: 0.3em;">
            <button onclick="updateProgress2()" 
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
    const rating = ratingInput ? -ratingInput.value + 6 : 1;

    if (!text || !rating) {
        alert("Completează recenzia și selectează un rating.");
        return;
    }
    
    const url = `/WebInfoAn2SpilevoiAnton/book/submitReview/${bookId}/{{username}}/${text}/${rating}`;
    window.location.href = url;
}
let totalPages = {{total_pages}};  // Replace with actual total if available

function updateProgress() {
    const input = document.getElementById('pagesInput');
    const slider = document.getElementById('progressSlider');
    const display = document.getElementById('progressPercent');

    let pagesRead = {{pages_read}};

    if (pagesRead > totalPages) pagesRead = totalPages;

    const percent = Math.round((pagesRead / totalPages) * 100);
    slider.value = percent;
    display.textContent = percent + "%";

    // Update slider background gradient
    slider.style.background = `linear-gradient(to right, #0073e6 ${percent}%, #e0e0e0 ${percent}%)`;
}
function updateProgress2()
{
    const input = document.getElementById('pagesInput');
    const slider = document.getElementById('progressSlider');
    const display = document.getElementById('progressPercent');
    const bookId = '{{book_id}}';

    let pagesRead = parseInt(input.value);
    
    if (isNaN(pagesRead)) {
        alert("Introduceți un număr valid de pagini.");
        return;
    }
    
    const url = `/WebInfoAn2SpilevoiAnton/book/changeProgress/${bookId}/{{username}}/${pagesRead}`;
    window.location.href = url;
}
updateProgress();
</script>
    <br><br>
    
</body>
</html>
