<?php

namespace App\Controller;

use App\Data\SearchLodgingData;
use App\Form\SearchLodgingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $data = new SearchLodgingData();
        $form = $this->createForm(SearchLodgingType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('lodging_search', [
                'data' => $data
            ]);

        }

        return $this->render('main/home.html.twig', [
            'form' => $form->createView()
        ]);
    }

}