<?php

class LandingController extends Controller
{
    public function index(): void
    {
        $settings = new SettingsModel($this->db);
        $webLanding = $settings->get('web_landing', []);

        $this->renderPublic('landing/index', [
            'title' => 'ActivaWeb | Sitios Web y Sistemas a Medida para Pymes en Chile',
            'pageTitle' => 'ActivaWeb',
            'hidePortalHeader' => true,
            'webLanding' => is_array($webLanding) ? $webLanding : [],
        ]);
    }
}
