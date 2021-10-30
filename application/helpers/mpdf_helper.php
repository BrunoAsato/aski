<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pdf_create($html, $filename, $stream = TRUE, $footer = TRUE)
{
    require_once(APPPATH . 'helpers/mpdf/mpdf.php');
    $mpdf = new mPDF();
    //$mpdf->SetAutoFont(); 
    //$rodape = "<p>Relatório gerado em: " . date('d/m/Y');
    if ($footer) {
    $rodape = "<p></p><hr /><table width=\"1000\">
                   <tr>
                     <td style='font-size: 18px; padding-bottom: 20px;' align=\"left\">Sistema ASKI - Relatório gerado em: " . date('d/m/Y') . "</td>
                     <td style='font-size: 18px; padding-bottom: 20px;' align=\"right\">{PAGENO}</td>
                   </tr>
                 </table></p>";
    }
    // Imprime o pdf na tela                 
    if ($stream)
    {
        $mpdf->setHTMLFooter($rodape);
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename . '.pdf', 'I');
    }
    else
    {   
        // Força o download do arquivo .pdf
        $mpdf->setHTMLFooter($rodape);
        $mpdf->WriteHTML($html);
        $mpdf->Output('./uploads/temp/' . $filename . '.pdf', 'F');
        
        return './uploads/temp/' . $filename . '.pdf';
    }
}

?>
