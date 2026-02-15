<?php
$defaults = [
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
$web = array_replace_recursive($defaults, $webLanding ?? []);
$tel = preg_replace('/[^\d+]/', '', $web['hero']['phone']);
$intranetUrl = trim((string)($web['header']['intranet_url'] ?? 'login.php'));
if ($intranetUrl === '') { $intranetUrl = 'login.php'; }
?>
<style>
  :root {
    --brand: <?php echo e($web['style']['brand']); ?>;
    --accent: <?php echo e($web['style']['accent']); ?>;
    --bg-soft: <?php echo e($web['style']['bg_soft']); ?>;
    --h1-size: <?php echo (int)$web['style']['h1_size']; ?>px;
    --h2-size: <?php echo (int)$web['style']['h2_size']; ?>px;
    --body-size: <?php echo (int)$web['style']['body_size']; ?>px;
  }
  *{box-sizing:border-box} body{margin:0;background:var(--bg-soft);font-family:<?php echo e($web['style']['font_family']); ?>,system-ui,sans-serif;color:var(--brand);font-size:var(--body-size)}
  .container{width:min(1200px,calc(100% - 32px));margin:auto} a{text-decoration:none;color:inherit}
  .topline,.header,.dark-band,.footer{background:var(--brand);color:#fff}.topline{font-size:14px;border-bottom:1px solid rgba(255,255,255,.15)}
  .topline .container,.header .container{display:flex;justify-content:space-between;align-items:center;padding:10px 0;gap:14px}
  .header .container{padding:16px 0}.brand{font-size:30px;font-weight:800}.nav{display:flex;gap:20px;align-items:center}.nav__cta{background:var(--accent);color:#132c6f;padding:10px 16px;border-radius:6px;font-weight:700}
  .hero{background:var(--brand);color:#fff;padding:34px 0 0}.hero-top{display:grid;grid-template-columns:1.3fr .9fr;gap:28px}.hero h1{font-size:clamp(34px,5vw,var(--h1-size));line-height:1;margin:0}
  .hero-desc{font-size:20px;line-height:1.5}.chips{display:flex;gap:10px;flex-wrap:wrap}.chip{border:1px solid rgba(255,255,255,.3);padding:10px 12px;border-radius:6px}
  .hero-media{display:grid;grid-template-columns:1.3fr 1fr;gap:16px;margin-top:28px;transform:translateY(36px)}
  .ph{background:#c6d6ff;border-radius:10px;min-height:250px;background-size:cover;background-position:center}.ph.video{display:grid;place-items:center;color:#fff;font-size:44px}
  section{padding:64px 0}.logos{background:#fff}.logo-row{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}.logo{background:#f9fbff;border:1px dashed rgba(20,45,111,.2);border-radius:10px;padding:18px;text-align:center;font-weight:700}
  .split{display:grid;grid-template-columns:1fr 1fr;gap:36px;align-items:center}.box{background:#c6d6ff;border-radius:10px;min-height:320px}
  h2{font-size:clamp(30px,4vw,var(--h2-size));line-height:1.04;margin:0 0 14px}.lead{color:#35539f;line-height:1.5}
  .acc .item{border-bottom:1px solid rgba(20,45,111,.15);padding:10px 0}.acc .ttl{font-weight:700;font-size:22px}.cards{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}.card{background:#fff;border:1px solid rgba(20,45,111,.15);border-radius:10px;padding:18px}
  .tabs{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}.tab{text-align:center;border-bottom:2px solid rgba(255,255,255,.5);padding-bottom:8px;font-weight:700}
  .panel{background:#8fa8e6;border-radius:10px 10px 0 0;min-height:220px;display:grid;place-items:center;text-align:center;padding:22px;font-size:28px}
  .plans{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}.plan{background:#fff;border:1px solid rgba(20,45,111,.15);border-radius:10px;padding:18px}.price{font-size:40px;font-weight:800}.btn{display:inline-block;background:var(--accent);color:#132c6f;padding:10px 14px;border-radius:6px;font-weight:700}
  .footer-grid{display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr;gap:16px}.footer{padding:48px 0 14px}.copy{margin-top:16px;border-top:1px solid rgba(255,255,255,.2);padding-top:12px;text-align:center;color:rgba(255,255,255,.85)}
  @media(max-width:980px){.hero-top,.hero-media,.split,.plans,.footer-grid,.cards{grid-template-columns:1fr}.logo-row{grid-template-columns:repeat(2,1fr)}.tabs{grid-template-columns:repeat(2,1fr)}.nav{display:none}}
</style>

<div class="topline"><div class="container"><strong><?php echo e($web['header']['topline']); ?></strong><span><?php echo e($web['header']['social']); ?></span></div></div>
<header class="header"><div class="container"><a class="brand" href="#inicio"><?php echo e($web['header']['brand_text']); ?></a><nav class="nav"><a href="#inicio">Inicio</a><a href="#servicios">Servicios</a><a href="#nosotros">Nosotros</a><a href="<?php echo e($intranetUrl); ?>">Intranet</a><a href="#contacto">Contacto</a><a href="#contacto" class="nav__cta">Cotiza tu proyecto</a></nav></div></header>

<main id="inicio">
<section class="hero"><div class="container"><div class="hero-top"><div><div><?php echo e($web['hero']['rating']); ?></div><h1><?php echo e($web['hero']['title']); ?></h1></div><div><p class="hero-desc"><?php echo e($web['hero']['description']); ?></p><div class="chips"><a class="chip" href="tel:<?php echo e($tel); ?>"><?php echo e($web['hero']['phone']); ?></a><a class="chip" href="mailto:<?php echo e($web['hero']['email']); ?>"><?php echo e($web['hero']['email']); ?></a></div></div></div><div class="hero-media"><div class="ph" style="background-image:url('<?php echo e($web['hero']['image_main'] ?: 'https://images.unsplash.com/photo-1556740749-887f6717d7e4?q=80&w=1200&auto=format&fit=crop'); ?>')"></div><div class="ph video" style="background-image:linear-gradient(rgba(20,45,111,.55),rgba(20,45,111,.55)),url('<?php echo e($web['hero']['image_video'] ?: 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop'); ?>')">▶</div></div></div></section>

<section class="logos"><div class="container"><p><?php echo e($web['logos_title']); ?></p><div class="logo-row"><?php foreach (($web['logos'] ?? []) as $logo): ?><div class="logo"><?php echo e($logo); ?></div><?php endforeach; ?></div></div></section>

<section id="nosotros"><div class="container split"><div class="box"></div><div><h2><?php echo e($web['about']['title']); ?></h2><p class="lead"><?php echo e($web['about']['lead']); ?></p><div class="acc"><?php foreach (($web['about']['items'] ?? []) as $it): ?><div class="item"><div class="ttl"><?php echo e($it['title'] ?? ''); ?></div><div><?php echo e($it['text'] ?? ''); ?></div></div><?php endforeach; ?></div></div></div></section>

<section id="servicios"><div class="container"><h2 style="text-align:center"><?php echo e($web['services_title']); ?></h2><div class="cards"><?php foreach (($web['services'] ?? []) as $service): ?><article class="card"><h3><?php echo e($service['title'] ?? ''); ?></h3><p><?php echo e($service['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

<section><div class="container split"><div><h2><?php echo e($web['methodology']['title']); ?></h2><p class="lead"><?php echo e($web['methodology']['lead']); ?></p><div class="acc"><?php foreach (($web['methodology']['items'] ?? []) as $it): ?><div class="item"><div class="ttl"><?php echo e($it['title'] ?? ''); ?></div><div><?php echo e($it['text'] ?? ''); ?></div></div><?php endforeach; ?></div></div><div class="box"></div></div></section>

<section class="dark-band"><div class="container"><h2 style="text-align:center;color:#fff"><?php echo e($web['dark_band']['title']); ?></h2><div class="tabs"><?php foreach (($web['dark_band']['tabs'] ?? []) as $tab): ?><div class="tab"><?php echo e($tab); ?></div><?php endforeach; ?></div><div class="panel"><?php echo e($web['dark_band']['panel']); ?></div></div></section>

<section><div class="container"><h2 style="text-align:center"><?php echo e($web['plans_title']); ?></h2><div class="plans"><?php foreach (($web['plans'] ?? []) as $plan): ?><article class="plan"><h3><?php echo e($plan['name'] ?? ''); ?></h3><div class="price"><?php echo e($plan['price'] ?? ''); ?></div><ul><?php foreach (($plan['features'] ?? []) as $f): ?><li><?php echo e($f); ?></li><?php endforeach; ?></ul><a class="btn" href="#contacto"><?php echo e($plan['button'] ?? 'Cotizar ahora'); ?></a></article><?php endforeach; ?></div></div></section>

<section id="contacto"><div class="container" style="text-align:center"><h2><?php echo e($web['contact']['title']); ?></h2><p class="lead"><?php echo e($web['contact']['text']); ?><br><?php echo e($web['contact']['city']); ?> · <?php echo e($web['contact']['email']); ?> · <?php echo e($web['contact']['phone']); ?></p><a class="btn" href="mailto:<?php echo e($web['contact']['email']); ?>">Solicitar asesoría gratuita</a></div></section>
</main>

<footer class="footer"><div class="container footer-grid"><div><h4><?php echo e($web['header']['brand_text']); ?></h4><p><?php echo e($web['footer']['about']); ?></p><p><?php echo e($web['header']['social']); ?></p></div><div><h4>Accesos rápidos</h4><ul><?php foreach (($web['footer']['quick_links'] ?? []) as $link): ?><li><?php echo e($link); ?></li><?php endforeach; ?></ul></div><div><h4>Intranet Clientes</h4><p><?php echo e($web['footer']['intranet_text']); ?></p><a href="<?php echo e($intranetUrl); ?>">Intranet Cliente</a></div><div><h4>Contacto</h4><p><?php echo e($web['contact']['email']); ?><br><?php echo e($web['contact']['phone']); ?></p></div></div><div class="container copy">Desarrollado por Activa Web · © <?php echo date('Y'); ?></div></footer>
