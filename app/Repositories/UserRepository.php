<?php

namespace App\Repositories;

use App\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 30, 2020, 11:04 pm -03
 */
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'active',
        'remember_token'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create($input)
    {
        $input['password'] = bcrypt($input['password']);
        $input['active'] = isset($input['active']) ? $input['active'] : 0;

        $model = parent::create($input);

        if (isset($attributes['roles'])) {
            $this->addPermissions($model, $attributes['roles']);
        }
        return $model;
    }


    /**
     * @param User $user
     * @param $roles
     * @return bool
     */
    private function addPermissions(User $user, $roles)
    {
        if (!auth()->user()->level() >= 5) {
            return false;
        }
        $user->syncRoles($roles);
    }

    public function update($attributes, $id)
    {
        if (isset($attributes['password']) && strlen($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }
        if (auth()->user()->level() >= 5) {
            $attributes['active'] = intval($attributes['active']);
        }
        $model = parent::update($attributes, $id);

        if (isset($attributes['roles'])) {
            $this->addPermissions($model, $attributes['roles']);
        }

        return $model;
    }
}
