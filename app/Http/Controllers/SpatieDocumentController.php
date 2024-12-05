<?php

namespace App\Http\Controllers;


use App\Models\Document;
use Spatie\LaravelPdf\Enums\Unit;
use function Spatie\LaravelPdf\Support\pdf;

class SpatieDocumentController
{

    public function preview(Document $document)
    {
        $data['model'] = $document;
        return view('documents.variants.spatie.preview', $data);
    }

    public function previewPdf(Document $document)
    {
        $data['model'] = $document;
        return pdf()
            ->view('documents.variants.spatie.preview', $data)
            ->format('a4') ->margins(0, 0, 0, 0, Unit::Centimeter)
            ->name('project-'.now()->format('Y-m-d').'.pdf');
    }

    public function download(Document $document)
    {
        $data['model'] = $document;
        return pdf()
            ->view('documents.variants.spatie.preview', $data)
            ->format('a4') ->margins(0, 0, 0, 0, Unit::Centimeter)
            ->name('project-'.now()->format('Y-m-d').'.pdf')
            ->download();
    }
}

