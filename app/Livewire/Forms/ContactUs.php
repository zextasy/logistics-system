<?php

namespace App\Livewire\Forms;

use App\Helpers\Filament\Forms\FilamentUserFormHelper;
use App\Models\User;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContactUs extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone')->hiddenLabel()->placeholder('Phone'),
                TextInput::make('email')->hiddenLabel()->placeholder('Email'),
                Textarea::make('Address')->hiddenLabel()->placeholder('Address')
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();


    }

    public function render(): View
    {
        return view('livewire.forms.contact-us');
    }
}
