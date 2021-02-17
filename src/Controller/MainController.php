<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\SearchLodgingType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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

        $form = $this->createForm(SearchLodgingType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('lodging_search', [
                'beginsAt' => $form->get('beginsAt')->getData(),
                'endsAt' => $form->get('endsAt')->getData(),
                'capacity' => $form->get('capacity')->getData(),
            ]);

        }

        return $this->render('main/home.html.twig', [
            'form' => $form->createView()
        ]);
    }

}