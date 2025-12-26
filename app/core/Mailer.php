<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private SettingsModel $settings;
    private string $lastError = '';

    public function __construct(Database $db)
    {
        $this->settings = new SettingsModel($db);
    }

    public function send(string $type, $to, string $subject, string $html, array $attachments = []): bool
    {
        $this->lastError = '';
        $defaultConfig = [
            'host' => 'mail.gocreative.cl',
            'port' => 465,
            'security' => 'ssl',
            'username' => 'informevolcan@gocreative.cl',
            'password' => '#(3-QiWGI;l}oJW_',
            'from_name' => 'Información',
            'from_email' => 'informevolcan@gocreative.cl',
            'reply_to' => 'informevolcan@gocreative.cl',
        ];
        $config = $this->settings->get('smtp_info', []);
        if (!is_array($config)) {
            $config = [];
        }
        $mergedConfig = $defaultConfig;
        foreach ($config as $key => $value) {
            if ($value !== null && $value !== '') {
                $mergedConfig[$key] = $value;
            }
        }
        $config = $mergedConfig;
        if (empty($config['host']) || empty($config['username']) || empty($config['password'])) {
            $this->lastError = 'Configuración SMTP incompleta.';
            log_message('error', 'Mailer config incomplete for smtp_info.');
            return false;
        }
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $config['host'] ?? '';
            $mail->Port = (int)($config['port'] ?? 587);
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $security = strtolower(trim($config['security'] ?? 'tls'));
            if ($security === 'ssl') {
                $mail->SMTPSecure = defined('PHPMailer\\PHPMailer\\PHPMailer::ENCRYPTION_SMTPS')
                    ? PHPMailer::ENCRYPTION_SMTPS
                    : 'ssl';
            } elseif ($security === 'tls') {
                $mail->SMTPSecure = defined('PHPMailer\\PHPMailer\\PHPMailer::ENCRYPTION_STARTTLS')
                    ? PHPMailer::ENCRYPTION_STARTTLS
                    : 'tls';
            } else {
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $fromEmail = $config['username'] ?? '';
            $mail->setFrom($fromEmail, $config['from_name'] ?? '');
            $mail->Sender = $fromEmail;
            if (!empty($config['from_email']) && $config['from_email'] !== $fromEmail) {
                $mail->addReplyTo($config['from_email']);
            } elseif (!empty($config['reply_to'])) {
                $mail->addReplyTo($config['reply_to']);
            }
            $mail->addCustomHeader('X-Mailer', 'GoCreative GES');
            $recipients = is_array($to) ? $to : [$to];
            $validRecipients = [];
            foreach ($recipients as $recipient) {
                $recipient = trim((string)$recipient);
                if ($recipient !== '' && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                    $mail->addAddress($recipient);
                    $validRecipients[] = $recipient;
                }
            }
            if (empty($validRecipients)) {
                $this->lastError = 'Sin destinatarios válidos.';
                log_message('error', 'Mailer error: no valid recipients.');
                return false;
            }
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = strip_tags($html);
            $mail->send();
            return true;
        } catch (Throwable $e) {
            $detail = $mail->ErrorInfo ?: $e->getMessage();
            $this->lastError = $detail;
            log_message('error', 'Mailer error: ' . $detail);
            return false;
        }
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }
}
