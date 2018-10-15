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
    private $dndEquipment;

    public function __construct()
    {
        $this->dndEquipment = new ArrayCollection();
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
    public function getDndEquipment(): Collection
    {
        return $this->dndEquipment;
    }

    public function addDndEquipment(DndEquipment $dndEquipment): self
    {
        if (!$this->dndEquipment->contains($dndEquipment)) {
            $this->dndEquipment[] = $dndEquipment;
            $dndEquipment->setType($this);
        }

        return $this;
    }

    public function removeDndEquipment(DndEquipment $dndEquipment): self
    {
        if ($this->dndEquipment->contains($dndEquipment)) {
            $this->dndEquipment->removeElement($dndEquipment);
            // set the owning side to null (unless already changed)
            if ($dndEquipment->getType() === $this) {
                $dndEquipment->setType(null);
            }
        }

        return $this;
    }
}
