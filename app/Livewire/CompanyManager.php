<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;

class CompanyManager extends Component
{
    public $companies;
    public $companyId;
    public $name;
    public $email;
    public $logo;
    public $website_link;
    public $isEditing = false;

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
            'logo' => 'required|string',
            'website_link' => 'required|url',
        ]);

        Company::create([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo,
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
            'logo' => 'required|string',
            'website_link' => 'required|url',
        ]);

        $company = Company::findOrFail($this->companyId);
        $company->update([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo,
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
        $this->reset(['companyId', 'name', 'email', 'logo', 'website_link']);
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
