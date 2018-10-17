<?php

namespace App\Controller;

use App\Entity\DndEquipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\MoneyDecorator;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        $money = new MoneyDecorator(1234);

        $repository = $this->getDoctrine()->getRepository(DndEquipmentType::class);
        $types = $repository->findAllJoinedToDndEquipment();

//        foreach ($types as $type) {
//            dump($type);
//            die('ok');
//        }

        dump($types); die('ok');

        $repository = $this->getDoctrine()->getRepository(DndEquipmentType::class);
        $item = $repository->findAll();

        return $this->render('welcome/index.html.twig', [
            'money' => $money,
            'item'  => $item
        ]);
    }
}
