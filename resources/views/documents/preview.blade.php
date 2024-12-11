@switch($model->type)
    @case ('airway_bill')
        @include('documents.templates.airway_bill',[
        'shipment' => $model->shipment,
        'reference' => $model->reference_number,
        'document' => $model,
    ])
        @break

    @case ('bill_of_lading')
        @include('documents.templates.bill_of_lading',[
        'shipment' => $model->shipment,
        'reference' => $model->reference_number,
        'document' => $model,
    ])
        @break

    @default
        Something went wrong
@endswitch
