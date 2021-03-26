<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Comment;
use App\Entity\Lodging;
use App\Form\BookingType;
use App\Form\CommentType;
use App\Form\LodgingType;
use App\Repository\BookingRepository;
use App\Repository\BookingStateRepository;
use App\Repository\CommentRepository;
use App\Repository\LodgingRepository;
use App\Services\DateRangeHelper;
use App\Services\NotificationHelper;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("ROLE_HOST")
     */
    public function form(Lodging $lodging = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$lodging) {
            $lodging = new Lodging();
        }

        $form = $this->createForm(LodgingType::class, $lodging);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($lodging->getId()) {
                $lodging->setUpdatedAt(new DateTime());
            } else {
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


    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, Request $request, DateRangeHelper $dateRangeHelper, BookingRepository $bookingRepository, CommentRepository $commentRepository, BookingStateRepository $bookingStateRepository, EntityManagerInterface $manager, NotificationHelper $notif): Response
    {

        ## BOOKING PART ##
        $booking = new Booking();
        $formBooking = $this->createForm(BookingType::class, $booking, [
            'capacity' => $lodging->getCapacity(),
            'beginsAt' => $request->query->get('beginsAt'),
            'endsAt' => $request->query->get('endsAt'),
        ]);
        $formBooking->handleRequest($request);

        if ($formBooking->isSubmitted() && $formBooking->isValid()) {

            $this->denyAccessUnlessGranted('ROLE_USER');

            $booking
                ->setUser($this->getUser())
                ->setLodging($lodging)
                ->setBookingState($bookingStateRepository->find(1));

            $manager->persist($booking);
            $manager->flush();

            $notif->sendNotification($this->getUser(), $lodging, $manager);

            return $this->redirectToRoute('user_bookings');
        }

        ## COMMENT PART ##
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $this->denyAccessUnlessGranted('ROLE_USER');
            $comment
                ->setUser($this->getUser())
                ->setLodging($lodging);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirect($request->getUri());
        }

        $bookedRanges = $dateRangeHelper->getBookedDateRangesForJS($lodging);

        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
            'formBooking' => $formBooking->createView(),
            'formComment' => $formComment->createView(),
            'dates' => $bookedRanges,
            'comments' => $lodging->getComments(),
            'canUserRate' => $this->canUserRate($bookingRepository, $commentRepository, $lodging)
        ]);
    }

    /**
     * Add or remove lodging from user's wishlist
     *
     * @Route("/{id}/wishlist", name="manageWishList")
     */
    public function addOrRemoveWishList(Lodging $lodging, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if(!$user){
            return $this->JSON([
                'code' => 403,
                'message' => "Unauthorized"
            ], 403);
        }

        if($user->isAlreadyInWishList($lodging)){
            $user->removeWishList($lodging);

            $manager->persist($user);
            $manager->flush();

            return $this->JSON([
                'code' => 200,
                'message' => "Lodging removed from WishList"
            ], 200);
        }

        $user->addWishList($lodging);


        $manager->persist($user);
        $manager->flush();

        return $this->JSON([
            'code' => 200,
            'message' => "Lodging added to WishList"
        ], 200);

    }

    private function canUserRate(BookingRepository $bookingRepository, CommentRepository $commentRepository, Lodging $lodging): bool
    {
        return $this->isGranted('ROLE_USER')
            && count($bookingRepository->findByGuestAndLodgingId($this->getUser()->getId(), $lodging->getId())) > 0
            && count($commentRepository->findByGuestAndLodgingId($this->getUser()->getId(), $lodging->getId())) < 1;
    }

}
