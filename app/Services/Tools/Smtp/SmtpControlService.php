<?php


namespace App\Services\Tools\Smtp;

use Exception;
use PHPMailer\PHPMailer\SMTP;

class SmtpControlService
{
    public SmtpControlResult $smtp;

    public function __construct(string $host, int $port, float $timeout = 10, ?string $username = null, ?string $password = null, ?string $from = null, ?string $to = null)
    {
        $this->smtp = new SmtpControlResult();
        $this->smtp->setStatus(true);

        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');
        $msg = [];

        //Create a new SMTP instance
        $smtp = new SMTP();

        //Enable to show all logs while load page
        //$smtp->do_debug = SMTP::DEBUG_CONNECTION;

        try {
            if (!$smtp->connect($host, $port, 5)) {
                $this->smtp->setStatus(false);
            }

            //Say hello
            if (!$smtp->hello(gethostname())) {
                $this->smtp->setStatus(false);
                $msg[] = 'EHLO failed: ' . $smtp->getError()['error'];
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();

            //If server can do TLS encryption, use it
            if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                $tlsOk = $smtp->startTLS();

                if (!$tlsOk) {
                    $this->smtp->setStatus(false);
                    $msg[] = 'Failed to start encryption: ' . $smtp->getError()['error'];
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname())) {
                    $this->smtp->setStatus(false);
                    $msg[] = 'EHLO (2) failed: ' . $smtp->getError()['error'];
                }

                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }

            //If server supports authentication, do it (even if no encryption)
            if (!empty($username) && !empty($password)) {
                if (is_array($e) && array_key_exists('AUTH', $e)) {
                    if (!$smtp->authenticate($username, $password)) {
                        $this->smtp->setStatus(false);
                        $msg[] = 'Authentication failed: ' . $smtp->getError()['error'];
                    }
                }
            }
            if (!empty($to) && !empty($from)) {
                if (!$smtp->mail($from)) {
                    $this->smtp->setStatus(false);
                    $msg[] = 'MAIL FROM: ' . $smtp->getError()['error'];
                }

                if (!$smtp->recipient($to)) {
                    $this->smtp->setStatus(false);
                    $msg[] = 'RCPT TO: ' . $smtp->getError()['error'];
                }
            }

            $smtp->quit();

            $this->smtp->setResponse(json_encode($msg));
        } catch (Exception $e) {
            $this->smtp->setStatus(false);
            $smtp->quit();
        }
    }
}
