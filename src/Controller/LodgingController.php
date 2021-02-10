<?php

namespace App\Controller;

use App\Entity\Lodging;
use App\Repository\LodgingRepository;
use App\Repository\WeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lodging", name="lodging_")
 */
class LodgingController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(LodgingRepository $repository): Response
    {
        $lodgings = $repository->findAll();

        return $this->render('lodging/index.html.twig', [
            'lodgings' => $lodgings
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, WeekRepository $repository): Response
    {
        $weeks = $repository->findWeeksAvailaible($lodging->getId());

        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging
        ]);
    }

    /**
     * @Route("/{beginsAt}/{endsAt}/{visitors}", name="search")
     */
    public function search(\DateTime $beginsAt, \DateTime $endsAt, int $visitors): Response
    {
        return $this->render('lodging/index.html.twig.twig', [

        ]);
    }

}
