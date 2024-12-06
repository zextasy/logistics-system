<x-bvdh-document-layout>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td><strong>BILL OF LADEN</strong></td>
                            <td> <img class="document-logo" src="{{request()->route()->named('bvdh.documents.preview') ? asset('logo.jpeg') :public_path('logo.jpeg')}}" alt="logo"></td>
                        </tr>
                        <tr>
                            <td>
                                <x-documents.person-details-card
                                    title='SHIPPER'
                                    :name="$shipment->shipper_name"
                                    :address="$shipment->shipper_address"
                                    :phone="$shipment->shipper_phone"
                                    :email="$shipment->shipper_email"
                                />
                                <x-documents.person-details-card
                                    title='CONSIGNEE'
                                    :name="$shipment->consignee_name"
                                    :address="$shipment->consignee_address"
                                    :phone="$shipment->consignee_phone"
                                    :email="$shipment->consignee_email"
                                />
                                <x-documents.person-details-card
                                    title='NOTIFY PARTY'
                                    title-hint="Carrier not to be responsible for failure to notify"
                                    :name="$shipment->receiver_name"
                                    :address="$shipment->receiver_address"
                                    :phone="$shipment->receiver_phone"
                                    :email="$shipment->receiver_email"
                                />
                            </td>
                            <td>
                                <span>
                                    <div>
                                        <x-documents.single-detail-card
                                            title="TRACKING NUMBER"
                                            :text="$shipment->tracking_number"
                                        />
                                        <x-documents.single-detail-card
                                            title="BILL OF LADING NUMBER"
                                            :text="$reference"
                                        />
                                    </div>
                                </span>
                                <div>
                                    <x-documents.detail-card-with-image
                                        title='EXPORT REFERENCES'
                                        text-heading="CARRIER: "
                                        text='lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum'
                                    />
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td>
                                <x-documents.single-detail-card
                                    title="VESSEL"
                                    :text="$shipment->vessel"
                                />
                            </td>

                            <td>
                                <x-documents.single-detail-card
                                    title="PORT OF LOADING"
                                    :text="$shipment->loading_port"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="PORT OF DISCHARGE"
                                    :text="$shipment->discharge_port"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="FINAL PLACE FOR DELIVERY"
                                    :text="$shipment->destination_city"
                                />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <table>

                    <tr class="heading">
                        <td>DESCRIPTION OF PACKAGES</td>
                        <td>GROSS CARGO WEIGHT</td>
                        <td>MEASUREMENT</td>
                    </tr>

                    <tr class="details">
                        <td>{{$shipment->cargo_description}}</td>
                        <td>{{$shipment->cargo_weight}} {{$shipment->cargo_weight_unit}}</td>
                        <td>{{implode($shipment->cargo_dimensions)}}</td>
                    </tr>
                </table>
            </tr>
            <tr>
                <x-documents.single-detail-card
                    title="ADDITIONAL CLAUSES"
                    text="Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum "
                />
            </tr>
        </table>
    </div>
</x-bvdh-document-layout>
