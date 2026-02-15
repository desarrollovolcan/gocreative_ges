<?php $w = $web ?? []; ?>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0">WEB · Landing autoadministrable</h4>
    <a href="index.php?route=landing" target="_blank" class="btn btn-outline-primary">Ver landing</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="index.php?route=web/settings/update" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <h5 class="mb-3">Apariencia</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-3"><label class="form-label">Color principal</label><input class="form-control" name="brand" value="<?php echo e($w['style']['brand'] ?? '#142d6f'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Color acento</label><input class="form-control" name="accent" value="<?php echo e($w['style']['accent'] ?? '#a3bdff'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Color fondo</label><input class="form-control" name="bg_soft" value="<?php echo e($w['style']['bg_soft'] ?? '#f6f7fb'); ?>"></div>
                <div class="col-md-3"><label class="form-label">Fuente</label><input class="form-control" name="font_family" value="<?php echo e($w['style']['font_family'] ?? 'DM Sans'); ?>"></div>
                <div class="col-md-2"><label class="form-label">H1 (px)</label><input type="number" class="form-control" name="h1_size" value="<?php echo (int)($w['style']['h1_size'] ?? 64); ?>"></div>
                <div class="col-md-2"><label class="form-label">H2 (px)</label><input type="number" class="form-control" name="h2_size" value="<?php echo (int)($w['style']['h2_size'] ?? 52); ?>"></div>
                <div class="col-md-2"><label class="form-label">Body (px)</label><input type="number" class="form-control" name="body_size" value="<?php echo (int)($w['style']['body_size'] ?? 16); ?>"></div>
            </div>

            <h5 class="mb-3">Header y Hero</h5>
            <div class="row g-3 mb-4">
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

            <h5 class="mb-3">Logos / Clientes</h5>
            <div class="row g-3 mb-4">
                <div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="logos_title" value="<?php echo e($w['logos_title'] ?? ''); ?>"></div>
                <div class="col-12"><label class="form-label">Listado (1 por línea)</label><textarea class="form-control" rows="4" name="logos"><?php echo e(implode("\n", $w['logos'] ?? [])); ?></textarea></div>
            </div>

            <h5 class="mb-3">Nosotros</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="about_title" value="<?php echo e($w['about']['title'] ?? ''); ?>"></div>
                <div class="col-md-6"><label class="form-label">Lead</label><input class="form-control" name="about_lead" value="<?php echo e($w['about']['lead'] ?? ''); ?>"></div>
                <?php for ($i=1;$i<=3;$i++): $it = $w['about']['items'][$i-1] ?? ['title'=>'','text'=>'']; ?>
                <div class="col-md-4"><label class="form-label">Acordeón <?php echo $i; ?> título</label><input class="form-control" name="about_item_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div>
                <div class="col-md-8"><label class="form-label">Acordeón <?php echo $i; ?> texto</label><input class="form-control" name="about_item_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div>
                <?php endfor; ?>
            </div>

            <h5 class="mb-3">Servicios</h5>
            <div class="row g-3 mb-4">
                <div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="services_title" value="<?php echo e($w['services_title'] ?? ''); ?>"></div>
                <?php for ($i=1;$i<=6;$i++): $it = $w['services'][$i-1] ?? ['title'=>'','text'=>'']; ?>
                <div class="col-md-4"><label class="form-label">Servicio <?php echo $i; ?> título</label><input class="form-control" name="service_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div>
                <div class="col-md-8"><label class="form-label">Servicio <?php echo $i; ?> texto</label><input class="form-control" name="service_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div>
                <?php endfor; ?>
            </div>

            <h5 class="mb-3">Metodología</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="methodology_title" value="<?php echo e($w['methodology']['title'] ?? ''); ?>"></div>
                <div class="col-md-6"><label class="form-label">Lead</label><input class="form-control" name="methodology_lead" value="<?php echo e($w['methodology']['lead'] ?? ''); ?>"></div>
                <?php for ($i=1;$i<=3;$i++): $it = $w['methodology']['items'][$i-1] ?? ['title'=>'','text'=>'']; ?>
                <div class="col-md-4"><label class="form-label">Paso <?php echo $i; ?> título</label><input class="form-control" name="methodology_item_title_<?php echo $i; ?>" value="<?php echo e($it['title']); ?>"></div>
                <div class="col-md-8"><label class="form-label">Paso <?php echo $i; ?> texto</label><input class="form-control" name="methodology_item_text_<?php echo $i; ?>" value="<?php echo e($it['text']); ?>"></div>
                <?php endfor; ?>
            </div>

            <h5 class="mb-3">Banda oscura</h5>
            <div class="row g-3 mb-4">
                <div class="col-12"><label class="form-label">Título</label><input class="form-control" name="dark_title" value="<?php echo e($w['dark_band']['title'] ?? ''); ?>"></div>
                <div class="col-12"><label class="form-label">Tabs (1 por línea)</label><textarea class="form-control" rows="3" name="dark_tabs"><?php echo e(implode("\n", $w['dark_band']['tabs'] ?? [])); ?></textarea></div>
                <div class="col-12"><label class="form-label">Texto panel</label><textarea class="form-control" rows="2" name="dark_panel"><?php echo e($w['dark_band']['panel'] ?? ''); ?></textarea></div>
            </div>

            <h5 class="mb-3">Planes</h5>
            <div class="row g-3 mb-4">
                <div class="col-12"><label class="form-label">Título sección</label><input class="form-control" name="plans_title" value="<?php echo e($w['plans_title'] ?? ''); ?>"></div>
                <?php for ($i=1;$i<=3;$i++): $pl = $w['plans'][$i-1] ?? ['name'=>'','price'=>'','features'=>[],'button'=>'Cotizar ahora']; ?>
                <div class="col-md-4"><label class="form-label">Plan <?php echo $i; ?> nombre</label><input class="form-control" name="plan_name_<?php echo $i; ?>" value="<?php echo e($pl['name']); ?>"></div>
                <div class="col-md-2"><label class="form-label">Plan <?php echo $i; ?> precio</label><input class="form-control" name="plan_price_<?php echo $i; ?>" value="<?php echo e($pl['price']); ?>"></div>
                <div class="col-md-3"><label class="form-label">Botón</label><input class="form-control" name="plan_button_<?php echo $i; ?>" value="<?php echo e($pl['button']); ?>"></div>
                <div class="col-md-3"><label class="form-label">Features (1 por línea)</label><textarea class="form-control" rows="3" name="plan_features_<?php echo $i; ?>"><?php echo e(implode("\n", $pl['features'] ?? [])); ?></textarea></div>
                <?php endfor; ?>
            </div>

            <h5 class="mb-3">Contacto y footer</h5>
            <div class="row g-3 mb-4">
                <div class="col-12"><label class="form-label">Título contacto</label><input class="form-control" name="contact_title" value="<?php echo e($w['contact']['title'] ?? ''); ?>"></div>
                <div class="col-12"><label class="form-label">Texto contacto</label><textarea class="form-control" rows="2" name="contact_text"><?php echo e($w['contact']['text'] ?? ''); ?></textarea></div>
                <div class="col-md-4"><label class="form-label">Ciudad</label><input class="form-control" name="contact_city" value="<?php echo e($w['contact']['city'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">Email</label><input class="form-control" name="contact_email" value="<?php echo e($w['contact']['email'] ?? ''); ?>"></div>
                <div class="col-md-4"><label class="form-label">Teléfono</label><input class="form-control" name="contact_phone" value="<?php echo e($w['contact']['phone'] ?? ''); ?>"></div>
                <div class="col-12"><label class="form-label">Footer descripción</label><textarea class="form-control" rows="2" name="footer_about"><?php echo e($w['footer']['about'] ?? ''); ?></textarea></div>
                <div class="col-md-6"><label class="form-label">Footer links (1 por línea)</label><textarea class="form-control" rows="3" name="footer_links"><?php echo e(implode("\n", $w['footer']['quick_links'] ?? [])); ?></textarea></div>
                <div class="col-md-6"><label class="form-label">Texto intranet</label><textarea class="form-control" rows="3" name="footer_intranet_text"><?php echo e($w['footer']['intranet_text'] ?? ''); ?></textarea></div>
            </div>

            <div class="text-end">
                <button class="btn btn-primary" type="submit">Guardar configuración WEB</button>
            </div>
        </form>
    </div>
</div>
