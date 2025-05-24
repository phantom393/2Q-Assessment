<x-layouts.admin>
    <h1 class="text-xl font-bold">Admin Dashboard</h1>
    <p>Welcome, {{ Auth::guard('admin')->user()->name }}</p>

    <h1 class="text-xl font-bold mb-4">Company Manager</h1>

    <livewire:company-manager />
</x-layouts.admin>