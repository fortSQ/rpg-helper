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
            'Light armor', 'Medium armor', 'Heavy armor', 'Shield',
            'Simple melee weapons', 'Simple Ranged meapons', 'Martial melee weapons', 'Martial ranged weapons',
            'Ammunition', 'Arcane focus', 'Druidic focus', 'Holy symbol',
            'Artisan\'s tools', 'Gaming set', 'Musical instrument',
            'Mounts and other animals', 'Tack, harness, and drawn vehicles', 'Saddle', 'Waterborne vehicles',
            'Lifestyle Expenses',
            'Ale', 'Inn stay (per day)', 'Meals (per day)', 'Wine',
            'Coach cab', 'Hireling',
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
            ['Armor', 'Medium Armor', 'Hide', 1000, 12, '', '', '', '12 + Dex modifier (max 2)'],
            ['Armor', 'Medium Armor', 'Chain shirt', 5000, 20, '', '', '', '13 + Dex modifier (max 2)'],
            ['Armor', 'Medium Armor', 'Scale mail', 5000, 45, 'Stealth: disadvantage', '', '', '14 + Dex modifier (max 2)'],
            ['Armor', 'Medium Armor', 'Breastplate', 40000, 20, '', '', '', '14 + Dex modifier (max 2)'],
            ['Armor', 'Medium Armor', 'Half plate', 75000, 40, '', '', '', '15 + Dex modifier (max 2)'],
            ['Armor', 'Heavy Armor', 'Ring mail', 3000, 40, 'Stealth: disadvantage', '', '', '14'],
            ['Armor', 'Heavy Armor', 'Chain mail', 7500, 55, 'Strength: Str 13, Stealth: disadvantage', '', '', '16'],
            ['Armor', 'Heavy Armor', 'Splint', 20000, 60, 'Strength: Str 15, Stealth: disadvantage', '', '', '17'],
            ['Armor', 'Heavy Armor', 'Plate', 150000, 65, 'Strength: Str 15, Stealth: disadvantage', '', '', '18'],
            ['Armor', 'Shield', 'Shield', 1000, 6, 'Strength: Str 15, Stealth: disadvantage', '', '', '+2'],
            ['Weapons', 'Simple Melee Weapons', 'Club', 10, 2, 'Light', '1d4', 'bludgeoning', ''],

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
