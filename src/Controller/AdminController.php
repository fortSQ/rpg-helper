<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/users", name="user_list", methods="GET")
     */
    public function users(UserRepository $userRepository): Response
    {
        return $this->render('admin/user_list.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

}
