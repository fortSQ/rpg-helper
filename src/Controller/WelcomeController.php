<?php

namespace App\Controller;

use App\Entity\DndEquipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\MoneyDecorator;
use App\Helpers\WeightDecorator;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        $weight = new WeightDecorator(123);


        return $this->render('welcome/index.html.twig', [
            'weight' => $weight,
        ]);
    }
}
