<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

class HabitPolicy
{
    public function view(User $user, Habit $habit)
    {
        return $user->id === $habit->user_id;
    }

    public function create(User $user)
    {
        return true; // Semua user boleh bikin habit
    }

    public function update(User $user, Habit $habit)
    {
        return $user->id === $habit->user_id;
    }

    public function delete(User $user, Habit $habit)
    {
        return $user->id === $habit->user_id;
    }

    public function viewAny(User $user)
    {
        return true; // Boleh lihat daftar habit miliknya (ditangani pakai filter di controller)
    }
}
