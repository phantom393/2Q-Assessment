<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $this->email)->first();

        if ($admin && $admin->status === Admin::STATUS_ACTIVE && Hash::check($this->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        
        $this->addError('email', 'Invalid credentials or inactive account.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
