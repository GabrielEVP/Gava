<?php

namespace App\Interfaces;

interface PDFGeneratorInterface
{
    public function fromView(string $view, array $data): string;
}
