<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ResetPasswordTrait
{
    /**
     * @ORM\Column(name="reset_token", type="string", length=64, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(name="reset_token_expires_at", type="integer", nullable=true)
     */
    private $resetTokenExpiresAt;

    /**
     * @ORM\Column(name="activation_token", type="string", length=64, nullable=true)
     */
    private $activationToken;

    /**
     * @ORM\Column(name="activation_token_expires_at", type="integer", nullable=true)
     */
    private $activationTokenExpiresAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $activatedAt;

    private function generateToken(): string
    {
        return bin2hex(\random_bytes(32));
    }

    private function generateExpiresAt(?\DateInterval $interval): int
    {
        if (null == $interval) {
            $interval = new \DateInterval('PT1H');
        }

        return (new \DateTime())->add($interval)->getTimestamp();
    }

    public function generateResetToken(\DateInterval $interval = null): int
    {
        $this->resetToken          = $this->generateToken();
        $this->resetTokenExpiresAt = $this->generateExpiresAt($interval);

        return $this->resetToken;
    }

    public function generateActivationToken(\DateInterval $interval = null): string
    {
        $this->activationToken          = $this->generateToken();
        $this->activationTokenExpiresAt = $this->generateExpiresAt($interval);

        return $this->activationToken;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function isResetTokenValid(string $token): bool
    {
        return
            $this->resetToken === $token
            && $this->resetTokenExpiresAt !== null
            && $this->resetTokenExpiresAt > time();
    }

    public function isActivationTokenValid(string $token): bool
    {
        return
            $this->activationToken === $token
            && $this->activationTokenExpiresAt !== null
            && $this->activationTokenExpiresAt > time();
    }

    public function clearResetToken(): self
    {
        $this->resetToken          = null;
        $this->resetTokenExpiresAt = null;

        return $this;
    }

    public function clearActivationToken(): self
    {
        $this->activationToken          = null;
        $this->activationTokenExpiresAt = null;

        return $this;
    }

    public function getActivatedAt(): ?\DateTimeInterface
    {
        return $this->activatedAt;
    }

    public function setActivatedAt(?\DateTimeInterface $activatedAt): self
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }
}