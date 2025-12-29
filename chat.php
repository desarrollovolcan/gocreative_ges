<?php
require __DIR__ . '/app/bootstrap.php';

if (!Auth::check()) {
    header('Location: login.php');
    exit;
}

$chatModel = new ChatModel($db);
$currentUser = Auth::user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';

    if ($action === 'create_thread') {
        $clientId = (int)($_POST['client_id'] ?? 0);
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($clientId === 0 || $subject === '' || $message === '') {
            $_SESSION['chat_error'] = 'Completa el cliente, asunto y mensaje.';
        } else {
            $threadId = $chatModel->createThread($clientId, $subject);
            $chatModel->addMessage($threadId, 'user', (int)$currentUser['id'], $message);
            $_SESSION['chat_success'] = 'Conversación creada correctamente.';
            header('Location: chat.php?thread=' . $threadId);
            exit;
        }
    }

    if ($action === 'send_message') {
        $threadId = (int)($_POST['thread_id'] ?? 0);
        $message = trim($_POST['message'] ?? '');
        if ($threadId === 0 || $message === '') {
            $_SESSION['chat_error'] = 'Escribe un mensaje antes de enviar.';
        } else {
            $thread = $chatModel->getThread($threadId);
            if (!$thread) {
                $_SESSION['chat_error'] = 'No encontramos la conversación seleccionada.';
            } else {
                $chatModel->addMessage($threadId, 'user', (int)$currentUser['id'], $message);
                $_SESSION['chat_success'] = 'Mensaje enviado.';
                header('Location: chat.php?thread=' . $threadId);
                exit;
            }
        }
    }
}

$chatThreads = $chatModel->getThreadsForAdmin();
$activeThreadId = (int)($_GET['thread'] ?? 0);
if ($activeThreadId === 0 && !empty($chatThreads)) {
    $activeThreadId = (int)$chatThreads[0]['id'];
}

$activeThread = $activeThreadId ? $chatModel->getThread($activeThreadId) : null;
$chatMessages = $activeThread ? $chatModel->getMessages($activeThreadId) : [];
$clients = $db->fetchAll('SELECT id, name, email FROM clients WHERE deleted_at IS NULL ORDER BY name');
$chatSuccess = $_SESSION['chat_success'] ?? null;
$chatError = $_SESSION['chat_error'] ?? null;
unset($_SESSION['chat_success'], $_SESSION['chat_error']);
?>

<?php include('partials/html.php'); ?>

