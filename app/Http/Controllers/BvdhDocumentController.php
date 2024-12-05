<?php

namespace App\Http\Controllers;


use App\Models\Document;
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
        return view('documents.variants.bvdh.preview', $data);
    }

    public function download(Document $document)
    {
        $data['model'] = $document;
        return pdf()
            ->view('documents.variants.bvdh.preview', $data)
            ->format('a4') ->margins(0, 0, 0, 0, Unit::Centimeter)
            ->name('project-'.now()->format('Y-m-d').'.pdf')
            ->download();
    }
}

