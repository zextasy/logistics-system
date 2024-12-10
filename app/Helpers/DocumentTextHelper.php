<?php

namespace App\Helpers;

use App\Models\Document;

class DocumentTextHelper
{
    public function getTextForDocumentAdditionalClause(Document $document): string
    {
        return match ($document->type) {
            'airway_bill' => $this->getTextForAirWayBillAdditionalClause(),
            'bill_of_lading' => $this->getTextForBillOfLadenAdditionalClause(),
            default => throw new \InvalidArgumentException("Invalid document type: {$document->type}")
        };
    }

    public function getTextForDocumentExportReference(Document $document): string
    {
        return match ($document->type) {
            'airway_bill' => $this->getTextForAirWayBillExportReference(),
            'bill_of_lading' => $this->getTextForBillOfLadenExportReference(),
            default => throw new \InvalidArgumentException("Invalid document type: {$document->type}")
        };
    }
    private function getTextForBillOfLadenAdditionalClause(): string
    {
        return "SHIPPED, as far as ascertained by reasonable means of checking, in apparent good order and condition unless otherwise stated herein, the total number or quantity of Containers or other packages or units indicated in the box entitled \"Carrier's Receipt\" for carriage from the Port of Loading (or the Place
of Receipt, if mentioned above) to the Port of Discharge (or the Place of Delivery, if mentioned above), such carriage being always subject to the terms, rights, defences, provisions, conditions, exceptions, limitations, and liberties hereof (INCLUDING ALL THOSE TERMS AND CONDITIONS ON THE REVERSE HEREOF NUMBERED 1-26 AND THOSE TERMS AND CONDITIONS CONTAINED IN THE CARRIER'S APPLICABLE TARIFF) and the Merchant's attention
is drawn in particular to the Carrier's liberties in respect of on deck stowage (see clause 18) and the carrying vessel (see clause 19). Where the bill of
lading is non-negotiable the Carrier may give delivery of the Goods to the named consignee upon reasonable proof of identity and without requiring
surrender of an original bill of lading. Where the bill of lading is negotiable, the Merchant is obliged to surrender one original, duly endorsed, in exchange for the Goods. The Carrier accepts a duty of reasonable care to check that any such document which the Merchant surrenders as a bill of lading is
genuine and original. If the Carrier complies with this duty, it will be entitled to deliver the Goods against what it reasonably believes to be a genuine and original bill of lading, such delivery discharging the Carrier’s delivery obligations. In accepting this bill of lading, any local customs or privileges to the contrary notwithstanding, the Merchant agrees to be bound by all T erms and Conditions stated herein whether written, printed, stamped or incorporated on the face or reverse side hereof, as fully as if they were all signed by the Merchant.
    IN WITNESS WHEREOF the number of original Bills of Lading stated on this side have been signed and wherever one original Bill of Lading has been surrendered any others shall be void.
    ";
    }

    private function getTextForAirWayBillAdditionalClause()
    {
        return "Shipper certifies that the parriculars on the face hereof are correct and that insofar as any oart of the consignment contains dangerous goods,such part is properly described by name and is in proper condition for carriage by air according to the applicable Dangerous Goods Regulations";
    }

    private function getTextForAirWayBillExportReference()
    {
        return "IT IS AGREED THAT THE GOODS DESCRIBED HEREIN ARE ACCEPTED IN APPARENT GOOD ORDER AND CONDITION(EXCEPT AS NOTED) FOR CARRIAGE SUBJECT TO THE CONDITIONS OF CONTRACT ON THE REVERSE HEREOF. ALL GOODS MAY BE CARRIED BY ANY OTHER MEANS INCLUDING ROAD OTR ANY OTHER CARRIER UNLESS SPECIFIC CONTRARY INSTRUCTIONS ARE GIVEN HEREON BY THE SHIPPER, AND SHIPPER AGREES THAT THE SHIPMENT MAY ME CARRIED VIA INTRMEDIATE STOPPING PLACES WHICH THE CARRIER DEEMS APPROPRIATE. THE SHIPPER'S ATTENTION IS DRWAN TO THE NOTICE CONCERNING CARRIER'S LIMITATION OF LIABILITY. SHIPPER MAY INCRESE SUCH LIMITATIONS OF LIABILITY BY DECLARING A HIGHER VALUE FOR CARRIAGE AND PAYING A SUPPLIMENTAL CHARGE IF REQUIRED.";
    }

    private function getTextForBillOfLadenExportReference()
    {
        return "CMA CGM Société Anonvme au
Cana de 234 988 330 Euros
Head Office: 4, quai d'Arenc - 13002 Marseille - Fra
A° 33 4 88 91 90 00- Fay (334 88 91
562 024 422 R.C.S. Marseille";
    }
}
