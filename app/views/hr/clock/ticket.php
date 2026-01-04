<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Ticket de marcación</h4>
            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
        </div>
        <div class="border rounded p-3" style="max-width: 420px;">
            <div class="fw-semibold"><?php echo e($employeeName); ?></div>
            <div class="text-muted">RUT: <?php echo e($employeeRut); ?></div>
            <div class="mt-2">Acción: <strong><?php echo e(ucfirst($action)); ?></strong></div>
            <div>Fecha: <?php echo e($date); ?></div>
            <div>Hora: <?php echo e($time); ?></div>
        </div>
        <div class="text-muted mt-3">Se imprimió automáticamente el comprobante de entrada/salida.</div>
    </div>
</div>
<script>
    window.onload = () => {
        window.print();
    };
</script>
