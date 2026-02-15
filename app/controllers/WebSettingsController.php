<?php

class WebSettingsController extends Controller
{
    private SettingsModel $settings;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->settings = new SettingsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $web = $this->settings->get('web_landing', $this->defaults());
        $web = array_replace_recursive($this->defaults(), is_array($web) ? $web : []);

        $this->render('web/settings', [
            'title' => 'WEB · Landing',
            'pageTitle' => 'WEB',
            'web' => $web,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();

        $current = $this->settings->get('web_landing', $this->defaults());
        $current = array_replace_recursive($this->defaults(), is_array($current) ? $current : []);

        $web = [
            'style' => [
                'brand' => trim($_POST['brand'] ?? '#142d6f'),
                'accent' => trim($_POST['accent'] ?? '#a3bdff'),
                'bg_soft' => trim($_POST['bg_soft'] ?? '#f6f7fb'),
                'font_family' => trim($_POST['font_family'] ?? 'DM Sans'),
                'h1_size' => (int)($_POST['h1_size'] ?? 64),
                'h2_size' => (int)($_POST['h2_size'] ?? 52),
                'body_size' => (int)($_POST['body_size'] ?? 16),
            ],
            'header' => [
                'brand_text' => trim($_POST['brand_text'] ?? 'ACTIVAWEB'),
                'topline' => trim($_POST['topline'] ?? 'Desarrollo escalable, crecemos con tu empresa!'),
                'social' => trim($_POST['social'] ?? 'Facebook · Instagram · Youtube'),
                'intranet_url' => trim($_POST['intranet_url'] ?? 'login.php'),
            ],
            'hero' => [
                'rating' => trim($_POST['hero_rating'] ?? '★★★★★ 4.8 / 5 rating by users'),
                'title' => trim($_POST['hero_title'] ?? 'IMPULSAMOS TU PRESENCIA DIGITAL'),
                'description' => trim($_POST['hero_description'] ?? ''),
                'phone' => trim($_POST['hero_phone'] ?? '+628-123-9876'),
                'email' => trim($_POST['hero_email'] ?? 'hola@activa-web.cl'),
                'image_main' => $current['hero']['image_main'] ?? '',
                'image_video' => $current['hero']['image_video'] ?? '',
            ],
            'logos_title' => trim($_POST['logos_title'] ?? ''),
            'logos' => array_values(array_filter(array_map('trim', explode("\n", (string)($_POST['logos'] ?? ''))))),
            'about' => [
                'title' => trim($_POST['about_title'] ?? ''),
                'lead' => trim($_POST['about_lead'] ?? ''),
                'items' => $this->collectItems($_POST, 'about_item', 3),
            ],
            'services_title' => trim($_POST['services_title'] ?? ''),
            'services' => $this->collectItems($_POST, 'service', 6),
            'methodology' => [
                'title' => trim($_POST['methodology_title'] ?? ''),
                'lead' => trim($_POST['methodology_lead'] ?? ''),
                'items' => $this->collectItems($_POST, 'methodology_item', 3),
            ],
            'dark_band' => [
                'title' => trim($_POST['dark_title'] ?? ''),
                'tabs' => array_values(array_filter(array_map('trim', explode("\n", (string)($_POST['dark_tabs'] ?? ''))))),
                'panel' => trim($_POST['dark_panel'] ?? ''),
            ],
            'plans_title' => trim($_POST['plans_title'] ?? ''),
            'plans' => $this->collectPlans($_POST),
            'contact' => [
                'title' => trim($_POST['contact_title'] ?? ''),
                'text' => trim($_POST['contact_text'] ?? ''),
                'city' => trim($_POST['contact_city'] ?? ''),
                'email' => trim($_POST['contact_email'] ?? ''),
                'phone' => trim($_POST['contact_phone'] ?? ''),
            ],
            'footer' => [
                'about' => trim($_POST['footer_about'] ?? ''),
                'quick_links' => array_values(array_filter(array_map('trim', explode("\n", (string)($_POST['footer_links'] ?? ''))))),
                'intranet_text' => trim($_POST['footer_intranet_text'] ?? ''),
            ],
        ];

        $mainImage = upload_web_asset($_FILES['hero_image_main'] ?? null, 'hero-main');
        if (!empty($mainImage['error'])) {
            flash('error', $mainImage['error']);
            $this->redirect('index.php?route=web/settings');
        }
        if (!empty($mainImage['path'])) {
            $web['hero']['image_main'] = $mainImage['path'];
        }

        $videoImage = upload_web_asset($_FILES['hero_image_video'] ?? null, 'hero-video');
        if (!empty($videoImage['error'])) {
            flash('error', $videoImage['error']);
            $this->redirect('index.php?route=web/settings');
        }
        if (!empty($videoImage['path'])) {
            $web['hero']['image_video'] = $videoImage['path'];
        }

        $this->settings->set('web_landing', $web);
        flash('success', 'Configuración WEB actualizada correctamente.');
        $this->redirect('index.php?route=web/settings');
    }

    private function collectItems(array $post, string $prefix, int $count): array
    {
        $items = [];
        for ($i = 1; $i <= $count; $i++) {
            $title = trim($post[$prefix . '_title_' . $i] ?? '');
            $text = trim($post[$prefix . '_text_' . $i] ?? '');
            if ($title !== '' || $text !== '') {
                $items[] = ['title' => $title, 'text' => $text];
            }
        }
        return $items;
    }

    private function collectPlans(array $post): array
    {
        $plans = [];
        for ($i = 1; $i <= 3; $i++) {
            $features = array_values(array_filter(array_map('trim', explode("\n", (string)($post['plan_features_' . $i] ?? '')))));
            $plans[] = [
                'name' => trim($post['plan_name_' . $i] ?? ''),
                'price' => trim($post['plan_price_' . $i] ?? ''),
                'features' => $features,
                'button' => trim($post['plan_button_' . $i] ?? 'Cotizar ahora'),
            ];
        }
        return $plans;
    }

    private function defaults(): array
    {
        return [
            'style' => ['brand' => '#142d6f', 'accent' => '#a3bdff', 'bg_soft' => '#f6f7fb', 'font_family' => 'DM Sans', 'h1_size' => 64, 'h2_size' => 52, 'body_size' => 16],
            'header' => ['brand_text' => 'ACTIVAWEB', 'topline' => 'Desarrollo escalable, crecemos con tu empresa!', 'social' => 'Facebook · Instagram · Youtube', 'intranet_url' => 'login.php'],
            'hero' => ['rating' => '★★★★★ 4.8 / 5 rating by users', 'title' => 'IMPULSAMOS TU PRESENCIA DIGITAL', 'description' => 'Desarrolla y haz crecer tu empresa. Creamos sitios web profesionales y sistemas web a medida para pymes en Chile, optimizados para generar clientes, automatizar procesos y mejorar la gestión digital.', 'phone' => '+628-123-9876', 'email' => 'hola@activa-web.cl', 'image_main' => '', 'image_video' => ''],
            'logos_title' => 'Resultados reales, relaciones duraderas: empresas que confían en nuestras soluciones digitales.',
            'logos' => ['Municipalidad Pozo Almonte', 'Acqua Perla', 'Volcan Foods', 'Grupo LMR', 'GBC Repuestos'],
            'about' => ['title' => 'Entregamos soluciones, construimos confianza', 'lead' => 'En ActivaWeb desarrollamos sistemas web y plataformas digitales a medida para empresas en Chile. Trabajamos de forma cercana y estratégica para optimizar procesos, aumentar productividad y fortalecer la presencia digital.', 'items' => [['title' => 'Desarrollo de sistemas web a medida', 'text' => 'Creamos plataformas personalizadas según los procesos de tu empresa, con control en tiempo real y escalabilidad.'], ['title' => 'Diseño y desarrollo de páginas web', 'text' => 'Sitios profesionales, rápidos y optimizados para buscadores, orientados a atraer clientes y vender mejor.'], ['title' => 'Automatización de procesos empresariales', 'text' => 'Digitalizamos tareas repetitivas e integramos áreas para reducir errores y aumentar productividad.']]],
            'services_title' => 'Soluciones digitales para hacer crecer tu empresa',
            'services' => [['title' => 'Integración de sistemas y bases de datos', 'text' => 'Conectamos plataformas, APIs y bases de datos para centralizar información y mejorar decisiones.'], ['title' => 'Plataformas de gestión para pymes', 'text' => 'Sistemas de inventario, ventas, clientes y operaciones adaptados a pequeñas y medianas empresas chilenas.'], ['title' => 'Soporte, mejora y escalabilidad web', 'text' => 'Mantenimiento y evolución continua para que la plataforma crezca junto a tu negocio.'], ['title' => 'Portafolio ActivaWeb (100+ proyectos)', 'text' => 'Municipalidad Pozo Almonte, Acqua Perla, Volcan Foods, Grupo LMR, GBC Repuestos, Maysam Transporte y Palermo Vestidos.']],
            'methodology' => ['title' => 'Nuestra metodología de desarrollo web', 'lead' => 'Levantamiento, desarrollo con QA e implementación con acompañamiento post-lanzamiento.', 'items' => [['title' => 'Levantamiento y conocimiento del rubro', 'text' => 'Analizamos tu empresa y flujos para diseñar una solución alineada a tus objetivos comerciales.'], ['title' => 'Desarrollo, integraciones y QA', 'text' => 'Construimos con tecnologías modernas, pruebas funcionales, seguridad y rendimiento.'], ['title' => 'Implementación y acompañamiento', 'text' => 'Capacitamos equipos y damos soporte continuo para consolidar la transformación digital.']]],
            'dark_band' => ['title' => 'Impulsa la transformación digital de tu empresa hoy', 'tabs' => ['Asesoría estratégica', 'Desarrollo a medida', 'Integraciones', 'Soporte continuo'], 'panel' => 'Plataforma centralizada para clientes, operaciones y control de proyectos en tiempo real.'],
            'plans_title' => 'Planes de trabajo según etapa de tu empresa',
            'plans' => [['name' => 'Plan Presencia Digital', 'price' => 'Web', 'features' => ['Sitio corporativo profesional', 'SEO técnico inicial', 'Formulario y analítica básica'], 'button' => 'Cotizar ahora'], ['name' => 'Plan Automatización', 'price' => 'Web+', 'features' => ['Procesos internos digitalizados', 'Integración con APIs y datos', 'Dashboard de seguimiento'], 'button' => 'Cotizar ahora'], ['name' => 'Plan Escalamiento', 'price' => 'Pro', 'features' => ['Plataforma a medida de alto tráfico', 'Roadmap evolutivo y soporte prioritario', 'Mejoras continuas por objetivos'], 'button' => 'Cotizar ahora']],
            'contact' => ['title' => 'Contáctanos ahora y convierte tu idea en una solución real', 'text' => 'Acompañamos a emprendedores, pymes y profesionales con soporte cercano, experiencia técnica y foco en resultados.', 'city' => 'Concepción, Región del Bio bio, Chile', 'email' => 'hola@activa-web.cl', 'phone' => '+56 9 8452 4563'],
            'footer' => ['about' => 'Desarrollamos plataformas web, sistemas a medida y soluciones digitales para empresas en Chile.', 'quick_links' => ['Inicio', 'Servicios', 'Nosotros', 'Intranet'], 'intranet_text' => 'Control total de tus proyectos y más'],
        ];
    }
}
