<?php

namespace App\Controller;

use App\Repository\DndEquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DndEquipmentController extends AbstractController
{
    /**
     * @Route("/dnd/equipment", name="dnd_equipment")
     */
    public function index(DndEquipmentRepository $dndEquipmentRepository)
    {
        return $this->render('dnd_equipment/index.html.twig', [
            'title'     => 'All DnD equipment',
            'equipmentList' => $dndEquipmentRepository->findAll()
        ]);
    }
}
