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
            ['Armor', 'Light armor', 'Padded', 'padded.png', 500, 8, '', '', '', '11 + Dex modifier', null, 'Disadvantage', null, null],
            ['Armor', 'Light armor', 'Leather', 'leather.png', 1000, 10, '', '', '', '11 + Dex modifier', null, '', null, null],
            ['Armor', 'Light armor', 'Studded leather', 'studded-leather.png', 4500, 13, '', '', '', '12 + Dex modifier', null, '', null, null],
            ['Armor', 'Medium armor', 'Hide', 'hide.png', 1000, 12, '', '', '', '12 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Chain shirt', 'chain-shirt.png', 5000, 20, '', '', '', '13 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Scale mail', 'scale-mail.png', 5000, 45, '', '', '', '14 + Dex modifier (max 2)', null, 'Disadvantage', null, null],
            ['Armor', 'Medium armor', 'Breastplate', 'breastplate.png', 40000, 20, '', '', '', '14 + Dex modifier (max 2)', null, '', null, null],
            ['Armor', 'Medium armor', 'Half plate', 'half-plate.png', 75000, 40, '', '', '', '15 + Dex modifier (max 2)', null, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Ring mail', 'ring-mail.png', 3000, 40, '', '', '', '14', null, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Chain mail', 'chain-mail.png', 7500, 55, '', '', '', '16', 13, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Splint', 'splint.png', 20000, 60, '', '', '', '17', 15, 'Disadvantage', null, null],
            ['Armor', 'Heavy armor', 'Plate', 'plate.png', 150000, 65, '', '', '', '18', 15, 'Disadvantage', null, null],
            ['Armor', 'Shield', 'Shield', 'shield.png', 1000, 6, '', '', '', '+2', 15, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Club', 'club.png', 10, 2, 'Light', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Dagger', 'dagger.png', 200, 1, 'Finesse, light, thrown (range 20/60)', '1d4', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Greatclub', 'greatclub.png', 20, 10, 'Two-handed', '1d8', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Handaxe', 'handaxe.png', 500, 2, 'Light, thrown (range 20/60)', '1d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Javelin', 'javelin.png', 50, 2, 'Thrown (range 20/60)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Light hammer', 'light-hammer.png', 200, 2, 'Light, thrown (range 20/60)', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Mace', 'mace.png', 500, 4, '', '1d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Quarterstaff', 'quarterstaff.png', 20, 4, 'Versatile (1d8)', '1d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Sickle', 'sickle.png', 100, 2, 'Light', '1d4', 'slashing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Spear', 'spear.png', 100, 3, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple melee weapons', 'Unarmed strike', 'unarmed-strike.png', 0, 0, '', '1', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Crossbow, light', 'crossbow-light.png', 2500, 5, 'Ammunition (range 80/320), loading, two-handed', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Dart', 'dart.png', 5, 0.25, 'Finesse, thrown (range 20/60)', '1d4', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Shortbow', 'shortbow.png', 2500, 2, 'Ammunition (range 80/320), two-handed', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Simple ranged weapons', 'Sling', 'sling.png', 100, 0, 'Ammunition (range 30/120)', '1d4', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Battleaxe', 'battleaxe.png', 1000, 4, 'Versatile (1d10)', '1d8', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Flail', 'flail.png', 1000, 2, '', '1d8', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Glaive', 'glaive.png', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Greataxe', 'greataxe.png', 3000, 7, 'Heavy, two-handed', '1d12', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Greatsword', 'greatsword.png', 5000, 6, 'Heavy, two-handed', '2d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Halberd', 'halberd.png', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Lance', 'lance.png', 1000, 6, 'Reach, special', '1d12', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Longsword', 'longsword.png', 1500, 3, 'Versatile (1d10)', '1d8', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Maul', 'maul.png', 1000, 10, 'Heavy, two-handed', '2d6', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Morningstar', 'morningstar.png', 1500, 4, '', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Pike', 'pike.png', 500, 18, 'Heavy, reach, two-handed', '1d10', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Rapier', 'rapier.png', 2500, 2, 'Finesse', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Scimitar', 'scimitar.png', 2500, 3, 'Finesse, light', '1d6', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Shortsword', 'shortsword.png', 1000, 2, 'Finesse, light', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Trident', 'trident.png', 500, 4, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'War pick', 'war-pick.png', 500, 2, '', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Warhammer', 'warhammer.png', 1500, 2, '', '1d8', 'bludgeoning', '', null, '', null, null],
            ['Weapons', 'Martial melee weapons', 'Whip', 'whip.png', 200, 3, 'Finesse, reach', '1d4', 'slashing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Blowgun', 'blowgun.png', 1000, 1, 'Ammunition (range 25/100), loading', '1', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, hand', 'crossbow-hand.png', 7500, 3, 'Ammunition (range 30/120), light, loading', '1d6', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, heavy', 'crossbow-heavy.png', 5000, 18, 'Ammunition (range 100/400), heavy, loading, two-handed', '1d10', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Longbow', 'longbow.png', 5000, 2, 'Ammunition (range 150/600), heavy, two-handed', '1d8', 'piercing', '', null, '', null, null],
            ['Weapons', 'Martial ranged weapons', 'Net', 'net.png', 100, 3, 'Special, thrown (range 5/15)', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Abacus', 'abacus.png', 200, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Acid (vial)', 'acid-vial.png', 2500, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Alchemist’s fire (flask)', 'alchemists-fire-flask.png', 5000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Arrows (20)', 'arrows-20.png', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Blowgun needles (50)', 'blowgun-needles-50.png', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Ammunition', 'Crossbow bolts (20)', 'crossbow-bolts-20.png', 100, 1.5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Antitoxin (vial)', 'antitoxin-vial.png', 50, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Crystal', 'crystal.png', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Orb', 'orb.png', 2000, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Rod', 'rod.png', 1000, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Staff', 'staff.png', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Arcane focus', 'Wand', 'wand.png', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Backpack', 'backpack.png', 200, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Ball bearings (bag of 1000)', 'ball-bearings-bag-of-1000.png', 100, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Barrel', 'barrel.png', 200, 70, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Basket', 'basket.png', 40, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bedroll', 'bedroll.png', 100, 7, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bell', 'bell.png', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Blanket', 'blanket.png', 500, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Block and tackle', 'block-and-tackle.png', 100, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Book', 'book.png', 2500, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bottle, glass', 'bottle-glass.png', 200, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Bucket', 'bucket.png', 5, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Caltrops (bag of 20)', 'caltrops-bag-of-20.png', 100, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Candle', 'candle.png', 1, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Case, crossbow bolt', 'case-crossbow-bolt.png', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Case, map or scroll', 'case-map-or-scroll.png', 100, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chain (10 feet)', 'chain-10-feet.png', 500, 10, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chalk (1 piece)', 'chalk-1-piece.png', 1, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Chest', 'chest.png', 500, 25, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Climber\'s kit', 'climbers-kit.png', 2500, 12, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, common', 'clothes-common.png', 50, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, costume', 'clothes-costume.png', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, fine', 'clothes-fine.png', 1500, 6, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Clothes, traveler\'s', 'clothes-travelers.png', 200, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Component pouch', 'component-pouch.png', 2500, 2, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Crowbar', 'crowbar.png', 200, 5, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Sprig of mistletoe', 'sprig-of-mistletoe.png', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Totem', 'totem.png', 100, 0, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Wooden staff', 'wooden-staff.png', 500, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', 'Druidic focus', 'Yew wand', 'yew-wand.png', 1000, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Fishing tackle', 'fishing-tackle.png', 100, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Flask or tankard', 'flask-or-tankard.png', 2, 1, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Grappling hook', 'grappling-hook.png', 200, 4, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Hammer', 'hammer.png', 100, 3, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Hammer, sledge', 'hammer-sledge.png', 200, 10, '', '', '', '', null, '', null, null],
            ['Adventuring gear', '', 'Healer\'s kit', 'healers-kit.png', 500, 3, '', '', '', '', null, '', null, null],


            ['Adventuring gear', '', '', '.png', 0, 0, '', '', '', '', null, '', null, null],

        ];

        foreach ($data as [$type, $subtype, $name, $image, $cost, $weight, $properties, $damage, $damageType, $armorClass, $strength, $stealth, $capacity, $speed]) {
            $equipment = new DndEquipment();
            $equipment->setType($manager->getRepository(DndEquipmentType::class)->findOneBy(['name' => $type]));
            $equipment->setSubtype($manager->getRepository(DndEquipmentSubtype::class)->findOneBy(['name' => $subtype]));
            $equipment->setName($name);
            $equipment->setImage($image);
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
