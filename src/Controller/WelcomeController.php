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
    //TODO
    // add to character status (active, deleted)
    // and description

    // race
        // racial increases
    // class
        // class features
        // proficiencies
        // hit point maximum + hit points + type of hit dice
        // proficiency bonus
    // alignment
    // traits, ideals, bonds + flows
    // background
    // inventory? equipment?
    // переделать money в new/edit
    // age, size, speed, languages, sex, height, weight
    // inspiration
    // skills

    // метод для рассчета AC
    // картинки для монет


    // Delete link
    // https://stackoverflow.com/questions/21747685/best-practices-delete-links-with-symfony-2

    // advantage and disadvantage




    // ResetPasswordTrait.php
    // https://github.com/webinarium/symfony-lazysec/blob/master/src/Entity/ResetPasswordTrait.php

    // Symfony 4 change password by username - email can not be null --- LAST ANSWER
    // https://stackoverflow.com/questions/50530114/symfony-4-change-password-by-username-email-can-not-be-null


    /**
     * @Route("/", name="app_homepage")
     *
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
