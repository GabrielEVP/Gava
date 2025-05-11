<?php

namespace App\Services;

use App\Interfaces\PDFGeneratorInterface;
use Barryvdh\DomPDF\Facade\Pdf;

class DomPDFGenerator implements PDFGeneratorInterface
{
    public function fromView(string $view, array $data): string
    {
        return Pdf::loadView($view, $data)->output();
    }
}

