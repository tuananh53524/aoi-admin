<?php

namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Hiển thị danh sách người dùng
    public function index(Request $request)
    {
        $filters  = $request->all();
        $users = $this->userService->getListUsers($filters);
        $roles = array_flip(config('app.roles'));
        return view('dashboard.user.index', compact('users','roles'));
    }

    // Hiển thị form tạo người dùng mới
    public function create()
    {
        return view('dashboard.user.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $data = $request->all();
        $created = $this->userService->createUser($data);
        if ($created) {
            return redirect()->route('users.index')->with('Success', 'The account has been successfully created');
        } else {
            return redirect()->route('users.index')->with('Error', 'Could not create user');
        }
    }


    // Hiển thị form sửa thông tin người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.user.edit', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $result = $this->userService->updateUser($id, $data);
    
        if ($result['success']) {
            return redirect()->route('users.index')->with('Success', $result['message']);
        } else {
            return redirect()->back()->withInput()->with('Error', $result['message']);
        }
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
