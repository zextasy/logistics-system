<div>
    <x-filament-actions::group
        :actions="[
            $this->editQuoteStatusAction,
        ]"
        label="Actions"
        icon="heroicon-m-ellipsis-vertical"
        color="primary"
        size="md"
        button="true"
        tooltip="More actions"
        dropdown-placement="bottom-start"
    />

    <x-filament-actions::modals />
</div>
