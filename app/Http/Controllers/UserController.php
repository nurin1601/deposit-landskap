<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'E-mel wajib diisi.',
            'email.email' => 'Format e-mel tidak betul.',
            'email.unique' => 'E-mel ini sudah digunakan.',
            'password.required' => 'Kata laluan wajib diisi.',
            'password.min' => 'Kata laluan mesti sekurang-kurangnya 8 aksara.',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Akaun berjaya dicipta.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->withErrors(['delete' => 'Anda tidak boleh memadam akaun sendiri.']);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Akaun telah dipadam.');
    }
}
