<?php

class SiiActivitiesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        try {
            $activities = $this->db->fetchAll('SELECT code, name FROM sii_activity_codes ORDER BY code');
        } catch (Throwable $e) {
            log_message('error', 'Failed to load SII activities: ' . $e->getMessage());
            $activities = [];
        }
        $this->render('maintainers/sii-activities/index', [
            'title' => 'Actividades SII',
            'pageTitle' => 'Actividades SII',
            'activities' => $activities,
        ]);
    }
}
