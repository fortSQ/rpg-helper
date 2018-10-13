<?php

namespace App\Controller;

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

        return $this->render('welcome/index.html.twig', [
            'money' => $money
        ]);
    }
}
