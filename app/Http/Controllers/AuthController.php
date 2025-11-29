<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Unit;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Ambil unit, tapi kita juga tahu count-nya
        $units = \App\Models\Unit::orderBy('nama_unit')->get(['id', 'nama_unit']);
        $unitsCount = $units->count();

        return view('auth.login', compact('units', 'unitsCount'));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'unit_id'  => 'required|integer|exists:units,id',
        ]);

        $unit_id = (int) $validated['unit_id'];

        // Check email
        $user = User::where('email', $validated['email'])->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        // Check password
        if (! Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Non-owner MUST match unit
        if ($user->role !== 'owner') {
            if ((int) $user->unit_id !== $unit_id) {
                return back()->withErrors(['unit_id' => 'Unit tidak sesuai akun.'])->withInput();
            }
        }

        // Login now
        Auth::login($user);
        $request->session()->regenerate();

        // Simpan unit aktif ke session
        session([
            'active_unit_id' => $unit_id,
            'active_unit_name' => Unit::find($unit_id)->nama_unit,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
