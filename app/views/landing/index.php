<style>
    :root{
      --bg: #0b1220;
      --bg2:#0a1b2f;
      --surface: rgba(255,255,255,.92);
      --surface2: rgba(255,255,255,.75);
      --text: #0f172a;
      --muted:#475569;
      --muted2:#64748b;
      --border: rgba(15, 23, 42, .12);
      --brand:#2563eb;
      --brand2:#06b6d4;
      --ok:#16a34a;
      --danger:#dc2626;
      --shadow: 0 18px 50px rgba(2,6,23,.22);
      --shadow2: 0 8px 22px rgba(2,6,23,.14);
      --radius: 18px;
      --radius2: 14px;
      --container: 1120px;
      --pad: clamp(16px, 3vw, 28px);
    }

    *{ box-sizing:border-box; }
    html{ scroll-behavior:smooth; }
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
      color:var(--text);
      background:
        radial-gradient(1200px 500px at 15% 5%, rgba(37,99,235,.35), transparent 60%),
        radial-gradient(900px 500px at 85% 10%, rgba(6,182,212,.30), transparent 55%),
        linear-gradient(180deg, var(--bg), var(--bg2));
      min-height:100vh;
    }

    a{ color:inherit; text-decoration:none; }
    a:hover{ text-decoration:underline; }
    img{ max-width:100%; height:auto; }

    .container{
      width:min(var(--container), calc(100% - 2*var(--pad)));
      margin-inline:auto;
    }

    .sr-only{
      position:absolute !important;
      width:1px; height:1px;
      padding:0; margin:-1px;
      overflow:hidden; clip:rect(0,0,0,0);
      white-space:nowrap; border:0;
    }
    .skip-link{
      position:absolute;
      top:10px; left:10px;
      padding:10px 12px;
      background:#fff;
      border:1px solid var(--border);
      border-radius:12px;
      transform:translateY(-150%);
      transition:transform .18s ease;
      z-index:9999;
    }
    .skip-link:focus{ transform:translateY(0); outline: 3px solid rgba(37,99,235,.35); }

    .topbar{
      color:rgba(255,255,255,.92);
      border-bottom:1px solid rgba(255,255,255,.12);
      background: rgba(0,0,0,.18);
      backdrop-filter: blur(10px);
    }
    .topbar__inner{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      padding:10px 0;
      font-size:14px;
    }
    .topbar__msg{
      margin:0;
      color:rgba(255,255,255,.90);
    }
    .topbar__right{
      display:flex;
      align-items:center;
      gap:12px;
      flex-wrap:wrap;
      justify-content:flex-end;
    }
    .pill{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 10px;
      border-radius:999px;
      border:1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.08);
      text-decoration:none;
      white-space:nowrap;
    }
    .pill:hover{ text-decoration:none; background: rgba(255,255,255,.12); }
    .social{
      display:flex; align-items:center; gap:8px;
    }
    .iconbtn{
      width:34px; height:34px;
      display:inline-grid; place-items:center;
      border-radius:10px;
      border:1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.08);
    }
    .iconbtn:hover{ background: rgba(255,255,255,.12); text-decoration:none; }
    .iconbtn svg{ width:18px; height:18px; fill:rgba(255,255,255,.92); }

    header{
      position:sticky;
      top:0;
      z-index:1000;
      background: rgba(11,18,32,.55);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(255,255,255,.12);
    }
    .header__inner{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      padding:14px 0;
    }
    .brand{
      display:flex;
      align-items:center;
      gap:10px;
      text-decoration:none;
    }
    .brand:hover{ text-decoration:none; }
    .brand__logo{
      width:40px; height:40px;
      border-radius:14px;
      display:grid; place-items:center;
      background: linear-gradient(135deg, rgba(37,99,235,.95), rgba(6,182,212,.85));
      color:white;
      font-weight:800;
      letter-spacing:.5px;
      box-shadow: var(--shadow2);
    }
    .brand__name{
      color:rgba(255,255,255,.96);
      font-weight:800;
      letter-spacing:.2px;
    }
    .nav{
      display:flex;
      align-items:center;
      gap:18px;
      color:rgba(255,255,255,.92);
      font-weight:600;
    }
    .nav a{
      opacity:.92;
      text-decoration:none;
      padding:8px 10px;
      border-radius:12px;
    }
    .nav a:hover{
      background: rgba(255,255,255,.08);
      text-decoration:none;
      opacity:1;
    }
    .nav__secondary{
      border:1px solid rgba(255,255,255,.16);
      background: rgba(255,255,255,.06);
    }
    .header__cta{
      display:flex;
      gap:10px;
      align-items:center;
    }
    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:10px;
      padding:12px 14px;
      border-radius: 14px;
      border:1px solid transparent;
      font-weight:800;
      letter-spacing:.2px;
      text-decoration:none;
      cursor:pointer;
      user-select:none;
      white-space:nowrap;
    }
    .btn:hover{ text-decoration:none; }
    .btn--primary{
      color:white;
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      box-shadow: 0 14px 38px rgba(37,99,235,.22);
    }
    .btn--primary:hover{ filter: brightness(1.04); }
    .btn--ghost{
      color:rgba(255,255,255,.92);
      border-color: rgba(255,255,255,.20);
      background: rgba(255,255,255,.06);
    }
    .btn--ghost:hover{ background: rgba(255,255,255,.10); }

    .nav-toggle{
      display:none;
      padding:10px 12px;
      border-radius:14px;
      border:1px solid rgba(255,255,255,.18);
      background: rgba(255,255,255,.06);
      color:rgba(255,255,255,.92);
      cursor:pointer;
    }
    .nav-toggle:hover{ background: rgba(255,255,255,.10); }

    main{ padding-bottom: 64px; }
    section{
      padding: 56px 0;
    }

    .hero{
      padding: 34px 0 18px;
    }
    .hero__inner{
      display:grid;
      grid-template-columns: 1.25fr .75fr;
      gap: 18px;
      align-items:stretch;
    }
    .hero__left{
      padding: 34px;
      border-radius: var(--radius);
      background: rgba(255,255,255,.92);
      border:1px solid rgba(255,255,255,.55);
      box-shadow: var(--shadow);
    }
    .eyebrow{
      display:inline-flex;
      align-items:center;
      gap:10px;
      font-weight:900;
      letter-spacing:.12em;
      text-transform:uppercase;
      font-size:12px;
      color:#0b1220;
      background: rgba(37,99,235,.10);
      border:1px solid rgba(37,99,235,.18);
      padding:10px 12px;
      border-radius: 999px;
      margin:0 0 14px;
    }
    .hero h1{
      margin:0 0 12px;
      font-size: clamp(34px, 4.2vw, 54px);
      line-height:1.05;
      letter-spacing:-.02em;
    }
    .lead{
      margin:0 0 18px;
      color: var(--muted);
      font-size: clamp(16px, 1.4vw, 18px);
      line-height:1.6;
      max-width: 70ch;
    }
    .hero__actions{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
      margin: 18px 0;
    }
    .hero__bullets{
      margin: 14px 0 0;
      padding: 0;
      list-style:none;
      display:grid;
      gap:10px;
      color: var(--muted);
    }
    .hero__bullets li{
      display:flex;
      gap:10px;
      align-items:flex-start;
    }
    .hero__bullets li::before{
      content:"✓";
      color: var(--ok);
      font-weight:900;
      margin-top:1px;
    }

    .hero__card{
      background: rgba(255,255,255,.88);
      border:1px solid rgba(255,255,255,.55);
      box-shadow: var(--shadow);
      border-radius: var(--radius);
      padding: 22px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      gap:16px;
    }
    .cardtitle{
      margin:0;
      font-size:18px;
      letter-spacing:-.01em;
    }
    .small{
      color: var(--muted2);
      margin: 6px 0 0;
      line-height:1.5;
      font-size:14px;
    }
    .quick{
      display:grid;
      gap:10px;
      padding-top: 6px;
    }
    .quick a{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      padding:12px 12px;
      border-radius: 14px;
      border:1px solid rgba(15,23,42,.10);
      background: rgba(2,6,23,.03);
      text-decoration:none;
    }
    .quick a:hover{ background: rgba(2,6,23,.05); }
    .tag{
      display:inline-flex;
      align-items:center;
      padding: 6px 10px;
      border-radius: 999px;
      font-size:12px;
      font-weight:800;
      border:1px solid rgba(15,23,42,.12);
      background: rgba(255,255,255,.70);
      color:#0b1220;
    }

    .section-title{
      color: rgba(255,255,255,.92);
      margin: 0 0 10px;
      font-size: clamp(26px, 2.8vw, 36px);
      letter-spacing:-.02em;
    }
    .section-subtitle{
      color: rgba(255,255,255,.78);
      margin: 0 0 22px;
      max-width: 78ch;
      line-height:1.7;
    }

    .grid{
      display:grid;
      gap: 14px;
    }
    .grid--2{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .grid--3{ grid-template-columns: repeat(3, minmax(0, 1fr)); }

    .card{
      background: rgba(255,255,255,.92);
      border:1px solid rgba(255,255,255,.55);
      border-radius: var(--radius2);
      box-shadow: var(--shadow2);
      padding: 18px;
    }
    .card h3{
      margin:0 0 8px;
      font-size:18px;
      letter-spacing:-.01em;
    }
    .card p{
      margin:0;
      color: var(--muted);
      line-height:1.65;
    }

    .cta-band{
      padding: 0;
    }
    .cta-band .cta{
      margin-top: 12px;
      padding: 26px;
      border-radius: var(--radius);
      background: linear-gradient(135deg, rgba(37,99,235,.95), rgba(6,182,212,.88));
      box-shadow: var(--shadow);
      color:white;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      flex-wrap:wrap;
    }
    .cta h2{
      margin:0;
      font-size: clamp(20px, 2.2vw, 28px);
      letter-spacing:-.01em;
    }
    .cta p{
      margin:8px 0 0;
      max-width: 70ch;
      color: rgba(255,255,255,.90);
      line-height:1.65;
    }
    .cta .cta__actions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      align-items:center;
    }
    .btn--light{
      background: rgba(255,255,255,.96);
      color:#0b1220;
      border:1px solid rgba(255,255,255,.65);
    }
    .btn--light:hover{ filter: brightness(1.02); }

    .kpi{
      display:flex;
      align-items:baseline;
      gap:10px;
      margin-top: 14px;
      color: rgba(255,255,255,.92);
    }
    .kpi strong{
      font-size: 38px;
      letter-spacing:-.02em;
    }
    .kpi span{ color: rgba(255,255,255,.78); }

    .contact-wrap{
      background: rgba(255,255,255,.92);
      border:1px solid rgba(255,255,255,.55);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 22px;
    }
    form{
      display:grid;
      gap:12px;
    }
    label{
      font-weight:800;
      font-size:13px;
      color:#0b1220;
      letter-spacing:.02em;
    }
    input, textarea{
      width:100%;
      padding:12px 12px;
      border-radius: 14px;
      border:1px solid rgba(15,23,42,.14);
      background: rgba(255,255,255,.86);
      font: inherit;
    }
    input:focus, textarea:focus{
      outline: 3px solid rgba(37,99,235,.22);
      border-color: rgba(37,99,235,.35);
    }
    textarea{ min-height: 120px; resize: vertical; }
    .form-row{
      display:grid;
      gap:12px;
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .hint{
      color: var(--muted2);
      font-size: 13px;
      line-height:1.5;
      margin: 0;
    }
    .notice{
      display:none;
      border-radius: 14px;
      padding: 12px 12px;
      border: 1px solid rgba(15,23,42,.14);
      background: rgba(22,163,74,.10);
      color: #0b1220;
      font-weight:700;
    }
    .notice--error{
      background: rgba(220,38,38,.10);
    }

    footer{
      padding: 34px 0 50px;
      color: rgba(255,255,255,.82);
    }
    .footer__grid{
      display:grid;
      gap:14px;
      grid-template-columns: 1.2fr .8fr;
      align-items:start;
    }
    .foot-card{
      border:1px solid rgba(255,255,255,.12);
      background: rgba(255,255,255,.06);
      border-radius: var(--radius);
      padding: 18px;
    }
    .foot-card h3{
      margin:0 0 10px;
      color: rgba(255,255,255,.92);
      letter-spacing:-.01em;
    }
    .foot-card p{ margin:0; color: rgba(255,255,255,.78); line-height:1.7; }
    .foot-links{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top: 12px;
    }
    .foot-links a{
      padding:10px 12px;
      border-radius: 14px;
      border:1px solid rgba(255,255,255,.12);
      background: rgba(255,255,255,.06);
      text-decoration:none;
    }
    .foot-links a:hover{ background: rgba(255,255,255,.10); }

    .to-top{
      position: fixed;
      right: 18px;
      bottom: 18px;
      z-index:1500;
      display:none;
      padding: 12px 13px;
      border-radius: 16px;
      border:1px solid rgba(255,255,255,.18);
      background: rgba(11,18,32,.62);
      backdrop-filter: blur(12px);
      color: rgba(255,255,255,.92);
      box-shadow: var(--shadow2);
    }
    .to-top:hover{ text-decoration:none; background: rgba(11,18,32,.74); }

    @media (max-width: 980px){
      .hero__inner{ grid-template-columns: 1fr; }
      .grid--3{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .footer__grid{ grid-template-columns: 1fr; }
    }
    @media (max-width: 760px){
      .header__cta{ display:none; }
      .nav-toggle{ display:inline-flex; align-items:center; gap:10px; }
      .nav{
        position: absolute;
        left: 0; right: 0;
        top: 100%;
        margin: 0;
        display:none;
        flex-direction:column;
        gap: 0;
        padding: 10px;
        background: rgba(11,18,32,.92);
        border-bottom: 1px solid rgba(255,255,255,.12);
      }
      .nav a{
        width:100%;
        padding: 14px 12px;
      }
      .nav.is-open{ display:flex; }
      .grid--2{ grid-template-columns: 1fr; }
      .grid--3{ grid-template-columns: 1fr; }
      .form-row{ grid-template-columns: 1fr; }
    }

    @media (prefers-reduced-motion: reduce){
      html{ scroll-behavior:auto; }
      *{ transition:none !important; animation:none !important; }
    }
</style>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Activa Web",
  "url": "https://activa-web.cl/",
  "email": "hola@activa-web.cl",
  "telephone": "+56984524563",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Concepción",
    "addressRegion": "Biobío",
    "addressCountry": "CL"
  },
  "sameAs": [
    "https://www.facebook.com/",
    "https://www.instagram.com/",
    "https://www.youtube.com/"
  ]
}
</script>

