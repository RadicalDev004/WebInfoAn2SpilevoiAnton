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
            <p {{hide}}><strong>Rating: </strong>{{avarage_rating}} /5★</p>
            <p><strong>Descriere: </strong><br>{{description}}</p>           
        </div>
    </div>


    <div class="review-section" {{hide}}>
        <h3>Adaugă o recenzie</h3>
        <form method="post" action="/WebInfoAn2SpilevoiAnton/book/submitReview/{{book_id}}">
            <textarea name="review" placeholder="Scrie recenzia ta aici..."></textarea>

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
    <br><br>
</body>
</html>
