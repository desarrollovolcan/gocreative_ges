<?php

class ChileCommunesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        try {
            $communes = $this->db->fetchAll(
                'SELECT id, commune, city, region FROM chile_communes ORDER BY commune, city'
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

    public function create(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $this->render('maintainers/chile-communes/create', [
            'title' => 'Nueva comuna',
            'pageTitle' => 'Nueva comuna',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $commune = trim($_POST['commune'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $region = trim($_POST['region'] ?? '');
        if ($commune === '' || $city === '' || $region === '') {
            flash('error', 'Completa comuna, ciudad y región.');
            $this->redirect('index.php?route=maintainers/chile-communes/create');
        }
        $duplicate = $this->db->fetch(
            'SELECT id FROM chile_communes WHERE commune = :commune',
            ['commune' => $commune]
        );
        if ($duplicate) {
            flash('error', 'La comuna ya existe en el listado.');
            $this->redirect('index.php?route=maintainers/chile-communes/create');
        }
        try {
            $this->db->execute(
                'INSERT INTO chile_communes (commune, city, region) VALUES (:commune, :city, :region)',
                ['commune' => $commune, 'city' => $city, 'region' => $region]
            );
            audit($this->db, Auth::user()['id'], 'create', 'chile_communes');
            flash('success', 'Comuna creada correctamente.');
        } catch (Throwable $e) {
            log_message('error', 'Failed to create Chile commune: ' . $e->getMessage());
            flash('error', 'No se pudo guardar la comuna.');
        }
        $this->redirect('index.php?route=maintainers/chile-communes');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $commune = $this->db->fetch(
            'SELECT id, commune, city, region FROM chile_communes WHERE id = :id',
            ['id' => $id]
        );
        if (!$commune) {
            $this->redirect('index.php?route=maintainers/chile-communes');
        }
        $this->render('maintainers/chile-communes/edit', [
            'title' => 'Editar comuna',
            'pageTitle' => 'Editar comuna',
            'commune' => $commune,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $commune = $this->db->fetch(
            'SELECT id FROM chile_communes WHERE id = :id',
            ['id' => $id]
        );
        if (!$commune) {
            $this->redirect('index.php?route=maintainers/chile-communes');
        }
        $communeName = trim($_POST['commune'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $region = trim($_POST['region'] ?? '');
        if ($communeName === '' || $city === '' || $region === '') {
            flash('error', 'Completa comuna, ciudad y región.');
            $this->redirect('index.php?route=maintainers/chile-communes/edit&id=' . $id);
        }
        $duplicate = $this->db->fetch(
            'SELECT id FROM chile_communes WHERE commune = :commune AND id != :id',
            ['commune' => $communeName, 'id' => $id]
        );
        if ($duplicate) {
            flash('error', 'La comuna ya está asignada a otro registro.');
            $this->redirect('index.php?route=maintainers/chile-communes/edit&id=' . $id);
        }
        try {
            $this->db->execute(
                'UPDATE chile_communes SET commune = :commune, city = :city, region = :region WHERE id = :id',
                ['commune' => $communeName, 'city' => $city, 'region' => $region, 'id' => $id]
            );
            audit($this->db, Auth::user()['id'], 'update', 'chile_communes', $id);
            flash('success', 'Comuna actualizada correctamente.');
        } catch (Throwable $e) {
            log_message('error', 'Failed to update Chile commune: ' . $e->getMessage());
            flash('error', 'No se pudo actualizar la comuna.');
        }
        $this->redirect('index.php?route=maintainers/chile-communes');
    }
}
