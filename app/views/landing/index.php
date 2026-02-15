<style>
  :root {
    --brand: #142d6f;
    --brand-2: #1d3f97;
    --text: #142d6f;
    --muted: #5d6f9f;
    --bg-soft: #f6f7fb;
    --card: #ffffff;
    --line: rgba(20, 45, 111, 0.14);
    --accent: #a3bdff;
    --ok: #29b873;
    --danger: #e85d74;
    --container: 1200px;
  }

  * { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body {
    margin: 0;
    color: var(--text);
    background: var(--bg-soft);
    font-family: "DM Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  }

  .container {
    width: min(var(--container), calc(100% - 32px));
    margin-inline: auto;
  }

  .skip-link {
    position: absolute;
    left: 12px;
    top: 12px;
    transform: translateY(-140%);
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 10px 12px;
    z-index: 9999;
  }
  .skip-link:focus { transform: translateY(0); }

  a { color: inherit; text-decoration: none; }

  .topline {
    background: var(--brand);
    color: #fff;
    border-bottom: 1px solid rgba(255,255,255,.12);
    font-size: 14px;
  }
  .topline__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 10px 0;
  }
  .topline__social { display: flex; gap: 14px; opacity: .95; }

  .header {
    background: var(--brand);
    color: #fff;
    position: sticky;
    top: 0;
    z-index: 1000;
  }
  .header__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 16px 0;
  }
  .brand {
    font-weight: 800;
    font-size: 30px;
    letter-spacing: 1px;
  }
  .nav {
    display: flex;
    align-items: center;
    gap: 22px;
    font-size: 16px;
  }
  .nav a { opacity: .92; }
  .nav a:hover { opacity: 1; }
  .nav__cta {
    background: var(--accent);
    color: #132c6f;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 700;
  }
  .toggle {
    display: none;
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    background: transparent;
    border-radius: 8px;
    padding: 8px 10px;
  }

  .hero {
    background: var(--brand);
    color: #fff;
    padding: 34px 0 0;
    overflow: hidden;
  }
  .hero__top {
    display: grid;
    grid-template-columns: 1.3fr .9fr;
    gap: 34px;
    align-items: center;
  }
  .stars { color: #59d9a9; font-weight: 700; margin-bottom: 12px; }
  .hero h1 {
    margin: 0;
    font-size: clamp(34px, 5.2vw, 64px);
    line-height: .98;
    letter-spacing: -1.8px;
  }
  .hero__desc {
    font-size: 20px;
    line-height: 1.5;
    color: rgba(255,255,255,.9);
    margin-bottom: 28px;
  }
  .stores { display: flex; flex-wrap: wrap; gap: 12px; }
  .store {
    border: 1px solid rgba(255,255,255,.24);
    border-radius: 7px;
    padding: 12px 16px;
    font-size: 15px;
    background: rgba(0,0,0,.25);
  }

  .hero__mock {
    margin-top: 36px;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 22px;
    transform: translateY(42px);
  }
  .mock-card {
    background: #c6d6ff;
    border-radius: 10px;
    padding: 20px;
    min-height: 280px;
    border: 1px solid rgba(255,255,255,.22);
  }
  .mock-card--video {
    background: linear-gradient(rgba(29,63,151,.62), rgba(29,63,151,.62)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop') center/cover;
    display: grid;
    place-items: center;
    color: #fff;
    font-size: 56px;
  }

  .logos {
    background: #fff;
    padding: 64px 0 40px;
  }
  .logos p {
    margin: 0 0 26px;
    text-align: center;
    color: var(--muted);
    font-size: 16px;
  }
  .logo-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
  }
  .logo {
    border: 1px dashed var(--line);
    border-radius: 10px;
    padding: 22px 12px;
    text-align: center;
    font-weight: 700;
    color: #284181;
    background: #f9fbff;
  }

  section {
    padding: 68px 0;
  }
  .split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 52px;
    align-items: center;
  }
  .image-box {
    background: #c6d6ff;
    border-radius: 10px;
    min-height: 420px;
    border: 1px solid var(--line);
    padding: 18px;
  }
  .image-box--mini {
    min-height: 330px;
    display: grid;
    place-items: center;
    font-size: 62px;
    color: #3251a2;
  }
  h2 {
    margin: 0 0 18px;
    font-size: clamp(30px, 4vw, 52px);
    line-height: .98;
    letter-spacing: -1px;
  }
  .lead {
    margin: 0 0 24px;
    color: #3251a2;
    font-size: 18px;
    line-height: 1.45;
  }

  .acc {
    display: grid;
    gap: 14px;
  }
  .acc__item {
    border-bottom: 1px solid var(--line);
    padding-bottom: 12px;
  }
  .acc__btn {
    width: 100%;
    border: none;
    background: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font: inherit;
    color: var(--text);
    font-weight: 700;
    font-size: 24px;
    cursor: pointer;
    text-align: left;
  }
  .acc__panel {
    color: #3251a2;
    line-height: 1.6;
    display: none;
    padding-top: 8px;
    font-size: 17px;
  }
  .acc__item.is-open .acc__panel { display: block; }

  .cards-title {
    text-align: center;
    margin-bottom: 28px;
  }
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
  .feature {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 20px;
    min-height: 220px;
  }
  .feature h3 { margin: 0 0 8px; font-size: 30px; }
  .feature p { margin: 0; color: #3251a2; line-height: 1.6; font-size: 16px; }

  .dark-band {
    background: var(--brand);
    color: #fff;
    padding-bottom: 0;
  }
  .dark-band h2 {
    text-align: center;
    color: #fff;
    margin-bottom: 18px;
  }
  .band-tabs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 26px;
  }
  .band-tab {
    border-bottom: 2px solid rgba(255,255,255,.45);
    text-align: center;
    padding-bottom: 10px;
    font-weight: 700;
    opacity: .95;
    font-size: 20px;
  }
  .panel-mock {
    background: #8fa8e6;
    border-radius: 10px 10px 0 0;
    min-height: 360px;
    border: 1px solid rgba(255,255,255,.24);
    display: grid;
    place-items: center;
    color: #fff;
    font-size: 32px;
    text-align: center;
    padding: 20px;
  }

  .pricing h2 { text-align: center; }
  .pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .plan {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 20px;
    display: grid;
    grid-template-rows: auto auto 1fr auto;
    gap: 16px;
  }
  .price {
    font-size: 48px;
    font-weight: 700;
    line-height: 1;
  }
  .plan ul {
    margin: 0;
    padding-left: 18px;
    color: #3251a2;
    display: grid;
    gap: 8px;
    font-size: 16px;
  }
  .btn-block {
    border: none;
    background: var(--accent);
    color: #132c6f;
    padding: 12px 14px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 16px;
  }

  .cta-final {
    text-align: center;
    padding: 54px 0 88px;
    position: relative;
  }
  .cta-final p {
    max-width: 900px;
    margin: 0 auto 24px;
    color: #3251a2;
    line-height: 1.6;
    font-size: 18px;
  }
  .footer {
    background: var(--brand);
    color: #fff;
    padding: 56px 0 18px;
  }
  .footer__grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1fr 1fr;
    gap: 22px;
  }
  .footer h4 { margin: 0 0 14px; font-size: 24px; }
  .footer p, .footer li, .footer a { color: rgba(255,255,255,.9); font-size: 16px; }
  .footer ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 8px; }
  .newsletter {
    display: grid;
    gap: 10px;
  }
  .newsletter input {
    width: 100%;
    border: 1px solid rgba(255,255,255,.45);
    border-radius: 4px;
    background: transparent;
    color: #fff;
    padding: 10px 12px;
    font-size: 16px;
  }
  .newsletter button {
    border: none;
    border-radius: 4px;
    background: var(--accent);
    color: #132c6f;
    padding: 12px;
    font-weight: 700;
    font-size: 16px;
  }
  .copy {
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px solid rgba(255,255,255,.2);
    text-align: center;
    color: rgba(255,255,255,.86);
    font-size: 15px;
  }

  .to-top {
    position: fixed;
    right: 16px;
    bottom: 16px;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: #fff;
    background: var(--brand);
    border: 1px solid rgba(255,255,255,.4);
    opacity: 0;
    pointer-events: none;
    transition: .2s;
  }
  .to-top.is-show { opacity: 1; pointer-events: auto; }

  @media (max-width: 1080px) {
    .hero__top, .hero__mock, .split, .footer__grid { grid-template-columns: 1fr; }
    .cards-grid { grid-template-columns: 1fr; }
    .pricing-grid { grid-template-columns: 1fr; }
    .logo-row { grid-template-columns: repeat(2, 1fr); }
    .band-tabs { grid-template-columns: repeat(2, 1fr); }
    .nav { display: none; }
    .toggle { display: inline-block; }

    .brand { font-size: 24px; }
    .hero h1 { font-size: clamp(30px, 9vw, 42px); }
    .hero__desc { font-size: 17px; }
    h2 { font-size: clamp(28px, 8vw, 40px); }
    .acc__btn { font-size: 21px; }
    .nav.is-open {
      display: grid;
      position: absolute;
      top: 68px;
      left: 0;
      right: 0;
      background: var(--brand);
      padding: 12px 22px 18px;
    }
    .nav.is-open .nav__cta { text-align: center; }
  }
