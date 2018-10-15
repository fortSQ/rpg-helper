<?php

namespace App\DataFixtures;

use App\Entity\DndEquipmentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DndFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->equipmentTypes as $item) {
            $type = new DndEquipmentType();
            $type->setName($item);
            $manager->persist($type);
        }

        $manager->flush();
    }

    public $equipmentTypes = [
        'Armor', 'Weapons', 'Adventuring Gear', 'Tools', 'Mount and Vehicles', 'Trade Goods', 'Food, Drink, and Lodging', 'Services'
    ];

    public $armor = [
        ['name' => 'Padded', 'subtype' => 'Light Armor', 'cost' => 500, 'armor_class' => '', 'weight' => 8]
    ];
}
