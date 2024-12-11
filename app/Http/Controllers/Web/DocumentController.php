<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\LaravelPdf\Enums\Unit;


class DocumentController extends Controller
{

    public function preview(Document $document)
    {
        $data['model'] = $document;
        return view('documents.preview', $data);
    }

    public function previewPdf(Document $document)
    {
        $data['model'] = $document;
        $pdf = PDF::loadView('documents.preview', $data);
        return $pdf->stream();
    }

    public function download(Document $document)
    {
        $data['model'] = $document;

        $pdf = PDF::loadView('documents.preview', $data);
        return $pdf->download();
    }
}

