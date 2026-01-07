<?php

class ReportsController
{
    public function download(): void
    {
        $template = isset($_GET['template']) ? basename((string)$_GET['template']) : '';
        $source = isset($_GET['source']) ? (string)$_GET['source'] : 'formulario';
        $templateByRoute = [
            'email_templates/create' => 'informeIcargaEspanol.php',
            'email_templates/edit' => 'informeIcargaEspanol.php',
            'purchases/create' => 'informeIcargaEspanol.php',
            'treasury/transaction-edit' => 'informeIcargaEspanol.php',
            'treasury/account-edit' => 'informeIcargaEspanol.php',
            'products/create' => 'informeIcargaEspanol.php',
            'products/edit' => 'informeIcargaEspanol.php',
            'taxes/period-edit' => 'informeIcargaEspanol.php',
            'taxes/withholding-edit' => 'informeIcargaEspanol.php',
            'roles/create' => 'informeIcargaEspanol.php',
            'roles/edit' => 'informeIcargaEspanol.php',
            'companies/create' => 'informeIcargaEspanol.php',
            'companies/edit' => 'informeIcargaEspanol.php',
            'services/create' => 'informeIcargaEspanol.php',
            'services/edit' => 'informeIcargaEspanol.php',
            'sales/create' => 'informeIcargaEspanol.php',
            'fixed-assets/create' => 'informeIcargaEspanol.php',
            'fixed-assets/edit' => 'informeIcargaEspanol.php',
            'quotes/create' => 'informeIcargaInvoice.php',
            'quotes/edit' => 'informeIcargaInvoice.php',
            'hr/payrolls/create' => 'informeIcargaEspanol.php',
            'hr/contracts/create' => 'informeIcargaEspanol.php',
            'hr/contracts/edit' => 'informeIcargaEspanol.php',
            'hr/attendance/create' => 'informeIcargaEspanol.php',
            'hr/employees/create' => 'informeIcargaEspanol.php',
            'hr/employees/edit' => 'informeIcargaEspanol.php',
            'tickets/create' => 'informeIcargaEspanol.php',
            'suppliers/create' => 'informeIcargaEspanol.php',
            'suppliers/edit' => 'informeIcargaEspanol.php',
            'users/create' => 'informeIcargaEspanol.php',
            'users/edit' => 'informeIcargaEspanol.php',
            'projects/create' => 'informeIcargaEspanol.php',
            'projects/edit' => 'informeIcargaEspanol.php',
            'inventory/movement-edit' => 'informeIcargaEspanol.php',
            'clients/create' => 'informeIcargaEspanol.php',
            'clients/edit' => 'informeIcargaEspanol.php',
            'accounting/journals-create' => 'informeIcargaEspanol.php',
            'accounting/chart-create' => 'informeIcargaEspanol.php',
            'accounting/chart-edit' => 'informeIcargaEspanol.php',
            'honorarios/create' => 'informeIcargaEspanol.php',
            'invoices/create' => 'informeIcargaInvoice.php',
            'invoices/edit' => 'informeIcargaInvoice.php',
        ];

        $reportsDir = __DIR__ . '/../../documento';
        if ($template === '' || !is_dir($reportsDir)) {
            http_response_code(404);
            echo 'Plantilla no encontrada.';
            return;
        }

        if (!isset($templateByRoute[$source]) || $templateByRoute[$source] !== $template) {
            http_response_code(404);
            echo 'Plantilla no encontrada.';
            return;
        }

        $templatePath = $reportsDir . '/' . $template;
        if (!is_file($templatePath)) {
            http_response_code(404);
            echo 'Plantilla no encontrada.';
            return;
        }

        require_once __DIR__ . '/../../api/fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetTitle('Informe de formulario');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Informe de formulario', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Formulario: ' . $source, 0, 1, 'L');
        $pdf->Cell(0, 8, 'Plantilla base: ' . pathinfo($template, PATHINFO_FILENAME), 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->MultiCell(0, 6, 'Este reporte usa FPDF como generador. La plantilla indicada proviene de la carpeta documento/.');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 5, 'Este PDF corresponde al formulario actual y sirve como referencia de formato para el reporte asociado.');

        $filename = 'informe-' . preg_replace('/[^a-z0-9\\-]+/i', '-', pathinfo($template, PATHINFO_FILENAME)) . '.pdf';
        $pdf->Output('D', $filename);
    }
}