<a class="skip-link" href="#contenido">Ir al contenido</a>

<div class="topbar">
  <div class="container topbar__inner">
    <p class="topbar__msg"><strong>Desarrollo escalable, crecemos con tu empresa!</strong></p>

    <div class="topbar__right" aria-label="Redes y contacto rápido">
      <div class="social" aria-label="Redes sociales">
        <a class="iconbtn" href="#" aria-label="Facebook" title="Facebook">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3H13.5V9.1c0-.9.3-1.6 1.6-1.6H16.8V4.8c-.3 0-1.4-.1-2.7-.1-2.7 0-4.6 1.6-4.6 4.6V11H7v3h2.5v8h4z"/></svg>
        </a>
        <a class="iconbtn" href="#" aria-label="Instagram" title="Instagram">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4.3A3.7 3.7 0 1 1 8.3 12 3.7 3.7 0 0 1 12 8.3zm0 2A1.7 1.7 0 1 0 13.7 12 1.7 1.7 0 0 0 12 10.3zM18 6.8a.9.9 0 1 1-.9.9.9.9 0 0 1 .9-.9z"/></svg>
        </a>
        <a class="iconbtn" href="#" aria-label="YouTube" title="YouTube">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.8 7.4a3 3 0 0 0-2.1-2.1C17.9 4.8 12 4.8 12 4.8s-5.9 0-7.7.5A3 3 0 0 0 2.2 7.4 31.6 31.6 0 0 0 1.7 12c0 1.6.2 3.1.5 4.6a3 3 0 0 0 2.1 2.1c1.8.5 7.7.5 7.7.5s5.9 0 7.7-.5a3 3 0 0 0 2.1-2.1c.3-1.5.5-3 .5-4.6s-.2-3.1-.5-4.6zM10.4 15.2V8.8L15.8 12l-5.4 3.2z"/></svg>
        </a>
      </div>

      <a class="pill" href="tel:+6281239876" aria-label="Llamar al +628-123-9876">+628-123-9876</a>
      <a class="pill" href="mailto:hola@activa-web.cl" aria-label="Escribir al correo hola@activa-web.cl">hola@activa-web.cl</a>
    </div>
  </div>
