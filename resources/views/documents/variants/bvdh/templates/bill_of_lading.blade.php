<x-bvdh-document-layout>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td><strong>BILL OF LADEN</strong></td>
                            <td><img src="{{asset('logo.jpeg')}}" alt="logo" width="120px" style="float: right"></td>
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
                                    :name="$shipment->receiver_name"
                                    :address="$shipment->receiver_address"
                                    :phone="$shipment->receiver_phone"
                                    :email="$shipment->receiver_email"
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
                                    title="PRE CARRIAGE BY"
                                    text="Text"
                                />
                            </td>

                            <td>
                                <x-documents.single-detail-card
                                    title="PLACE OF RECEIPT"
                                    text="Text"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="FREIGHT TO BE PAID AT"
                                    text="Text"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="NO. OF ORIGINAL BILLS OF LANDING"
                                    text="Text"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <x-documents.single-detail-card
                                    title="VESSEL"
                                    text="Text"
                                />
                            </td>

                            <td>
                                <x-documents.single-detail-card
                                    title="PORT OF LOADING"
                                    text="Text"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="PORT OF DISCHARGE"
                                    text="Text"
                                />
                            </td>
                                                        <td>
                                <x-documents.single-detail-card
                                    title="FINAL PLACE FOR DELIVERY"
                                    text="Text"
                                />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <table>

                    <tr class="heading">
                        <td>MARKS AND NOS CONTAINER AND SEALS</td>
                        <td>NO AND KIND OF PACKAGES</td>
                        <td>DESCRIPTION OF PACKAGES</td>
                        <td>GROSS CARGO WEIGHT</td>
                        <td>TARE</td>
                        <td>MEASUREMENT</td>
                    </tr>

                    <tr class="details">
                        <td>Text</td>
                        <td>Text</td>
                        <td>Long Text</td>
                        <td>10</td>
                        <td>100</td>
                        <td>20</td>
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
