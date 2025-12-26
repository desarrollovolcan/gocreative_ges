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
        $config = $this->settings->get('smtp_' . $type, []);
        if (!is_array($config)) {
            $config = [];
        }
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $config['host'] ?? '';
            $mail->Port = (int)($config['port'] ?? 587);
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $security = $config['security'] ?? 'tls';
            if ($security === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($security === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->setFrom($config['from_email'] ?? $config['username'] ?? '', $config['from_name'] ?? '');
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
        } catch (Exception $e) {
            log_message('error', 'Mailer error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
