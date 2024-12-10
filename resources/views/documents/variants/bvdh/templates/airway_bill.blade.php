<x-bvdh-document-layout>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td><strong> HOUSE AIRWAY BILL</strong></td>
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
                                <table>
                                    <tr>
                                        <td>
                                            <x-documents.single-detail-card
                                                title="TRACKING NUMBER"
                                                :text="$shipment->tracking_number"
                                            />
                                        </td>
                                        <td>
                                            <x-documents.single-detail-card
                                                title="AIRWAY BILL NUMBER"
                                                :text="$reference"
                                            />
                                        </td>
                                    </tr>
                                </table>
                                <div>
                                    <x-documents.detail-card-with-image
                                        title='EXPORT REFERENCES'
                                        :text="$document->export_reference"
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
                                    title="PLACE OF DEPARTURE"
                                    :text="$shipment->loading_port"
                                />
                            </td>
                            <td>
                                <x-documents.single-detail-card
                                    title="DATE OF DEPARTURE"
                                    :text="$shipment->date_of_shipment"
                                />
                            </td>
                            <td>
                                <x-documents.single-detail-card
                                    title="PLACE OF DESTINATION"
                                    :text="$shipment->discharge_port"
                                />
                            </td>
                            <td>
                                <x-documents.single-detail-card
                                    title="ESTIMATED TIME OF ARRIVAL"
                                    :text="$shipment->estimated_delivery"
                                />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <table>

                    <tr class="heading">
                        <td class="cell-width-half">DESCRIPTION OF PACKAGES</td>
                        <td>GROSS CARGO WEIGHT</td>
                        <td>MEASUREMENT</td>
                    </tr>

                    <tr class="details">
                        <td class="cell-width-half">{{$shipment->description}}</td>
                        <td>{{$shipment->weight}} {{$shipment->weight_unit}}</td>
                        <td>{!! $shipment->dimensions_in_html !!}</td>
                    </tr>
                </table>
            </tr>
            <tr>
                <x-documents.single-detail-card
                    title="ADDITIONAL CLAUSES"
                    :text="$document->additional_clause"
                />
            </tr>
        </table>
    </div>
</x-bvdh-document-layout>
