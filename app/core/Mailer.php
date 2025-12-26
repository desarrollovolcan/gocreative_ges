<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private SettingsModel $settings;

    public function __construct(Database $db)
    {
        $this->settings = new SettingsModel($db);
    }

    public function send(string $type, string $to, string $subject, string $html, array $attachments = []): bool
    {
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
        $config = array_merge($defaultConfig, $config);
        if (empty($config['host']) || empty($config['username']) || empty($config['password'])) {
            log_message('error', 'Mailer config incomplete for smtp_info.');
            return false;
        }
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = $config['host'] ?? '';
            $mail->Port = (int)($config['port'] ?? 587);
            $mail->SMTPAuth = !empty($config['username']);
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $security = strtolower(trim($config['security'] ?? 'tls'));
            if ($security === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($security === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
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

            $fromEmail = $config['from_email'] ?? $config['username'] ?? '';
            if ($fromEmail === '' && !empty($config['reply_to'])) {
                $fromEmail = $config['reply_to'];
            }
            $mail->setFrom($fromEmail, $config['from_name'] ?? '');
            if (!empty($config['reply_to'])) {
                $mail->addReplyTo($config['reply_to']);
            }
            $mail->addAddress($to);
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
            log_message('error', 'Mailer error: ' . $detail);
            return false;
        }
    }
}
