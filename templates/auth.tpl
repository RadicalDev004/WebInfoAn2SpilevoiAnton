<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--responsive-->

    
    <style>

        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212;
    color: #e0e0e0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    max-width: 400px;
    width: 100%;
    background-color: #1c1c1c;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(30, 58, 95, 0.6);
    border: 1px solid #1e3a5f;
    transition: all 0.3s ease-in-out;
}
@media (max-width: 400px) {
    .container {
        padding: 20px;
    }
}

h2 {
    text-align: center;
    color: #ffffff;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px 0px;
    margin: 10px 0;
    background-color: #2a2a2a;
    border: 1px solid #1e3a5f;
    border-radius: 8px;
    font-size: 15px;
    color: #ffffff;
    transition: border-color 0.3s, background-color 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #3b82f6;
    outline: none;
    background-color: #1e1e1e;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #1e3a5f;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3b82f6;
}

.switch {
    margin-top: 20px;
    text-align: center;
    cursor: pointer;
    color: #90cdf4;
    font-size: 14px;
    text-decoration: underline;
}

.form-section {
    display: none;
    animation: fadeIn 0.5s ease-in-out;
}

.form-section.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>



</head>
<body>
    <div class="container">
        <div id="loginForm" class="form-section active">
            <h2>Login</h2>
            <form action="/auth/login" method="POST">
                <input type="text" name="username" placeholder="Utilizator" required><br>
                <input type="password" name="password" placeholder="Parolă" required><br>
                <button type="submit">Login</button>
            </form>
            <div class="switch" onclick="switchForm('register')">Nu ai cont? Înregistrează-te</div>
        </div>

        <div id="registerForm" class="form-section">
            <h2>Înregistrare</h2>
            <form action="/auth/register" method="POST">
                <input type="text" name="username" placeholder="Utilizator" required><br>
                <input type="password" name="password" placeholder="Parolă" required><br>
                <button type="submit">Înregistrează-te</button>
            </form>
            <div class="switch" onclick="switchForm('login')">Ai deja cont? Login</div>
        </div>
    </div>

    <script>
        function switchForm(form) {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('registerForm').classList.remove('active');
            if (form === 'login') {
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('registerForm').classList.add('active');
            }
        }
    </script>
</body>
</html>

