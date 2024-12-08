<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="flex justify-end my-3">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                Submit Quote Request
            </button>
        </div>
    </form>

    <x-filament-actions::modals />
</div>
