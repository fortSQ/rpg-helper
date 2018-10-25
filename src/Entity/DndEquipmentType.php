<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndEquipmentTypeRepository")
 */
class DndEquipmentType
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
     * @ORM\OneToMany(targetEntity="App\Entity\DndEquipment", mappedBy="type")
     */
    private $equipments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DndEquipmentSubtype", mappedBy="type")
     */
    private $subtypes;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->subtypes = new ArrayCollection();
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
     * @return Collection|DndEquipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(DndEquipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setType($this);
        }

        return $this;
    }

    public function removeEquipment(DndEquipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getType() === $this) {
                $equipment->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DndEquipmentSubtype[]
     */
    public function getSubtypes(): Collection
    {
        return $this->subtypes;
    }

    public function addSubtype(DndEquipmentSubtype $subtype): self
    {
        if (!$this->subtypes->contains($subtype)) {
            $this->subtypes[] = $subtype;
            $subtype->setType($this);
        }

        return $this;
    }

    public function removeSubtype(DndEquipmentSubtype $subtype): self
    {
        if ($this->subtypes->contains($subtype)) {
            $this->subtypes->removeElement($subtype);
            // set the owning side to null (unless already changed)
            if ($subtype->getType() === $this) {
                $subtype->setType(null);
            }
        }

        return $this;
    }
}
