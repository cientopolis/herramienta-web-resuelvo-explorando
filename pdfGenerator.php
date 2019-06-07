<?php
function initPdf() {
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Resuelvo Explorando');
	$pdf->SetTitle('Configuración del espacio');

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to print standard ASCII chars, you can use core fonts like helvetica or times to reduce file size.
	$pdf->SetFont('dejavusans', '', 14, '', true);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage();

	$pdf->setCellPaddings(1, 1, 1, 1);
	$pdf->setCellMargins(1, 1, 1, 1);
	ini_set('memory_limit','512M');
	return $pdf;
}

function imprimirEspaciosDeUso($pdf) {
	$pdf->writeHTML('<h1>Como configurar el espacio físico</h1><br>');
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Espacio de uso</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/deposit_to_deposit.jpg">', 1, 0, 0, true, 'C', true);
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Lugar inicial</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/default.jpg">', 1, 0, 0, true, 'C', true);
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Depósitos</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/deposits.jpg">', 1, 1, 0, true, 'C', true);
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Tarea 1</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/task1.jpg" >', 1, 0, 0, true, 'C', true);
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Tarea 2</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/task2.jpg" >', 1, 0, 0, true, 'C', true);
	$pdf->writeHTMLCell(60, 5, '', '', '<p>Tarea 3</p><img src="utils/ResuelvoExplorando'.$_GET['espaciosDeUso'].'/Configuracion/Imagenes/task3.jpg" >', 1, 1, 0, true, 'C', true);
	$pdf->AddPage();
}

function imprimirTareas($pdf){
	for ($i=1; $i<=3 ; $i++) {
		$files = glob('utils/CodigosQR/Elementos/T'.$i.'/*.*');
		if($files){
			$contador = 0;
			$pdf->writeHTML('<h3>Tarea '.$i.'</h3><br>');
			$pdf->writeHTMLCell(0, 5, '', '', "<img src=\"utils/CodigosQR/Tareas/tarea ".$i.".jpg\" >", 0, 1, 0, true, 'C', false);
			$pdf->writeHTML('<h5>Elementos:</h5><br>');
			foreach($files as $index => $file) {
				if (($index - 3) % 9 == 0)  {
					$pdf->AddPage();
				}
				$pdf->writeHTMLCell(60, 85, '', '', "<p>".get_string_between($file,'/T'.$i.'/','_')."</p><img src=\"".$file."\" >", 1, (($index + 1) % 3 == 0) || ($file === end($files)) ? 1 :0 , 0, true, 'C', true);
			}
		}
		$pdf->AddPage();
	}
}

function imprimirDepositos($pdf){
	$pdf->writeHTML('<h3>Depósitos</h3><br>');
	$files = glob('utils/CodigosQR/Depositos/*.*');
	if ($files) {
		foreach ($files as $file) {
			$pdf->writeHTMLCell(60, 5, '', '', "<p>".get_string_between($file,"Depositos/",'.jpg')."</p><img src=\"".$file."\" >", 1, 0, 0, true, 'C', false);
		}
	}
}

function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

?>
