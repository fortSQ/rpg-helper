<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ResetPasswordTrait
{
    /**
     * @ORM\Column(name="reset_token", type="string", length=32, nullable=true)
     */
    protected $resetToken;

    /**
     * @ORM\Column(name="reset_token_expires_at", type="integer", nullable=true)
     */
    protected $resetTokenExpiresAt;

    public function generateResetToken(\DateInterval $interval = null): string
    {
        if (null == $interval) {
            $interval = new \DateInterval('PT1H');
        }

        $now = new \DateTime();

        $this->resetToken          = bin2hex(\random_bytes(16));
        $this->resetTokenExpiresAt = $now->add($interval)->getTimestamp();

        return $this->resetToken;
    }

    public function clearResetToken(): self
    {
        $this->resetToken          = null;
        $this->resetTokenExpiresAt = null;

        return $this;
    }

    public function isResetTokenValid(string $token): bool
    {
        return
            $this->resetToken === $token
            && $this->resetTokenExpiresAt !== null
            && $this->resetTokenExpiresAt > time();
    }
}