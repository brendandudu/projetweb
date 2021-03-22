<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\BookingRepository;
use App\Repository\LodgingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class UserController extends AbstractController
{
//    /**
//     * @Route("/info", name="info")
//     */
//    public function index(): Response
//    {
//        return $this->render('user/info.html.twig', [
//            'user' => $this->getUser()
//        ]);
//    }
//
//    /**
//     * @Route("/edit", name="edit")
//     */
//    public function edit(Request $request, EntityManagerInterface $manager): Response
//    {
//        $user = $this->getUser();
//        $form = $this->createForm(UserType::class, $user);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()){
//            $manager->persist($user);
//            $manager->flush();
//
//            $this->addFlash('success', 'Informations modifiées !');
//        }
//
//        return $this->render('user/edit.html.twig', [
//            'form' => $form->createView(),
//            'user' => $user
//        ]);
//    }

    /**
     * @Route("/user/bookings", name="user_bookings")
     */
    public function showBookings(BookingRepository $repository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_EDITOR')) {
            $bookings = $repository->findByUserId($user->getId());
        }
        else {
            $bookings = $user->getBookings();
        }

        return $this->render('user/bookings.html.twig', [
            'bookings' => $bookings,
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/lodgings", name="user_lodgings")
     * @IsGranted("ROLE_HOST")
     */
    public function showLodgings(LodgingRepository $repository): Response
    {
        $user = $this->getUser();

        $lodgings = $repository->findByOwnerId($user->getId());


        return $this->render('user/lodgings.html.twig', [
            'lodgings' => $lodgings,
            'user' => $user
        ]);
    }

    /**
     * @Route("/info/user", name="user_info")
     */
    public function uiinfo(Request $request,UserInterface $user): Response
    {
        //$user = $this->userRepository->find(1);

        return $this->render('user/info.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("/edit/user", name="useredit")
     */
    public function edit(Request $request,EntityManagerInterface $manager, UserInterface $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){//提交修改
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_info');
        }

        //$user = $this->userRepository->find(3);

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reservation/user", name="reservation")
     */
    public function reservation(Request $request,UserInterface $user,LodgingRepository $repository,BookingRepository $r,BookingRepository $br): Response
    {

        $lodgings = $repository->findAvailableLodgingsMe($user,$r);//$this->getUser()->getId()
        //$booking = $br->findBy(array("User"=>$user));
        //dump($booking);
        return $this->render('user/reservation.html.twig', [
            'user' => $user,
            'lodgings'=> $lodgings,
            //'booking'=> $booking,
        ]);
    }

    /**
     * @Route("/details/{$id}", name="reservationdetails")
     */
    public function reservationdetails(Request $request,UserInterface $user,LodgingRepository $repository,BookingRepository $br): Response
    {
        // $_GET parameters
        $param = $request->query->get('id');
        // $_POST parameters
        //$request->request->get('name');
        $lodging = $repository->find($param);
        $booking = $br->findOneBy(array('user'=>$user));//,'lodgingId'=>$param
        return $this->render('user/lodgingDetails.html.twig', [
            'user' => $user,
            'lodging'=>$lodging,
            'booking'=>$booking
        ]);
    }
}
