<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndClassRepository")
 */
class DndClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DndCharacter", mappedBy="class")
     */
    private $characters;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hit_die;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primary_ability;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $saving_prof;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $armor_weapon_prof;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
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

    /**
     * @return Collection|DndCharacter[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(DndCharacter $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setClass($this);
        }

        return $this;
    }

    public function removeCharacter(DndCharacter $character): self
    {
        if ($this->characters->contains($character)) {
            $this->characters->removeElement($character);
            // set the owning side to null (unless already changed)
            if ($character->getClass() === $this) {
                $character->setClass(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHitDie(): ?string
    {
        return $this->hit_die;
    }

    public function setHitDie(string $hit_die): self
    {
        $this->hit_die = $hit_die;

        return $this;
    }

    public function getPrimaryAbility(): ?string
    {
        return $this->primary_ability;
    }

    public function setPrimaryAbility(string $primary_ability): self
    {
        $this->primary_ability = $primary_ability;

        return $this;
    }

    public function getSavingProf(): ?string
    {
        return $this->saving_prof;
    }

    public function setSavingProf(string $saving_prof): self
    {
        $this->saving_prof = $saving_prof;

        return $this;
    }

    public function getArmorWeaponProf(): ?string
    {
        return $this->armor_weapon_prof;
    }

    public function setArmorWeaponProf(string $armor_weapon_prof): self
    {
        $this->armor_weapon_prof = $armor_weapon_prof;

        return $this;
    }
}
