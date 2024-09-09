<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct(private UserRepository $userRepository) {}

    public function index(User $users)
    {
        $users = User::all()->where('role', '=', 'user');
        return $this->jsonResponse('success', 'All users list', ['users' => $users], 200);
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if (! $token = auth('api')->attempt($validated)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', '=', $validated['email']);

        return $this->jsonResponse('success', 'User Login', ['user' => $user, 'token' => $token], 201);
    }


    public function store(Request $request, User $user)
    {
        $inputs = $request->all();
        $password = $inputs['password'];
        $inputs['password'] = Hash::make($inputs['password']);

        if ($request->hasFile('profile_picture')) {

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $inputs['profile_picture'] = $path;
        }

        $user = $this->userRepository->create($inputs);

        if (!$token = auth('api')->attempt(['email' => $inputs['email'], 'password' => $password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->jsonResponse('success', 'User created', ['user' => $user, 'token' => $token], 201);
    }


    public function update(Request $request, User $user)
    {
        $inputs = $request->all();

        if (isset($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public/profile_picture')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $inputs['profile_picture'] = $path;
        }

        $user = $this->userRepository->update($inputs, $user->id);
        return $this->jsonResponse('success', 'User Updated', ['user' => $user], 201);
    }


    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return $this->jsonResponse('success', 'User details', ['user' => $user], 201);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return $this->jsonResponse('success', 'User Deleted', ['user' => $user], 204);
    }
}
