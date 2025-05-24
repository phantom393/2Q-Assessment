<div>
    <button type="button" wire:click="create" class="btn btn-primary mb-4">
        Add Company
    </button>

    <div wire:ignore.self class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="submit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="companyModalLabel">
                            @if ($isEditing)
                                Edit Company
                            @else
                                Add Company
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="text" wire:model.defer="name" placeholder="Company Name" class="form-control mb-1">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror

                        <input type="email" wire:model.defer="email" placeholder="Email" class="form-control mb-1">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror

                        <input type="file" wire:model="logoFile" class="form-control mb-1">
                        @error('logoFile') <small class="text-danger">{{ $message }}</small> @enderror

                        @if ($logoFile)
                            <div class="mb-2">
                                <img src="{{ $logoFile->temporaryUrl() }}" alt="Logo Preview" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @elseif ($isEditing && $logo)
                            <div class="mb-2">
                                <img src="{{ $logo }}" alt="Current Logo" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif

                        <input type="text" wire:model.defer="website_link" placeholder="Website Link" class="form-control mb-1">
                        @error('website_link') <small class="text-danger">{{ $message }}</small> @enderror
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

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $index => $company)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            <a href="{{ $company->website_link }}" target="_blank">
                                {{ $company->website_link }}
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" wire:click="edit('{{ $company->id }}')">Edit</button>

                            <button class="btn btn-sm btn-danger" wire:click="delete('{{ $company->id }}')" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
