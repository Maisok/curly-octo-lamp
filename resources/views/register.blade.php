<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xdxdxd</title>
</head>
<body>
    <form id="registerForm">
        <input type="text" placeholder='name' name='name'>
        <input type="text" placeholder='email' name='email'>
        <input type="text" placeholder='password' name='password'>
        <button type='submit'>xdxdxd</button>
    </form>

    <a href="{{route('welcome')}}">Пользователи</a>
    <a href="{{route('login')}}">Войти</a>
    <a href="{{route('users')}}">Все ползователи</a>
    <div id="message"></div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('/api/auth/register', {
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
</body>
</html>