</style>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Activa Web",
  "url": "https://activa-web.cl/",
  "email": "hola@activa-web.cl",
  "telephone": "+628-123-9876",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Concepción",
    "addressRegion": "Biobío",
    "addressCountry": "CL"
  }
}
</script>

<a class="skip-link" href="#contenido">Ir al contenido</a>

<div class="topline">
  <div class="container topline__inner">
    <div><strong>Desarrollo escalable, crecemos con tu empresa!</strong></div>
    <div class="topline__social">Facebook · Instagram · Youtube</div>
  </div>
</div>

<header class="header" id="inicio">
  <div class="container header__inner">
    <a href="#inicio" class="brand" aria-label="ActivaWeb">ACTIVAWEB</a>
    <button class="toggle" id="menuToggle" aria-label="Abrir menú">☰</button>
    <nav class="nav" id="mainNav">
      <a href="#inicio">Inicio</a>
      <a href="#servicios">Servicios</a>
      <a href="#nosotros">Nosotros</a>
      <a href="/intranet">Intranet</a>
      <a href="#contacto">Contacto</a>
      <a href="#contacto" class="nav__cta">Cotiza tu proyecto</a>
    </nav>
  </div>
</header>

<main id="contenido">
  <section class="hero">
    <div class="container">
      <div class="hero__top">
        <div>
          <div class="stars">★★★★★ 4.8 / 5 rating by users</div>
          <h1>IMPULSAMOS TU PRESENCIA DIGITAL</h1>
        </div>
        <div>
          <p class="hero__desc">
            Desarrolla y haz crecer tu empresa. Creamos sitios web profesionales y sistemas web a medida para pymes en Chile,
            optimizados para generar clientes, automatizar procesos y mejorar la gestión digital.
          </p>
          <div class="stores">
            <a class="store" href="tel:+6281239876">+628-123-9876</a>
            <a class="store" href="mailto:hola@activa-web.cl">hola@activa-web.cl</a>
          </div>
        </div>
      </div>

      <div class="hero__mock">
        <div class="mock-card" aria-hidden="true"></div>
        <div class="mock-card mock-card--video" aria-hidden="true">▶</div>
      </div>
    </div>
  </section>

  <section class="logos">
    <div class="container">
      <p>Resultados reales, relaciones duraderas: empresas que confían en nuestras soluciones digitales.</p>
      <div class="logo-row" aria-label="Marcas">
        <div class="logo">Municipalidad Pozo Almonte</div>
        <div class="logo">Acqua Perla</div>
        <div class="logo">Volcan Foods</div>
        <div class="logo">Grupo LMR</div>
        <div class="logo">GBC Repuestos</div>
      </div>
    </div>
  </section>

  <section id="nosotros">
    <div class="container split">
      <div class="image-box image-box--mini" aria-hidden="true">◔</div>
      <div>
        <h2>Entregamos soluciones, construimos confianza</h2>
        <p class="lead">
          En ActivaWeb desarrollamos sistemas web y plataformas digitales a medida para empresas en Chile.
          Trabajamos de forma cercana y estratégica para optimizar procesos, aumentar productividad y fortalecer la presencia digital.
        </p>
        <div class="acc" id="accOne">
          <div class="acc__item is-open">
            <button class="acc__btn" type="button">Desarrollo de sistemas web a medida <span>−</span></button>
            <div class="acc__panel">Creamos plataformas personalizadas según los procesos de tu empresa, con control en tiempo real y escalabilidad.</div>
          </div>
          <div class="acc__item">
            <button class="acc__btn" type="button">Diseño y desarrollo de páginas web <span>+</span></button>
            <div class="acc__panel">Sitios profesionales, rápidos y optimizados para buscadores, orientados a atraer clientes y vender mejor.</div>
          </div>
          <div class="acc__item">
            <button class="acc__btn" type="button">Automatización de procesos empresariales <span>+</span></button>
            <div class="acc__panel">Digitalizamos tareas repetitivas e integramos áreas para reducir errores y aumentar productividad.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="servicios">
    <div class="container">
      <h2 class="cards-title">Soluciones digitales para hacer crecer tu empresa</h2>
      <div class="cards-grid">
        <article class="feature">
          <h3>Integración de sistemas y bases de datos</h3>
          <p>Conectamos plataformas, APIs y bases de datos para centralizar información y mejorar decisiones.</p>
        </article>
        <article class="feature">
          <h3>Plataformas de gestión para pymes</h3>
          <p>Sistemas de inventario, ventas, clientes y operaciones adaptados a pequeñas y medianas empresas chilenas.</p>
        </article>
        <article class="feature">
          <h3>Soporte, mejora y escalabilidad web</h3>
          <p>Mantenimiento y evolución continua para que la plataforma crezca junto a tu negocio.</p>
        </article>
        <article class="feature">
          <h3>Portafolio ActivaWeb (100+ proyectos)</h3>
          <p>Municipalidad Pozo Almonte, Acqua Perla, Volcan Foods, Grupo LMR, GBC Repuestos, Maysam Transporte y Palermo Vestidos.</p>
        </article>
      </div>
    </div>
  </section>

  <section>
    <div class="container split">
      <div>
        <h2>Nuestra metodología de desarrollo web</h2>
        <p class="lead">Levantamiento, desarrollo con QA e implementación con acompañamiento post-lanzamiento.</p>
        <div class="acc" id="accTwo">
          <div class="acc__item is-open">
            <button class="acc__btn" type="button">Levantamiento y conocimiento del rubro <span>−</span></button>
            <div class="acc__panel">Analizamos tu empresa y flujos para diseñar una solución alineada a tus objetivos comerciales.</div>
          </div>
          <div class="acc__item">
            <button class="acc__btn" type="button">Desarrollo, integraciones y QA <span>+</span></button>
            <div class="acc__panel">Construimos con tecnologías modernas, pruebas funcionales, seguridad y rendimiento.</div>
          </div>
          <div class="acc__item">
            <button class="acc__btn" type="button">Implementación y acompañamiento <span>+</span></button>
            <div class="acc__panel">Capacitamos equipos y damos soporte continuo para consolidar la transformación digital.</div>
          </div>
        </div>
      </div>
      <div class="image-box" aria-hidden="true"></div>
    </div>
  </section>

  <section class="dark-band">
    <div class="container">
      <h2>Impulsa la transformación digital de tu empresa hoy</h2>
      <div class="band-tabs">
        <div class="band-tab">Asesoría estratégica</div>
        <div class="band-tab">Desarrollo a medida</div>
        <div class="band-tab">Integraciones</div>
        <div class="band-tab">Soporte continuo</div>
      </div>
      <div class="panel-mock">
        Plataforma centralizada para clientes, operaciones y control de proyectos en tiempo real.
      </div>
    </div>
  </section>

  <section class="pricing">
    <div class="container">
      <h2>Planes de trabajo según etapa de tu empresa</h2>
      <div class="pricing-grid">
        <article class="plan">
          <h3>Plan Presencia Digital</h3>
          <div class="price">Web</div>
          <ul>
            <li>Sitio corporativo profesional</li>
            <li>SEO técnico inicial</li>
            <li>Formulario y analítica básica</li>
          </ul>
          <a class="btn-block" href="#contacto">Cotizar ahora</a>
        </article>

        <article class="plan">
          <h3>Plan Automatización</h3>
          <div class="price">Web+</div>
          <ul>
            <li>Procesos internos digitalizados</li>
            <li>Integración con APIs y datos</li>
            <li>Dashboard de seguimiento</li>
          </ul>
          <a class="btn-block" href="#contacto">Cotizar ahora</a>
        </article>

        <article class="plan">
          <h3>Plan Escalamiento</h3>
          <div class="price">Pro</div>
          <ul>
            <li>Plataforma a medida de alto tráfico</li>
            <li>Roadmap evolutivo y soporte prioritario</li>
            <li>Mejoras continuas por objetivos</li>
          </ul>
          <a class="btn-block" href="#contacto">Cotizar ahora</a>
        </article>
      </div>
    </div>
  </section>

  <section class="cta-final" id="contacto">
    <div class="container">
      <h2>Contáctanos ahora y convierte tu idea en una solución real</h2>
      <p>
        Acompañamos a emprendedores, pymes y profesionales con soporte cercano, experiencia técnica y foco en resultados.
        Concepción, Región del Bio bio, Chile · hola@activa-web.cl · ‪+56 9 8452 4563‬.
      </p>
      <a href="mailto:hola@activa-web.cl" class="nav__cta">Solicitar asesoría gratuita</a>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="container footer__grid">
    <div>
      <h4>ACTIVAWEB</h4>
      <p>Desarrollamos plataformas web, sistemas a medida y soluciones digitales para empresas en Chile.</p>
      <p style="margin-top:10px;">Facebook · Instagram · Youtube</p>
    </div>

    <div>
      <h4>Accesos rápidos</h4>
      <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#servicios">Servicios</a></li>
        <li><a href="#nosotros">Nosotros</a></li>
        <li><a href="/intranet">Intranet</a></li>
      </ul>
    </div>

    <div>
      <h4>Intranet Clientes</h4>
      <ul>
        <li><a href="/intranet">Intranet Cliente</a></li>
        <li>Control total de tus proyectos y más</li>
        <li><a href="#inicio">Scroll al inicio</a></li>
      </ul>
    </div>

    <div>
      <h4>Contacto</h4>
      <form class="newsletter" onsubmit="event.preventDefault(); alert('Gracias, te contactaremos pronto.');">
        <input type="email" placeholder="hola@tuempresa.cl" aria-label="Correo de contacto" required>
        <button type="submit">Suscribirme / Cotizar</button>
      </form>
      <p style="margin-top:10px;">hola@activa-web.cl<br>+628-123-9876</p>
    </div>
  </div>

  <div class="container copy">Desarrollado por Activa Web · © <span id="year"></span> Todos los derechos reservados</div>
