<?php

namespace App\Domains\Users;

use App\Models\User;
use App\Support\Repositories\BaseRepository;

class UsersRepository extends BaseRepository
{
    protected $modelClass = User::class;

    public function getUsers($limit = 15, $paginate = false)
    {
        $query = $this->newQuery();
        $query->orderBy('name');

        return $this->doQuery($query, $limit, $paginate);
    }

    public function getUserById($id, $fail = true)
    {
        return $this->findByID($id, $fail);
    }

    public function getUserByEmail($email)
    {
        return $this->newQuery->where('email', $email)->first();
    }

    public function checkIfuserExists($value, $column = 'email')
    {
        return (bool)$this->newQuery->where($column, $value)->count();
    }

    public function createUser($data)
    {
        if ($this->getUserByEmail($data['email'])) {
            return false;
        }

        return $this->newQuery()->create($data);
    }

    public function updateUser($id, $data)
    {
        return $this->newQuery()
            ->findOrFail($id)
            ->fill($data)
            ->save();
    }

    public function deleteUser($id, $fail = true)
    {
        return $this->deleteByID($id, $fail);
    }
}
