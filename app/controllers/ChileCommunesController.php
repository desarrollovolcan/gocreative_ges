<?php

class ChileCommunesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        try {
            $communes = $this->db->fetchAll(
                'SELECT commune, city, region FROM chile_communes ORDER BY commune, city'
            );
        } catch (Throwable $e) {
            log_message('error', 'Failed to load Chile communes: ' . $e->getMessage());
            $communes = [];
        }
        $this->render('maintainers/chile-communes/index', [
            'title' => 'Comunas y ciudades',
            'pageTitle' => 'Comunas y ciudades',
            'communes' => $communes,
        ]);
    }
}
