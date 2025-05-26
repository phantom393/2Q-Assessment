<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class AdminLogout extends Component
{
    public function confirmLogout()
    {
        LivewireAlert::title('Log Out')
            ->text('Are you sure you want to logout?')
            ->asConfirm()
            ->onConfirm('logout')
            ->show();
    }

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
