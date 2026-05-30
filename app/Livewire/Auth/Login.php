<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username;
    public $password;

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi bos.',
            'password.required' => 'Password jangan dikosongin.',
        ]);

        // Cek ke database pake kolom username
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session()->regenerate();
            
            $user = Auth::user();
            
            // AMAN UNTUK ENUM: Ambil string value dari enum-nya
            $roleValue = method_exists($user->role, 'value') ? $user->role->value : $user->role;
            
            // Redirect otomatis sesuai dengan 4 jabatan menggunakan Switch Case biar rapi
            switch ($roleValue) {
                case 'marketing':
                    return redirect()->route('marketing.dashboard');
                case 'purchasing':
                    return redirect()->route('purchasing.dashboard');
                case 'engineering':
                    return redirect()->route('engineering.dashboard');
                case 'direktur':
                    return redirect()->route('direktur.dashboard');
                default:
                    return redirect('/');
            }
        }

        $this->addError('username', 'Username atau password salah! Cek lagi.');
    }

    public function render()
    {
        // Pakai layout polos khusus halaman login
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}