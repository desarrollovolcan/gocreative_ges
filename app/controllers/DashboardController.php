<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        try {
            $clientsActive = $this->db->fetch('SELECT COUNT(*) as total FROM clients WHERE status = "activo" AND deleted_at IS NULL');
            $servicesActive = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND deleted_at IS NULL');
            $monthBilling = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "pagada" AND MONTH(fecha_emision) = MONTH(CURRENT_DATE()) AND YEAR(fecha_emision) = YEAR(CURRENT_DATE())');
            $pending = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "pendiente" AND deleted_at IS NULL');
            $overdue = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE estado = "vencida" AND deleted_at IS NULL');
            $pendingCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "pendiente" AND deleted_at IS NULL');
            $overdueCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "vencida" AND deleted_at IS NULL');
            $paidCount = $this->db->fetch('SELECT COUNT(*) as total FROM invoices WHERE estado = "pagada" AND deleted_at IS NULL');
            $paymentsMonth = $this->db->fetch('SELECT COALESCE(SUM(monto),0) as total FROM payments WHERE MONTH(fecha_pago) = MONTH(CURRENT_DATE()) AND YEAR(fecha_pago) = YEAR(CURRENT_DATE())');
            $projectsTotal = $this->db->fetch('SELECT COUNT(*) as total FROM projects WHERE deleted_at IS NULL');
            $ticketsOpen = $this->db->fetch('SELECT COUNT(*) as total FROM support_tickets WHERE status IN ("abierto","en_progreso","pendiente")');

            $upcoming7 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)');
            $upcoming15 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)');
            $upcoming30 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)');

            $recentInvoices = $this->db->fetchAll(
                'SELECT invoices.*, clients.name as client_name
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL
                 ORDER BY invoices.fecha_emision DESC, invoices.id DESC
                 LIMIT 5'
            );
            $overdueInvoices = $this->db->fetchAll(
                'SELECT invoices.*, clients.name as client_name
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL AND invoices.estado = "vencida"
                 ORDER BY invoices.fecha_vencimiento ASC
                 LIMIT 5'
            );
            $upcomingServices = $this->db->fetchAll(
                'SELECT services.*, clients.name as client_name
                 FROM services
                 JOIN clients ON services.client_id = clients.id
                 WHERE services.status = "activo" AND services.due_date >= CURDATE()
                 ORDER BY services.due_date ASC
                 LIMIT 5'
            );
            $topClients = $this->db->fetchAll(
                'SELECT clients.name as client_name, COALESCE(SUM(invoices.total),0) as total
                 FROM invoices
                 JOIN clients ON invoices.client_id = clients.id
                 WHERE invoices.deleted_at IS NULL
                 GROUP BY clients.id
                 ORDER BY total DESC
                 LIMIT 5'
            );
            $recentPayments = $this->db->fetchAll(
                'SELECT payments.*, invoices.numero as invoice_number, clients.name as client_name
                 FROM payments
                 JOIN invoices ON payments.invoice_id = invoices.id
                 JOIN clients ON invoices.client_id = clients.id
                 ORDER BY payments.fecha_pago DESC, payments.id DESC
                 LIMIT 5'
            );
            $revenueTrend = $this->db->fetchAll(
                'SELECT DATE_FORMAT(fecha_emision, "%Y-%m") as period, COALESCE(SUM(total),0) as total
                 FROM invoices
                 WHERE deleted_at IS NULL
                 GROUP BY DATE_FORMAT(fecha_emision, "%Y-%m")
                 ORDER BY period DESC
                 LIMIT 6'
            );
            $ticketStatusSummary = $this->db->fetchAll(
                'SELECT status, COUNT(*) as total
                 FROM support_tickets
                 GROUP BY status'
            );
            $invoiceStatusSummary = $this->db->fetchAll(
                'SELECT estado as status, COUNT(*) as total
                 FROM invoices
                 WHERE deleted_at IS NULL
                 GROUP BY estado'
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
        ]);
    }
}
