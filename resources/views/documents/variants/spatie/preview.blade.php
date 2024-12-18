@switch($model->type)
    @case ('airway_bill')
        @include('documents.variants.spatie.templates.airway_bill',[
            'shipment' => $model->shipment,
            'reference' => $model->reference_number
        ])
        @break

    @case ('bill_of_lading')
        @include('documents.variants.spatie.templates.bill_of_lading',[
            'shipment' => $model->shipment,
            'reference' => $model->reference_number
        ])
        @break

    @default
        Something went wrong
@endswitch
