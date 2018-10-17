<?php

namespace App\DataFixtures;

use App\Entity\DndEquipment;
use App\Entity\DndEquipmentSubtype;
use App\Entity\DndEquipmentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DndFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /* EQUIPMENT TYPES */

        $equipmentTypes = ['Armor', 'Weapons', 'Adventuring Gear', 'Tools', 'Mount and Vehicles', 'Trade Goods', 'Food, Drink, and Lodging', 'Services'];

        foreach ($equipmentTypes as $name) {
            $type = new DndEquipmentType();
            $type->setName($name);
            $manager->persist($type);
        }
        $manager->flush();

        /* EQUIPMENT SUBTYPES */

        $equipmentSubtypes = [
            'Light Armor', 'Medium Armor', 'Heavy Armor', 'Shield',
            'Simple Melee Weapon'
        ];

        foreach ($equipmentSubtypes as $name) {
            $subtype = new DndEquipmentSubtype();
            $subtype->setName($name);
            $manager->persist($subtype);
        }
        $manager->flush();

        /* EQUIPMENT */

        $data = [
            ['Armor', 'Light Armor', 'Padded', 500, 8, 'Stealth: disadvantage', '', '', '11 + Dex modifier'],
            ['Armor', 'Light Armor', 'Leather', 1000, 10, '', '', '', '11 + Dex modifier'],
            ['Armor', 'Light Armor', 'Studded leather', 4500, 13, '', '', '', '12 + Dex modifier'],



            ['Weapons', 'Simple Melee Weapon', 'Club', 10, 2, 'Light', '1d4', 'bludgeoning', '']

        ];

        foreach ($data as [$type, $subtype, $name, $cost, $weight, $info, $damage, $damageType, $armorClass]) {
            $equipment = new DndEquipment();
            $equipment->setType($manager->getRepository(DndEquipmentType::class)->findOneBy(['name' => $type]));
            $equipment->setSubtype($manager->getRepository(DndEquipmentSubtype::class)->findOneBy(['name' => $subtype]));
            $equipment->setName($name);
            $equipment->setCost($cost);
            $equipment->setWeight($weight);
            $equipment->setInfo($info);
            $equipment->setDamage($damage);
            $equipment->setDamageType($damageType);
            $equipment->setArmorClass($armorClass);
            $manager->persist($equipment);
        }
        $manager->flush();


    }
}
