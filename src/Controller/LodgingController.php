<?php

namespace App\Controller;

use App\Entity\Lodging;
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
            'lodgings' => $lodgings
        ]);
    }

    /**
     * @Route("/lodging/{id}", name="lodging_show")
     */
    public function show(Lodging $lodging): Response
    {
        return $this->render('lodging/.......', [
            'lodging' => $lodging
        ]);
    }

    /**
     * @Route("/lodging/search", name="lodging_search")
     */
    public function searchLodging(LodgingRepository $repository): Response
    {
        $lodgings = $repository->findAll(); //changer methode pour trouver les hebergements dispo

        return $this->render('lodging/index.html.twig', [
            'lodgings' => $lodgings
        ]);
    }

}
