<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin-right: 5px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Список пользователей</h1>
    <a href="{{route('main')}}">На главную</a>
    <table id="usersTable">
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID</th>
                <th onclick="sortTable('name')">Имя</th>
                <th onclick="sortTable('email')">Email</th>
            </tr>
        </thead>
        <tbody>
            <!-- Данные будут загружены с помощью JavaScript -->
        </tbody>
    </table>
    <div class="pagination" id="pagination">
        <!-- Пагинация будет загружена с помощью JavaScript -->
    </div>

    <script>
        let currentPage = 1;
        let sortBy = 'id';
        let order = 'asc';
        let filter = '';

        function fetchUsers() {
            const url = `/api/users?sort_by=${sortBy}&order=${order}&filter=${filter}&page=${currentPage}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    renderTable(data.data);
                    renderPagination(data.links);
                });
        }

        function renderTable(users) {
    const tableBody = document.querySelector('#usersTable tbody');
    tableBody.innerHTML = '';
    users.forEach(user => {
        const row = document.createElement('tr');
        const userId = user.id; // Получаем идентификатор пользователя
        const url = `/api/users/${userId}/roles`; // Формируем URL
        row.innerHTML = `
            <td><a href="${url}">${user.id}</a></td>
            <td>${user.name}</td>
            <td>${user.email}</td>
        `;
        tableBody.appendChild(row);
    });
}

        function renderPagination(links) {
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = '';
            links.forEach(link => {
                const pageLink = document.createElement('a');
                pageLink.href = '#';
                pageLink.innerText = link.label;
                if (link.active) {
                    pageLink.classList.add('active');
                }
                if (link.url) {
                    pageLink.onclick = () => {
                        currentPage = new URL(link.url).searchParams.get('page');
                        fetchUsers();
                    };
                }
                paginationDiv.appendChild(pageLink);
            });
        }

        function sortTable(column) {
            if (sortBy === column) {
                order = order === 'asc' ? 'desc' : 'asc';
            } else {
                sortBy = column;
                order = 'asc';
            }
            fetchUsers();
        }

        function applyFilter() {
            filter = document.getElementById('filter').value;
            fetchUsers();
        }

        // Инициализация загрузки данных
        fetchUsers();
    </script>
</body>
</html>