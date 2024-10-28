<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;

;

use Illuminate\Support\Str;

class UserService
{
    protected $imageHelper, $model;

    public function __construct(ImageHelper $imageHelper, User $model)
    {
        $this->imageHelper = $imageHelper;
        $this->model = $model;
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListUsers($data)
    {
        $users = $this->model
                  ->filter($data)
                  ->paginate(10);
        return $users;
    }

    /**
     * Find user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->role = !empty($data['role']) ? $data['role'] : config('app.roles.admin');
        $user->password = Hash::make($data['password']);
        $user->status = ($data['status'] == 'on') ? 1 : 0;
        if (!empty($data['cropped_avatar'])) {
            $avatar_path = $this->imageHelper->handleImage($data['cropped_avatar'], 'avatar', Str::slug($data['name']));
        }
        $user->avatar = $avatar_path ?? '';

        return $user->save();
    }

    /**
     * Update a user by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser($id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            
            // Cập nhật thông tin người dùng
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->role = !empty($data['role']) ? $data['role'] : config('app.roles.admin');
            $user->status = isset($data['status']) ? 1 : 0;
    
            // Xử lý avatar nếu có
            if (!empty($data['cropped_avatar'])) {
                $avatar_path = $this->imageHelper->handleImage($data['cropped_avatar'], 'avatar', Str::slug($data['name']));
                $user->avatar = $avatar_path;
            }
    
            $user->save();
            DB::commit();
            
            return ['success' => true, 'message' => 'User updated successfully!'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Failed to update user: ' . $e->getMessage()];
        }
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $user = $this->findUserById($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}
