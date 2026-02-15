<?php

class LandingController extends Controller
{
    public function index(): void
    {
        $this->renderPublic('landing/index', [
            'title' => 'ActivaWeb | Desarrollo escalable',
            'pageTitle' => 'ActivaWeb',
            'hidePortalHeader' => true,
        ]);
    }
}
