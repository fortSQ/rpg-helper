<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Строка ниже нужна для автодополнения PhpShtorm'a, т.к. метод parent::getUser() не знает, объект какого класса он вернет.
 * @method User getUser()
 */
abstract class BaseController extends AbstractController
{
}
