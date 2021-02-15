<?php

namespace App\Controller;

use App\Entity\Lodging;
use App\Repository\LodgingRepository;
use App\Repository\WeekRepository;
use DateInterval;
use DatePeriod;
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
        /*$weeks = $repository->findWeeksAvailaible($lodging->getId());
        $end=new \DateTime('2021-02-25');

        $period = new DatePeriod(
            new \DateTime('2021-02-20'),
            new DateInterval('P1D'),
            $end->modify('+1 day')
        );
        $dates = iterator_to_array($period);*/


        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
        ]);
    }

    /**
     * @Route("/{beginsAt}/{endsAt}/{visitors}", name="search")
     */
    public function search(\DateTime $beginsAt, \DateTime $endsAt, int $visitors): Response
    {
        return $this->render('lodging/index.html.twig', [

        ]);
    }

}
