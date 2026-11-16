<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function editPassword()
    {
        return view('account.password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'current_password.required' => 'Kata laluan semasa wajib diisi.',
            'current_password.current_password' => 'Kata laluan semasa tidak betul.',
            'password.required' => 'Kata laluan baharu wajib diisi.',
            'password.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
            'password_confirmation.required' => 'Pengesahan kata laluan baharu wajib diisi.',
            'password_confirmation.same' => 'Pengesahan kata laluan tidak sepadan.',
        ]);

        $request->user()->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('account.password.edit')
            ->with('success', 'Kata laluan berjaya ditukar.');
    }
}
