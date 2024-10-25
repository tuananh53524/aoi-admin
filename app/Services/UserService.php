<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListUsers()
    {
        return User::paginate(10);
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
        $user->avatar = $data['avatar'];
        $user->status = ($data['status'] == 'on') ? 1 : 0;
        dd($user);
        if ($user->save()) {
            return redirect()->route('users.index')->with('Success', 'The account has been successfully created');
        } else {
            return redirect()->route('users.index')->with('Error', 'Could not creat user');
        }
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
        $user = $this->findUserById($id);
        if ($user) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            return $user->update($data);
        }
        return false;
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
