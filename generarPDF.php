<?php
require_once('libs\TCPDF\tcpdf.php');
require 'pdfGenerator.php';

$pdf = initPdf();

if (isset($_GET['verEspacios'])) {
	imprimirEspaciosDeUso($pdf);
}
if (isset($_GET['verQRs'])) {
	imprimirTareas($pdf);
	imprimirDepositos($pdf);
}

// Close and output PDF document
$pdf->Output('Instructivo.pdf', 'I');

?>
