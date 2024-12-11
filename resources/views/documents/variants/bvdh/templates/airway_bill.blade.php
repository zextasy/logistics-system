<x-bvdh-document-layout>
    <div class="invoice-box">
        <div class="logo-div"><img class="document-logo" src="{{request()->route()->named('bvdh.documents.preview') ? asset('logo.jpeg') :public_path('logo.jpeg')}}" alt="logo"></div>
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td >
                    <table>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="text-lg"><strong> HOUSE AIRWAY BILL</strong></td>
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
                <td>
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
            <tr class="">
                <td>
                    <table class="">
                        <tr class="heading">
                            <td class="cell-width-half">DESCRIPTION OF PACKAGES</td>
                            <td>GROSS CARGO WEIGHT</td>
                            <td>MEASUREMENT</td>
                        </tr>
                        <tr class="details">
                            <td class="cell-width-half">{{$shipment->description}}</td>
                            <td>{{$shipment->weight}} {{$shipment->weight_unit}}</td>
                            <td>{!! $shipment->dimensions_summarized !!}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <x-documents.single-detail-card-tiny-text
                        title="ADDITIONAL CLAUSES"
                        :text="$document->additional_clause"
                    />
                </td>
            </tr>
        </table>
    </div>
</x-bvdh-document-layout>
