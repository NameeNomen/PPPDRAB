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
    ]);

    if (Auth::attempt([
        'username' => $this->username,
        'password' => $this->password
    ])) {

        session()->regenerate();

        $user = Auth::user();

        $roleValue = method_exists($user->role, 'value')
            ? $user->role->value
            : $user->role;

        switch ($roleValue) {
            case 'marketing':
                return $this->redirectRoute('marketing.dashboard');

            case 'purchasing':
                return $this->redirectRoute('purchasing.dashboard');

            case 'engineering':
                return $this->redirectRoute('engineering.dashboard');

            case 'direktur':
                return $this->redirectRoute('direktur.dashboard');

            default:
                return $this->redirect('/');
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