<div>
    <div wire:ignore.self class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="companyModalLabel">
                            {{ $isEditing ? 'Edit Company' : 'Add Company' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" wire:model.defer="name" placeholder="Company Name" class="form-control" style="font-size: 12px;">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <input type="email" wire:model.defer="email" placeholder="Email" class="form-control" style="font-size: 12px;">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <input type="file" wire:model="logoFile" class="form-control" style="font-size: 12px;">
                            @error('logoFile') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            @if ($logoFile)
                                <img src="{{ $logoFile->temporaryUrl() }}" alt="Logo Preview" class="img-thumbnail" style="max-height: 150px;">
                            @elseif ($isEditing && $logo)
                                <img src="{{ Storage::url($logo) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 150px;">
                            @endif
                        </div>
                        <div class="mb-3">
                            <input type="text" wire:model.defer="websiteLink" placeholder="Website Link" class="form-control" style="font-size: 12px;">
                            @error('websiteLink') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            {{ $isEditing ? 'Update' : 'Add' }} Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="p-2 d-flex justify-content-end align-items-center">
        <input type="text" wire:model.live="search" placeholder="Search" class="form-control rounded me-2" style="max-width: 250px; font-size: 12px;">
        <button type="button" wire:click="create" class="btn btn-primary" style="font-size: 12px;">
            Add Company
        </button>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead style="background-color: #3b82f6; color: black;">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr>
                        <td>{{ $loop->iteration + ($companies->currentPage() - 1) * $companies->perPage() }}</td>
                        <td class="d-flex align-items-center gap-2">
                            <img src="{{ Storage::url($company->logo) }}" alt="Logo" class="rounded" style="width: 32px; height: 32px; object-fit: cover;">
                            {{ $company->name }}
                        </td>
                        <td>{{ $company->email }}</td>
                        <td>
                            <a href="{{ $company->website_link }}" target="_blank" rel="noopener noreferrer">
                                {{ $company->website_link }}
                            </a>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px;">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" style="font-size: 12px;" wire:click.prevent="edit('{{ $company->id }}')" href="#">Edit</a></li>
                                    <li><a class="dropdown-item text-danger" style="font-size: 12px;" wire:click.prevent="confirmDelete('{{ $company->id }}')" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $companies->links() }}
        </div>
    </div>
</div>

<script>
    let bootstrapModal;

    window.addEventListener('open-modal', () => {
        const el = document.getElementById('companyModal');
        if (!bootstrapModal) {
            bootstrapModal = new bootstrap.Modal(el);
        }
        bootstrapModal.show();
    });

    window.addEventListener('close-modal', () => {
        if (bootstrapModal) {
            bootstrapModal.hide();
        }
    });
</script>