<div>
    <x-filament-actions::group
        :actions="[
            $this->confirmShipmentDateAction,
            $this->previewInitialDocumentAction,
            $this->previewInitialPdfAction,
            $this->downloadInitialDocumentAction,
            $this->editShipmentDetailsAction,
            $this->editOriginAndDestinationDetailsAction,
            $this->editContactDetailsAction,
            $this->editExtraDetailsAction
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
