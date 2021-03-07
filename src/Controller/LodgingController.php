<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Lodging;
use App\Form\BookingType;
use App\Form\LodgingType;
use App\Repository\BookingStateRepository;
use App\Repository\LodgingRepository;
use App\Services\DateRangeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lodging", name="lodging_")
 */
class LodgingController extends AbstractController
{

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, LodgingRepository $repository): Response
    {
        $data = $request->query->get('data');

        $lodgings = $repository->findSearch((array)$data);

        return $this->render('lodging/search.html.twig', [
            'lodgings' => $lodgings,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @Route("/{id}/edit", name="edit")
     */
    public function form(Lodging $lodging = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$lodging){
            $lodging = new Lodging();
        }

        $form = $this->createForm(LodgingType::class, $lodging);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($lodging->getId()){
                $lodging->setUpdatedAt(new \DateTime());
            }
            else{
                $lodging->setUser($this->getUser());
            }

            $manager->persist($lodging);
            $manager->flush();
        }

        return $this->render('lodging/create.html.twig', [
            'form' => $form->createView(),
            'editMode' => $lodging->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, Request $request, DateRangeHelper $dateRangeHelper, BookingStateRepository $bookingStateRepository, EntityManagerInterface $manager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $booking->setUser($this->getUser());
            $booking->setLodging($lodging);
            $booking->setBookingState($bookingStateRepository->find(1));

            $manager->persist($booking);
            $manager->flush();
        }

        $bookedRanges = $dateRangeHelper->getBookedDateRangesForJS($lodging);

        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
            'form' => $form->createView(),
            'dates' => $bookedRanges
        ]);
    }


}
