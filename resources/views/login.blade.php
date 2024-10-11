<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="loginForm" action="{{route('loginUser')}}" method='post'>
        <input name="email" type="text" placeholder='email'>
        <input name="password" type="text" placeholder='password'>
        <button type='submit'>Войти</button>
    </form>
    <div id="message"></div>
</body>
<script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/auth/login', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.status) {
                    messageDiv.textContent = data.message;
                    messageDiv.style.color = 'green';
                } else {
                    messageDiv.textContent = data.message + ': ' + JSON.stringify(data.errors);
                    messageDiv.style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</html>