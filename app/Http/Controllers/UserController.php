<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Получаем параметры запроса
        $sortBy = $request->input('sort_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter');
        $page = $request->input('page', 1);

        // Создаем запрос к модели User
        $query = User::query();

        // Применяем сортировку
        $query->orderBy($sortBy, $order);

        // Применяем фильтрацию, если параметр filter задан
        if ($filter) {
            list($field, $value) = explode(':', $filter);
            $query->where($field, 'like', '%' . $value . '%');
        }

        // Применяем пагинацию
        $users = $query->paginate(10, ['*'], 'page', $page);

        return response()->json($users);
    }

    public function showUploadForm($id)
    {
        $user = User::findOrFail($id);
        return view('avatar', compact('user'));
    }

    public function uploadAvatar(Request $request, $id)
{
    // Найти пользователя по ID
    $user = User::findOrFail($id);

    // Валидация файла
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Загрузка файла
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();

        // Сохранение файла в локальную файловую систему
        $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');

        // Отладочный вывод
        \Log::info('Avatar saved to: ' . $avatarPath);

        // Обновление аватара пользователя
        $user->avatar = $avatarPath;
        $user->save();

        return redirect()->back()->with('success', 'Аватар успешно загружен');
    }

    return redirect()->back()->with('error', 'Ошибка загрузки аватара');
}
}