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

    /**
     * @ORM\Column(type="integer")
     */
    private $level = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $experience_points = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $money;

    /**
     * @ORM\Column(type="integer")
     */
    private $strength;

    /**
     * @ORM\Column(type="integer")
     */
    private $dexterity;

    /**
     * @ORM\Column(type="integer")
     */
    private $constitution;

    /**
     * @ORM\Column(type="integer")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     */
    private $wisdom;

    /**
     * @ORM\Column(type="integer")
     */
    private $charisma;

    /**
     * @ORM\Column(type="integer")
     */
    private $armor_class;

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

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDexterity(): ?int
    {
        return $this->dexterity;
    }

    public function setDexterity(int $dexterity): self
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): self
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getWisdom(): ?int
    {
        return $this->wisdom;
    }

    public function setWisdom(int $wisdom): self
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    public function getCharisma(): ?int
    {
        return $this->charisma;
    }

    public function setCharisma(int $charisma): self
    {
        $this->charisma = $charisma;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(?int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getArmorClass(): ?int
    {
        return $this->armor_class;
    }

    public function setArmorClass(int $armor_class): self
    {
        $this->armor_class = $armor_class;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getExperiencePoints(): ?int
    {
        return $this->experience_points;
    }

    public function setExperiencePoint(?int $experience_points): self
    {
        $this->experience_points = $experience_points;

        return $this;
    }

    public function setExperiencePoints(int $experience_points): self
    {
        $this->experience_points = $experience_points;

        return $this;
    }
}