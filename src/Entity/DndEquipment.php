<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndEquipmentRepository")
 */
class DndEquipment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndEquipmentType", inversedBy="dndEquipment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndEquipmentSubtype", inversedBy="dndEquipment")
     */
    private $subtype;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $properties;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $damage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $damage_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $armor_class;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $strength;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stealth;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $speed;

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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDamage(): ?string
    {
        return $this->damage;
    }

    public function setDamage(?string $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getDamageType(): ?string
    {
        return $this->damage_type;
    }

    public function setDamageType(?string $damage_type): self
    {
        $this->damage_type = $damage_type;

        return $this;
    }

    public function getArmorClass(): ?string
    {
        return $this->armor_class;
    }

    public function setArmorClass(?string $armor_class): self
    {
        $this->armor_class = $armor_class;

        return $this;
    }

    public function getType(): ?DndEquipmentType
    {
        return $this->type;
    }

    public function setType(?DndEquipmentType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSubtype(): ?DndEquipmentSubtype
    {
        return $this->subtype;
    }

    public function setSubtype(?DndEquipmentSubtype $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }

    public function getProperties(): ?string
    {
        return $this->properties;
    }

    public function setProperties(?string $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(?int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getStealth(): ?string
    {
        return $this->stealth;
    }

    public function setStealth(?string $stealth): self
    {
        $this->stealth = $stealth;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(?int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }
}
