<x-bvdh-document-layout>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td >
                    <table>
                        <tr class="mb-10">
                            <td class="text-lg"><strong>{{$shipment->container_size == \App\Enums\ContainerSizeEnum::LCL ? 'HOUSE ' : '' }}BILL OF LADEN</strong></td>
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
                                    title="DATE OF DEPARTURE"
                                    :text="$shipment->date_of_shipment"
                                />
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <x-documents.single-detail-card
                                    title="PORT OF DISCHARGE"
                                    :text="$shipment->discharge_port"
                                />
                            </td>
                            <td>
                                <x-documents.single-detail-card
                                    title="ESTIMATED TIME OF ARRIVAL"
                                    :text="$shipment->estimated_delivery"
                                />
                            </td>
                            <td>
                                <x-documents.single-detail-card
                                    title="FINAL PLACE FOR DELIVERY"
                                    :text="$shipment->final_place_for_delivery"
                                />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr class="heading">
                            <td class="cell-width-half">DESCRIPTION OF PACKAGES</td>
                            <td>GROSS CARGO WEIGHT</td>
                            <td>MEASUREMENT</td>
                        </tr>
                        <tr class="details">
                            <td class="cell-width-half">{{$shipment->description}} &nbsp;</td>
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
