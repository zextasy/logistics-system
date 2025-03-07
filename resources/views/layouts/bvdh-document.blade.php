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
        }
        .header {
            text-align: center;
            /*margin-bottom: 20px;*/
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
            padding-bottom: 5px;
        }

        .invoice-box table tr.top table td.title {
            /*font-size: 45px;*/
            /*line-height: 45px;*/
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 5px;
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
        #watermark {
            position: fixed;
            top: 35%;
            width: 100%;
            text-align: center;
            opacity: .10;
            transform: rotate(10deg);
            transform-origin: 50% 50%;
            /*z-index: -1000;*/
            font-family: sans-serif;
            font-size: 50px;
        }
        .document-logo{
            display: inline-block;
            vertical-align: top;
            /*float: right;*/
            margin-top: 0;
            width: 100px;
        }
        .document-logo-large{
            display: inline-block;
            vertical-align: top;
            /*float: right;*/
            margin-top: 0;
            width: 200px;
        }
        .width-half {
            width: 50%;
        }
        .height-lg{
            min-height: 250px;
            max-height: 275px;
        }
        .height-xl{
            min-height: 300px;
            max-height: 325px;
        }
        .image-container {
            text-align: center;
        }
        .bottom-element {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 100%; /* Adjust width as needed */
        }
        .text-red{
            color: red;
        }
        .text-blue{
            color: blue;
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
            font-size: 19px;
            line-height: 21px;
        }
        .text-sm{
            font-size: 13px;
            line-height: 15px;
        }
        .text-xs{
            font-size: 9px;
            line-height: 11px;
        }
        .text-xxs{
            font-size: 5px;
            line-height: 6px;
        }
        .w-full {
            width: 100%;
        }
        .mb-10 {
            margin-bottom: 20px;
        }
        .mt-0 {
            margin-top: 0;
        }
        .pb-10 {
            padding-bottom: 10px;
        }
        .p-0 {
            padding: 0;
        }
        .mx-auto{
            margin-left: auto;
            margin-right: auto;
        }


    </style>
</head>
<body>
{{$slot}}
<div class="image-container bottom-element">
    www.canarylogisticsllc.com
</div>
</body>
</html>
