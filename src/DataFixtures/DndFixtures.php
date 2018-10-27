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
            ['Weapons', 'Martial melee weapons', 'Greataxe', 3000, 7, 'Heavy, two-handed', '1d12', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Greatsword', 5000, 6, 'Heavy, two-handed', '2d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Halberd', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Lance', 1000, 6, 'Reach, special', '1d12', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Longsword', 1500, 3, 'Versatile (1d10)', '1d8', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Maul', 1000, 10, 'Heavy, two-handed', '2d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Morningstar', 1500, 4, '', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Pike', 500, 18, 'Heavy, reach, two-handed', '1d10', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Rapier', 2500, 2, 'Finesse', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Scimitar', 2500, 3, 'Finesse, light', '1d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Shortsword', 1000, 2, 'Finesse, light', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Trident', 500, 4, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'War pick', 500, 2, '', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Warhammer', 1500, 2, '', '1d8', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Whip', 200, 3, 'Finesse, reach', '1d4', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Blowgun', 1000, 1, 'Ammunition (range 25/100), loading', '1', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, hand', 7500, 3, 'Ammunition (range 30/120), light, loading', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, heavy', 5000, 18, 'Ammunition (range 100/400), heavy, loading, two-handed', '1d10', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Longbow', 5000, 2, 'Ammunition (range 150/600), heavy, two-handed', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Net', 100, 3, '', 'Special, thrown (range 5/15)', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Abacus', 200, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Acid (vial)', 2500, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Alchemist’s fire (flask)', 5000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Arrows (20)', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Blowgun needles (50)', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Crossbow bolts (20)', 100, 1.5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Antitoxin (vial)', 50, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Crystal', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Orb', 2000, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Rod', 1000, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Staff', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Wand', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Backpack', 200, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Ball bearings (bag o f 1,000)', 100, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Barrel', 200, 70, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Basket', 40, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bedroll', 100, 7, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bell', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Blanket', 500, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Block and tackle', 100, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Book', 2500, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bottle, glass', 200, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bucket', 5, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Caltrops (bag of 20)', 100, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Candle', 1, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Case, crossbow bolt', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Case, map or scroll', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chain (10 feet)', 500, 10, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chalk (1 piece)', 1, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chest', 500, 25, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Climber\'s kit', 2500, 12, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, common', 50, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, costume', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, fine', 1500, 6, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, traveler\'s', 200, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Component pouch', 2500, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Crowbar', 200, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Sprig of mistletoe', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Totem', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Wooden staff', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Yew wand', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Fishing tackle', 100, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Flask or tankard', 2, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Grappling hook', 200, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Hammer', 100, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Hammer, sledge', 200, 10, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Healer\'s kit', 500, 3, '', '', '', '', null, '', null, null],






            ['Adventuring gear', '', '', 0, 0, '', '', '', '', null, '', null, null],

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
