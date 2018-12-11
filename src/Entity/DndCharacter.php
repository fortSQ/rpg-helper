<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DndCharacterRepository")
 */
class DndCharacter
{
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    /* Languages */

    const LANGUAGE_COMMON      = 'common';
    const LANGUAGE_DWARVISH    = 'dwarvish';
    const LANGUAGE_ELVISH      = 'elvish';
    const LANGUAGE_GIANT       = 'giant';
    const LANGUAGE_GNOMISH     = 'gnomish';
    const LANGUAGE_GOBLIN      = 'goblin';
    const LANGUAGE_HALFLING    = 'halfling';
    const LANGUAGE_ORC         = 'orc';
    const LANGUAGE_ABYSSAL     = 'abyssal';
    const LANGUAGE_CELESTIAL   = 'celestial';
    const LANGUAGE_DRACONIC    = 'draconic';
    const LANGUAGE_DEEP_SPEECH = 'deep speech';
    const LANGUAGE_INFERNAL    = 'infernal';
    const LANGUAGE_PRIMORDIAL  = 'primordial';
    const LANGUAGE_SYLVAN      = 'sylvan';
    const LANGUAGE_UNDERCOMMON = 'undercommon';

    const ALLOWED_LANGUAGES = [
        self::LANGUAGE_COMMON,
        self::LANGUAGE_DWARVISH,
        self::LANGUAGE_ELVISH,
        self::LANGUAGE_GIANT,
        self::LANGUAGE_GNOMISH,
        self::LANGUAGE_GOBLIN,
        self::LANGUAGE_HALFLING,
        self::LANGUAGE_ORC,
        self::LANGUAGE_ABYSSAL,
        self::LANGUAGE_CELESTIAL,
        self::LANGUAGE_DRACONIC,
        self::LANGUAGE_DEEP_SPEECH,
        self::LANGUAGE_INFERNAL,
        self::LANGUAGE_PRIMORDIAL,
        self::LANGUAGE_SYLVAN,
        self::LANGUAGE_UNDERCOMMON,
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+$/")
     * @Assert\Length(min = 2, max = 30)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndClass", inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $class;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DndRace", inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $race;

    /**
     * @ORM\Column(type="integer", options={"default" = 1})
     * @Assert\NotBlank
     * @Assert\Range(min = 0, max = 20)
     */
    private $level = 1;

    /**
     * @ORM\Column(type="integer", options={"default" = 0})
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     */
    private $experience_points = 0;

    /**
     * @ORM\Column(type="integer", options={"default" = 0})
     * @Assert\NotBlank
     */
    private $money = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $strength;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $dexterity;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $constitution;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $wisdom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 30)
     */
    private $charisma;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min = 1)
     */
    private $armor_class;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::STATUS_ACTIVE;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="dndCharacters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $languages = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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

    public function setStrength(?int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDexterity(): ?int
    {
        return $this->dexterity;
    }

    public function setDexterity(?int $dexterity): self
    {
        $this->dexterity = $dexterity;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(?int $constitution): self
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(?int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getWisdom(): ?int
    {
        return $this->wisdom;
    }

    public function setWisdom(?int $wisdom): self
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    public function getCharisma(): ?int
    {
        return $this->charisma;
    }

    public function setCharisma(?int $charisma): self
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

    public function setArmorClass(?int $armor_class): self
    {
        $this->armor_class = $armor_class;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getExperiencePoints(): ?int
    {
        return $this->experience_points;
    }

    public function setExperiencePoints(?int $experience_points): self
    {
        $this->experience_points = $experience_points;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE
        ])) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getModifier($abilityScore): int
    {
        return floor(($abilityScore - 10) / 2);
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setLanguages(?array $languages): self
    {
        foreach ($languages as $language) {
            if (!in_array($language, self::ALLOWED_LANGUAGES)) {
                throw new \InvalidArgumentException("Invalid language");
            }
        }

        $this->languages = $languages;

        return $this;
    }
}
