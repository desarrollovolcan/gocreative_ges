<?php

require_once __DIR__ . '/InvoiceTemplatePDF.php';

function generate_form_report(array $config): void
{
    $title = $config['title'] ?? 'Informe de formulario';
    $source = $config['source'] ?? 'formulario';
    $template = $config['template'] ?? 'plantilla';

    $normalizeText = static function ($text): string {
        $text = (string)($text ?? '');
        $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
        return $converted !== false ? $converted : utf8_decode($text);
    };

    $pdf = new InvoiceTemplatePDF('P', 'mm', 'Letter');
    $pdf->AliasNbPages();
    $pdf->docTitle = $normalizeText($title);
    $pdf->docSubTitle = $normalizeText('Informe generado para el formulario solicitado');
    $pdf->brandName = $normalizeText('GoCreative GES');
    $pdf->brandRUT = $normalizeText('76.123.456-7');
    $pdf->brandAddress = $normalizeText('Gestión Empresarial y Servicios');
    $pdf->brandContact = $normalizeText('soporte@gocreative.cl • +56 9 0000 0000 • gocreative.cl');
    $pdf->footerLeft = $normalizeText('Documento generado automáticamente');
    $pdf->SetTitle($normalizeText($title));
    $pdf->AddPage();

    $actionLabel = 'Detalle';
    if (strpos($source, 'create') !== false) {
        $actionLabel = 'Creación';
    } elseif (strpos($source, 'edit') !== false) {
        $actionLabel = 'Actualización';
    }

    $pdf->Section(
        $normalizeText('Resumen del formulario'),
        $normalizeText('Información base del reporte vinculado al formulario.')
    );
    $pdf->FieldGrid([
        ['label' => $normalizeText('Formulario'), 'value' => $normalizeText($source)],
        ['label' => $normalizeText('Acción'), 'value' => $normalizeText($actionLabel)],
        ['label' => $normalizeText('Plantilla base'), 'value' => $normalizeText(pathinfo($template, PATHINFO_FILENAME))],
        ['label' => $normalizeText('Fecha de generación'), 'value' => $normalizeText(date('d/m/Y H:i'))],
    ], 2);

    $pdf->Section(
        $normalizeText('Detalle del informe'),
        $normalizeText('Cada formulario tiene su propio informe generado con la plantilla de diseño.')
    );
    $pdf->NotesBlock(
        $normalizeText('Observaciones'),
        $normalizeText('Este documento fue generado con FPDF usando la plantilla de informes y corresponde al formulario solicitado.')
    );

    $filename = 'informe-' . preg_replace('/[^a-z0-9\\-]+/i', '-', pathinfo($template, PATHINFO_FILENAME)) . '.pdf';
    $pdf->Output('D', $filename);
    exit;
}
