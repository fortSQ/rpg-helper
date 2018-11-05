<?php

namespace App\Controller;

use App\Repository\DndEquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DndEquipmentController extends AbstractController
{
    /**
     * @Route("/dnd/equipment", name="dnd_equipment")
     */
    public function index(DndEquipmentRepository $repository, Request $request)
    {
        $q = $request->query->get('q');
        $equipments = $repository->findAllWithSearch($q);

        return $this->render('dnd_equipment/index3.html.twig', [
            'title'      => 'All DnD equipment',
            'equipments'      => $equipments,
        ]);
    }
}
