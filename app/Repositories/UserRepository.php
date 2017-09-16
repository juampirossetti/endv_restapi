<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        
        \DB::beginTransaction();
        try {
            $user = new User;
            $user->fill($data);
            $user->save();
        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        
        return $user;
    }

    public function update(User $user, array $data)
    {

        \DB::beginTransaction();
        try {
            $user->fill($data);
            $user->save();
        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();


        return $user;
    }
}