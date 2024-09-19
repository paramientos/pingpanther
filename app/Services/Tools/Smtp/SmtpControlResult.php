<?php

namespace App\Services\Tools\Smtp;

class SmtpControlResult
{
    protected bool $status;
    protected ?string $response;

    public function response(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): void
    {
        $this->response = $response;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function status(): bool
    {
        return $this->status;
    }
}
