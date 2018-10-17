<?php

namespace App\Controller;

use App\Repository\DndEquipmentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DndEquipmentController extends AbstractController
{
    /**
     * @Route("/dnd/equipment", name="dnd_equipment")
     */
    public function index(DndEquipmentTypeRepository $dndEquipmentTypeRepository)
    {
        return $this->render('dnd_equipment/index.html.twig', [
            'title'     => 'All DnD equipment',
            'equipmentTypeList' => $dndEquipmentTypeRepository->findAllJoinedToDndEquipment()
        ]);
    }
}