</div>

<header>
  <div class="container header__inner">
    <a class="brand" href="#inicio" aria-label="Ir al inicio">
      <span class="brand__logo" aria-hidden="true">AW</span>
      <span class="brand__name">ActivaWeb</span>
    </a>

    <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="siteNav">
      <span aria-hidden="true">☰</span>
      <span class="sr-only">Abrir menú</span>
    </button>

    <nav class="nav" id="siteNav" aria-label="Navegación principal">
      <a href="#inicio">Inicio</a>
      <a href="#servicios">Servicios</a>
      <a href="#nosotros">Nosotros</a>
      <a class="nav__secondary" href="/intranet">Intranet</a>
    </nav>

    <div class="header__cta">
      <a class="btn btn--ghost" href="tel:+6281239876">Llamar</a>
      <a class="btn btn--primary" href="#contacto">Cotiza tu proyecto</a>
    </div>
  </div>
</header>

<main id="contenido">
  <section class="hero" id="inicio" aria-labelledby="heroTitle">
    <div class="container hero__inner">
      <div class="hero__left">
        <p class="eyebrow">IMPULSAMOS TU PRESENCIA DIGITAL</p>
        <h1 id="heroTitle">Desarrolla y haz crecer tu empresa</h1>
        <p class="lead">
          Creamos sitios web profesionales y sistemas web a medida para pymes en Chile.
          Diseñamos plataformas optimizadas, rápidas y enfocadas en generar clientes,
          automatizar procesos y mejorar la gestión digital de tu negocio.
        </p>

        <div class="hero__actions" aria-label="Acciones principales">
          <a class="btn btn--primary" href="#contacto">Cotiza tu proyecto</a>
          <a class="btn btn--ghost" href="#portafolio">Ver portafolio</a>
        </div>

        <ul class="hero__bullets" aria-label="Beneficios">
          <li>Soluciones tecnológicas eficientes y escalables.</li>
          <li>Optimización para buscadores y velocidad de carga.</li>
          <li>Soporte continuo y mejoras a largo plazo.</li>
        </ul>
      </div>

      <aside class="hero__card" aria-label="Contacto rápido">
        <div>
          <p class="cardtitle">Cotiza en minutos</p>
          <p class="small">Cuéntanos tu idea y te respondemos con una propuesta clara y aterrizada.</p>
        </div>

        <div class="quick">
          <a href="tel:+6281239876" aria-label="Llamar ahora">
            <span><strong>Teléfono</strong><span class="small" style="display:block">+628-123-9876</span></span>
            <span class="tag">Llamar</span>
          </a>
          <a href="mailto:hola@activa-web.cl" aria-label="Escribir por email">
            <span><strong>Email</strong><span class="small" style="display:block">hola@activa-web.cl</span></span>
            <span class="tag">Escribir</span>
          </a>
          <a href="#contacto" aria-label="Ir al formulario de cotización">
            <span><strong>Formulario</strong><span class="small" style="display:block">Cotiza tu proyecto</span></span>
            <span class="tag">Cotizar</span>
          </a>
        </div>

        <p class="small" style="margin:0; border-top:1px solid rgba(15,23,42,.10); padding-top:14px;">
          <strong>Enfoque:</strong> resultados reales, relaciones duraderas.
        </p>
      </aside>
    </div>
  </section>

  <section id="nosotros" aria-labelledby="nosotrosTitle">
    <div class="container">
      <h2 class="section-title" id="nosotrosTitle">Resultados reales, relaciones duraderas</h2>
      <p class="section-subtitle">
        Entregamos soluciones, construimos confianza. En ActivaWeb desarrollamos sistemas web y plataformas digitales
        a medida para empresas en Chile, enfocándonos en optimizar procesos, aumentar productividad y fortalecer tu presencia digital.
        Trabajamos de forma cercana y estratégica, entendiendo tus flujos de trabajo y objetivos comerciales.
      </p>

      <div class="grid grid--2">
        <div class="card">
          <h3>Soluciones tecnológicas con impacto</h3>
          <p>
            Desarrollos eficientes, escalables y orientados a resultados: automatización, control de información y mejora continua
            para acompañar el crecimiento del negocio.
          </p>
        </div>
        <div class="card">
          <h3>Soporte y evolución</h3>
          <p>
            Nuestro compromiso es una relación de largo plazo: soporte post-lanzamiento, mejoras continuas y nuevas funcionalidades
            para que tu plataforma evolucione contigo.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="servicios" aria-labelledby="serviciosTitle">
    <div class="container">
      <h2 class="section-title" id="serviciosTitle">Soluciones digitales para hacer crecer tu empresa</h2>
      <p class="section-subtitle">
        Servicios pensados para pymes en Chile: desde páginas web rápidas hasta plataformas internas y sistemas a medida.
      </p>

      <div class="grid grid--3" role="list">
        <article class="card" role="listitem">
          <h3>Desarrollo de sistemas web a medida</h3>
          <p>Plataformas personalizadas según tus procesos: flujos de trabajo, gestión interna y control en tiempo real.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Diseño y desarrollo de páginas web</h3>
          <p>Sitios profesionales, rápidos y optimizados para buscadores, enfocados en atraer clientes y comunicar confianza.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Automatización de procesos empresariales</h3>
          <p>Digitalizamos tareas repetitivas y conectamos áreas para reducir errores, ahorrar tiempo y aumentar productividad.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Integración de sistemas y bases de datos</h3>
          <p>Conectamos plataformas, APIs y bases de datos para centralizar información y mejorar la toma de decisiones.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Plataformas de gestión para pymes</h3>
          <p>Sistemas de inventario, ventas, clientes y operaciones adaptados a pequeñas y medianas empresas.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Soporte, mejora y escalabilidad web</h3>
          <p>Mantenimiento, optimización y nuevas funciones para que tu plataforma crezca con tu empresa.</p>
        </article>
      </div>
    </div>
  </section>

  <section id="metodologia" aria-labelledby="metodoTitle">
    <div class="container">
      <h2 class="section-title" id="metodoTitle">Metodología profesional</h2>
      <p class="section-subtitle">
        Un proceso claro para reducir riesgos, asegurar calidad y entregar una plataforma estable, rápida y confiable.
      </p>

      <div class="grid grid--3" role="list">
        <article class="card" role="listitem">
          <h3>Levantamiento y conocimiento del rubro</h3>
          <p>
            Analizamos tu empresa, procesos internos y flujos de información para diseñar una solución alineada a objetivos
            comerciales y operativos.
          </p>
        </article>

        <article class="card" role="listitem">
          <h3>Desarrollo, integraciones y QA</h3>
          <p>
            Construimos con tecnologías modernas, integraciones necesarias y bases de datos optimizadas. Probamos funcionalidad,
            seguridad y rendimiento.
          </p>
        </article>

        <article class="card" role="listitem">
          <h3>Implementación y acompañamiento</h3>
          <p>
            Puesta en marcha, capacitación y soporte post-lanzamiento. Seguimos optimizando para acompañar el crecimiento.
          </p>
        </article>
      </div>
    </div>
  </section>

  <section class="cta-band" aria-label="Llamado a la acción principal">
    <div class="container">
      <div class="cta">
        <div>
          <h2>Impulsa la transformación digital de tu empresa hoy</h2>
          <p>
            Obtén una asesoría gratuita y descubre cómo un sistema web a medida puede optimizar tus procesos,
            aumentar tu productividad y hacer crecer tu negocio.
          </p>
        </div>
        <div class="cta__actions">
          <a class="btn btn--light" href="tel:+56984524563">+56 9 8452 4563</a>
          <a class="btn btn--light" href="mailto:hola@activa-web.cl">hola@activa-web.cl</a>
          <a class="btn btn--primary" href="#contacto">Quiero cotizar</a>
        </div>
      </div>
    </div>
  </section>

  <section id="portafolio" aria-labelledby="portafolioTitle">
    <div class="container">
      <h2 class="section-title" id="portafolioTitle">Portafolio ActivaWeb</h2>
      <p class="section-subtitle">
        Proyectos recientes, construyendo confianza y relaciones duraderas. Desarrollamos plataformas web y sistemas a medida,
        enfocados en resultados reales, optimización de procesos y crecimiento sostenible.
      </p>

      <div class="kpi" aria-label="Métrica de proyectos realizados">
        <strong>100+</strong>
        <span>Proyectos realizados</span>
      </div>

      <div class="grid grid--3" style="margin-top:16px;" role="list">
        <article class="card" role="listitem">
          <h3>Gestión de eventos · Municipalidad Pozo Almonte</h3>
          <p>Plataforma digital para organizar, administrar y monitorear eventos municipales de forma eficiente y centralizada.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Sistema gestión agua · Acqua Perla</h3>
          <p>Sistema web para el control operativo, comercial y de distribución en empresa de agua purificada.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Software de trazabilidad · Volcan Foods</h3>
          <p>Plataforma de trazabilidad para controlar procesos productivos y seguimiento de productos en tiempo real.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Web informativa · Grupo LMR</h3>
          <p>Sitio corporativo profesional que fortalece la presencia digital y comunica los servicios de la empresa.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Web informativa · GBC Repuestos</h3>
          <p>Página web corporativa orientada a mostrar catálogo, servicios y facilitar el contacto con clientes.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Web informativa · Maysam Servicios de transporte</h3>
          <p>Sitio web empresarial que presenta servicios de transporte, genera confianza y facilita la captación de clientes.</p>
        </article>

        <article class="card" role="listitem">
          <h3>Web tienda · Palermo Vestidos</h3>
          <p>Tienda online moderna para exhibir y vender vestidos con una experiencia de compra simple y atractiva.</p>
        </article>
      </div>
    </div>
  </section>

  <section id="contacto" aria-labelledby="contactoTitle">
    <div class="container">
      <h2 class="section-title" id="contactoTitle">Contáctanos ahora</h2>
      <p class="section-subtitle">
        Cuéntanos qué necesitas y te ayudamos a convertir tu idea en una solución digital sólida, moderna y pensada para generar resultados reales.
        Analizamos tu requerimiento y te proponemos la mejor estrategia para tu negocio.
      </p>

      <div class="contact-wrap">
        <div class="grid grid--2" style="align-items:start;">
          <div>
            <p class="cardtitle" style="margin:0 0 10px;">Formulario de cotización</p>
            <p class="small" style="margin:0 0 14px;">
              Respuesta rápida: deja tus datos y una descripción breve del proyecto.
            </p>

            <div class="notice" id="formNotice" role="status" aria-live="polite"></div>

            <form id="leadForm" novalidate>
              <div class="form-row">
                <div>
                  <label for="nombre">Nombre</label>
                  <input id="nombre" name="nombre" type="text" autocomplete="name" required />
                </div>
                <div>
                  <label for="empresa">Empresa</label>
                  <input id="empresa" name="empresa" type="text" autocomplete="organization" />
                </div>
              </div>

              <div class="form-row">
                <div>
                  <label for="email">Correo</label>
                  <input id="email" name="email" type="email" autocomplete="email" required />
                </div>
                <div>
                  <label for="telefono">Teléfono</label>
                  <input id="telefono" name="telefono" type="tel" autocomplete="tel" placeholder="+56 9 ..." />
                </div>
              </div>

              <div>
                <label for="mensaje">¿Qué necesitas?</label>
                <textarea id="mensaje" name="mensaje" required placeholder="Ej: necesito un sistema para inventario + ventas, o una web corporativa con formulario de contacto..."></textarea>
              </div>

              <p class="hint">
                Al enviar, se abrirá tu cliente de correo para crear el mensaje. (Puedes conectar este formulario a un endpoint o servicio de envío cuando lo publiques.)
              </p>

              <button class="btn btn--primary" type="submit">Enviar solicitud</button>
            </form>
          </div>

          <div>
            <p class="cardtitle" style="margin:0 0 10px;">Contacto</p>
            <p class="small" style="margin:0 0 12px;">
              Concepción, Región del Bio bio, Chile
            </p>

            <div class="quick" aria-label="Datos de contacto">
              <a href="mailto:hola@activa-web.cl">
                <span><strong>Email</strong><span class="small" style="display:block">hola@activa-web.cl</span></span>
                <span class="tag">Mail</span>
              </a>
              <a href="tel:+56984524563">
                <span><strong>Teléfono</strong><span class="small" style="display:block">+56 9 8452 4563</span></span>
                <span class="tag">Llamar</span>
              </a>
              <a href="/intranet">
                <span><strong>Intranet cliente</strong><span class="small" style="display:block">Accede a tu plataforma privada</span></span>
                <span class="tag">Entrar</span>
              </a>
            </div>

            <div style="margin-top:14px;">
              <p class="cardtitle" style="margin:0 0 10px;">Accesos rápidos</p>
              <div class="foot-links" aria-label="Accesos rápidos">
                <a href="#inicio">Inicio</a>
                <a href="/intranet">Intranet</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#contacto">Contacto</a>
              </div>
            </div>

            <div style="margin-top:16px;">
              <p class="small" style="margin:0;">
                Acompañamos a emprendedores, pymes y profesionales con soluciones digitales y soporte cercano,
                combinando experiencia técnica con un trato humano y comprometido.
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>

