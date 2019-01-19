<?php

namespace App\DataFixtures;

use App\Entity\DndEquipmentType;
use App\Entity\DndEquipmentSubtype;
use App\Entity\DndEquipment;
use App\Entity\DndRace;
use App\Entity\DndClass;
use App\Entity\DndCharacter;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DndFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        /* EQUIPMENT TYPES */

        $equipmentTypes = ['Armor', 'Weapons', 'Adventuring gear', 'Tools'];

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
        ];

        foreach ($equipmentSubtypes as [$type, $name]) {
            $subtype = new DndEquipmentSubtype();
            $subtype->setName($name);
            $subtype->setType($manager->getRepository(DndEquipmentType::class)->findOneBy(['name' => $type]));
            $manager->persist($subtype);
        }

        $manager->flush();

        /* EQUIPMENT */

        $equipments = [
            ['Armor', 'Light armor', 'Padded', 'padded.png', 500, 8, '', '', '', '11 + Dex modifier', null, 'Disadvantage'],
            ['Armor', 'Light armor', 'Leather', 'leather.png', 1000, 10, '', '', '', '11 + Dex modifier', null, ''],
            ['Armor', 'Light armor', 'Studded leather', 'studded-leather.png', 4500, 13, '', '', '', '12 + Dex modifier', null, ''],
            ['Armor', 'Medium armor', 'Hide', 'hide.png', 1000, 12, '', '', '', '12 + Dex modifier (max 2)', null, ''],
            ['Armor', 'Medium armor', 'Chain shirt', 'chain-shirt.png', 5000, 20, '', '', '', '13 + Dex modifier (max 2)', null, ''],
            ['Armor', 'Medium armor', 'Scale mail', 'scale-mail.png', 5000, 45, '', '', '', '14 + Dex modifier (max 2)', null, 'Disadvantage'],
            ['Armor', 'Medium armor', 'Breastplate', 'breastplate.png', 40000, 20, '', '', '', '14 + Dex modifier (max 2)', null, ''],
            ['Armor', 'Medium armor', 'Half plate', 'half-plate.png', 75000, 40, '', '', '', '15 + Dex modifier (max 2)', null, 'Disadvantage'],
            ['Armor', 'Heavy armor', 'Ring mail', 'ring-mail.png', 3000, 40, '', '', '', '14', null, 'Disadvantage'],
            ['Armor', 'Heavy armor', 'Chain mail', 'chain-mail.png', 7500, 55, '', '', '', '16', 13, 'Disadvantage'],
            ['Armor', 'Heavy armor', 'Splint', 'splint.png', 20000, 60, '', '', '', '17', 15, 'Disadvantage'],
            ['Armor', 'Heavy armor', 'Plate', 'plate.png', 150000, 65, '', '', '', '18', 15, 'Disadvantage'],
            ['Armor', 'Shield', 'Shield', 'shield.png', 1000, 6, '', '', '', '+2', 15, ''],
            ['Weapons', 'Simple melee weapons', 'Club', 'club.png', 10, 2, 'Light', '1d4', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Dagger', 'dagger.png', 200, 1, 'Finesse, light, thrown (range 20/60)', '1d4', 'piercing', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Greatclub', 'greatclub.png', 20, 10, 'Two-handed', '1d8', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Handaxe', 'handaxe.png', 500, 2, 'Light, thrown (range 20/60)', '1d6', 'slashing', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Javelin', 'javelin.png', 50, 2, 'Thrown (range 20/60)', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Light hammer', 'light-hammer.png', 200, 2, 'Light, thrown (range 20/60)', '1d4', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Mace', 'mace.png', 500, 4, '', '1d6', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Quarterstaff', 'quarterstaff.png', 20, 4, 'Versatile (1d8)', '1d6', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Sickle', 'sickle.png', 100, 2, 'Light', '1d4', 'slashing', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Spear', 'spear.png', 100, 3, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Simple melee weapons', 'Unarmed strike', 'unarmed-strike.png', 0, 0, '', '1', 'bludgeoning', '', null, ''],
            ['Weapons', 'Simple ranged weapons', 'Crossbow, light', 'crossbow-light.png', 2500, 5, 'Ammunition (range 80/320), loading, two-handed', '1d8', 'piercing', '', null, ''],
            ['Weapons', 'Simple ranged weapons', 'Dart', 'dart.png', 5, 0.25, 'Finesse, thrown (range 20/60)', '1d4', 'piercing', '', null, ''],
            ['Weapons', 'Simple ranged weapons', 'Shortbow', 'shortbow.png', 2500, 2, 'Ammunition (range 80/320), two-handed', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Simple ranged weapons', 'Sling', 'sling.png', 100, 0, 'Ammunition (range 30/120)', '1d4', 'bludgeoning', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Battleaxe', 'battleaxe.png', 1000, 4, 'Versatile (1d10)', '1d8', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Flail', 'flail.png', 1000, 2, '', '1d8', 'bludgeoning', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Glaive', 'glaive.png', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Greataxe', 'greataxe.png', 3000, 7, 'Heavy, two-handed', '1d12', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Greatsword', 'greatsword.png', 5000, 6, 'Heavy, two-handed', '2d6', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Halberd', 'halberd.png', 2000, 6, 'Heavy, reach, two-handed', '1d10', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Lance', 'lance.png', 1000, 6, 'Reach, special', '1d12', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Longsword', 'longsword.png', 1500, 3, 'Versatile (1d10)', '1d8', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Maul', 'maul.png', 1000, 10, 'Heavy, two-handed', '2d6', 'bludgeoning', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Morningstar', 'morningstar.png', 1500, 4, '', '1d8', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Pike', 'pike.png', 500, 18, 'Heavy, reach, two-handed', '1d10', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Rapier', 'rapier.png', 2500, 2, 'Finesse', '1d8', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Scimitar', 'scimitar.png', 2500, 3, 'Finesse, light', '1d6', 'slashing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Shortsword', 'shortsword.png', 1000, 2, 'Finesse, light', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Trident', 'trident.png', 500, 4, 'Thrown (range 20/60), versatile (1d8)', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'War pick', 'war-pick.png', 500, 2, '', '1d8', 'piercing', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Warhammer', 'warhammer.png', 1500, 2, '', '1d8', 'bludgeoning', '', null, ''],
            ['Weapons', 'Martial melee weapons', 'Whip', 'whip.png', 200, 3, 'Finesse, reach', '1d4', 'slashing', '', null, ''],
            ['Weapons', 'Martial ranged weapons', 'Blowgun', 'blowgun.png', 1000, 1, 'Ammunition (range 25/100), loading', '1', 'piercing', '', null, ''],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, hand', 'crossbow-hand.png', 7500, 3, 'Ammunition (range 30/120), light, loading', '1d6', 'piercing', '', null, ''],
            ['Weapons', 'Martial ranged weapons', 'Crossbow, heavy', 'crossbow-heavy.png', 5000, 18, 'Ammunition (range 100/400), heavy, loading, two-handed', '1d10', 'piercing', '', null, ''],
            ['Weapons', 'Martial ranged weapons', 'Longbow', 'longbow.png', 5000, 2, 'Ammunition (range 150/600), heavy, two-handed', '1d8', 'piercing', '', null, ''],
            ['Weapons', 'Martial ranged weapons', 'Net', 'net.png', 100, 3, 'Special, thrown (range 5/15)', '', '', '', null, ''],
            ['Adventuring gear', '', 'Abacus', 'abacus.png', 200, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Acid (vial)', 'acid-vial.png', 2500, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Alchemist’s fire (flask)', 'alchemists-fire-flask.png', 5000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', 'Ammunition', 'Arrows (20)', 'arrows-20.png', 100, 1, '', '', '', '', null, ''],
            ['Adventuring gear', 'Ammunition', 'Blowgun needles (50)', 'blowgun-needles-50.png', 100, 1, '', '', '', '', null, ''],
            ['Adventuring gear', 'Ammunition', 'Crossbow bolts (20)', 'crossbow-bolts-20.png', 100, 1.5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Antitoxin (vial)', 'antitoxin-vial.png', 50, 0, '', '', '', '', null, ''],
            ['Adventuring gear', 'Arcane focus', 'Crystal', 'crystal.png', 1000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', 'Arcane focus', 'Orb', 'orb.png', 2000, 3, '', '', '', '', null, ''],
            ['Adventuring gear', 'Arcane focus', 'Rod', 'rod.png', 1000, 2, '', '', '', '', null, ''],
            ['Adventuring gear', 'Arcane focus', 'Staff', 'staff.png', 500, 4, '', '', '', '', null, ''],
            ['Adventuring gear', 'Arcane focus', 'Wand', 'wand.png', 1000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Backpack', 'backpack.png', 200, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Ball bearings (bag of 1000)', 'ball-bearings-bag-of-1000.png', 100, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Barrel', 'barrel.png', 200, 70, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Basket', 'basket.png', 40, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Bedroll', 'bedroll.png', 100, 7, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Bell', 'bell.png', 100, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Blanket', 'blanket.png', 500, 3, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Block and tackle', 'block-and-tackle.png', 100, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Book', 'book.png', 2500, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Bottle, glass', 'bottle-glass.png', 200, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Bucket', 'bucket.png', 5, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Caltrops (bag of 20)', 'caltrops-bag-of-20.png', 100, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Candle', 'candle.png', 1, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Case, crossbow bolt', 'case-crossbow-bolt.png', 100, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Case, map or scroll', 'case-map-or-scroll.png', 100, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Chain (10 feet)', 'chain-10-feet.png', 500, 10, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Chalk (1 piece)', 'chalk-1-piece.png', 1, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Chest', 'chest.png', 500, 25, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Climber\'s kit', 'climbers-kit.png', 2500, 12, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Clothes, common', 'clothes-common.png', 50, 3, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Clothes, costume', 'clothes-costume.png', 500, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Clothes, fine', 'clothes-fine.png', 1500, 6, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Clothes, traveler\'s', 'clothes-travelers.png', 200, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Component pouch', 'component-pouch.png', 2500, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Crowbar', 'crowbar.png', 200, 5, '', '', '', '', null, ''],
            ['Adventuring gear', 'Druidic focus', 'Sprig of mistletoe', 'sprig-of-mistletoe.png', 100, 0, '', '', '', '', null, ''],
            ['Adventuring gear', 'Druidic focus', 'Totem', 'totem.png', 100, 0, '', '', '', '', null, ''],
            ['Adventuring gear', 'Druidic focus', 'Wooden staff', 'wooden-staff.png', 500, 4, '', '', '', '', null, ''],
            ['Adventuring gear', 'Druidic focus', 'Yew wand', 'yew-wand.png', 1000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Fishing tackle', 'fishing-tackle.png', 100, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Flask or tankard', 'flask-or-tankard.png', 2, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Grappling hook', 'grappling-hook.png', 200, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Hammer', 'hammer.png', 100, 3, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Hammer, sledge', 'hammer-sledge.png', 200, 10, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Healer\'s kit', 'healers-kit.png', 500, 3, '', '', '', '', null, ''],
            ['Adventuring gear', 'Holy Symbol', 'Amulet', 'amulet.png', 500, 10, '', '', '', '', null, ''],
            ['Adventuring gear', 'Holy Symbol', 'Emblem', 'emblem.png', 500, 0, '', '', '', '', null, ''],
            ['Adventuring gear', 'Holy Symbol', 'Reliquary', 'reliquary.png', 500, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Holy water (flask)', 'holy-water-flask.png', 2500, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Hourglass', 'hourglass.png', 2500, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Hunting trap', 'hunting-trap.png', 500, 25, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Ink (1 ounce bottle)', 'ink-1-ounce-bottle.png', 1000, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Ink pen', 'ink-pen.png', 2, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Jug or pitcher', 'jug-or-pitcher.png', 2, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Ladder (10-foot)', 'ladder-10-foot.png', 10, 25, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Lamp', 'lamp.png', 50, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Lantern, bullseye', 'lantern-bullseye.png', 100, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Lantern, hooded', 'lantern-hooded.png', 500, 2, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Lock', 'lock.png', 1000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Magnifying glass', 'magnifying-glass.png', 10000, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Manacles', 'manacles.png', 200, 6, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Mess kit', 'mess-kit.png', 20, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Mirror, steel', 'mirror-steel.png', 500, 0.5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Oil (flask)', 'oil-flask.png', 10, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Paper (one sheet)', 'paper-one-sheet.png', 20, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Parchment (one sheet)', 'parchment-one-sheet.png', 10, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Perfume (vial)', 'perfume-vial.png', 500, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Pick, miner\'s', 'pick-miners.png', 200, 10, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Piton', 'piton.png', 5, 0.25, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Poison, basic (vial)', 'poison-basic-vial.png', 10000, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Pole (10-foot)', 'pole-10-foot.png', 5, 7, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Pot, iron', 'pot-iron.png', 200, 10, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Potion of healing', 'potion-of-healing.png', 5000, 0.5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Pouch', 'pouch.png', 50, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Quiver', 'quiver.png', 100, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Ram, portable', 'ram-portable.png', 400, 35, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Rations (1 day)', 'rations-1-day.png', 50, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Robes', 'robes.png', 100, 4, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Rope, hempen (50 feet)', 'rope-hempen-50-feet.png', 100, 10, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Rope, silk', 'rope-silk.png', 1000, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Sack', 'sack.png', 1, 0.5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Scale, merchant\'s', 'scale-merchants.png', 500, 3, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Sealing wax', 'sealing-wax.png', 50, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Shovel', 'shovel.png', 200, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Signal whistle', 'signal-whistle.png', 5, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Signet ring', 'signet-ring.png', 500, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Soap', 'soap.png', 2, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Spellbook', 'spellbook.png', 5000, 3, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Spikes, iron (10)', 'spikes-iron-10.png', 100, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Spyglass', 'spyglass.png', 100000, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Tent, two-person', 'tent-two-person.png', 200, 20, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Tinderbox', 'tinderbox.png', 50, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Torch', 'torch.png', 1, 1, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Vial', 'vial.png', 100, 0, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Waterskin', 'waterskin.png', 20, 5, '', '', '', '', null, ''],
            ['Adventuring gear', '', 'Whetstone', 'whetstone.png', 1, 1, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Alchemist\'s supplies', 'alchemists-supplies.png', 5000, 8, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Brewer\'s supplies', 'brewers-supplies.png', 2000, 9, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Calligrapher\'s supplies', 'calligraphers-supplies.png', 1000, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Carpenter\'s tools', 'carpenters-tools.png', 800, 6, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Cartographer\'s tools', 'cartographers-tools.png', 1500, 6, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Cobbler\'s tools', 'cobblers-tools.png', 500, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Cook\'s utensils', 'cooks-utensils.png', 100, 8, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Glassblower\'s tools', 'glassblowers-tools.png', 3000, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Jeweler\'s tools', 'jewelwers-tools.png', 2500, 2, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Leatherworker\'s tools', 'leatherworkers-tools.png', 500, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Mason\'s tools', 'mason-tools.png', 1000, 8, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Painter\'s supplies', 'painters-supplies.png', 1000, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Potter\'s tools', 'potters-tools.png', 1000, 3, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Smith\'s tools', 'smiths-tools.png', 2000, 8, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Tinker\'s tools', 'tinker-tools.png', 5000, 10, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Weaver\'s tools', 'weaver-tools.png', 100, 5, '', '', '', '', null, ''],
            ['Tools', 'Artisan\'s tools', 'Woodcarver\'s tools', 'woodcarver-tools.png', 100, 5, '', '', '', '', null, ''],
            ['Tools', '', 'Disguise kit', 'disguise-kit.png', 2500, 3, '', '', '', '', null, ''],
            ['Tools', '', 'Forgery kit', 'forgery-kit.png', 1500, 5, '', '', '', '', null, ''],
            ['Tools', 'Gaming set', 'Dice set', 'dice-set.png', 10, 0, '', '', '', '', null, ''],
            ['Tools', 'Gaming set', 'Dragonchess set', 'dragonchess-set.png', 10, 0.5, '', '', '', '', null, ''],
            ['Tools', 'Gaming set', 'Playing card set', 'playing-card-set.png', 10, 0, '', '', '', '', null, ''],
            ['Tools', 'Gaming set', 'Three-Dragon Ante set', 'three-dragon-ante-set.png', 100, 0, '', '', '', '', null, ''],
            ['Tools', '', 'Herbalism kit', 'herbalism-kit.png', 500, 3, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Bagpipes', 'bagpipes.png', 3000, 6, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Drum', 'drum.png', 600, 3, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Dulcimer', 'dulcimer.png', 2500, 10, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Flute', 'flute.png', 200, 1, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Lute', 'lute.png', 3500, 2, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Lyre', 'lyre.png', 3000, 2, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Horn', 'horn.png', 300, 2, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Pan flute', 'pan-flute.png', 1200, 2, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Shawm', 'shawm.png', 200, 1, '', '', '', '', null, ''],
            ['Tools', 'Musical instrument', 'Viol', 'viol.png', 3000, 1, '', '', '', '', null, ''],
            ['Tools', '', 'Navigator\'s tools', 'navigators-tools.png', 2500, 2, '', '', '', '', null, ''],
            ['Tools', '', 'Poisoner\'s kit', 'poisoners-kit.png', 5000, 2, '', '', '', '', null, ''],
            ['Tools', '', 'Thieves\' tools', 'thieves-tools.png', 2500, 1, '', '', '', '', null, ''],
        ];

        foreach ($equipments as [$type, $subtype, $name, $image, $cost, $weight, $properties, $damage, $damageType, $armorClass, $strength, $stealth]) {
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
            $manager->persist($equipment);
        }

        $manager->flush();

        /* CHARACTER RACE */

        $races = ['Dwarf', 'Elf', 'Halfling', 'Human', 'Dragonborn', 'Gnome', 'Half-Elf', 'Half-Orc', 'Tiefling'];

        foreach ($races as $name) {
            $race = new DndRace();
            $race->setName($name);
            $manager->persist($race);
        }

        $manager->flush();

        /* CHARACTER CLASS */

        $classes = [
            ['Barbarian', '~dnd.barbarian_description', 'd12', 'Strength', 'Strength, Constitution', '~dnd.barbarian_armor_weapon_prof'],
            ['Bard', '~dnd.bard_description', 'd8', 'Charisma', 'Dexterity, Charisma', '~dnd.bard_armor_weapon_prof'],
            ['Cleric', '~dnd.cleric_description', 'd8', 'Wisdom', 'Wisdom, Charisma', '~dnd.cleric_armor_weapon_prof'],
            ['Druid', '~dnd.druid_description', 'd8', 'Wisdom', 'Intelligence, Wisdom', '~dnd.druid_armor_weapon_prof'],
            ['Fighter', '~dnd.fighter_description', 'd10', 'Strength or Dexterity', 'Strength, Constitution', '~dnd.fighter_armor_weapon_prof'],
            ['Monk', '~dnd.monk_description', 'd8', 'Dexterity, Wisdom', 'Strength, Dexterity', '~dnd.monk_armor_weapon_prof'],
            ['Paladin', '~dnd.paladin_description', 'd10', 'Strength, Charisma', 'Wisdom, Charisma', '~dnd.paladin_armor_weapon_prof'],
            ['Ranger', '~dnd.ranger_description', 'd10', 'Dexterity, Wisdom', 'Strength, Dexterity', '~dnd.ranger_armor_weapon_prof'],
            ['Rogue', '~dnd.rogue_description', 'd8', 'Dexterity', 'Dexterity, Intelligence', '~dnd.rogue_armor_weapon_prof'],
            ['Sorcerer', '~dnd.sorcerer_description', 'd6', 'Charisma', 'Constitution, Charisma', '~dnd.sorcerer_armor_weapon_prof'],
            ['Warlock', '~dnd.warlock_description', 'd8', 'Charisma', 'Wisdom, Charisma', '~dnd.warlock_armor_weapon_prof'],
            ['Wizard', '~dnd.wizard_description', 'd6', 'Intelligence', 'Intelligence, Wisdom', '~dnd.wizard_armor_weapon_prof']
        ];

        foreach ($classes as [$nm, $description, $dice, $primary, $saveProf, $armorWeaponProf]) {
            $class = new DndClass();
            $class->setName($nm);
            $class->setDescription($description);
            $class->setHitDie($dice);
            $class->setPrimaryAbility($primary);
            $class->setSavingProf($saveProf);
            $class->setArmorWeaponProf($armorWeaponProf);
            $manager->persist($class);
        }

        $manager->flush();

        /* CHARACTER */

        $this->createMany(50, 'characters', function () use ($races, $classes) {
            $character = new DndCharacter();
            $character->setRace($this->manager->getRepository(DndRace::class)->findOneBy([ 'name' => $races[array_rand($races)] ]));
            $character->setClass($this->manager->getRepository(DndClass::class)->findOneBy(['name' => $classes[array_rand($classes)]]));
            $character->setName($this->faker->firstName);
            $character->setLevel($this->faker->numberBetween(1, 10));
            $character->setExperiencePoints($this->faker->numberBetween(0, 10000));
            $character->setMoney($this->faker->numberBetween(1, 50000));
            $character->setStrength($this->faker->numberBetween(3, 18));
            $character->setDexterity($this->faker->numberBetween(3, 18));
            $character->setConstitution($this->faker->numberBetween(3, 18));
            $character->setIntelligence($this->faker->numberBetween(3, 18));
            $character->setWisdom($this->faker->numberBetween(3, 18));
            $character->setCharisma($this->faker->numberBetween(3, 18));
            $character->setArmorClass($this->faker->numberBetween(3, 18));
            $character->setStatus($this->faker->randomElement([DndCharacter::STATUS_ACTIVE, DndCharacter::STATUS_INACTIVE]));
            $character->setUser(
                $user = $this->faker->boolean(95)
                    ? $this->getRandomReference(UserFixtures::ROLE_USER_REFERENCE)
                    : $this->getRandomReference(UserFixtures::ROLE_ADMIN_REFERENCE)
            );

            return $character;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
