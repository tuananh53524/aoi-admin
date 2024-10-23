<?php

namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = $this->userService->getListUsers();
        $roles = array_flip(config('app.roles'));
        return view('dashboard.user.index', compact('users','roles'));
    }

    // Hiển thị form tạo người dùng mới
    public function create()
    {
        return view('users.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $this->userService->createUser($request->all());
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Hiển thị thông tin người dùng cụ thể
    public function show($id)
    {
        $user = $this->userService->findUserById($id);
        return view('users.show', compact('user'));
    }

    // Hiển thị form sửa thông tin người dùng
    public function edit($id)
    {
        $user = $this->userService->findUserById($id);
        return view('users.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $this->userService->updateUser($id, $request->all());
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
