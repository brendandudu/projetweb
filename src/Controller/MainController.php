<?php

namespace App\Controller;

use App\Entity\Customer;
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
        $form = $this->createFormBuilder()
            ->add('beginsAt', DateType::class,[
                'widget' => 'single_text',
            ])

            ->add('endsAt', DateType::class,[
                'widget' => 'single_text',
            ])

            ->add('visitors', IntegerType::class)
            ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            return $this->redirectToRoute('lodging_search', [
                'beginsAt' => $formData['beginsAt']->format('Y-m-d'),
                'endsAt' => $formData['endsAt']->format('Y-m-d'),
                'visitors' => $formData['visitors'],
            ]);

        }

        return $this->render('main/home.html.twig', [
            'form' => $form->createView()
        ]);
    }

}