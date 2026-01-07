<?php

class ReportsController
{
    public function download(): void
    {
        $template = isset($_GET['template']) ? basename((string)$_GET['template']) : '';
        $source = isset($_GET['source']) ? (string)$_GET['source'] : 'formulario';
        $templateByRoute = [
            'email_templates/create' => 'informeIcargaEnglish.php',
            'email_templates/edit' => 'informeIcargaEnglish.php',
            'purchases/create' => 'informeIcargaEnglish.php',
            'treasury/transaction-edit' => 'informeIcargaEnglish.php',
            'treasury/account-edit' => 'informeIcargaEnglish.php',
            'products/create' => 'informeIcargaEnglish.php',
            'products/edit' => 'informeIcargaEnglish.php',
            'taxes/period-edit' => 'informeIcargaEnglish.php',
            'taxes/withholding-edit' => 'informeIcargaEnglish.php',
            'roles/create' => 'informeIcargaEnglish.php',
            'roles/edit' => 'informeIcargaEnglish.php',
            'companies/create' => 'informeIcargaEnglish.php',
            'companies/edit' => 'informeIcargaEnglish.php',
            'services/create' => 'informeIcargaEnglish.php',
            'services/edit' => 'informeIcargaEnglish.php',
            'sales/create' => 'informeIcargaEnglish.php',
            'fixed-assets/create' => 'informeIcargaEnglish.php',
            'fixed-assets/edit' => 'informeIcargaEnglish.php',
            'quotes/create' => 'informeIcargaEnglish.php',
            'quotes/edit' => 'informeIcargaEnglish.php',
            'hr/payrolls/create' => 'informeIcargaEnglish.php',
            'hr/contracts/create' => 'informeIcargaEnglish.php',
            'hr/contracts/edit' => 'informeIcargaEnglish.php',
            'hr/attendance/create' => 'informeIcargaEnglish.php',
            'hr/employees/create' => 'informeIcargaEnglish.php',
            'hr/employees/edit' => 'informeIcargaEnglish.php',
            'tickets/create' => 'informeIcargaEnglish.php',
            'suppliers/create' => 'informeIcargaEnglish.php',
            'suppliers/edit' => 'informeIcargaEnglish.php',
            'users/create' => 'informeIcargaEnglish.php',
            'users/edit' => 'informeIcargaEnglish.php',
            'projects/create' => 'informeIcargaEnglish.php',
            'projects/edit' => 'informeIcargaEnglish.php',
            'inventory/movement-edit' => 'informeIcargaEnglish.php',
            'clients/create' => 'informeIcargaEnglish.php',
            'clients/edit' => 'informeIcargaEnglish.php',
            'accounting/journals-create' => 'informeIcargaEnglish.php',
            'accounting/chart-create' => 'informeIcargaEnglish.php',
            'accounting/chart-edit' => 'informeIcargaEnglish.php',
            'honorarios/create' => 'informeIcargaEnglish.php',
            'invoices/create' => 'informeIcargaEnglish.php',
            'invoices/edit' => 'informeIcargaEnglish.php',
        ];
        $titlesByRoute = [
            'email_templates/create' => 'Informe plantilla de correo',
            'email_templates/edit' => 'Informe plantilla de correo',
            'purchases/create' => 'Informe de compra',
            'treasury/transaction-edit' => 'Informe de transacción',
            'treasury/account-edit' => 'Informe de cuenta',
            'products/create' => 'Informe de producto',
            'products/edit' => 'Informe de producto',
            'taxes/period-edit' => 'Informe de periodo tributario',
            'taxes/withholding-edit' => 'Informe de retención',
            'roles/create' => 'Informe de rol',
            'roles/edit' => 'Informe de rol',
            'companies/create' => 'Informe de empresa',
            'companies/edit' => 'Informe de empresa',
            'services/create' => 'Informe de servicio',
            'services/edit' => 'Informe de servicio',
            'sales/create' => 'Informe de venta',
            'fixed-assets/create' => 'Informe de activo fijo',
            'fixed-assets/edit' => 'Informe de activo fijo',
            'quotes/create' => 'Informe de cotización',
            'quotes/edit' => 'Informe de cotización',
            'hr/payrolls/create' => 'Informe de nómina',
            'hr/contracts/create' => 'Informe de contrato',
            'hr/contracts/edit' => 'Informe de contrato',
            'hr/attendance/create' => 'Informe de asistencia',
            'hr/employees/create' => 'Informe de empleado',
            'hr/employees/edit' => 'Informe de empleado',
            'tickets/create' => 'Informe de ticket',
            'suppliers/create' => 'Informe de proveedor',
            'suppliers/edit' => 'Informe de proveedor',
            'users/create' => 'Informe de usuario',
            'users/edit' => 'Informe de usuario',
            'projects/create' => 'Informe de proyecto',
            'projects/edit' => 'Informe de proyecto',
            'inventory/movement-edit' => 'Informe de movimiento de inventario',
            'clients/create' => 'Informe de cliente',
            'clients/edit' => 'Informe de cliente',
            'accounting/journals-create' => 'Informe de asiento contable',
            'accounting/chart-create' => 'Informe de plan de cuentas',
            'accounting/chart-edit' => 'Informe de plan de cuentas',
            'honorarios/create' => 'Informe de honorarios',
            'invoices/create' => 'Informe de factura',
            'invoices/edit' => 'Informe de factura',
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
        $title = $titlesByRoute[$source] ?? 'Informe de formulario';
        $pdf->SetTitle($title);
        $pdf->SetAutoPageBreak(true, 18);

        $pdf->SetFillColor(37, 99, 235);
        $pdf->Rect(0, 0, 210, 18, 'F');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(14, 6);
        $pdf->Cell(0, 6, $title, 0, 1, 'L');

        $pdf->SetTextColor(31, 41, 55);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(14, 24);
        $pdf->Cell(0, 6, 'Formulario: ' . $source, 0, 1, 'L');
        $pdf->Cell(0, 6, 'Plantilla base: ' . pathinfo($template, PATHINFO_FILENAME), 0, 1, 'L');
        $pdf->Ln(4);

        $pdf->SetFillColor(243, 244, 246);
        $pdf->SetDrawColor(229, 231, 235);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(60, 8, 'Campo', 1, 0, 'L', true);
        $pdf->Cell(0, 8, 'Valor', 1, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);

        $items = [];
        $walker = function ($data, $prefix = '') use (&$items, &$walker) {
            foreach ((array)$data as $key => $value) {
                $label = $prefix === '' ? (string)$key : $prefix . '.' . $key;
                if (is_array($value)) {
                    $walker($value, $label);
                } else {
                    $items[] = [$label, (string)$value];
                }
            }
        };
        $walker($_POST);

        if ($items === []) {
            $items[] = ['Sin datos', 'El formulario no contiene valores en este momento.'];
        }

        foreach ($items as [$label, $value]) {
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(55, 65, 81);
            $pdf->Cell(60, 7, mb_substr($label, 0, 30), 1, 0, 'L', false);
            $pdf->MultiCell(0, 7, mb_substr($value, 0, 120), 1, 'L');
        }

        $filename = 'informe-' . preg_replace('/[^a-z0-9\\-]+/i', '-', pathinfo($template, PATHINFO_FILENAME)) . '.pdf';
        $pdf->Output('D', $filename);
    }
}
