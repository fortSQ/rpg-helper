<?php

namespace App\DataFixtures;

use App\Entity\DndEquipmentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DndFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->dndEquipmentTypes as $item) {
            $type = new DndEquipmentType();
            $type->setName($item['name']);
            $manager->persist($type);
        }

        $manager->flush();
    }

    public $dndEquipmentTypes = [
        ['name' => 'Armor', 'name_ru' => 'Доспехи'],
        ['name' => 'Weapons', 'name_ru' => 'Оружие'],
        ['name' => 'Adventuring Gear', 'name_ru' => ''],
        ['name' => 'Tools', 'name_ru' => ''],
        ['name' => 'Mount and Vehicles', 'name_ru' => ''],
        ['name' => 'Trade Goods', 'name_ru' => ''],
        ['name' => 'Services', 'name_ru' => ''],
    ];
}
