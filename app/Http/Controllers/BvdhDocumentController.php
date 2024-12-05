<?php

namespace App\Http\Controllers;


use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\LaravelPdf\Enums\Unit;


class BvdhDocumentController
{

    public function preview(Document $document)
    {
        $data['model'] = $document;
        return view('documents.variants.bvdh.preview', $data);
    }

    public function previewPdf(Document $document)
    {
        $data['model'] = $document;
        $pdf = PDF::loadView('documents.variants.bvdh.preview', $data);
        return $pdf->stream();
    }

    public function download(Document $document)
    {
        $data['model'] = $document;

        $pdf = PDF::loadView('documents.variants.bvdh.preview', $data);
        return $pdf->download();
    }
}