<head>
    <?php $title = "Chat"; include('partials/title-meta.php'); ?>

    <?php include('partials/head-css.php'); ?>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <?php include('partials/menu.php'); ?>

        <!-- ============================================================== -->
        <!-- Start Main Content -->
        <!-- ============================================================== -->

        <div class="content-page">

            <div class="container-fluid">

                <?php $subtitle = "Apps"; $title = "Chat"; include('partials/page-title.php'); ?>

                <?php if (!empty($chatError)): ?>
                    <div class="alert alert-danger"><?php echo e($chatError); ?></div>
                <?php endif; ?>
                <?php if (!empty($chatSuccess)): ?>
                    <div class="alert alert-success"><?php echo e($chatSuccess); ?></div>
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-xxl-4">
                        <div class="card h-100 mb-0">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Conversaciones</h5>
                                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#adminNewChat">
                                        <i class="ti ti-plus me-1"></i>Nuevo
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="collapse mb-3" id="adminNewChat">
                                    <div class="card card-body border">
                                        <form method="post" action="chat.php">
                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="action" value="create_thread">
                                            <div class="mb-3">
                                                <label class="form-label">Cliente</label>
                                                <select name="client_id" class="form-select" required>
                                                    <option value="">Selecciona un cliente</option>
                                                    <?php foreach ($clients as $client): ?>
                                                        <option value="<?php echo (int)$client['id']; ?>">
                                                            <?php echo e($client['name'] ?? ''); ?> · <?php echo e($client['email'] ?? ''); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Asunto</label>
                                                <input type="text" name="subject" class="form-control" placeholder="Ej. Planificación del proyecto" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mensaje inicial</label>
                                                <textarea name="message" class="form-control" rows="3" placeholder="Escribe el primer mensaje..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Crear conversación</button>
                                        </form>
                                    </div>
                                </div>

                                <?php if (!empty($chatThreads)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($chatThreads as $thread): ?>
                                            <?php $isActive = (int)$thread['id'] === $activeThreadId; ?>
                                            <a href="chat.php?thread=<?php echo (int)$thread['id']; ?>" class="list-group-item list-group-item-action <?php echo $isActive ? 'active' : ''; ?>">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="fw-semibold"><?php echo e($thread['client_name'] ?? 'Cliente'); ?></div>
                                                        <div class="text-muted fs-xs <?php echo $isActive ? 'text-white-50' : ''; ?>">
                                                            <?php echo e($thread['subject'] ?? 'Conversación'); ?>
                                                        </div>
                                                        <div class="text-muted fs-xxs <?php echo $isActive ? 'text-white-50' : ''; ?>">
                                                            <?php echo e($thread['last_message'] ?? 'Sin mensajes aún.'); ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($thread['last_message_at'])): ?>
                                                        <span class="fs-xxs text-muted <?php echo $isActive ? 'text-white-50' : ''; ?>">
                                                            <?php echo e($thread['last_message_at']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted fs-sm">Aún no existen conversaciones activas.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-8">
                        <div class="card h-100 mb-0">
                            <div class="card-header">
                                <?php if (!empty($activeThread)): ?>
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                                        <div>
                                            <h5 class="mb-1"><?php echo e($activeThread['client_name'] ?? 'Cliente'); ?></h5>
                                            <div class="text-muted fs-xs"><?php echo e($activeThread['subject'] ?? 'Conversación'); ?></div>
                                        </div>
                                        <span class="badge bg-success-subtle text-success"><?php echo e(ucfirst($activeThread['status'] ?? 'abierto')); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted">Selecciona una conversación para comenzar.</div>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column" style="min-height: 520px;">
                                <?php if (!empty($activeThread)): ?>
                                    <div class="flex-grow-1 overflow-auto mb-3" style="max-height: 420px;">
                                        <?php if (!empty($chatMessages)): ?>
                                            <?php foreach ($chatMessages as $message): ?>
                                                <?php
                                                $isUser = ($message['sender_type'] ?? '') === 'user';
                                                $bubbleClasses = $isUser ? 'bg-primary text-white ms-auto' : 'bg-light';
                                                ?>
                                                <div class="d-flex mb-3 <?php echo $isUser ? 'justify-content-end' : 'justify-content-start'; ?>">
                                                    <div class="p-3 rounded-3 <?php echo $bubbleClasses; ?>" style="max-width: 75%;">
                                                        <div class="fw-semibold mb-1"><?php echo e($message['sender_name'] ?? ($isUser ? 'Equipo' : 'Cliente')); ?></div>
                                                        <div><?php echo nl2br(e($message['message'] ?? '')); ?></div>
                                                        <?php if (!empty($message['created_at'])): ?>
                                                            <div class="fs-xxs mt-2 <?php echo $isUser ? 'text-white-50' : 'text-muted'; ?>">
                                                                <?php echo e($message['created_at']); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted">Aún no hay mensajes en esta conversación.</div>
                                        <?php endif; ?>
                                    </div>
                                    <form method="post" action="chat.php?thread=<?php echo (int)$activeThreadId; ?>" class="mt-auto">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="action" value="send_message">
                                        <input type="hidden" name="thread_id" value="<?php echo (int)$activeThreadId; ?>">
                                        <div class="mb-2">
                                            <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php include('partials/footer.php'); ?>

        </div>

        <?php include('partials/right-sidebar.php'); ?>

    </div>
    <!-- END wrapper -->

    <?php include('partials/footer-scripts.php'); ?>
</body>

</html>
