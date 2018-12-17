<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("name")
 */
class User implements UserInterface
{
    const ROLE_USER       = 'ROLE_USER';
    const ROLE_MODERATOR  = 'ROLE_MODERATOR';
    const ROLE_ADMIN      = 'ROLE_ADMIN';

    const ALLOWED_ROLES = [
        self::ROLE_USER,
        self::ROLE_MODERATOR,
        self::ROLE_ADMIN,
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [self::ROLE_USER];

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+$/")
     * @Assert\Length(min = 2, max = 30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DndCharacter", mappedBy="user", orphanRemoval=true)
     */
    private $dndCharacters;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginAt;

    public function __construct()
    {
        $this->dndCharacters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
                throw new \InvalidArgumentException("Invalid status");
            }
        }

        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
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
        // $this->plainPassword = null;
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(?\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

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
}
