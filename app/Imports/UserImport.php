<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserImport extends AdvancedImport
{
    protected function processChunk(Collection $chunk): void
    {
        foreach ($chunk as $row) {
            try {
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'password' => Hash::make($row['password'] ?? 'password123')
                ]);
                
                $this->successCount++;
            } catch (\Exception $e) {
                $this->failures[] = [
                    'row' => $row,
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.email' => ['required', 'email', 'unique:users,email'],
            '*.name' => ['required', 'string', 'max:255'],
            '*.phone' => ['nullable', 'string', 'max:20'],
        ];
    }
}