<?php

namespace App\Controller;

use App\Repository\LodgingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LodgingController extends AbstractController
{
    /**
     * @Route("/lodging", name="lodging")
     */
    public function index(LodgingRepository $repository): Response
    {
        $lodgings = $repository->findAll();

        return $this->render('lodging/index.html.twig', [
            'controller_name' => 'LodgingController',
            'lodgings' => $lodgings
        ]);
    }
}