<footer aria-label="Pie de página">
  <div class="container footer__grid">
    <div class="foot-card">
      <h3>Intranet Clientes</h3>
      <p>Accede a tu plataforma privada y mantén el control total de tus proyectos y más.</p>
      <div class="foot-links">
        <a href="/intranet">Intranet Cliente</a>
        <a href="#inicio">Scroll al inicio</a>
      </div>
    </div>

    <div class="foot-card">
      <h3>Desarrollado por Activa Web</h3>
      <p style="margin-top:8px;">© <span id="year"></span> · Todos los derechos reservados.</p>
    </div>
  </div>
</footer>

<a class="to-top" id="toTop" href="#inicio" aria-label="Volver arriba">↑</a>

<script>
(function () {
  const navToggle = document.getElementById('navToggle');
  const nav = document.getElementById('siteNav');
  const year = document.getElementById('year');
  const toTop = document.getElementById('toTop');

  if (year) year.textContent = new Date().getFullYear();

  if (navToggle && nav) {
    navToggle.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    nav.addEventListener('click', (e) => {
      const target = e.target;
      if (target && target.tagName === 'A' && target.getAttribute('href')?.startsWith('#')) {
        nav.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  window.addEventListener('scroll', () => {
    if (!toTop) return;
    if (window.scrollY > 700) toTop.style.display = 'inline-flex';
    else toTop.style.display = 'none';
  }, { passive: true });

  const form = document.getElementById('leadForm');
  const notice = document.getElementById('formNotice');

  function showNotice(msg, isError) {
    if (!notice) return;
    notice.style.display = 'block';
    notice.classList.toggle('notice--error', !!isError);
    notice.textContent = msg;
  }

  function escapeText(s) {
    return String(s || '').replace(/\s+/g, ' ').trim();
  }

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const nombre = escapeText(document.getElementById('nombre')?.value);
      const empresa = escapeText(document.getElementById('empresa')?.value);
      const email = escapeText(document.getElementById('email')?.value);
      const telefono = escapeText(document.getElementById('telefono')?.value);
      const mensaje = escapeText(document.getElementById('mensaje')?.value);

      if (!nombre || !email || !mensaje) {
        showNotice('Por favor completa al menos: Nombre, Correo y Qué necesitas.', true);
        return;
      }

      const subject = encodeURIComponent('Cotización / Consulta - ActivaWeb');
      const bodyLines = [
        'Hola ActivaWeb,',
        '',
        'Quiero cotizar / consultar un proyecto:',
        '',
        '— Datos',
        `Nombre: ${nombre}`,
        `Empresa: ${empresa || '(no indicada)'}`,
        `Correo: ${email}`,
        `Teléfono: ${telefono || '(no indicado)'}`,
        '',
        '— Requerimiento',
        mensaje,
        '',
        'Gracias.'
      ];
      const body = encodeURIComponent(bodyLines.join('\n'));

      const mailTo = `mailto:hola@activa-web.cl?subject=${subject}&body=${body}`;

      showNotice('Listo. Se abrirá tu correo para enviar la solicitud.', false);
      window.location.href = mailTo;
    });
  }
})();
</script>
