<div {{ $attributes->class(['bg-gray-100']) }}><strong>ISSUED BY:</strong></div>
<div class="image-container">
    <img class="document-logo-large"
         src="{{request()->route()->named('bvdh.documents.preview') ? asset('logo.jpeg') :public_path('logo.jpeg')}}"
         alt="Image">
</div>
<div class="image-container">
    <p class="text-red">CANARY LOGISTICS LLC</p>
    <p class="text-blue">
        HEAD OFFICE: NO 202, HUSSAIN NASSERLOOTHA & SAUD HUMAIDAM BLDG, AL NAKHEEL ROAD, DEIRA, DUBAI, U.A.E.
        <br>www.canarylogisticsllc.com
    </p>
</div>
