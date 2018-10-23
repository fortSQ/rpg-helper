<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndCharacterRepository")
 */
class DndCharacter
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
     * @ORM\ManyToOne(targetEntity="App\Entity\DndClass", inversedBy="dndCharacters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $class;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndRace", inversedBy="dndCharacters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

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

    public function getClass(): ?DndClass
    {
        return $this->class;
    }

    public function setClass(?DndClass $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getRace(): ?DndRace
    {
        return $this->race;
    }

    public function setRace(?DndRace $race): self
    {
        $this->race = $race;

        return $this;
    }
}
