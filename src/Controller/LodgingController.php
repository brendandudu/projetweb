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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

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

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Lodging $lodging, Request $request, DateRangeHelper $dateRangeHelper, BookingStateRepository $bookingStateRepository, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking, [
            'capacity' => $lodging->getCapacity(),
            'beginsAt' => $request->query->get('beginsAt'),
            'endsAt' => $request->query->get('endsAt'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $this->denyAccessUnlessGranted('ROLE_USER');

            $booking->setUser($this->getUser());
            $booking->setLodging($lodging);
            $booking->setBookingState($bookingStateRepository->find(1));

            $manager->persist($booking);
            $manager->flush();

            //send email
            $email = (new TemplatedEmail())
                ->from(new Address('betview.conseil@gmail.com', 'Projet RESA (NE PAS RÉPONDRE)'))
                ->to($this->getUser()->getEmail())
                ->subject('Réservation confirmée de ' . $lodging->getName())
                ->htmlTemplate('user/email.html.twig')
                ->context([
                    'user' => $this->getUser(),
                    'booking'=> $booking
                ])
            ;

            $mailer->send($email);
        }

        $bookedRanges = $dateRangeHelper->getBookedDateRangesForJS($lodging);

        return $this->render('lodging/show.html.twig', [
            'lodging' => $lodging,
            'form' => $form->createView(),
            'dates' => $bookedRanges
        ]);
    }


}
