<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0"><?php echo e($project['name']); ?></h4>
    </div>
    <div class="card-body">
        <p class="text-muted"><?php echo e($project['description']); ?></p>
        <div class="row">
            <div class="col-md-4"><strong>Estado:</strong> <?php echo e($project['status']); ?></div>
            <div class="col-md-4"><strong>Inicio:</strong> <?php echo e($project['start_date']); ?></div>
            <div class="col-md-4"><strong>Entrega:</strong> <?php echo e($project['delivery_date']); ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><strong>Mandante:</strong> <?php echo e($project['mandante_name']); ?></div>
            <div class="col-md-6"><strong>Mandante RUT:</strong> <?php echo e($project['mandante_rut']); ?></div>
            <div class="col-md-6"><strong>Mandante Teléfono:</strong> <?php echo e($project['mandante_phone']); ?></div>
            <div class="col-md-6"><strong>Mandante Correo:</strong> <?php echo e($project['mandante_email']); ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h4 class="card-title mb-0">Checklist</h4></div>
    <div class="card-body">
        <ul class="list-group">
            <?php foreach ($checklist as $task): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo e($task['title']); ?>
                    <span class="badge bg-<?php echo $task['completed'] ? 'success' : 'warning'; ?>-subtle text-<?php echo $task['completed'] ? 'success' : 'warning'; ?>">
                        <?php echo $task['completed'] ? 'Listo' : 'Pendiente'; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
