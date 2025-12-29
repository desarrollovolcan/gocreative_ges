<?php

class TicketsController extends Controller
{
    private SupportTicketsModel $tickets;
    private SupportTicketMessagesModel $messages;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->tickets = new SupportTicketsModel($db);
        $this->messages = new SupportTicketMessagesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $tickets = $this->tickets->allWithClient();
        $this->render('tickets/index', [
            'title' => 'Tickets de soporte',
            'pageTitle' => 'Tickets de soporte',
            'tickets' => $tickets,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $clients = $this->db->fetchAll('SELECT id, name, email FROM clients WHERE deleted_at IS NULL ORDER BY name');
        $users = $this->db->fetchAll('SELECT id, name FROM users WHERE deleted_at IS NULL ORDER BY name');
        $this->render('tickets/create', [
            'title' => 'Nuevo ticket',
            'pageTitle' => 'Nuevo ticket',
            'clients' => $clients,
            'users' => $users,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $clientId = (int)($_POST['client_id'] ?? 0);
        $subject = trim($_POST['subject'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($clientId === 0 || $subject === '' || $description === '') {
            $_SESSION['error'] = 'Completa los campos obligatorios.';
            $this->redirect('index.php?route=tickets/create');
        }
        $priority = $_POST['priority'] ?? 'media';
        $assignedUser = (int)($_POST['assigned_user_id'] ?? 0);
        $now = date('Y-m-d H:i:s');
        $ticketId = $this->tickets->create([
            'client_id' => $clientId,
            'subject' => $subject,
            'description' => $description,
            'status' => 'abierto',
            'priority' => $priority,
            'assigned_user_id' => $assignedUser ?: null,
            'created_by_type' => 'user',
            'created_by_id' => (int)Auth::user()['id'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $this->messages->create([
            'ticket_id' => $ticketId,
            'sender_type' => 'user',
            'sender_id' => (int)Auth::user()['id'],
            'message' => $description,
            'created_at' => $now,
        ]);
        $this->redirect('index.php?route=tickets/show&id=' . $ticketId);
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $ticket = $this->tickets->findWithClient($id);
        if (!$ticket) {
            $this->redirect('index.php?route=tickets');
        }
        $messages = $this->messages->forTicket($id);
        $users = $this->db->fetchAll('SELECT id, name FROM users WHERE deleted_at IS NULL ORDER BY name');
        $this->render('tickets/show', [
            'title' => 'Ticket #' . $id,
            'pageTitle' => 'Ticket #' . $id,
            'ticket' => $ticket,
            'messages' => $messages,
            'users' => $users,
        ]);
    }

    public function addMessage(): void
    {
        $this->requireLogin();
        verify_csrf();
        $ticketId = (int)($_POST['ticket_id'] ?? 0);
        $message = trim($_POST['message'] ?? '');
        if ($ticketId === 0 || $message === '') {
            $_SESSION['error'] = 'Escribe un mensaje antes de enviar.';
            $this->redirect('index.php?route=tickets/show&id=' . $ticketId);
        }
        $ticket = $this->tickets->findWithClient($ticketId);
        if (!$ticket) {
            $this->redirect('index.php?route=tickets');
        }
        $now = date('Y-m-d H:i:s');
        $this->messages->create([
            'ticket_id' => $ticketId,
            'sender_type' => 'user',
            'sender_id' => (int)Auth::user()['id'],
            'message' => $message,
            'created_at' => $now,
        ]);
        $this->tickets->update($ticketId, [
            'updated_at' => $now,
        ]);
        $this->redirect('index.php?route=tickets/show&id=' . $ticketId);
    }

    public function updateStatus(): void
    {
        $this->requireLogin();
        verify_csrf();
        $ticketId = (int)($_POST['ticket_id'] ?? 0);
        $newStatus = trim($_POST['status'] ?? '');
        $assignedUser = (int)($_POST['assigned_user_id'] ?? 0);
        $ticket = $this->tickets->findWithClient($ticketId);
        if (!$ticket) {
            $this->redirect('index.php?route=tickets');
        }
        $allowed = ['abierto', 'en_progreso', 'pendiente', 'resuelto', 'cerrado'];
        if (!in_array($newStatus, $allowed, true)) {
            $_SESSION['error'] = 'Estado inválido.';
            $this->redirect('index.php?route=tickets/show&id=' . $ticketId);
        }
        $now = date('Y-m-d H:i:s');
        $data = [
            'status' => $newStatus,
            'assigned_user_id' => $assignedUser ?: null,
            'updated_at' => $now,
        ];
        if ($newStatus === 'cerrado') {
            $data['closed_at'] = $now;
        }
        $this->tickets->update($ticketId, $data);

        if (($ticket['status'] ?? '') !== $newStatus) {
            $mailer = new Mailer($this->db);
            $subject = 'Actualización de ticket #' . $ticketId;
            $html = sprintf(
                '<p>Hola %s,</p><p>Tu ticket <strong>#%s</strong> cambió de estado a <strong>%s</strong>.</p><p>Asunto: %s</p>',
                e($ticket['client_name'] ?? 'Cliente'),
                $ticketId,
                e(ucfirst(str_replace('_', ' ', $newStatus))),
                e($ticket['subject'] ?? '')
            );
            $mailer->send('support_ticket_status', $ticket['client_email'] ?? '', $subject, $html);
        }

        $_SESSION['success'] = 'Estado actualizado.';
        $this->redirect('index.php?route=tickets/show&id=' . $ticketId);
    }
}
