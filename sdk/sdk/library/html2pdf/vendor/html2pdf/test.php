<?php
    $content = "
<page>
    <h1>Ejemplo de utilización</h1>
    <br>
    Este es un <b>ejemplo de utilización</b>
    de <a href='http://html2pdf.fr/'>HTML2PDF</a>.
    <div>
    	Este es un div
    </div>
</page>";
	require_once('../autoload.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
?>
