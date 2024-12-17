
<x-document-layout>
    <div class="flex-col">
        <div class="header flex justify-between">
            <div class="w-1/2 pt-4">
                <x-documents.person-details-card
                            title='SHIPPER'
                            :name="$shipment->shipper_name"
                            :address="$shipment->shipper_address"
                            :phone="$shipment->shipper_phone"
                            :email="$shipment->shipper_email"
                />
                <x-documents.person-details-card
                    title='CONSIGNEE'
                    :name="$shipment->notify_party_name"
                    :address="$shipment->notify_party_address"
                    :phone="$shipment->notify_party_phone"
                    :email="$shipment->notify_party_email"
                />
                <x-documents.person-details-card
                    title='NOTIFY PARTY'
                    title-hint="Carrier not to be responsible for failure to notify"
                    :name="$shipment->notify_party_name"
                    :address="$shipment->notify_party_address"
                    :phone="$shipment->notify_party_phone"
                    :email="$shipment->notify_party_email"
                />
            </div>
            <div class="w-1/2 flex-col">
                <div class="h-1/3 flex justify-between">
                    <div class="w-6/10 flex">
                    <span class="mx-auto my-auto">
                        <h1 class="text-xl font-extrabold">BILL OF LADING</h1>
                    </span>
                    </div>
                    <div class="w-4/10">
                        <x-documents.single-detail-card
                            title="TRACKING NUMBER"
                            :text="$shipment->tracking_number"
                        />
                        <x-documents.single-detail-card
                            title="BILL OF LADING NUMBER"
                            :text="$reference"
                        />
                    </div>
                </div>
                <div class="">
                    <x-documents.detail-card-with-image
                        title='EXPORT REFERENCES'
                        text-heading="CARRIER: "
                        text='lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum'
                    />
                </div>
            </div>
        </div>
        <div></div>

        {{--<div class="section">--}}
        {{--    <h3>Vessel Details</h3>--}}
        {{--    <p>Vessel Name: {{ $data['vessel_name'] }}</p>--}}
        {{--    <p>Voyage Number: {{ $data['voyage_number'] }}</p>--}}
        {{--    <p>Port of Loading: {{ $data['port_of_loading'] }}</p>--}}
        {{--    <p>Port of Discharge: {{ $data['port_of_discharge'] }}</p>--}}
        {{--</div>--}}

        {{--<div class="section">--}}
        {{--    <h3>Container Details</h3>--}}
        {{--    <p>Container Numbers: {{ $data['container_numbers'] }}</p>--}}
        {{--    <p>Seal Numbers: {{ $data['seal_numbers'] }}</p>--}}
        {{--</div>--}}

        <div class="section">
            <h3>Cargo Details</h3>
            <p>Description: {{ $shipment->description }}</p>
            <p>Weight: {{ $shipment->weight .' '. $shipment->weight_unit}}</p>
        </div>
    </div>

</x-document-layout>

