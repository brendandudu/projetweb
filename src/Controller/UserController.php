<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user/info", name="user-info")
     */
    public function index(): Response
    {
        return $this->render('user/info.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/edit", name="user-edit")
     */
    public function edit(): Response
    {
        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
