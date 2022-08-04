<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService 
{

    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }















}