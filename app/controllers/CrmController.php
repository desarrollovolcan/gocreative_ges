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
        $this->render('crm/reports', [
            'title' => 'Reportes CRM',
            'pageTitle' => 'Reportes CRM',
        ]);
    }
}
