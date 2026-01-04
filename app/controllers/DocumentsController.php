<?php

class DocumentsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $this->render('documents/index', [
            'title' => 'Documentos',
            'pageTitle' => 'Documentos',
        ]);
    }
}
