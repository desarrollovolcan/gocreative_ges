<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        try {
            $isAdmin = (Auth::user()['role'] ?? '') === 'admin';
            $companyId = $isAdmin ? null : current_company_id();
            $companyFilter = $companyId ? ' AND company_id = :company_id' : '';
            $companyParams = $companyId ? ['company_id' => $companyId] : [];

            $clientsActive = $this->db->fetch('SELECT COUNT(*) as total FROM clients WHERE status = "activo" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $servicesActive = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $monthBilling = $this->db->fetch(
                'SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "pagada" AND MONTH(fecha_emision) = MONTH(CURRENT_DATE()) AND YEAR(fecha_emision) = YEAR(CURRENT_DATE())' . $companyFilter,
                $companyParams
            );
            $pending = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "pendiente" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $overdue = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "vencida" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $pendingCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "pendiente" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $overdueCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "vencida" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $paidCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "pagada" AND deleted_at IS NULL' . $companyFilter, $companyParams);
            $paymentsMonth = $this->db->fetch(
                'SELECT COALESCE(SUM(payments.monto),0) as total FROM payments JOIN invoices ON payments.invoice_id = invoices.id WHERE MONTH(payments.fecha_pago) = MONTH(CURRENT_DATE()) AND YEAR(payments.fecha_pago) = YEAR(CURRENT_DATE())' . ($companyId ? ' AND invoices.company_id = :company_id' : ''),
                $companyParams
            );
            $projectsTotal = $this->db->fetch('SELECT COUNT(*) as total FROM projects WHERE deleted_at IS NULL' . $companyFilter, $companyParams);
            $ticketsOpen = $this->db->fetch('SELECT COUNT(*) as total FROM support_tickets WHERE status IN ("abierto","en_progreso","pendiente")' . $companyFilter, $companyParams);

            $upcoming7 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)' . $companyFilter, $companyParams);
            $upcoming15 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)' . $companyFilter, $companyParams);
            $upcoming30 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)' . $companyFilter, $companyParams);

            $recentInvoices = $this->db->fetchAll(
                'SELECT invoices.*, clients.name as client_name
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL' . ($companyId ? ' AND invoices.company_id = :company_id' : '') . '
                 ORDER BY invoices.fecha_emision DESC, invoices.id DESC
                 LIMIT 5',
                $companyParams
            );
            $overdueInvoices = $this->db->fetchAll(
                'SELECT invoices.*, clients.name as client_name
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL AND invoices.estado = "vencida"' . ($companyId ? ' AND invoices.company_id = :company_id' : '') . '
                 ORDER BY invoices.fecha_vencimiento ASC
                 LIMIT 5',
                $companyParams
            );
            $upcomingServices = $this->db->fetchAll(
                'SELECT services.*, clients.name as client_name
                 FROM services
                 JOIN clients ON services.client_id = clients.id
                 WHERE services.status = "activo" AND services.due_date >= CURDATE()' . ($companyId ? ' AND services.company_id = :company_id' : '') . '
                 ORDER BY services.due_date ASC
                 LIMIT 5',
                $companyParams
            );
            $topClients = $this->db->fetchAll(
                'SELECT clients.name as client_name, COALESCE(SUM(invoices.total),0) as total
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL' . ($companyId ? ' AND invoices.company_id = :company_id' : '') . '
                 GROUP BY clients.id
                 ORDER BY total DESC
                 LIMIT 5',
                $companyParams
            );
            $recentPayments = $this->db->fetchAll(
                'SELECT payments.*, invoices.numero as invoice_number, clients.name as client_name
                 FROM payments
                 JOIN invoices ON payments.invoice_id = invoices.id
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE 1=1' . ($companyId ? ' AND invoices.company_id = :company_id' : '') . '
                 ORDER BY payments.fecha_pago DESC, payments.id DESC
                 LIMIT 5',
                $companyParams
            );
            $revenueTrend = $this->db->fetchAll(
                'SELECT DATE_FORMAT(fecha_emision, "%Y-%m") as period, COALESCE(SUM(total),0) as total
                 FROM invoices
                 WHERE deleted_at IS NULL' . ($companyId ? ' AND company_id = :company_id' : '') . '
                 GROUP BY DATE_FORMAT(fecha_emision, "%Y-%m")
                 ORDER BY period DESC
                 LIMIT 6',
                $companyParams
            );
            $ticketStatusSummary = $this->db->fetchAll(
                'SELECT status, COUNT(*) as total
                 FROM support_tickets
                 WHERE 1=1' . ($companyId ? ' AND company_id = :company_id' : '') . '
                 GROUP BY status',
                $companyParams
            );
            $invoiceStatusSummary = $this->db->fetchAll(
                'SELECT estado as status, COUNT(*) as total
                 FROM invoices
                 WHERE deleted_at IS NULL' . ($companyId ? ' AND company_id = :company_id' : '') . '
                 GROUP BY estado',
                $companyParams
            );
            $accountingJournals = $this->db->fetch('SELECT COUNT(*) as total FROM accounting_journals WHERE 1=1' . $companyFilter, $companyParams);
            $taxPeriods = $this->db->fetch('SELECT COUNT(*) as total FROM tax_periods WHERE 1=1' . $companyFilter, $companyParams);
            $honorariosPending = $this->db->fetch('SELECT COUNT(*) as total FROM honorarios_documents WHERE status = "pendiente"' . $companyFilter, $companyParams);
            $fixedAssets = $this->db->fetch('SELECT COUNT(*) as total FROM fixed_assets WHERE 1=1' . $companyFilter, $companyParams);
            $bankAccounts = $this->db->fetch('SELECT COUNT(*) as total FROM bank_accounts WHERE 1=1' . $companyFilter, $companyParams);
            $inventoryMovesMonth = $this->db->fetch(
                'SELECT COUNT(*) as total FROM inventory_movements WHERE movement_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)' . $companyFilter,
                $companyParams
            );
        } catch (PDOException $e) {
            log_message('error', 'Failed to load dashboard metrics: ' . $e->getMessage());
            $clientsActive = ['total' => 0];
            $servicesActive = ['total' => 0];
            $monthBilling = ['total' => 0];
            $pending = ['total' => 0];
            $overdue = ['total' => 0];
            $pendingCount = ['total' => 0];
            $overdueCount = ['total' => 0];
            $paidCount = ['total' => 0];
            $paymentsMonth = ['total' => 0];
            $projectsTotal = ['total' => 0];
            $ticketsOpen = ['total' => 0];
            $upcoming7 = ['total' => 0];
            $upcoming15 = ['total' => 0];
            $upcoming30 = ['total' => 0];
            $recentInvoices = [];
            $overdueInvoices = [];
            $upcomingServices = [];
            $topClients = [];
            $recentPayments = [];
            $revenueTrend = [];
            $ticketStatusSummary = [];
            $invoiceStatusSummary = [];
            $accountingJournals = ['total' => 0];
            $taxPeriods = ['total' => 0];
            $honorariosPending = ['total' => 0];
            $fixedAssets = ['total' => 0];
            $bankAccounts = ['total' => 0];
            $inventoryMovesMonth = ['total' => 0];
        }

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
            'clientsActive' => $clientsActive['total'] ?? 0,
            'servicesActive' => $servicesActive['total'] ?? 0,
            'monthBilling' => $monthBilling['total'] ?? 0,
            'pending' => $pending['total'] ?? 0,
            'overdue' => $overdue['total'] ?? 0,
            'pendingCount' => $pendingCount['total'] ?? 0,
            'overdueCount' => $overdueCount['total'] ?? 0,
            'paidCount' => $paidCount['total'] ?? 0,
            'paymentsMonth' => $paymentsMonth['total'] ?? 0,
            'projectsTotal' => $projectsTotal['total'] ?? 0,
            'ticketsOpen' => $ticketsOpen['total'] ?? 0,
            'upcoming7' => $upcoming7['total'] ?? 0,
            'upcoming15' => $upcoming15['total'] ?? 0,
            'upcoming30' => $upcoming30['total'] ?? 0,
            'recentInvoices' => $recentInvoices,
            'overdueInvoices' => $overdueInvoices,
            'upcomingServices' => $upcomingServices,
            'topClients' => $topClients,
            'recentPayments' => $recentPayments,
            'revenueTrend' => $revenueTrend,
            'ticketStatusSummary' => $ticketStatusSummary,
            'invoiceStatusSummary' => $invoiceStatusSummary,
            'accountingJournals' => $accountingJournals['total'] ?? 0,
            'taxPeriods' => $taxPeriods['total'] ?? 0,
            'honorariosPending' => $honorariosPending['total'] ?? 0,
            'fixedAssets' => $fixedAssets['total'] ?? 0,
            'bankAccounts' => $bankAccounts['total'] ?? 0,
            'inventoryMovesMonth' => $inventoryMovesMonth['total'] ?? 0,
        ]);
    }
}
