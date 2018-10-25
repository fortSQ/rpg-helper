<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndEquipmentSubtypeRepository")
 */
class DndEquipmentSubtype
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
     * @ORM\OneToMany(targetEntity="App\Entity\DndEquipment", mappedBy="subtype")
     */
    private $equipments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndEquipmentType", inversedBy="subtypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
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
            $equipment->setSubtype($this);
        }

        return $this;
    }

    public function removeEquipment(DndEquipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getSubtype() === $this) {
                $equipment->setSubtype(null);
            }
        }

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
}
