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

        $equipmentTypes = ['Armor', 'Weapons', 'Adventuring gear', 'Tools', 'Mount and vehicles', 'Trade goods', 'Lifestyle Expenses', 'Food, drink, and lodging', 'Services'];

        foreach ($equipmentTypes as $name) {
            $type = new DndEquipmentType();
            $type->setName($name);
            $manager->persist($type);
        }
        $manager->flush();

        /* EQUIPMENT SUBTYPES */

        $equipmentSubtypes = [
            ['Armor', 'Light armor'], ['Armor', 'Medium armor'], ['Armor', 'Heavy armor'], ['Armor', 'Shield'],
            ['Weapons', 'Simple melee weapons'], ['Weapons', 'Simple ranged weapons'], ['Weapons', 'Martial melee weapons'], ['Weapons', 'Martial ranged weapons'],
            ['Adventuring gear', 'Ammunition'], ['Adventuring gear', 'Arcane focus'], ['Adventuring gear', 'Druidic focus'], ['Adventuring gear', 'Holy symbol'],
            ['Tools', 'Artisan\'s tools'], ['Tools', 'Gaming set'], ['Tools', 'Musical instrument'],
            ['Mount and vehicles', 'Mounts and other animals'], ['Mount and vehicles', 'Tack, harness, and drawn vehicles'], ['Mount and vehicles', 'Saddle'], ['Mount and vehicles', 'Waterborne vehicles'],
            ['Food, drink, and lodging', 'Ale'], ['Food, drink, and lodging', 'Inn stay (per day)'], ['Food, drink, and lodging', 'Meals (per day)'], ['Food, drink, and lodging', 'Wine'],
            ['Services', 'Coach cab'], ['Services', 'Hireling'],
        ];

        foreach ($equipmentSubtypes as [$type, $name]) {
            $subtype = new DndEquipmentSubtype();
            $subtype->setName($name);
            $subtype->setType($manager->getRepository(DndEquipmentType::class)->findOneBy(['name' => $type]));
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
            ['Weapons', 'Simple melee weapons', 'Handaxe', 500, 2, 'Light, thrown (range 20/60)', '1d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Javelin', 50, 2, 'Thrown (range 20/60)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Light hammer', 200, 2, 'Light, thrown (range 20/60)', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Mace', 500, 4, '', '1d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Quarterstaff', 20, 4, 'Versatile (1d8)', '1d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Sickle', 100, 2, 'Light', '1d4', 'slashing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Spear', 100, 3, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Unarmed strike', 0, 0, '', '1', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Crossbow, light', 2500, 5, 'Ammunition (range 80/320), loading, two-handed', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Dart', 5, 0.25, 'Finesse, thrown (range 20/60)', '1d4', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Shortbow', 2500, 2, 'Ammunition (range 80/320), two-handed', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Sling', 100, 0, 'Ammunition (range 30/120)', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Battleaxe', 1000, 4, 'Versatile (1d10)', '1d8', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Flail', 1000, 2, '', '1d8', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Glaive', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, '', null, null],
            ['Weapons', '', 'Greataxe', 3000, 7, 'Heavy, two-handed', '1d12', 'slashing', '', null, '', null, null],


            ['Weapons', 'Martial melee weapons', '', 0, 0, '', '1d', '', '', null, '', null, null],

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
