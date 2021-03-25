<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Lodging;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\LodgingType;
use App\Form\CommentType;
use App\Repository\BookingStateRepository;
use App\Repository\CommentRepository;
use App\Repository\LodgingRepository;
use App\Repository\BookingRepository;
use App\Services\DateRangeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @IsGranted("ROLE_HOST")
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

            return $this->redirectToRoute('user_lodgings');
        }

        return $this->render('lodging/create.html.twig', [
            'form' => $form->createView(),
            'editMode' => $lodging->getId() !== null
        ]);
    }

    private function canUserRate(BookingRepository $bookingRepository, CommentRepository $commentRepository, Lodging $lodging): bool {
        return $this->isGranted('ROLE_USER') 
            && count($bookingRepository->findByGuestAndLodgingId($this->getUser()->getId(), $lodging->getId())) > 0
            && count($commentRepository->findByGuestAndLodgingId($this->getUser()->getId(), $lodging->getId())) < 1;
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, Request $request, DateRangeHelper $dateRangeHelper, BookingRepository $bookingRepository, CommentRepository $commentRepository, BookingStateRepository $bookingStateRepository, EntityManagerInterface $manager): Response
    {
        $canUserRate = $this->canUserRate($bookingRepository, $commentRepository, $lodging);

        $booking = new Booking();
        $formBooking = $this->createForm(BookingType::class, $booking, [
            'capacity' => $lodging->getCapacity(),
            'beginsAt' => $request->query->get('beginsAt'),
            'endsAt' => $request->query->get('endsAt'),
        ]);
        $formBooking->handleRequest($request);

        if ($formBooking->isSubmitted() && $formBooking->isValid()) {

            $this->denyAccessUnlessGranted('ROLE_USER');

            $booking->setUser($this->getUser());
            $booking->setLodging($lodging);
            $booking->setBookingState($bookingStateRepository->find(1));

            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('user_bookings');
        }

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $this->denyAccessUnlessGranted('ROLE_USER');
            $comment->setUser($this->getUser());
            $comment->setLodging($lodging);
            $comment->setDate(new \DateTime('now'));

            $manager->persist($comment);
            $manager->flush();

            return $this->redirect($request->getUri());
        }

        $bookedRanges = $dateRangeHelper->getBookedDateRangesForJS($lodging);

        $comments = $lodging->getComments();

        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
            'formBooking' => $formBooking->createView(),
            'formComment' => $formComment->createView(),
            'dates' => $bookedRanges,
            'comments' => $comments,
            'canUserRate' => $canUserRate
        ]);
    }


}
