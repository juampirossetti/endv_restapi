<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Models\User;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepo) {
        $this->userRepository = $userRepo;
    }


    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->get('user', []);
        
        //JUST FOR TESTING
        $data['password'] = bcrypt('secret');

        $user = $this->userRepository->create($data);

        return response()->json($user, 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->get('user', []);
        
        $user = $this->userRepository->update($user, $data);
        
        return response()->json($user, 201);

    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    
}
