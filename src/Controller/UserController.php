<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Repository\BookingRepository;
use App\Repository\NotificationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUpdatedAt(new DateTime());
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Informations modifiées !');
            return $this->redirectToRoute('user_info');
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

        if ($this->isGranted('ROLE_HOST')) {
            $bookings = $repository->findByUserId($user->getId());
        } else {
            $bookings = $user->getBookings();
        }

        return $this->render('user/bookings.html.twig', [
            'bookings' => $bookings,
            'user' => $user
        ]);
    }

    /**
     * @Route("/lodgings", name="lodgings")
     * @IsGranted("ROLE_HOST")
     */
    public function showLodgings(): Response
    {
        $user = $this->getUser();

        $lodgings = $user->getLodgings();

        return $this->render('user/lodgings.html.twig', [
            'lodgings' => $lodgings,
            'user' => $user
        ]);
    }

    /**
     * @Route("/notifications", name="notif")
     */
    public function showNotifications(NotificationRepository $repository): Response
    {
        $user = $this->getUser();

        $notifications = $user->getNotifications();
        $repository->setNotificationsSeen($user->getId());

        return $this->render('user/notifications.html.twig', [
            'notifications' => $notifications,
            'user' => $user
        ]);
    }

    /**
     * @Route("/wishlist", name="wishlist")
     */
    public function showWishlist(): Response
    {
        $user = $this->getUser();

        $wishList = $user->getWishList();

        return $this->render('user/wishlist.html.twig', [
            'lodgings' => $wishList,
            'user' => $user
        ]);
    }

    /**
     * @Route("/security", name="security")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $form->get('oldPassword')->getData();

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());

                $user->setPassword($newEncodedPassword);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('user_security');
            }

            $form->get('oldPassword')->addError(new FormError('Ancien mot de passe incorrect'));

        }

        return $this->render('user/editPassword.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
