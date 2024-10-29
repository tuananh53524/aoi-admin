<?php

namespace App\Exports;

class UserExport extends AdvancedExport
{
    public function map($user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'created_at' => $user->created_at
        ];
    }
}
