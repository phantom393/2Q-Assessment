<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CompanyManager extends Component
{
    use WithFileUploads;

    public $companies;
    public $companyId;
    public $name;
    public $email;
    public $logo;
    public $website_link;
    public $isEditing = false;
    public $logoFile;

    public function mount()
    {
        $this->loadCompanies();
    }

    public function loadCompanies()
    {
        $this->companies = Company::latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $this->companyId = $company->id;
        $this->name = $company->name;
        $this->email = $company->email;
        $this->logo = $company->logo;
        $this->website_link = $company->website_link;
        $this->isEditing = true;

        $this->dispatch('open-modal');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logoFile' => 'required|image|max:1024',
            'website_link' => 'required|url',
        ]);

        $logoPath = $this->logoFile->store('logos', 'public');

        Company::create([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => Storage::url($logoPath),
            'website_link' => $this->website_link,
        ]);

        $this->resetForm();
        $this->loadCompanies();
        $this->dispatch('close-modal');
    }


    public function update()
{
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'website_link' => 'required|url',
        'logoFile' => 'nullable|image|max:1024',
    ]);

    $company = Company::findOrFail($this->companyId);

    $logoUrl = $company->logo;
    if ($this->logoFile) {
        $logoPath = $this->logoFile->store('logos', 'public');
        $logoUrl = Storage::url($logoPath);
    }

    $company->update([
        'name' => $this->name,
        'email' => $this->email,
        'logo' => $logoUrl,
        'website_link' => $this->website_link,
    ]);

    $this->resetForm();
    $this->loadCompanies();
    $this->dispatch('close-modal');
}

    public function delete($id)
    {
        Company::destroy($id);
        $this->loadCompanies();
    }

    private function resetForm()
{
    $this->reset(['companyId', 'name', 'email', 'logoFile', 'logo', 'website_link']);
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
        return view('livewire.company-manager');
    }
}
