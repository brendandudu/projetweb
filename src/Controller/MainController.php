<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/index", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager)
    {
        $customer = new Customer();
        $form = $this->createForm(UserType::class, $customer);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $customer->setCreatedAt(new \DateTime());

            $manager->persist($customer);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('main/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
