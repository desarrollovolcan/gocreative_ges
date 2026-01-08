<?php

require_once __DIR__ . '/report-base.php';

generate_form_report([
    'title' => 'Informe de brief comercial',
    'source' => 'crm/briefs',
    'template' => 'informeIcargaEspanol.php',
]);
