<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Cria um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Retorna todos os usuários paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllUsers()
    {
        return User::paginate(10); // 10 usuários por página
    }
}
