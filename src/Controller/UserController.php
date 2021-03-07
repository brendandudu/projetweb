<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/info", name="info")
     */
    public function index(): Response
    {
        return $this->render('user/info.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Informations modifiées !');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/bookings", name="bookings")
     */
    public function showBookings(BookingRepository $repository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_EDITOR')) {
            $bookings = $repository->findByOwnerId($user->getId());
        }
        else {
            $bookings = $user->getBookings();
        }

        return $this->render('user/bookings.html.twig', [
            'bookings' => $bookings,
            'user' => $user
        ]);
    }

}
