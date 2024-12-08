<?php

namespace App\Livewire\Forms;

use App\Enums\UserRoleEnum;
use App\Helpers\Filament\Forms\FilamentUserFormHelper;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

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
