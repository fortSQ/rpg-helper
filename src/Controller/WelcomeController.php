<?php

namespace App\Controller;

use App\Helpers\DiceHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\MoneyDecorator;
use App\Helpers\WeightDecorator;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function index() : Response
    {
        $data = [];

        $dice = new DiceHelper('2d6+1');

        for ($i = 0; $i < 1000; $i++) {
            $data[] = $dice->roll();
        }

        $data = array_count_values($data);
        krsort($data);

        //dump($data); die('ok');

        return $this->render('welcome/index.html.twig', [
            'data' => $data,
        ]);
    }
}
