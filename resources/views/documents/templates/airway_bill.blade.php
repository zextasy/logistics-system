<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Waybill</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;  /* Changed from #f8f9fa for PDF */
            color: #333;
        }

        .container {
            width: 210mm;
            height: 297mm;
            margin: 0;          /* Changed from auto for PDF */
            background: #fff;
            padding: 20mm;
            box-sizing: border-box;
            /* Removed box-shadow for PDF */
        }

        /* Ensure no page breaks inside elements */
        .detail-box,
        table,
        .additional {
            page-break-inside: avoid;
        }

        /* Rest of your styles remain the same, but let's optimize for print */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;  /* Changed from #ddd for better print contrast */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* ... rest of existing styles ... */

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .container {
                box-shadow: none;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 1.8em;
            margin: 0;
            color: #007bff;
        }

        .header img {
            height: 50px;
        }

        .details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-box {
            flex: 1 1 calc(33.333% - 20px);
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .detail-box.highlight {
            background: #eef7ff;
            border-color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #f1f1f1;
        }

        .additional {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 0.9em;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>House Airway Bill</h1>
        <img src="logo.png" alt="Company Logo">
    </div>

    <div class="details">
        <div class="detail-box highlight">
            <strong>Shipper:</strong><br>
            Stephanie Boms<br>
            Lagos<br>
            08057545445<br>
            stefanie07@gmail.com
        </div>
        <div class="detail-box">
            <strong>Consignee:</strong><br>
            Stephanie Boms<br>
            Home<br>
            stefanie07@gmail.com
        </div>
        <div class="detail-box">
            <strong>Tracking Number:</strong> ATLA-4013<br>
            <strong>Airway Bill Number:</strong> AWB-50KCL7EA
        </div>
    </div>

    <div class="details">
        <div class="detail-box">
            <strong>Export References:</strong><br>
            The goods described herein are accepted in apparent good order and condition (except as noted) for carriage subject to the conditions of contract on the reverse hereof. All goods may be carried by any other means, including road or other carriers, unless specific contrary instructions are given herein by the shipper.
        </div>
        <div class="detail-box">
            <strong>Notify Party:</strong><br>
            Stephanie Boms<br>
            8966669<br>
            stefanie07@gmail.com<br>
            (Carrier not responsible for failure to notify)
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Description of Packages</th>
            <th>Gross Cargo Weight</th>
            <th>Measurement</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Goodies</td>
            <td>17 kg</td>
            <td>Length:<br>Length: 12 cm,<br> Width: 12 cm,<br> Height: 12 cm
            </td>
        </tr>
        </tbody>
    </table>

    <div class="details">
        <div class="detail-box">
            <strong>Place of Departure:</strong><br>
            Northpole
        </div>
        <div class="detail-box">
            <strong>Date of Departure:</strong><br>
            December 11, 2024
        </div>
        <div class="detail-box">
            <strong>Place of Destination:</strong><br>
            Port
        </div>
        <div class="detail-box">
            <strong>Estimated Time of Arrival:</strong><br>
            10:50 AM
        </div>
    </div>

    <div class="additional">
        <strong>Additional Clauses:</strong><br>
        Shipper certifies that the particulars on the face hereof are correct and that insofar as any part of the consignment contains dangerous goods, such part is properly described by name and is in proper condition for carriage by air according to the applicable Dangerous Goods Regulations.
    </div>

    <div class="footer">
        &copy; 2024 Canary Logistics. All rights reserved.
    </div>
</div>
</body>
</html>
