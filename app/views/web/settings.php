<?php $w = $web ?? []; ?>
<style>
    .web-editor-preview {
        position: sticky;
        top: 90px;
    }
    .web-canvas {
        border: 1px solid #dfe4ef;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(12, 31, 79, .10);
        background: #fff;
    }
    .web-topline{padding:8px 14px;color:#fff;font-size:12px;display:flex;justify-content:space-between;gap:8px}
    .web-header{padding:12px 14px;color:#fff;display:flex;justify-content:space-between;align-items:center}
    .web-brand{font-weight:800;letter-spacing:.4px}
    .web-nav{font-size:12px;opacity:.9}
    .web-hero{padding:14px;color:#fff}
    .web-hero h2{margin:8px 0 6px;font-weight:800;line-height:1.05}
    .web-hero p{margin:0;opacity:.95}
    .web-chip{display:inline-block;font-size:11px;border:1px solid rgba(255,255,255,.4);padding:4px 8px;border-radius:6px;margin-right:6px;margin-top:8px}
    .web-section{padding:12px 14px;border-top:1px solid #eef2f7}
    .web-title{font-weight:700;margin-bottom:8px}
    .web-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:6px}
    .web-item{background:#f8faff;border:1px solid #e6ecf7;border-radius:8px;padding:8px;font-size:12px}
</style>

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0">WEB · Editor visual Landing <span class="badge bg-primary-subtle text-primary">beta</span></h4>
    <div class="d-flex gap-2">
        <a href="index.php?route=landing" target="_blank" class="btn btn-outline-primary">Ver landing</a>
        <button form="webSettingsForm" class="btn btn-primary" type="submit">Guardar cambios</button>
    </div>
</div>

<form id="webSettingsForm" method="post" action="index.php?route=web/settings/update" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card mb-3">
            <div class="card-header"><h5 class="mb-0">Apariencia global</h5></div>
            <div class="card-body row g-3">
                <div class="col-md-3"><label class="form-label">Color principal</label><input class="form-control" name="brand" value="<?php echo e($w['style']['brand'] ?? '#142d6f'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Color acento</label><input class="form-control" name="accent" value="<?php echo e($w['style']['accent'] ?? '#a3bdff'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Color fondo</label><input class="form-control" name="bg_soft" value="<?php echo e($w['style']['bg_soft'] ?? '#f6f7fb'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Fuente</label><input class="form-control" name="font_family" value="<?php echo e($w['style']['font_family'] ?? 'DM Sans'); ?>"></div>
                <div class="col-md-2"><label class="form-label">H1 (px)</label><input type="number" class="form-control" name="h1_size" value="<?php echo (int)($w['style']['h1_size'] ?? 64); ?>"></div>
                <div class="col-md-2"><label class="form-label">H2 (px)</label><input type="number" class="form-control" name="h2_size" value="<?php echo (int)($w['style']['h2_size'] ?? 52); ?>"></div>
                <div class="col-md-2"><label class="form-label">Body (px)</label><input type="number" class="form-control" name="body_size" value="<?php echo (int)($w['style']['body_size'] ?? 16); ?>"></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h5 class="mb-0">Header y Hero</h5></div>
            <div class="card-body row g-3">
                <div class="col-md-4"><label class="form-label">Texto marca</label><input class="form-control" name="brand_text" value="<?php echo e($w['header']['brand_text'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">Topline</label><input class="form-control" name="topline" value="<?php echo e($w['header']['topline'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">Redes (texto)</label><input class="form-control" name="social" value="<?php echo e($w['header']['social'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">URL botón Intranet</label><input class="form-control" name="intranet_url" value="<?php echo e($w['header']['intranet_url'] ?? 'login.php'); ?>"></div>
                <div class="col-md-6"><label class="form-label">Rating</label><input class="form-control" name="hero_rating" value="<?php echo e($w['hero']['rating'] ?? ''); ?>"></div>
                <div class="col-md-6"><label class="form-label">Título Hero</label><input class="form-control" name="hero_title" value="<?php echo e($w['hero']['title'] ?? ''); ?>"></div>
                <div class="col-12"><label class="form-label">Descripción Hero</label><textarea class="form-control" name="hero_description" rows="3"><?php echo e($w['hero']['description'] ?? ''); ?></textarea></div>
                <div class="col-md-4"><label class="form-label">Teléfono hero</label><input class="form-control" name="hero_phone" value="<?php echo e($w['hero']['phone'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">Correo hero</label><input class="form-control" name="hero_email" value="<?php echo e($w['hero']['email'] ?? ''); ?>"></div>
                <div class="col-md-2"><label class="form-label">Imagen hero izquierda</label><input type="file" name="hero_image_main" class="form-control"></div>
                <div class="col-md-2"><label class="form-label">Imagen hero derecha</label><input type="file" name="hero_image_video" class="form-control"></div>
            </div>
        </div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Logos / Clientes</h5></div><div class="card-body row g-3"><div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="logos_title" value="<?php echo e($w['logos_title'] ?? ''); ?>"></div><div class="col-12"><label class="form-label">Listado (1 por línea)</label><textarea class="form-control" rows="4" name="logos"><?php echo e(implode("\n", $w['logos'] ?? [])); ?></textarea></div></div></div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Nosotros</h5></div><div class="card-body row g-3"><div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="about_title" value="<?php echo e($w['about']['title'] ?? ''); ?>"></div><div class="col-md-6"><label class="form-label">Lead</label><input class="form-control" name="about_lead" value="<?php echo e($w['about']['lead'] ?? ''); ?>"></div><?php for ($i=1;$i<=3;$i++): $it = $w['about']['items'][$i-1] ?? ['title'=>'','text'=>'']; ?><div class="col-md-4"><label class="form-label">Acordeón <?php echo $i; ?> título</label><input class="form-control" name="about_item_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div><div class="col-md-8"><label class="form-label">Acordeón <?php echo $i; ?> texto</label><input class="form-control" name="about_item_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div><?php endfor; ?></div></div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Servicios</h5></div><div class="card-body row g-3"><div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="services_title" value="<?php echo e($w['services_title'] ?? ''); ?>"></div><?php for ($i=1;$i<=6;$i++): $it = $w['services'][$i-1] ?? ['title'=>'','text'=>'']; ?><div class="col-md-4"><label class="form-label">Servicio <?php echo $i; ?> título</label><input class="form-control" name="service_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div><div class="col-md-8"><label class="form-label">Servicio <?php echo $i; ?> texto</label><input class="form-control" name="service_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div><?php endfor; ?></div></div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Metodología</h5></div><div class="card-body row g-3"><div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="methodology_title" value="<?php echo e($w['methodology']['title'] ?? ''); ?>"></div><div class="col-md-6"><label class="form-label">Lead</label><input class="form-control" name="methodology_lead" value="<?php echo e($w['methodology']['lead'] ?? ''); ?>"></div><?php for ($i=1;$i<=3;$i++): $it = $w['methodology']['items'][$i-1] ?? ['title'=>'','text'=>'']; ?><div class="col-md-4"><label class="form-label">Paso <?php echo $i; ?> título</label><input class="form-control" name="methodology_item_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div><div class="col-md-8"><label class="form-label">Paso <?php echo $i; ?> texto</label><input class="form-control" name="methodology_item_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div><?php endfor; ?></div></div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Banda oscura</h5></div><div class="card-body row g-3"><div class="col-12"><label class="form-label">Título</label><input class="form-control" name="dark_title" value="<?php echo e($w['dark_band']['title'] ?? ''); ?>"></div><div class="col-12"><label class="form-label">Tabs (1 por línea)</label><textarea class="form-control" rows="3" name="dark_tabs"><?php echo e(implode("\n", $w['dark_band']['tabs'] ?? [])); ?></textarea></div><div class="col-12"><label class="form-label">Texto panel</label><textarea class="form-control" rows="2" name="dark_panel"><?php echo e($w['dark_band']['panel'] ?? ''); ?></textarea></div></div></div>

        <div class="card mb-3"><div class="card-header"><h5 class="mb-0">Planes</h5></div><div class="card-body row g-3"><div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="plans_title" value="<?php echo e($w['plans_title'] ?? ''); ?>"></div><?php for ($i=1;$i<=3;$i++): $pl = $w['plans'][$i-1] ?? ['name'=>'','price'=>'','features'=>[],'button'=>'Cotizar ahora']; ?><div class="col-md-4"><label class="form-label">Plan <?php echo $i; ?> nombre</label><input class="form-control" name="plan_name_<?php echo $i; ?>" value="<?php echo e($pl['name']); ?>"></div><div class="col-md-2"><label class="form-label">Plan <?php echo $i; ?> precio</label><input class="form-control" name="plan_price_<?php echo $i; ?>" value="<?php echo e($pl['price']); ?>"></div><div class="col-md-3"><label class="form-label">Botón</label><input class="form-control" name="plan_button_<?php echo $i; ?>" value="<?php echo e($pl['button']); ?>"></div><div class="col-md-3"><label class="form-label">Features (1 por línea)</label><textarea class="form-control" rows="3" name="plan_features_<?php echo $i; ?>"><?php echo e(implode("\n", $pl['features'] ?? [])); ?></textarea></div><?php endfor; ?></div></div>

        <div class="card"><div class="card-header"><h5 class="mb-0">Contacto y footer</h5></div><div class="card-body row g-3"><div class="col-12"><label class="form-label">Título contacto</label><input class="form-control" name="contact_title" value="<?php echo e($w['contact']['title'] ?? ''); ?>"></div><div class="col-12"><label class="form-label">Texto contacto</label><textarea class="form-control" rows="2" name="contact_text"><?php echo e($w['contact']['text'] ?? ''); ?></textarea></div><div class="col-md-4"><label class="form-label">Ciudad</label><input class="form-control" name="contact_city" value="<?php echo e($w['contact']['city'] ?? ''); ?>"></div><div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="contact_email" value="<?php echo e($w['contact']['email'] ?? ''); ?>"></div><div class="col-md-4"><label class="form-label">Teléfono</label><input class="form-control" name="contact_phone" value="<?php echo e($w['contact']['phone'] ?? ''); ?>"></div><div class="col-12"><label class="form-label">Footer descripción</label><textarea class="form-control" rows="2" name="footer_about"><?php echo e($w['footer']['about'] ?? ''); ?></textarea></div><div class="col-md-6"><label class="form-label">Footer links (1 por línea)</label><textarea class="form-control" rows="3" name="footer_links"><?php echo e(implode("\n", $w['footer']['quick_links'] ?? [])); ?></textarea></div><div class="col-md-6"><label class="form-label">Texto intranet</label><textarea class="form-control" rows="3" name="footer_intranet_text"><?php echo e($w['footer']['intranet_text'] ?? ''); ?></textarea></div></div></div>
    </div>

    <div class="col-xl-4">
        <div class="web-editor-preview">
            <div class="alert alert-primary mb-3 py-2">
                <strong>Vista previa en vivo:</strong> edita campos y verás cambios al instante (estilo Elementor).
            </div>
            <div class="web-canvas" id="webCanvas">
                <div class="web-topline" id="pvTopline"><span id="pvToplineText"><?php echo e($w['header']['topline'] ?? ''); ?></span><span id="pvSocial"><?php echo e($w['header']['social'] ?? ''); ?></span></div>
                <div class="web-header" id="pvHeader"><strong class="web-brand" id="pvBrand"><?php echo e($w['header']['brand_text'] ?? ''); ?></strong><span class="web-nav">Inicio · Servicios · Nosotros · Intranet</span></div>
                <div class="web-hero" id="pvHero">
                    <div style="font-size:11px;opacity:.9" id="pvRating"><?php echo e($w['hero']['rating'] ?? ''); ?></div>
                    <h2 id="pvHeroTitle"><?php echo e($w['hero']['title'] ?? ''); ?></h2>
                    <p id="pvHeroDesc"><?php echo e($w['hero']['description'] ?? ''); ?></p>
                    <span class="web-chip" id="pvPhone"><?php echo e($w['hero']['phone'] ?? ''); ?></span>
                    <span class="web-chip" id="pvEmail"><?php echo e($w['hero']['email'] ?? ''); ?></span>
                </div>
                <div class="web-section">
                    <div class="web-title" id="pvLogosTitle"><?php echo e($w['logos_title'] ?? ''); ?></div>
                    <div class="web-list" id="pvLogos"></div>
                </div>
                <div class="web-section">
                    <div class="web-title" id="pvServicesTitle"><?php echo e($w['services_title'] ?? ''); ?></div>
                    <div class="web-list" id="pvServices"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
(function(){
  const form = document.getElementById('webSettingsForm');
  const cssVars = ['brand','accent','bg_soft'];
  const bind = {
    brand_text: 'pvBrand', topline: 'pvToplineText', social: 'pvSocial',
    hero_rating: 'pvRating', hero_title: 'pvHeroTitle', hero_description: 'pvHeroDesc',
    hero_phone: 'pvPhone', hero_email: 'pvEmail', logos_title: 'pvLogosTitle', services_title: 'pvServicesTitle'
  };

  function lines(name){
    const el = form.querySelector(`[name="${name}"]`);
    if(!el) return [];
    return (el.value || '').split('\n').map(v=>v.trim()).filter(Boolean);
  }

  function renderLists(){
    const logos = lines('logos').slice(0,6);
    const services = [];
    for(let i=1;i<=4;i++){
      const t = form.querySelector(`[name="service_title_${i}"]`)?.value?.trim();
      if(t) services.push(t);
    }
    document.getElementById('pvLogos').innerHTML = logos.map(i=>`<div class="web-item">${i}</div>`).join('');
    document.getElementById('pvServices').innerHTML = services.map(i=>`<div class="web-item">${i}</div>`).join('');
  }

  function refresh(){
    Object.entries(bind).forEach(([name,id])=>{
      const el = form.querySelector(`[name="${name}"]`);
      const pv = document.getElementById(id);
      if(el && pv) pv.textContent = el.value;
    });

    const brand = form.querySelector('[name="brand"]')?.value || '#142d6f';
    const accent = form.querySelector('[name="accent"]')?.value || '#a3bdff';
    const bg = form.querySelector('[name="bg_soft"]')?.value || '#f6f7fb';
    const font = form.querySelector('[name="font_family"]')?.value || 'DM Sans';
    const h1 = parseInt(form.querySelector('[name="h1_size"]')?.value || '64',10);
    const body = parseInt(form.querySelector('[name="body_size"]')?.value || '16',10);

    const canvas = document.getElementById('webCanvas');
    canvas.style.background = bg;
    canvas.style.fontFamily = `${font}, system-ui, sans-serif`;
    document.getElementById('pvTopline').style.background = brand;
    document.getElementById('pvHeader').style.background = brand;
    document.getElementById('pvHero').style.background = brand;
    document.querySelectorAll('.web-chip').forEach(c=>c.style.background = accent);
    document.querySelectorAll('.web-chip').forEach(c=>c.style.color = '#132c6f');
    document.getElementById('pvHeroTitle').style.fontSize = Math.max(22, Math.round(h1*0.42)) + 'px';
    canvas.style.fontSize = Math.max(12, body-2) + 'px';

    renderLists();
  }

  form.addEventListener('input', refresh);
  refresh();
})();
</script>
