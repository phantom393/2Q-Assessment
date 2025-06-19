<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class CompanyManager extends Component
{
    use WithFileUploads, WithPagination;

    public $companyId;
    public $name;
    public $email;
    public $logo;       
    public $websiteLink;
    public $isEditing = false;
    public $logoFile;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $this->companyId = $company->id;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->logo = $company->logo; 
        $this->websiteLink = $company->website_link;
        $this->isEditing = true;

        $this->dispatch('open-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:companies',
            'email' => 'required|email|unique:companies',
            'logoFile' => 'required|image|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=100,min_height=100',
            'websiteLink' => 'required|url',
        ]);

        $logoPath = $this->logoFile->store('logos', 'public');

        Company::create([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $logoPath,   
            'website_link' => $this->websiteLink,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal');

        LivewireAlert::title('Company stored successfully.')
            ->success()
            ->withConfirmButton('Ok')
            ->show();
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('companies', 'name')
                    ->ignore($this->companyId)
                    ->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('companies', 'email')
                    ->ignore($this->companyId)
                    ->whereNull('deleted_at'),
            ],
            'logoFile' => 'nullable|image|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=100,min_height=100',
            'websiteLink' => 'required|url',
        ]);

        $company = Company::findOrFail($this->companyId);

        $logoPath = $company->logo;

        if ($this->logoFile) {
            $logoPath = $this->logoFile->store('logos', 'public');
        }

        $company->update([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $logoPath, 
            'website_link' => $this->websiteLink,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal');

        LivewireAlert::title('Company updated successfully.')
            ->success()
            ->withConfirmButton('Ok')
            ->show();
    }

    public function confirmDelete($id)
    {
        LivewireAlert::title('Delete Item')
            ->text('Are you sure you want to delete this item?')
            ->asConfirm()
            ->onConfirm('deleteItem', ['id' => $id])
            ->onDeny('keepItem')
            ->show();
    }

    public function deleteItem($id)
    {
        Company::destroy($id['id']);

        LivewireAlert::title('Company deleted successfully.')
            ->success()
            ->withConfirmButton('Ok')
            ->show();
    }

    public function keepItem()
    {
        $this->dispatch('close-modal');
    }

    private function resetForm()
    {
        $this->reset(['companyId', 'name', 'email', 'logoFile', 'logo', 'websiteLink']);
        $this->isEditing = false;
    }

    public function submit()
    {
        if ($this->isEditing) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function render()
    {
        $searchWords = '%'.$this->search.'%';

        return view('livewire.company-manager', [
            'companies' => Company::where('name', 'like', $searchWords)
                ->orWhere('website_link', 'like', $searchWords)
                ->latest()
                ->paginate(2),
        ]);
    }
}
