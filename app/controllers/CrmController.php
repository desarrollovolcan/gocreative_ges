<?php

class CrmController extends Controller
{
    public function hub(): void
    {
        $this->requireLogin();
        $this->render('crm/hub', [
            'title' => 'CRM Comercial',
            'pageTitle' => 'CRM Comercial',
        ]);
    }

    public function reports(): void
    {
        $this->requireLogin();
        $range = $_GET['range'] ?? '30d';
        $statusFilter = $_GET['status'] ?? 'all';
        $startInput = $_GET['start'] ?? '';
        $endInput = $_GET['end'] ?? '';

        $now = new DateTimeImmutable('today');
        $startDate = $now->modify('-30 days');
        $endDate = $now;

        if ($range === 'quarter') {
            $month = (int)$now->format('n');
            $quarterStartMonth = (int)(floor(($month - 1) / 3) * 3 + 1);
            $startDate = $now->setDate((int)$now->format('Y'), $quarterStartMonth, 1);
            $endDate = $startDate->modify('+2 months')->modify('last day of this month');
        } elseif ($range === 'year') {
            $startDate = $now->setDate((int)$now->format('Y'), 1, 1);
            $endDate = $now->setDate((int)$now->format('Y'), 12, 31);
        } elseif ($range === 'custom' && $startInput !== '' && $endInput !== '') {
            try {
                $startDate = new DateTimeImmutable($startInput);
                $endDate = new DateTimeImmutable($endInput);
            } catch (Exception $e) {
                $startDate = $now->modify('-30 days');
                $endDate = $now;
            }
        }

        if ($startDate > $endDate) {
            $swap = $startDate;
            $startDate = $endDate;
            $endDate = $swap;
        }

        $startParam = $startDate->format('Y-m-d');
        $endParam = $endDate->format('Y-m-d');

        $isAdmin = (Auth::user()['role'] ?? '') === 'admin';
        $companyId = $isAdmin ? null : current_company_id();
        $companyFilter = $companyId ? ' AND company_id = :company_id' : '';
        $companyParams = $companyId ? ['company_id' => $companyId] : [];

        try {
            $billing = $this->db->fetch(
                'SELECT COALESCE(SUM(total),0) as total
                 FROM invoices
                 WHERE estado = "pagada" AND deleted_at IS NULL
                   AND fecha_emision BETWEEN :start AND :end' . $companyFilter,
                array_merge(['start' => $startParam, 'end' => $endParam], $companyParams)
            );

            $pipeline = $this->db->fetch(
                'SELECT COALESCE(SUM(total),0) as total, COUNT(*) as count
                 FROM quotes
                 WHERE estado = "pendiente"
                   AND fecha_emision BETWEEN :start AND :end' . $companyFilter,
                array_merge(['start' => $startParam, 'end' => $endParam], $companyParams)
            );

            $ticketsTotal = $this->db->fetch(
                'SELECT COUNT(*) as total
                 FROM support_tickets
                 WHERE created_at BETWEEN :start AND :end' . $companyFilter,
                array_merge(['start' => $startParam . ' 00:00:00', 'end' => $endParam . ' 23:59:59'], $companyParams)
            );
            $ticketsClosed = $this->db->fetch(
                'SELECT COUNT(*) as total
                 FROM support_tickets
                 WHERE status = "cerrado"
                   AND updated_at BETWEEN :start AND :end' . $companyFilter,
                array_merge(['start' => $startParam . ' 00:00:00', 'end' => $endParam . ' 23:59:59'], $companyParams)
            );
            $slaPercent = 0;
            if ((int)$ticketsTotal['total'] > 0) {
                $slaPercent = (int)round(((int)$ticketsClosed['total'] / (int)$ticketsTotal['total']) * 100);
            }

            $alerts = $this->db->fetch(
                'SELECT COUNT(*) as total
                 FROM invoices
                 WHERE estado = "vencida" AND deleted_at IS NULL
                   AND fecha_vencimiento BETWEEN :start AND :end' . $companyFilter,
                array_merge(['start' => $startParam, 'end' => $endParam], $companyParams)
            );

            $statusClause = '';
            $statusParams = [];
            if ($statusFilter !== 'all') {
                $statusClause = ' AND quotes.estado = :status';
                $statusParams = ['status' => $statusFilter];
            }

            $activities = $this->db->fetchAll(
                'SELECT quotes.*, clients.name as client_name
                 FROM quotes
                 JOIN clients ON quotes.client_id = clients.id
                 WHERE quotes.fecha_emision BETWEEN :start AND :end' . $companyFilter . $statusClause . '
                 ORDER BY quotes.fecha_emision DESC, quotes.id DESC
                 LIMIT 8',
                array_merge(['start' => $startParam, 'end' => $endParam], $companyParams, $statusParams)
            );
        } catch (PDOException $e) {
            log_message('error', 'Failed to load CRM reports: ' . $e->getMessage());
            $billing = ['total' => 0];
            $pipeline = ['total' => 0, 'count' => 0];
            $slaPercent = 0;
            $alerts = ['total' => 0];
            $activities = [];
        }

        $this->render('crm/reports', [
            'title' => 'Reportes CRM',
            'pageTitle' => 'Reportes CRM',
            'billingTotal' => (float)($billing['total'] ?? 0),
            'pipelineTotal' => (float)($pipeline['total'] ?? 0),
            'pipelineCount' => (int)($pipeline['count'] ?? 0),
            'slaPercent' => $slaPercent,
            'alertCount' => (int)($alerts['total'] ?? 0),
            'activities' => $activities,
            'filters' => [
                'range' => $range,
                'status' => $statusFilter,
                'start' => $startParam,
                'end' => $endParam,
            ],
        ]);
    }
}
