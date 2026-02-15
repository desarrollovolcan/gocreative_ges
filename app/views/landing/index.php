<style>
    :root {
        --aw-bg: #040b1f;
        --aw-bg-soft: #0b1631;
        --aw-primary: #5a7bff;
        --aw-secondary: #14c4d4;
        --aw-text: #e8eeff;
        --aw-muted: #98a8d4;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: radial-gradient(circle at top right, #182f66 0%, #040b1f 45%, #020611 100%);
        color: var(--aw-text);
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    .landing-wrap {
        min-height: 100vh;
    }

    .glass {
        background: rgba(8, 17, 40, .75);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(138, 167, 255, .2);
        border-radius: 20px;
        box-shadow: 0 16px 40px rgba(4, 8, 23, .35);
    }

    .btn-aw {
        border-radius: 999px;
        padding: .75rem 1.4rem;
        font-weight: 600;
    }

    .btn-aw-primary {
        background: linear-gradient(120deg, var(--aw-primary), var(--aw-secondary));
        border: none;
        color: #fff;
    }

    .btn-aw-outline {
        border: 1px solid rgba(190, 208, 255, .5);
        color: #fff;
    }

    .navbar-aw {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(2, 6, 17, .78);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid rgba(161, 188, 255, .15);
    }

    .section-title {
        font-size: clamp(1.6rem, 2.6vw, 2.4rem);
        font-weight: 800;
        letter-spacing: .3px;
    }

    .hero-badge {
        color: #c6d5ff;
        background: rgba(91, 123, 255, .18);
        border: 1px solid rgba(122, 154, 255, .4);
        border-radius: 999px;
        display: inline-flex;
        padding: .4rem .85rem;
        font-size: .82rem;
        margin-bottom: 1rem;
    }

    .muted-aw {
        color: var(--aw-muted);
    }

    .card-aw {
        height: 100%;
        padding: 1.4rem;
    }

    .kpi {
        font-size: 2.3rem;
        font-weight: 900;
        background: linear-gradient(120deg, #bcd0ff, #70f0ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    footer {
        border-top: 1px solid rgba(161, 188, 255, .15);
    }
</style>

<div id="top" class="landing-wrap">
    <nav class="navbar-aw">
        <div class="container py-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <a class="fw-bold text-white text-decoration-none" href="#top">ActivaWeb</a>
            <div class="d-flex align-items-center gap-3 small muted-aw">
                <span>Facebook</span>
                <span>Instagram</span>
                <span>Youtube</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a class="text-decoration-none text-white-50" href="#inicio">Inicio</a>
                <a class="text-decoration-none text-white-50" href="#servicios">Servicios</a>
                <a class="text-decoration-none text-white-50" href="#nosotros">Nosotros</a>
                <a class="text-decoration-none text-white-50" href="login.php">Intranet</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <section id="inicio" class="row g-4 align-items-center mb-5 pb-4">
            <div class="col-lg-7">
                <span class="hero-badge">IMPULSAMOS TU PRESENCIA DIGITAL</span>
                <h1 class="display-5 fw-bold mb-3">Desarrollo escalable, cresemos con tu empresa!</h1>
                <h2 class="h3 fw-semibold mb-3">Desarrolla y Haz Crecer tu Empresa</h2>
                <p class="muted-aw fs-5">Creamos sitios web profesionales y sistemas web a medida para pymes en Chile. Diseñamos plataformas optimizadas, rápidas y enfocadas en generar clientes, automatizar procesos y mejorar la gestión digital de tu negocio.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#contacto" class="btn btn-aw btn-aw-primary">Cotiza tu proyecto</a>
                    <a href="tel:+6281239876" class="btn btn-aw btn-aw-outline">+628-123-9876</a>
                </div>
                <p class="mt-3 mb-0"><a class="text-info" href="mailto:hola@activa-web.cl">hola@activa-web.cl</a></p>
            </div>
            <div class="col-lg-5">
                <div class="glass p-4">
                    <h3 class="section-title mb-3">Entregamos Soluciones, Construimos Confianza</h3>
                    <p class="muted-aw mb-0">En ActivaWeb desarrollamos sistemas web y plataformas digitales a medida para empresas en Chile. Creamos soluciones tecnológicas eficientes, escalables y enfocadas en mejorar procesos, aumentar la productividad y fortalecer la presencia digital de tu negocio.</p>
                </div>
            </div>
        </section>

        <section id="nosotros" class="mb-5 pb-3">
            <div class="glass p-4 p-lg-5">
                <h3 class="section-title">Resultados reales, relaciones duraderas</h3>
                <p class="muted-aw mt-3 mb-0">Trabajamos de forma cercana y estratégica con cada cliente, entendiendo sus flujos de trabajo y objetivos comerciales. Nuestro compromiso es entregar desarrollos web de calidad, soporte continuo y relaciones de largo plazo basadas en confianza, resultados y crecimiento conjunto.</p>
            </div>
        </section>

        <section id="servicios" class="mb-5">
            <h3 class="section-title mb-4">Soluciones Digitales Para Hacer Crecer Tu Empresa</h3>
            <div class="row g-4">
                <?php
                $services = [
                    'Desarrollo de Sistemas Web a Medida' => 'Creamos plataformas web personalizadas según los procesos de tu empresa, optimizando flujos de trabajo, gestión interna y control de información en tiempo real.',
                    'Diseño y Desarrollo de Páginas Web' => 'Diseñamos sitios web profesionales, rápidos y optimizados para buscadores, enfocados en atraer clientes y mejorar la presencia digital de tu negocio en Chile.',
                    'Automatización de Procesos Empresariales' => 'Digitalizamos tareas repetitivas y conectamos áreas de tu empresa para reducir errores, ahorrar tiempo y aumentar la productividad mediante soluciones web inteligentes.',
                    'Integración de Sistemas y Bases de Datos' => 'Conectamos plataformas, APIs y bases de datos para centralizar la información de tu empresa y mejorar la toma de decisiones con datos confiables y actualizados.',
                    'Plataformas de Gestión para Pymes' => 'Desarrollamos sistemas de gestión, control de inventario, ventas, clientes y operaciones adaptados a pequeñas y medianas empresas chilenas.',
                    'Soporte, Mejora y Escalabilidad Web' => 'Acompañamos el crecimiento de tu empresa con mantenimiento, mejoras continuas y nuevas funcionalidades para que tu plataforma evolucione junto a tu negocio.',
                ];
                foreach ($services as $name => $description):
                ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="glass card-aw">
                            <h4 class="h5"><?php echo e($name); ?></h4>
                            <p class="muted-aw mb-0"><?php echo e($description); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mb-5">
            <h3 class="section-title mb-4">metodología Profesional</h3>
            <div class="row g-4">
                <div class="col-lg-4"><div class="glass card-aw"><h4 class="h5">Levantamiento y Conocimiento del Rubro</h4><p class="muted-aw mb-0">Analizamos tu empresa, procesos internos y flujos de información para entender a fondo tu rubro. Esta etapa nos permite diseñar una solución web a medida, alineada con tus objetivos comerciales y operativos.</p></div></div>
                <div class="col-lg-4"><div class="glass card-aw"><h4 class="h5">Desarrollo, Integraciones y QA</h4><p class="muted-aw mb-0">Construimos tu plataforma con tecnologías modernas, integraciones necesarias y bases de datos optimizadas. Realizamos pruebas funcionales, de seguridad y rendimiento (QA) para asegurar un sistema estable, rápido y confiable.</p></div></div>
                <div class="col-lg-4"><div class="glass card-aw"><h4 class="h5">Implementación y Acompañamiento</h4><p class="muted-aw mb-0">Te acompañamos en la puesta en marcha del sistema, capacitación de usuarios y soporte post-lanzamiento. Seguimos optimizando la plataforma para que evolucione junto al crecimiento de tu empresa.</p></div></div>
            </div>
        </section>

        <section class="glass p-4 p-lg-5 mb-5 text-center">
            <h3 class="section-title">Impulsa la Transformación Digital de Tu Empresa Hoy</h3>
            <p class="muted-aw my-3">Obtén una asesoría gratuita y descubre cómo un sistema web a medida puede optimizar tus procesos, aumentar tu productividad y hacer crecer tu negocio.</p>
            <p class="mb-1"><a class="text-info" href="tel:+6281239876">+628-123-9876</a></p>
            <p class="mb-0"><a class="text-info" href="mailto:hola@activa-web.cl">hola@activa-web.cl</a></p>
        </section>

        <section class="mb-5">
            <h3 class="section-title">PORTAFOLIO ACTIVAWEB</h3>
            <p class="muted-aw">Proyectos Recientes, Construyendo Confianza Y Relaciones Duraderas</p>
            <div class="row g-3">
                <?php
                $projects = [
                    'Gestión de eventos : Municipalidad Pozo Almonte' => 'Plataforma digital para organizar, administrar y monitorear eventos municipales de forma eficiente y centralizada.',
                    'Sistema gestión agua : Acqua Perla' => 'Sistema web para el control operativo, comercial y de distribución en empresa de agua purificada.',
                    'Software de trazabilidad : Volcan Foods' => 'Plataforma de trazabilidad que permite controlar procesos productivos y seguimiento de productos en tiempo real.',
                    'Web informativa :Grupo LMR' => 'Sitio corporativo profesional que fortalece la presencia digital y comunica los servicios de la empresa.',
                    'Web informativa : GBC Repuestos' => 'Página web corporativa orientada a mostrar catálogo, servicios y facilitar el contacto con clientes.',
                    'Web informativa :Maysam Servicios de transporte' => 'Sitio web empresarial que presenta servicios de transporte, genera confianza y facilita la captación de clientes.',
                    'Web tienda: Palermo Vestidos' => 'Tienda online moderna que permite exhibir y vender vestidos con una experiencia de compra simple y atractiva.',
                ];
                foreach ($projects as $title => $description):
                ?>
                    <div class="col-md-6">
                        <div class="glass card-aw"><h4 class="h6 mb-2"><?php echo e($title); ?></h4><p class="muted-aw mb-0"><?php echo e($description); ?></p></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="glass p-4 mt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div><span class="kpi">100+</span><p class="muted-aw mb-0">Proyectros realizados</p></div>
                <a href="#contacto" class="btn btn-aw btn-aw-primary">Contactanos ahora</a>
            </div>
        </section>

        <section id="contacto" class="glass p-4 p-lg-5 mb-5">
            <h3 class="section-title">Cuéntanos qué necesitas</h3>
            <p class="muted-aw">Te ayudamos a convertir tu idea en una solución digital sólida, moderna y pensada para generar resultados reales. Analizamos tu requerimiento y te proponemos la mejor estrategia para tu negocio.</p>
            <p class="muted-aw mb-0">Acompañamos a emprendedores, pymes y profesionales con soluciones digitales y soporte cercano, combinando experiencia técnica con un trato humano y comprometido.</p>
        </section>
    </main>

    <footer class="container py-4" id="contenido">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>Contacto</h5>
                <p class="muted-aw mb-1">Concepción, Región del Bio bio, Chile</p>
                <p class="mb-1"><a class="text-info" href="mailto:hola@activa-web.cl">hola@activa-web.cl</a></p>
                <p class="mb-0"><a class="text-info" href="tel:+56984524563">‪+56 9 8452 4563‬</a></p>
            </div>
            <div class="col-md-4">
                <h5>Accesos rapidos</h5>
                <ul class="list-unstyled muted-aw mb-0">
                    <li><a class="text-decoration-none text-white-50" href="#inicio">Inicio</a></li>
                    <li><a class="text-decoration-none text-white-50" href="login.php">Intranet</a></li>
                    <li><a class="text-decoration-none text-white-50" href="#nosotros">Nosotros</a></li>
                    <li><a class="text-decoration-none text-white-50" href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Intranet Clientes</h5>
                <p class="muted-aw">Accede a tu plataforma privada y mantén el control total de tus proyectos y màs</p>
                <a class="btn btn-aw btn-aw-outline" href="index.php?route=clients/login">Intranet Cliente</a>
            </div>
        </div>
        <div class="pt-4 mt-4 border-top border-secondary-subtle d-flex justify-content-between">
            <span class="muted-aw">Desarrollado por Activa Web</span>
            <a class="text-decoration-none text-white-50" href="#top">Scroll al inicio</a>
        </div>
    </footer>
</div>
