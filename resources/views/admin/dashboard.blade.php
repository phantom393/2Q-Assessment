<x-layouts.admin>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light w-100" style="background-color: #3b82f6;">
        <div class="container-fluid">
            <a class="navbar-brand text-dark fw-bold" style="font-size: 12px;" href="#">Companies</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <div class="collapse navbar-collapse" id="adminNavbar">
                    <div class="d-flex align-items-center ms-auto">
                        <span class="navbar-text text-dark me-3">
                            Welcome, {{ Auth::guard('admin')->user()->name }}
                        </span>
                        <livewire:admin-logout />
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        <livewire:company-manager />
    </div>
</x-layouts.admin>
