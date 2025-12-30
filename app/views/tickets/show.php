<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">Detalle del ticket</h5>
                <p class="mb-1">
                    <strong>Cliente:</strong>
                    <a href="index.php?route=clients/show&id=<?php echo (int)($ticket['client_id'] ?? 0); ?>" class="link-reset">
                        <?php echo e($ticket['client_name'] ?? ''); ?>
                    </a>
                </p>
                <p class="mb-1"><strong>Asunto:</strong> <?php echo e($ticket['subject'] ?? ''); ?></p>
                <p class="mb-3"><strong>Prioridad:</strong> <?php echo e(ucfirst($ticket['priority'] ?? 'media')); ?></p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="index.php?route=projects&client_id=<?php echo (int)($ticket['client_id'] ?? 0); ?>" class="btn btn-outline-primary btn-sm">Ver proyectos</a>
                    <a href="index.php?route=invoices&client_id=<?php echo (int)($ticket['client_id'] ?? 0); ?>" class="btn btn-outline-success btn-sm">Ver facturas</a>
                </div>

                <form method="post" action="index.php?route=tickets/status">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="ticket_id" value="<?php echo (int)$ticket['id']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <?php
                            $statuses = ['abierto' => 'Abierto', 'en_progreso' => 'En progreso', 'pendiente' => 'Pendiente', 'resuelto' => 'Resuelto', 'cerrado' => 'Cerrado'];
                            ?>
                            <?php foreach ($statuses as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php echo ($ticket['status'] ?? '') === $value ? 'selected' : ''; ?>>
                                    <?php echo e($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asignar a</label>
                        <select name="assigned_user_id" class="form-select">
                            <option value="">Sin asignar</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo (int)$user['id']; ?>" <?php echo (int)($ticket['assigned_user_id'] ?? 0) === (int)$user['id'] ? 'selected' : ''; ?>>
                                    <?php echo e($user['name'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar estado</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-3">Conversación</h5>
                <div class="flex-grow-1 overflow-auto mb-3" style="max-height: 420px;">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <?php
                            $isUser = ($message['sender_type'] ?? '') === 'user';
                            $bubbleClasses = $isUser ? 'bg-primary text-white ms-auto' : 'bg-light';
                            ?>
                            <div class="d-flex mb-3 <?php echo $isUser ? 'justify-content-end' : 'justify-content-start'; ?>">
                                <?php if (!$isUser): ?>
                                    <?php if (!empty($message['sender_avatar'])): ?>
                                        <img src="<?php echo e($message['sender_avatar']); ?>" alt="Avatar" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                            <?php echo e(strtoupper(substr($message['sender_name'] ?? 'C', 0, 1))); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="p-3 rounded-3 <?php echo $bubbleClasses; ?>" style="max-width: 75%;">
                                    <div class="fw-semibold mb-1"><?php echo e($message['sender_name'] ?? ($isUser ? 'Equipo' : 'Cliente')); ?></div>
                                    <div><?php echo nl2br(e($message['message'] ?? '')); ?></div>
                                    <?php if (!empty($message['created_at'])): ?>
                                        <div class="fs-xxs mt-2 <?php echo $isUser ? 'text-white-50' : 'text-muted'; ?>">
                                            <?php echo e($message['created_at']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($isUser): ?>
                                    <?php if (!empty($message['sender_avatar'])): ?>
                                        <img src="<?php echo e($message['sender_avatar']); ?>" alt="Avatar" class="rounded-circle ms-2" style="width: 36px; height: 36px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center ms-2" style="width: 36px; height: 36px;">
                                            <?php echo e(strtoupper(substr($message['sender_name'] ?? 'E', 0, 1))); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-muted">Aún no hay mensajes.</div>
                    <?php endif; ?>
                </div>
                <form method="post" action="index.php?route=tickets/message">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="ticket_id" value="<?php echo (int)$ticket['id']; ?>">
                    <div class="mb-2">
                        <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu respuesta..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
