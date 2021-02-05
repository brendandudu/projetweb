<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Availability;
use App\Form\SearchAvailabilityType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $availability = new Availability();

        $form = $this->createForm(SearchAvailabilityType::class, $availability);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $availability = $form->getData();

            return $this->redirectToRoute('search', [
                'beginsAt' => $availability->getBeginsAt()->format("Y-m-d"),
                'endsAt' => $availability->getEndsAt()->format("Y-m-d"),
                'visitors' => $availability->getLodging()->getCapacity()
            ]);
        }

        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

}