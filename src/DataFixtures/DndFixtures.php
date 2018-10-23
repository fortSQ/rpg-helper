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

        $equipmentTypes = ['Armor', 'Weapons', 'Adventuring gear', 'Tools', 'Mount and vehicles', 'Trade goods', 'Food, drink, and lodging', 'Services'];

        foreach ($equipmentTypes as $name) {
            $type = new DndEquipmentType();
            $type->setName($name);
            $manager->persist($type);
        }
        $manager->flush();

        /* EQUIPMENT SUBTYPES */

        $equipmentSubtypes = [
            'Light armor', 'Medium armor', 'Heavy armor', 'Shield',
            'Simple melee weapons', 'Simple ranged weapons', 'Martial melee weapons', 'Martial ranged weapons',
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
            ['Armor', 'Light armor', 'Padded', 500, 8, '', '', '', '11 + Dex modifier', null, 'Disadvantage', null, null],
            ['Armor', 'Light armor', 'Leather', 1000, 10, '', '', '', '11 + Dex modifier', null, 'Disadvantage', null, null],
            ['Armor', 'Light armor', 'Studded leather', 4500, 13, '', '', '', '12 + Dex modifier', null, '', null, null],
            ['Armor', 'Medium armor', 'Hide', 1000, 12, '', '', '', '12 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Chain shirt', 5000, 20, '', '', '', '13 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Scale mail', 5000, 45, '', '', '', '14 + Dex modifier (max 2)', null, 'Disadvantage', null, null],
            ['Armor', 'Medium armor', 'Breastplate', 40000, 20, '', '', '', '14 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Half plate', 75000, 40, '', '', '', '15 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Heavy armor', 'Ring mail', 3000, 40, '', '', '', '14', null, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Chain mail', 7500, 55, '', '', '', '16', 13, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Splint', 20000, 60, '', '', '', '17', 15, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Plate', 150000, 65, '', '', '', '18', 15, 'Disadvantage', null, null],
            ['Armor', 'Shield', 'Shield', 1000, 6, '', '', '', '+2', 15, 'Disadvantage', null, null],
            ['Weapons', 'Simple melee weapons', 'Club', 10, 2, 'Light', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Dagger', 200, 1, 'Finesse, light, thrown (range 20/60)', '1d4', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Greatclub', 20, 10, 'Two-handed', '1d8', 'bludgeoning', '', null, '', null, null],

            ['Weapons', 'Simple ranged weapons', 'Crossbow, light', 2500, 5, 'Ammunition (range 80/320), loading, two-handed', '1d8', 'piercing', '', null, '', null, null],



        ];

        foreach ($data as [$type, $subtype, $name, $cost, $weight, $properties, $damage, $damageType, $armorClass, $strength, $stealth, $capacity, $speed]) {
            $equipment = new DndEquipment();
            $equipment->setType($manager->getRepository(DndEquipmentType::class)->findOneBy(['name' => $type]));
            $equipment->setSubtype($manager->getRepository(DndEquipmentSubtype::class)->findOneBy(['name' => $subtype]));
            $equipment->setName($name);
            $equipment->setCost($cost);
            $equipment->setWeight($weight);
            $equipment->setProperties($properties);
            $equipment->setDamage($damage);
            $equipment->setDamageType($damageType);
            $equipment->setArmorClass($armorClass);
            $equipment->setStrength($strength);
            $equipment->setStealth($stealth);
            $equipment->setCapacity($capacity);
            $equipment->setSpeed($speed);
            $manager->persist($equipment);
        }
        $manager->flush();
    }
}
