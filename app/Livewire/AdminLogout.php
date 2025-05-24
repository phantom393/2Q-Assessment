<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogout extends Component
{
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
    
    public function render()
    {
        return view('livewire.admin-logout');
    }
}
