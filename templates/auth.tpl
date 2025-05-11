<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: auto; }
        .form-section { display: none; }
        .form-section.active { display: block; }
        button { margin-top: 10px; }
        .switch { margin-top: 20px; text-align: center; cursor: pointer; color: blue; }
    </style>
</head>
<body>
    <div class="container">
        <div id="loginForm" class="form-section active">
            <h2>Login</h2>
            <form action="/WebInfoAn2SpilevoiAnton/auth/login" method="POST">
                <input type="text" name="username" placeholder="Utilizator" required><br>
                <input type="password" name="password" placeholder="Parolă" required><br>
                <button type="submit">Login</button>
            </form>
            <div class="switch" onclick="switchForm('register')">Nu ai cont? Înregistrează-te</div>
        </div>

        <div id="registerForm" class="form-section">
            <h2>Înregistrare</h2>
            <form action="/WebInfoAn2SpilevoiAnton/auth/register" method="POST">
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
