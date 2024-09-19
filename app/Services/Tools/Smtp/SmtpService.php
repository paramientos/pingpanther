<?php

namespace App\Services\Tools\Smtp;

use App\Exceptions\CustomException;
use App\Services\Tools\Exception;

class SmtpService
{
    protected int $timeout = 10;

    protected string $host;

    protected int $port;

    protected bool $ssl = false;

    protected bool $tls = false;

    protected string $username;

    protected string $password;

    protected $socket = null;

    protected array $boundary = array();

    protected ?string $subject = null;

    protected array $body = array();

    protected array $to = array();

    protected array $cc = array();

    protected array $bcc = array();

    protected array $attachments = array();

    private bool $debugging = false;

    public function __construct(
        string $host,
        string $user,
        string $pass,
        int    $timeout,
        int    $port = null,
        bool   $ssl = false,
        bool   $tls = false,
    )
    {
        if (is_null($port)) {
            $port = $ssl ? 465 : 587;
        }

        $this->host = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->port = $port;
        $this->ssl = $ssl;
        $this->tls = $tls;
        $this->timeout = $timeout;

        $this->boundary[] = md5(time() . '1');
        $this->boundary[] = md5(time() . '2');
    }

    public function addAttachment($filename, $data, $mime = null): static
    {
        $this->attachments[] = array($filename, $data, $mime);
        return $this;
    }


    public function addBCC($email, $name = null): static
    {
        $this->bcc[$email] = $name;
        return $this;
    }

    public function addCC($email, $name = null): static
    {
        $this->cc[$email] = $name;
        return $this;
    }

    public function addTo($email, $name = null): static
    {
        $this->to[$email] = $name;
        return $this;
    }

    /**
     * @throws CustomException
     */
    public function connect(bool $test = false): static
    {
        $host = $this->host;

        if ($this->ssl) {
            $host = 'ssl://' . $host;
        } else {
            $host = 'tcp://' . $host;
        }

        $errno = 0;
        $errStr = '';
        $this->socket = stream_socket_client($host . ':' . $this->port, $errno, $errStr, $this->timeout);

        if (!$this->socket || strlen($errStr) > 0 || $errno > 0) {
            //throw exception
            Exception::i()
                ->setMessage('server')
                ->addVariable($host . ':' . $this->port)
                ->trigger();
        }

        $this->receive();

        if (!$this->call('EHLO ' . $_SERVER['HTTP_HOST'], 250)
            && !$this->call('HELO ' . $_SERVER['HTTP_HOST'], 250)) {
            $this->disconnect();
            //throw exception
            Exception::i()
                ->setMessage('server')
                ->addVariable($host . ':' . $this->port)
                ->trigger();
        }

        if ($this->tls && !$this->call('STARTTLS', 220, 250)) {
            if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                $this->disconnect();
                //throw exception
                Exception::i()
                    ->setMessage('tls')
                    ->addVariable($host . ':' . $this->port)
                    ->trigger();
            }

            if (!$this->call('EHLO ' . $_SERVER['HTTP_HOST'], 250)
                && !$this->call('HELO ' . $_SERVER['HTTP_HOST'], 250)) {
                $this->disconnect();
                //throw exception
                Exception::i()
                    ->setMessage('server')
                    ->addVariable($host . ':' . $this->port)
                    ->trigger();
            }
        }

        if ($test) {
            $this->disconnect();
            return $this;
        }

        //login
        if (!$this->call('AUTH LOGIN', 250, 334)) {
            $this->disconnect();
            throw new CustomException('Login error');
        }

        if (!$this->call(base64_encode($this->username), 334)) {
            $this->disconnect();
            throw new CustomException('Login error');
        }

        if (!$this->call(base64_encode($this->password), 235, 334)) {
            $this->disconnect();
            throw new CustomException('Login error');
        }

