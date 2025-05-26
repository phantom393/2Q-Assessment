<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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

        $key = Str::lower('login:' . $this->email);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Too many attempts. Please try again in {$seconds} seconds.");
            return;
        }

        $admin = Admin::where('email', $this->email)->first();

        if (
            $admin &&
            $admin->status === Admin::STATUS_ACTIVE &&
            Hash::check($this->password, $admin->password)
        ) {
            RateLimiter::clear($key); 
            Auth::guard('admin')->login($admin);
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        RateLimiter::hit($key, 120); 
        $this->addError('email', 'Invalid credentials or inactive account.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
