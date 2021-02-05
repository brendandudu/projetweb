<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Availability;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{beginsAt}/{endsAt}/{visitors}", name="search")
     */
    public function index(\DateTime $beginsAt, \DateTime $endsAt, int $visitors): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
