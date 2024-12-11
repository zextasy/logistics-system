<!DOCTYPE html>
<html>
<head>
{{--    <meta charset="utf-8">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name', 'Document') }}</title>
    <style>
        /* Add your PDF styling here */
        body {
            font-family: "Courier New", monospace;
            line-height: 0.3;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 3px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 11px;
            line-height: 16px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;!important;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.top table td.title {
            /*font-size: 45px;*/
            /*line-height: 45px;*/
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 15px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
        /** Zee **/
        .document-logo{
            display: inline-block;
            vertical-align: top;
            float: right;
            margin-top: 0;
            width: 100px;
        }
        .cell-width-half {
            width: 50%;
        }
        /** Debug **/
        div{
            /*border: 1px solid saddlebrown;*/
        }

        tr{
            /*border: 1px solid red;*/
        }

        td{
            /*border: 1px solid green;*/
        }

        table{
            /*border: 1px solid blue;*/
        }

        /** Tailwind **/
        .flex{
            display: flex;
        }
        .flex-col {
            flex-direction: column;
        }
        .border {
            border:  1px solid #ddd;
        }
        .bg-gray-100{
            background: #eee;
        }
        .text-lg{
            font-size: 16px;
        }
        .text-sm{
            font-size: 11px;
        }
        .text-xs{
            font-size: 8px;
        }
        .w-full {
            width: 100%;
        }

    </style>
</head>
<body>
{{$slot}}
</body>
</html>
