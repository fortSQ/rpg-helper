<?php

namespace App\Controller;

use App\Helpers\DiceHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\MoneyDecorator;
use App\Helpers\WeightDecorator;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(DiceHelper $diceHelper)
    {
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $data[] = $diceHelper->roll('2d6');
        }

        $data = array_count_values($data);
        ksort($data);


        dump($data); die('ok');

        return $this->render('welcome/index.html.twig', [
            'data' => $data,
        ]);
    }
}
