<?php

namespace App\Repositories;

use App\Models\User;

/*
 * Repository to manage users
 */

class UserRepository
{
    /*
     * Create and save a new user to DB
     */
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

    /*
     * Update an existing user in the DB
     */
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