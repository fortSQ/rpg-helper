<?php

namespace App\Controller;

use App\Repository\DndEquipmentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DndEquipmentController extends AbstractController
{
    /**
     * @Route("/dnd/equipment", name="dnd_equipment")
     */
    public function index(DndEquipmentTypeRepository $repository, Request $request)
    {
        $q = $request->query->get('q');
        $types = $repository->findAllWithSubtypesAndEquipments($q);

        return $this->render('dnd_equipment/index.html.twig', [
            'title'      => 'All DnD equipment',
            'types'      => $types,
        ]);
    }
}
