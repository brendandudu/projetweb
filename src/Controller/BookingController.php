<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingStateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking", name="booking_")
 */
class BookingController extends AbstractController
{

    /**
     * @Route("/{id}", name="details")
     */
    public function showDetails(Booking $booking, Request $request, EntityManagerInterface $manager, BookingStateRepository $bookingStateRepository): Response
    {
        if ($booking->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setBookingState($bookingStateRepository->find(4));
            $manager->persist($booking);
            $manager->flush();
        }

        return $this->render('booking/bookingDetails.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
            'isAlreadyFinished' => in_array($booking->getBookingState()->getId(), [4, 5], true)
        ]);
    }

}