        return $this;
    }

    public function disconnect(): static
    {
        if ($this->socket) {
            $this->push('QUIT');

            fclose($this->socket);

            $this->socket = null;
        }

        return $this;
    }

    public function reply($messageId, $topic = null, array $headers = array()): array
    {
        //if no socket
        if (!$this->socket) {
            //then connect
            $this->connect();
        }

        //add from
        $name = $this->getValue();

        $headers = $this->getHeaders($headers);
        $body = $this->getBody();

        $headers['In-Reply-To'] = $messageId;

        if ($topic) {
            $headers['Thread-Topic'] = $topic;
        }

        //send header data
        foreach ($headers as $name => $value) {
            var_dump($name . ': ' . $value);
            $this->push($name . ': ' . $value);
        }

        //send body data
        foreach ($body as $line) {
            if (str_starts_with($line, '.')) {
                // Escape lines prefixed with a '.'
                $line = '.' . $line;
            }

            $this->push($line);
        }

        //tell server this is the end
        if (!$this->call("\r\n.\r\n", 250)) {
            $this->disconnect();
            //throw exception
            Exception::i('smtp data')->trigger();
        }

        //reset (some reason without this, this class spazzes out)
        $this->push('RSET');

        return $headers;
    }

    public function reset(): static
    {
        $this->subject = null;
        $this->body = array();
        $this->to = array();
        $this->cc = array();
        $this->bcc = array();
        $this->attachments = array();

        $this->disconnect();

        return $this;
    }

    public function send(array $headers = array()): array
    {
        //if no socket
        if (!$this->socket) {
            //then connect
            $this->connect();
        }

        $headers = $this->getHeaders($headers);
        $body = $this->getBody();

        //add from
        $name = $this->getValue();

        //send header data
        foreach ($headers as $name => $value) {
            $this->push($name . ': ' . $value);
        }

        //send body data
        foreach ($body as $line) {
            if (str_starts_with($line, '.')) {
                // Escape lines prefixed with a '.'
                $line = '.' . $line;
            }

            $this->push($line);
        }

        //tell server this is the end
        if (!$this->call(".", 250)) {
            $this->disconnect();
            //throw exception
            Exception::i('smtp data')->trigger();
        }

        //reset (some reason without this, this class spazzes out)
        $this->push('RSET');

        return $headers;
    }

    public function setBody($body, $html = false): static
    {
        if ($html) {
            $this->body['text/html'] = $body;
            $body = strip_tags($body);
        }

        $this->body['text/plain'] = $body;

        return $this;
    }

    public function setSubject($subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        if (!$this->call('MAIL FROM:<' . $this->username . '>', 250, 251)) {
            $this->disconnect();
            //throw exception
            Exception::i()
                ->setMessage('add mail')
                ->addVariable($this->username)
                ->trigger();
        }

        //add to
        foreach ($this->to as $email => $name) {
            if (!$this->call('RCPT TO:<' . $email . '>', 250, 251)) {
                $this->disconnect();
                //throw exception
                Exception::i()
                    ->setMessage('add mail')
                    ->addVariable($email)
                    ->trigger();
            }
        }

        //add cc
        foreach ($this->cc as $email => $name) {
            if (!$this->call('RCPT TO:<' . $email . '>', 250, 251)) {
                $this->disconnect();
                //throw exception
                Exception::i()
                    ->setMessage('add mail')
                    ->addVariable($email)
                    ->trigger();
            }
        }

        //add bcc
        foreach ($this->bcc as $email => $name) {
            if (!$this->call('RCPT TO:<' . $email . '>', 250, 251)) {
                $this->disconnect();
                //throw exception
                Exception::i()
                    ->setMessage('add mail')
                    ->addVariable($email)
                    ->trigger();
            }
        }

        //start compose
        if (!$this->call('DATA', 354)) {
            $this->disconnect();
            //throw exception
            Exception::i('smtp data')->trigger();
        }
        return $name;
    }

    protected function addAttachmentBody(array $body): array
    {
        foreach ($this->attachments as $attachment) {
            list($name, $data, $mime) = $attachment;
            $mime = '';
            $data = base64_encode($data);
            $count = ceil(strlen($data) / 998);

            $body[] = '--' . $this->boundary[1];
            $body[] = 'Content-type: ' . $mime . '; name="' . $name . '"';
            $body[] = 'Content-disposition: attachment; filename="' . $name . '"';
            $body[] = 'Content-transfer-encoding: base64';
            $body[] = null;

            for ($i = 0; $i < $count; $i++) {
                $body[] = substr($data, ($i * 998), 998);
            }

            $body[] = null;
            $body[] = null;
        }

        $body[] = '--' . $this->boundary[1] . '--';

        return $body;
    }

    protected function call($command, $code = null): bool|string
    {
        if (!$this->push($command)) {
            return false;
        }

        $receive = $this->receive();

        $args = func_get_args();
        if (count($args) > 1) {
            for ($i = 1; $i < count($args); $i++) {
                if (str_starts_with($receive, (string)$args[$i])) {
                    return true;
                }
            }

            return false;
        }

        return $receive;
    }

    protected function getAlternativeAttachmentBody(): array
    {
        $alternative = $this->getAlternativeBody();

        return $this->getContent($alternative);
    }

    protected function getAlternativeBody(): array
    {
        $plain = $this->getPlainBody();
        $html = $this->getHtmlBody();

        $body = array();
        $body[] = 'Content-Type: multipart/alternative; boundary="' . $this->boundary[0] . '"';
        $body[] = null;
        $body[] = '--' . $this->boundary[0];

        foreach ($plain as $line) {
            $body[] = $line;
        }

        $body[] = '--' . $this->boundary[0];

        foreach ($html as $line) {
            $body[] = $line;
        }

        $body[] = '--' . $this->boundary[0] . '--';
        $body[] = null;
        $body[] = null;

        return $body;
    }

    protected function getBody()
    {
        $type = 'Plain';
        if (count($this->body) > 1) {
            $type = 'Alternative';
        } else if (isset($this->body['text/html'])) {
            $type = 'Html';
        }

        $method = 'get%sBody';
        if (!empty($this->attachments)) {
            $method = 'get%sAttachmentBody';
        }

        $method = sprintf($method, $type);

        return $this->$method();
    }

    protected function getHeaders(array $customHeaders = array())
    {
        $timestamp = $this->getTimestamp();

        $subject = trim($this->subject);
        $subject = str_replace(array("\n", "\r"), '', $subject);

        $to = $cc = $bcc = array();
        foreach ($this->to as $email => $name) {
            $to[] = trim($name . ' <' . $email . '>');
        }

        foreach ($this->cc as $email => $name) {
            $cc[] = trim($name . ' <' . $email . '>');
        }

        foreach ($this->bcc as $email => $name) {
            $bcc[] = trim($name . ' <' . $email . '>');
        }

        list($account, $suffix) = explode('@', $this->username);

        $headers = array(
            'Date' => $timestamp,
            'Subject' => $subject,
            'From' => '<' . $this->username . '>',
            'To' => implode(', ', $to));

        if (!empty($cc)) {
            $headers['Cc'] = implode(', ', $cc);
        }

        if (!empty($bcc)) {
            $headers['Bcc'] = implode(', ', $bcc);
        }

        $headers['Message-ID'] = '<' . md5(uniqid(time())) . '.eden@' . $suffix . '>';

        $headers['Thread-Topic'] = $this->subject;

        $headers['Reply-To'] = '<' . $this->username . '>';

        foreach ($customHeaders as $key => $value) {
            $headers[$key] = $value;
        }

        return $headers;
    }

    protected function getHtmlAttachmentBody(): array
    {
        $html = $this->getHtmlBody();

        return $this->getContent($html);
    }

    protected function getHtmlBody(): array
    {
        $charset = $this->isUtf8($this->body['text/html']) ? 'utf-8' : 'US-ASCII';
        $html = str_replace("\r", '', trim($this->body['text/html']));

        $encoded = explode("\n", $this->quotedPrintableEncode($html));
        $body = array();
        $body[] = 'Content-Type: text/html; charset=' . $charset;
        $body[] = 'Content-Transfer-Encoding: quoted-printable' . "\n";

        foreach ($encoded as $line) {
            $body[] = $line;
        }

        $body[] = null;
        $body[] = null;

        return $body;
    }

    protected function getPlainAttachmentBody(): array
    {
        $plain = $this->getPlainBody();

        return $this->getContent($plain);
    }

    protected function getPlainBody(): array
    {
        $charset = $this->isUtf8($this->body['text/plain']) ? 'utf-8' : 'US-ASCII';
        $plane = str_replace("\r", '', trim($this->body['text/plain']));
        $count = ceil(strlen($plane) / 998);

        $body = array();
        $body[] = 'Content-Type: text/plain; charset=' . $charset;
        $body[] = 'Content-Transfer-Encoding: 7bit';
        $body[] = null;

        for ($i = 0; $i < $count; $i++) {
            $body[] = substr($plane, ($i * 998), 998);
        }

        $body[] = null;
        $body[] = null;

        return $body;
    }

    protected function receive(): string
    {
        $data = '';
        $now = time();

        while ($str = fgets($this->socket, 1024)) {
            $data .= $str;

            if (substr($str, 3, 1) == ' ' || time() > ($now + $this->timeout)) {
                break;
            }
        }

        $this->debug('Receiving: ' . $data);

        return $data;
    }

    protected function push($command): false|int
    {
        $this->debug('Sending: ' . $command);

        return fwrite($this->socket, $command . "\r\n");
    }

    private function debug($string): void
    {
        if ($this->debugging) {
            $string = htmlspecialchars($string);
            echo '<pre>' . $string . '</pre>' . "\n";
        }

    }

    private function getTimestamp(): string
    {
        $zone = date('Z');
        $sign = ($zone < 0) ? '-' : '+';
        $zone = abs($zone);
        $zone = (int)($zone / 3600) * 100 + ($zone % 3600) / 60;
        return sprintf("%s %s%04d", date('D, j M Y H:i:s'), $sign, $zone);
    }

    private function isUtf8($string): bool
    {
        $regex = array(
            '[\xC2-\xDF][\x80-\xBF]',
            '\xE0[\xA0-\xBF][\x80-\xBF]',
            '[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}',
            '\xED[\x80-\x9F][\x80-\xBF]',
            '\xF0[\x90-\xBF][\x80-\xBF]{2}',
            '[\xF1-\xF3][\x80-\xBF]{3}',
            '\xF4[\x80-\x8F][\x80-\xBF]{2}');

        $count = ceil(strlen($string) / 5000);
        for ($i = 0; $i < $count; $i++) {
            if (preg_match('%(?:' . implode('|', $regex) . ')+%xs', substr($string, ($i * 5000), 5000))) {
                return false;
            }
        }

        return true;
    }

    private function quotedPrintableEncode($input, $line_max = 250): string
    {
        $hex = array('0', '1', '2', '3', '4', '5', '6', '7',
            '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        $lines = preg_split("/(?:\r\n|\r|\n)/", $input);
        $linebreak = "=0D=0A=\r\n";
        /* the linebreak also counts as characters in the mime_qp_long_line
        * rule of spam-assassin */
        $line_max = $line_max - strlen($linebreak);
        $escape = "=";
        $output = "";
        $cur_conv_line = "";
        $length = 0;
        $whitespace_pos = 0;
        $addTlChars = 0;

        // iterate lines
        for ($j = 0; $j < count($lines); $j++) {
            $line = $lines[$j];
            $lineLen = strlen($line);

            // iterate chars
            for ($i = 0; $i < $lineLen; $i++) {
                $c = substr($line, $i, 1);
                $dec = ord($c);

                $length++;

                if ($dec == 32) {
                    // space occurring at end of line, need to encode
                    if (($i == ($lineLen - 1))) {
                        $c = "=20";
                        $length += 2;
                    }

                    $addTlChars = 0;
                    $whitespace_pos = $i;
                } else if (($dec == 61) || ($dec < 32) || ($dec > 126)) {
                    $h2 = floor($dec / 16);
                    $h1 = floor($dec % 16);
                    $c = $escape . $hex["$h2"] . $hex["$h1"];
                    $length += 2;
                    $addTlChars += 2;
                }

                // length for wordwrap exceeded, get a newline into the text
                if ($length >= $line_max) {
                    $cur_conv_line .= $c;

                    // read only up to the whitespace for the current line
                    $whiteSpaceDiff = $i - $whitespace_pos + $addTlChars;

                    //the text after the whitespace will have to be read
                    // again ( + any additional characters that came into
                    // existence as a result of the encoding process after the whitespace)
                    //
                    // Also, do not start at 0, if there was *no* whitespace in
                    // the whole line
                    if (($i + $addTlChars) > $whiteSpaceDiff) {
                        $output .= substr($cur_conv_line, 0, (strlen($cur_conv_line) -
                                $whiteSpaceDiff)) . $linebreak;
                        $i = $i - $whiteSpaceDiff + $addTlChars;
                    } else {
                        $output .= $cur_conv_line . $linebreak;
                    }

                    $cur_conv_line = "";
                    $length = 0;
                    $whitespace_pos = 0;
                } else {
                    // length for wordwrap not reached, continue reading
                    $cur_conv_line .= $c;
                }
            } // end of for

            $length = 0;
            $whitespace_pos = 0;
            $output .= $cur_conv_line;
            $cur_conv_line = "";

            if ($j <= count($lines) - 1) {
                $output .= $linebreak;
            }
        } // end for

        return trim($output);
    }

    protected function getContent(array $alternative): array
    {
        $body = array();
        $body[] = 'Content-Type: multipart/mixed; boundary="' . $this->boundary[1] . '"';
        $body[] = null;
        $body[] = '--' . $this->boundary[1];

        foreach ($alternative as $line) {
            $body[] = $line;
        }

        return $this->addAttachmentBody($body);
    }
}
