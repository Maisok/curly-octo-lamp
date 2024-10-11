<div>
    <h2>Посты пользователя {{ $user->name }}</h2>
    <ul>
        @foreach($user->posts as $post)
            <li>
                {{ $post->title }} - {{ $post->content }}
                <button onclick="editPost({{ $post->id }})">Редактировать</button>
                <button onclick="deletePost({{ $post->id }})">Удалить</button>
            </li>
        @endforeach
    </ul>
    <h3>Создать новый пост</h3>
    <form id="createPostForm">
        <input type="text" id="title" placeholder="Заголовок" required>
        <textarea id="content" placeholder="Содержание" required></textarea>
        <button type="submit">Создать</button>
    </form>

    <!-- Форма редактирования поста -->
    <div id="editPostForm" style="display: none;">
        <h3>Редактировать пост</h3>
        <form id="updatePostForm">
            <input type="hidden" id="editPostId">
            <input type="text" id="editTitle" placeholder="Заголовок" required>
            <textarea id="editContent" placeholder="Содержание" required></textarea>
            <button type="submit">Сохранить</button>
            <button type="button" onclick="cancelEdit()">Отмена</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('createPostForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        createPost(title, content);
    });

    function createPost(title, content) {
        fetch(`/api/users/{{ $user->id }}/posts`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, content })
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }

    function editPost(postId) {
        // Получаем данные поста
        fetch(`/api/users/{{ $user->id }}/posts/${postId}`)
        .then(response => response.json())
        .then(post => {
            // Заполняем форму редактирования
            document.getElementById('editPostId').value = post.id;
            document.getElementById('editTitle').value = post.title;
            document.getElementById('editContent').value = post.content;
            // Показываем форму редактирования
            document.getElementById('editPostForm').style.display = 'block';
        });
    }

    document.getElementById('updatePostForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const postId = document.getElementById('editPostId').value;
        const title = document.getElementById('editTitle').value;
        const content = document.getElementById('editContent').value;
        updatePost(postId, title, content);
    });

    function updatePost(postId, title, content) {
        fetch(`/api/users/{{ $user->id }}/posts/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, content })
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }

    function cancelEdit() {
        document.getElementById('editPostForm').style.display = 'none';
    }

    function deletePost(postId) {
        fetch(`/api/users/{{ $user->id }}/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
</script>