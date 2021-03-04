<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Lodging;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\BookingStateRepository;
use App\Repository\LodgingRepository;
use App\Repository\WeekRepository;
use App\Services\DateRangeHelper;
use DateInterval;
use DatePeriod;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/search", name="search")
     */
    public function search(Request $request, LodgingRepository $repository): Response
    {
        $cityName = $request->query->get('cityName');
        $postalCodes = $request->query->get('postalCodes');
        $postalCodesArray = explode ( ';' , $postalCodes); //array
        $begin = new \DateTime($request->query->get('beginsAt'));
        $end = new \DateTime($request->query->get('endsAt'));
        $capacity = $request->query->get('visitors');

        $lodgings = $repository->findAvailableLodgings($postalCodesArray, $begin, $end, $capacity);

        return $this->render('lodging/index.html.twig', [
            'lodgings' => $lodgings,
            'cityName' => $cityName,
            'postalCodes' => $postalCodes,
            'beginsAt' => $begin,
            'endsAt' => $end,
        ]);
    }


    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, Request $request, DateRangeHelper $dateRangeHelper, BookingStateRepository $bookingStateRepository, EntityManagerInterface $manager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form -> handleRequest($request);

        $bookedRanges = $dateRangeHelper->getBookedDateRangesForJS($lodging);


        if($form->isSubmitted() && $form->isValid()){

            $booking->setUser($this->getUser());
            $booking->setLodging($lodging);
            $booking->setBookingState($bookingStateRepository->find(1));

            $manager->persist($booking);
            $manager->flush();
        }


        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
            'form' => $form->createView(),
            'dates' => $bookedRanges
        ]);
    }


}
