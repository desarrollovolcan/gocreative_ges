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

        require_once __DIR__ . '/../reports/InvoiceTemplatePDF.php';

        $title = $titlesByRoute[$source] ?? 'Informe de formulario';
        $pdf = new InvoiceTemplatePDF('P', 'mm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 18);
        $pdf->SetMargins($pdf->mx, 24, $pdf->mx);

        $pdf->brandName = 'Go Creative SpA';
        $pdf->brandRUT = '15.626.773-2';
        $pdf->brandAddress = 'Santiago, Chile';
        $pdf->brandContact = 'contacto@gocreative.cl • +56 9 0000 0000 • gocreative.cl';
        $pdf->docTitle = strtoupper($title);
        $pdf->docSubTitle = 'Plantilla base reutilizable (minimalista)';
        $pdf->footerLeft = 'Generado por sistema • Conserva este documento como respaldo';

        $pdf->AddPage();

        $pdf->Section('Datos del documento', 'Resumen de los valores capturados en el formulario.');
        $fieldsDoc = [];
        $skipKeys = ['csrf_token'];
        foreach ($_POST as $key => $value) {
            if (in_array($key, $skipKeys, true)) {
                continue;
            }
            if (is_array($value)) {
                continue;
            }
            $label = ucwords(str_replace(['_', '-'], ' ', (string)$key));
            $fieldsDoc[] = ['label' => $label, 'value' => (string)$value];
        }
        if ($fieldsDoc === []) {
            $fieldsDoc[] = ['label' => 'Sin datos', 'value' => 'El formulario no contiene valores ingresados.'];
        }
        $pdf->FieldGrid($fieldsDoc, cols: 3);

        $estado = isset($_POST['estado']) ? strtoupper((string)$_POST['estado']) : 'REGISTRO';
        $chipX = $pdf->GetPageWidth() - $pdf->mx - 42;
        $chipY = 42;
        $pdf->StatusChip($estado, [229, 231, 235], [55, 65, 81], $chipX, $chipY);

        if (!empty($_POST['items']) && is_array($_POST['items'])) {
            $pdf->Section('Detalle de ítems', 'Listado de ítems incluidos en el formulario.');
            $headers = ['Descripción', 'Cant.', 'Precio', 'Impuesto', 'Total'];
            $widths = [90, 14, 24, 20, 24];
            $rows = [];
            foreach ((array)$_POST['items'] as $item) {
                $rows[] = [
                    (string)($item['descripcion'] ?? $item['name'] ?? ''),
                    (string)($item['cantidad'] ?? $item['qty'] ?? ''),
                    (string)($item['precio_unitario'] ?? $item['price'] ?? ''),
                    (string)($item['impuesto_pct'] ?? $item['tax'] ?? ''),
                    (string)($item['total'] ?? ''),
                ];
            }
            if ($rows !== []) {
                $pdf->DataTable($headers, $rows, $widths, aligns: ['L', 'R', 'R', 'R', 'R']);
            }
        }

        $totals = [];
        if (isset($_POST['subtotal'])) {
            $totals[] = ['label' => 'Subtotal', 'value' => (string)$_POST['subtotal'], 'bold' => true];
        }
        if (isset($_POST['impuestos'])) {
            $totals[] = ['label' => 'Impuestos', 'value' => (string)$_POST['impuestos']];
        }
        if (isset($_POST['total'])) {
            $totals[] = ['label' => 'Total', 'value' => (string)$_POST['total'], 'bold' => true, 'big' => true];
        }
        if ($totals !== []) {
            $pdf->TotalsBlock($totals);
        }

        if (!empty($_POST['notas'])) {
            $pdf->NotesBlock('Observaciones', (string)$_POST['notas']);
        }

        $pdf->Section('Firma / Aprobación');
        $pdf->FieldGrid([
            ['label' => 'Responsable', 'value' => '________________________'],
            ['label' => 'Cargo', 'value' => '________________________'],
            ['label' => 'Fecha', 'value' => '________________________'],
        ], cols: 3);

        $filename = 'informe-' . preg_replace('/[^a-z0-9\\-]+/i', '-', pathinfo($template, PATHINFO_FILENAME)) . '.pdf';
        $pdf->Output('D', $filename);
    }
}
