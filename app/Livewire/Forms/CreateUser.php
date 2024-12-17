<?php

namespace App\Livewire\Forms;

use App\Helpers\Filament\Forms\FilamentUserFormHelper;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateUser extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?FilamentUserFormHelper $helper = null;

    public function mount(): void
    {
        $this->helper = new FilamentUserFormHelper();
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->helper->getCreateFormSchema())
            ->statePath('data')
            ->model(User::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = User::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.forms.create-user');
    }
}
