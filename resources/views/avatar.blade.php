<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка аватара</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Загрузка аватара</h1>
        <form action="{{ route('upload.avatar', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="avatar">Выберите файл:</label>
                <input type="file" name="avatar" id="avatar" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </form>

        <div id="currentAvatar">
            @if($user->avatar)
            <p>Ваш аватар:</p>
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар пользователя" class="img-thumbnail" style="max-width: 200px; border: 1px solid black; border-radius: 10%; margin-top: 2%;">
            @else
                <p>Аватар не загружен</p>
            @endif
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('user.posts', ['id' => $user->id]) }}" class="btn btn-secondary">Перейти к постам</a>
        </div>
    </div>
</body>
</html>