</footer>

<a href="#inicio" class="to-top" id="toTop" aria-label="Volver arriba">↑</a>

<script>
  (function () {
    const year = document.getElementById('year');
    if (year) year.textContent = new Date().getFullYear();

    const toggle = document.getElementById('menuToggle');
    const nav = document.getElementById('mainNav');
    if (toggle && nav) {
      toggle.addEventListener('click', () => nav.classList.toggle('is-open'));
      nav.addEventListener('click', (e) => {
        if (e.target && e.target.tagName === 'A') nav.classList.remove('is-open');
      });
    }

    document.querySelectorAll('.acc').forEach((acc) => {
      acc.querySelectorAll('.acc__btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          const item = btn.closest('.acc__item');
          const isOpen = item.classList.contains('is-open');
          acc.querySelectorAll('.acc__item').forEach((it) => {
            it.classList.remove('is-open');
            const sign = it.querySelector('.acc__btn span');
            if (sign) sign.textContent = '+';
          });
          if (!isOpen) {
            item.classList.add('is-open');
            const sign = item.querySelector('.acc__btn span');
            if (sign) sign.textContent = '−';
          }
        });
      });
    });

    const toTop = document.getElementById('toTop');
    window.addEventListener('scroll', () => {
      if (!toTop) return;
      toTop.classList.toggle('is-show', window.scrollY > 500);
    }, { passive: true });
  })();
</script>
