<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/pdf-source.php');
    $content = ob_get_clean();

    if($dominio=='localhost'){
        require_once(dirname(__FILE__).'/../../../library/html2pdf/vendor/autoload.php');
    }else{
        require_once(dirname(__FILE__).'/../library/html2pdf/vendor/autoload.php');
    }
    // convert to PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'letter', 'es');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('orden.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

