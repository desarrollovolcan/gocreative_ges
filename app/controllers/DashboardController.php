<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        try {
            $clientsActive = $this->db->fetch('SELECT COUNT(*) as total FROM clients WHERE status = "activo" AND deleted_at IS NULL');
            $servicesActive = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND deleted_at IS NULL');
            $monthBilling = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE status = "pagada" AND MONTH(fecha_emision) = MONTH(CURRENT_DATE()) AND YEAR(fecha_emision) = YEAR(CURRENT_DATE())');
            $pending = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE status = "pendiente" AND deleted_at IS NULL');
            $overdue = $this->db->fetch('SELECT COALESCE(SUM(total),0) as total FROM invoices WHERE status = "vencida" AND deleted_at IS NULL');

            $upcoming7 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)');
            $upcoming15 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)');
            $upcoming30 = $this->db->fetch('SELECT COUNT(*) as total FROM services WHERE status = "activo" AND fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)');
        } catch (PDOException $e) {
            log_message('error', 'Failed to load dashboard metrics: ' . $e->getMessage());
            $clientsActive = ['total' => 0];
            $servicesActive = ['total' => 0];
            $monthBilling = ['total' => 0];
            $pending = ['total' => 0];
            $overdue = ['total' => 0];
            $upcoming7 = ['total' => 0];
            $upcoming15 = ['total' => 0];
            $upcoming30 = ['total' => 0];
        }

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',
            'clientsActive' => $clientsActive['total'] ?? 0,
            'servicesActive' => $servicesActive['total'] ?? 0,
            'monthBilling' => $monthBilling['total'] ?? 0,
            'pending' => $pending['total'] ?? 0,
            'overdue' => $overdue['total'] ?? 0,
            'upcoming7' => $upcoming7['total'] ?? 0,
            'upcoming15' => $upcoming15['total'] ?? 0,
            'upcoming30' => $upcoming30['total'] ?? 0,
        ]);
    }
}
