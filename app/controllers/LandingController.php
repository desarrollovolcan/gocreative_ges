<?php

class LandingController extends Controller
{
    public function index(): void
    {
        $this->renderPublic('landing/index', [
            'title' => 'ActivaWeb | Sitios Web y Sistemas a Medida para Pymes en Chile',
            'pageTitle' => 'ActivaWeb',
            'hidePortalHeader' => true,
        ]);
    }
}
