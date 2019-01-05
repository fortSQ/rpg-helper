<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email")
 * @UniqueEntity("name")
 */
class User implements UserInterface
{
    use ResetPasswordTrait;
    use TimestampableEntityTrait;

    const ROLE_USER       = 'ROLE_USER';
    const ROLE_MODERATOR  = 'ROLE_MODERATOR';
    const ROLE_ADMIN      = 'ROLE_ADMIN';

    const ALLOWED_ROLES = [
        self::ROLE_USER,
        self::ROLE_MODERATOR,
        self::ROLE_ADMIN,
    ];

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const ALLOWED_STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    const INACTIVE_REASON_BANNED        = 'banned';
    const INACTIVE_REASON_NOT_ACTIVATED = 'not_activated';
    const INACTIVE_REASON_UNKNOWN       = 'unknown_reason'; // not used in DB

    const ALLOWED_INACTIVE_REASONS = [
        self::INACTIVE_REASON_BANNED,
        self::INACTIVE_REASON_NOT_ACTIVATED,
    ];

    const AUTHENTICATION_ERROR_MESSAGES = [
        User::INACTIVE_REASON_BANNED        => 'User is banned.',
        User::INACTIVE_REASON_NOT_ACTIVATED => 'User is not activated.',
        User::INACTIVE_REASON_UNKNOWN       => 'User is not active for unknown reason.'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+$/")
     * @Assert\Length(min = 2, max = 30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [self::ROLE_USER];

    /**
     * @Assert\NotBlank
     * @Assert\Length(min = 6, max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, options={"default" = User::STATUS_INACTIVE})
     */
    private $status = self::STATUS_INACTIVE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = User::INACTIVE_REASON_NOT_ACTIVATED})
     */
    private $inactive_reason = self::INACTIVE_REASON_NOT_ACTIVATED;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DndCharacter", mappedBy="user", orphanRemoval=true)
     */
    private $dndCharacters;

    public function __construct()
    {
        $this->dndCharacters = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using bcrypt or argon
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isActive()
    {
        return $this->getStatus() == self::STATUS_ACTIVE;
    }

    public function isBanned()
    {
        return $this->getStatus()         == self::STATUS_INACTIVE
            && $this->getInactiveReason() == self::INACTIVE_REASON_BANNED;
    }

    public function isNotActivated()
    {
        return $this->getStatus()         == self::STATUS_INACTIVE
            && $this->getInactiveReason() == self::INACTIVE_REASON_NOT_ACTIVATED;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        foreach ($roles as $role) {
            if (!in_array($role, self::ALLOWED_ROLES)) {
                throw new \InvalidArgumentException("Invalid user roles");
            }
        }

        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::ALLOWED_STATUSES)) {
            throw new \InvalidArgumentException("Invalid user status");
        }

        $this->status = $status;

        return $this;
    }

    public function getInactiveReason(): ?string
    {
        return $this->inactive_reason;
    }

    public function setInactiveReason(?string $inactive_reason): self
    {
        if (!in_array($inactive_reason, self::ALLOWED_INACTIVE_REASONS)) {
            throw new \InvalidArgumentException("Invalid user inactive reason");
        }

        $this->inactive_reason = $inactive_reason;

        return $this;
    }

    public function clearInactiveReason(): self
    {
        $this->inactive_reason = null;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * @return Collection|DndCharacter[]
     */
    public function getDndCharacters(): Collection
    {
        return $this->dndCharacters;
    }

    public function addDndCharacter(DndCharacter $dndCharacter): self
    {
        if (!$this->dndCharacters->contains($dndCharacter)) {
            $this->dndCharacters[] = $dndCharacter;
            $dndCharacter->setUser($this);
        }

        return $this;
    }

    public function removeDndCharacter(DndCharacter $dndCharacter): self
    {
        if ($this->dndCharacters->contains($dndCharacter)) {
            $this->dndCharacters->removeElement($dndCharacter);
            // set the owning side to null (unless already changed)
            if ($dndCharacter->getUser() === $this) {
                $dndCharacter->setUser(null);
            }
        }

        return $this;
    }
}
